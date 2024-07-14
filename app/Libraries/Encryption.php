<?php

namespace App\Libraries;

use App\Modules\Settings\Models\Configuration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class Encryption
{

    private static $defskey = "BAT4vA0q2z1B0c5F"; // EncryptionKey
    private static $chiperMethod = 'aes-256-cbc';

    public static function safe_b64encode($string)
    {
        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
        return urlencode($data);
    }

    public static function safe_b64decode($string)
    {
        $urlDecodedData = urldecode($string);
        $data = str_replace(array('-', '_'), array('+', '/'), $urlDecodedData);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    public static function encodeId($id)
    {
        return Encryption::encode( $id);
    }

    public static function decodeId($id)
    {
        return Encryption::decode($id);
    }

    /*
     * consider time, module, auth user
     *
     */
    public static function secureEncodeId($id, $module = "default-module")
    {
        $time = time();
        if (Auth::user()) {
            return Encryption::encode($time . '_' . $module . '_' . $id . '_' . Auth::user()->id);
        } else {
            return Encryption::encode($time . '_' . $module . '_' . $id);
        }
    }

    public static function secureDecodeId($id, $module = null)
    {
        $decodedData = explode('_', Encryption::decode($id));
        $timeStamp = $decodedData[0];
        $currentTimestamp = time();
        $minuteDifference = ($currentTimestamp - $timeStamp) / 60; // Convert seconds to minutes

        // Check if the difference is less than or equal to configured expire time
        $encryptionTimeLimit = Configuration::where('caption', 'SECURE_ENCRYPTION_TIME')->value('value');

        if ($minuteDifference > $encryptionTimeLimit) {
            die('Invalid Id! 401');
        }

        if (count($decodedData) == 4 && Auth::user()) {
            if (Auth::user()->id == $decodedData[3]) {
                if ($module) {
                    if (strcmp($module, $decodedData[1]) == 0) {
                        return $decodedData[2];
                    }
                } else {
                    return $decodedData[2];
                }
            }
        }
        if (count($decodedData) == 3) {
            if ($module) {
                if (strcmp($module, $decodedData[1]) == 0) {
                    return $decodedData[2];
                }
            } else {
                return $decodedData[2];
            }
        }
        die('Invalid Id! 402');
    }


    public static function encode($value)
    {
        if (in_array(SELF::$chiperMethod, openssl_get_cipher_methods())) {
            $ivlen = openssl_cipher_iv_length(SELF::$chiperMethod);
            $iv = openssl_random_pseudo_bytes($ivlen);
            $ciphertext_raw = openssl_encrypt(
                $value,
                SELF::$chiperMethod,
                SELF::$defskey,
                OPENSSL_RAW_DATA,
                $iv
            );

            $hmac = hash_hmac('sha256', $ciphertext_raw, SELF::$chiperMethod, $as_binary = true);
            $encodedText = Encryption::safe_b64encode($iv . $hmac . $ciphertext_raw);
        } else {
            $encodedText = Encryption::safe_b64encode($value);
        }
        return $encodedText;
    }

    //Return decrypted string
    public static function decode($encodedText)
    {
        try{
            $base64decodedText = Encryption::safe_b64decode($encodedText);
            if (in_array(SELF::$chiperMethod, openssl_get_cipher_methods())) {
                $ivlen = openssl_cipher_iv_length(SELF::$chiperMethod);
                $iv = substr($base64decodedText, 0, $ivlen);
                $sha2len = 32;
                $ciphertext_raw = substr($base64decodedText, $ivlen + $sha2len);

                // Verify HMAC
                $hmac = substr($base64decodedText, $ivlen, $sha2len);
                $calculatedHmac = hash_hmac('sha256', $ciphertext_raw, SELF::$chiperMethod, $as_binary = true);
                if (!hash_equals($hmac, $calculatedHmac)) {
                    die('Invalid Id! 403');
                }

                $plainText = openssl_decrypt(
                    $ciphertext_raw,
                    SELF::$chiperMethod,
                    SELF::$defskey,
                    OPENSSL_RAW_DATA,
                    $iv
                );
            } else {
                $plainText = Encryption::safe_b64decode($encodedText);
            }
            return $plainText;
        }
        catch (\Exception $e) {
            Log::error("Error occurred in Encryption@decode ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            die('Invalid Id! 404');
        }
    }

    public static function dataEncode($value)
    {
        return Encryption::safe_b64encode($value);
    }

    public static function dataDecode($value)
    {
        return Encryption::safe_b64decode($value);
    }

    public static function processDataEncrypt($data)
    {
        if (!$data) {
            return false;
        }
        // get IV length
        $ivlen = openssl_cipher_iv_length(Encryption::$chiperMethod);
        // Generate an initialization vector
        $iv = openssl_random_pseudo_bytes($ivlen);
        // Generate encrypted data
        $encrypted_data = openssl_encrypt($data, Encryption::$chiperMethod, Encryption::$defskey, 0, $iv);

        // put iv into encrypted data to decrypt later
        return Encryption::safe_b64encode($encrypted_data . '::' . $iv);
    }

    public static function processDataDecrypt($data)
    {
        if (!$data) {
            return false;
        }

        $data_array = explode('::', Encryption::safe_b64decode($data), 2);
        // Validation for old data
        if (count($data_array) < 2) {
            return false;
        }
        $encrypted_data = $data_array[0];
        $iv = $data_array[1];
        // Generate decrypted data
        return openssl_decrypt($encrypted_data, Encryption::$chiperMethod, Encryption::$defskey, 0, $iv);
    }
}

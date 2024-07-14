<?php

namespace App\Traits;

use App\Libraries\ImageProcessing;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

trait FileUploadTrait
{
    /**
     * Uploads a file to the server and returns the path where the file has been saved.
     *
     * @param  $file
     * @return string|RedirectResponse
     */
    public function uploadFile($file): string|RedirectResponse
    {
        try {

            if (! $file->isValid()) {
                throw new Exception('Invalid file uploaded.');
            }

            $year = date('Y');
            $month = date('m');
            $year_month = $year.'/'.$month.'/';
            $local_path = config('app.upload_doc_path').$year_month;
            $db_path = uniqid($local_path.time().'_', false).'.'.$file->getClientOriginalExtension();

            // Create directories if they don't exist
            if (! file_exists($local_path)) {
                $year_directory = config('app.upload_doc_path').$year.'/';
                if (! file_exists($year_directory)) {
                    mkdir($year_directory, 0755, true);
                    file_put_contents($year_directory.'index.php', ''); // Create an index.html file
                }
                mkdir($local_path, 0755, true);
                file_put_contents($local_path.'index.php', ''); // Create an index.html file
            }

            $file->move($local_path, $db_path);

            return $db_path;

        } catch (Exception $e) {
            Log::error("Error occurred in FileUploadTrait@uploadFile ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', 'Something went wrong during application data store [FileUpload-101]');

            return Redirect::back()->withInput();
        }
    }

    /**
     * Uploads a file to the server and returns the path where the file has been saved.
     *
     * @param  $file
     * @param  int  $width
     * @param  int  $height
     * @return string|RedirectResponse
     */
    public function uploadBase64File($file, $prefix = 'image', int $width = 300, int $height = 300): string|RedirectResponse
    {
        try {

            if (empty($file)) {
                throw new Exception('Invalid file uploaded.');
            }

            $year = date('Y');
            $month = date('m');
            $year_month = $year.'/'.$month.'/';
            $local_path = config('app.upload_doc_path').$year_month;

            // Create directories if they don't exist
            if (! file_exists($local_path)) {
                mkdir($local_path, 0777, true);
            }
            $year_directory = config('app.upload_doc_path').$year.'/';
            if (! file_exists($year_directory)) {
                mkdir($year_directory, 0755, true);
                file_put_contents($year_directory.'index.html', ''); // Create an index.html file
            }
            $splited = explode(',', substr($file, 5), 2);
            $imageData = $splited[1];

            $base64ResizeImage = base64_encode(ImageProcessing::resizeBase64Image($imageData, $width, $height));
            $base64ResizeImage = base64_decode($base64ResizeImage);
            $picture_name = trim(uniqid($prefix.'-', true).'.'.'jpeg');
            file_put_contents($local_path.$picture_name, $base64ResizeImage);
            $db_path = $local_path.$picture_name;

            return $db_path;

        } catch (Exception $e) {
            Log::error("Error occurred in FileUploadTrait@uploadBase64File ({$e->getFile()}:{$e->getLine()}): {$e->getMessage()}");
            Session::flash('error', 'Something went wrong during application data store [FileUpload-102]');

            return Redirect::back()->withInput();
        }
    }
}

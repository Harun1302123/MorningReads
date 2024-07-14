<?php

// Get real visitor IP behind CloudFlare network
if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
    $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
}
$client = @$_SERVER['HTTP_CLIENT_IP'];
$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
$remote = $_SERVER['REMOTE_ADDR'];


if (filter_var($client, FILTER_VALIDATE_IP)) {
    $ip = $client;
} elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
    $ip = $forward;
} else {
    $ip = $remote;
}
// if above code is not working properly then
/*
if(!empty($_SERVER['HTTP_X_REAL_IP'])){
    $ip=$_SERVER['HTTP_X_REAL_IP'];
}
*/

echo 'HTTP_X_REAL_IP = ' . @$_SERVER['HTTP_X_REAL_IP'] . '<br/><br/>';
echo 'HTTP_CLIENT_IP = ' . @$_SERVER['HTTP_CLIENT_IP'] . '<br/><br/>';
echo 'HTTP_X_FORWARDED_FOR = ' . @$_SERVER['HTTP_X_FORWARDED_FOR'] . '<br/><br/>';
echo 'REMOTE_ADDR = ' . @$_SERVER['REMOTE_ADDR'] . '<br/><br/>';

//dd($request->ip(),$request->getClientIp(), $request->REMOTE_ADDR, $ip,$_SERVER['HTTP_X_REAL_IP']);
return $ip;

<?php
$dir_name = dirname(__FILE__, 3);
require "$dir_name/vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable($dir_name, '.env');
$dotenv->load();



//$mysqli = new mysqli("45.114.84.185","ocpl-dev","OcPLDEV#321","ossp_v3.0", "3042");
//
//// Check connection
//if ($mysqli -> connect_errno) {
//    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
//    exit();
//}
//dd("ok");

$DB_HOST = env('DB_HOST');
$DB_PORT = env('DB_PORT');
$DB_DATABASE = env('DB_DATABASE');
$DB_USERNAME = env('DB_USERNAME');
$DB_PASSWORD = env('DB_PASSWORD');
$mysqli = new mysqli($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_DATABASE, $DB_PORT);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>

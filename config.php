<?php
error_reporting(E_ALL);
session_start();

function debug($arg, $is_die = 1)
{
    echo "<pre>";
    if (is_array($arg) || is_object($arg)) {
        print_r($arg);
    } else {
        echo $arg;
    }
    if ($is_die) {
        echo exit;
    }
}

define('BASE_URL', 'http://localhost:8383/spsoni/products/spitech_crud/');
define('API_BASE_URL', BASE_URL . 'vendor/api/index.php');


define('ROOT_PATH', dirname(__FILE__, 1));
define('OUTPUT_PATH', ROOT_PATH . '/output/');
define('TEMPLATE_PATH', ROOT_PATH . '/template/');

define('HOST', 'localhost');
define('USER', 'root');
define('PASSWORD', '');

//--app
define('APP_DB', 'spitech_crud');
$conn_app = mysqli_connect(HOST, USER, PASSWORD, APP_DB) or die('app mysqli not connected');
$_SESSION['conn_app'] = $conn_app;

// project 
$conn = mysqli_connect(HOST, USER, PASSWORD) or die('project mysqli not connected');
$_SESSION['conn'] = $conn;

$aProject = $conn_app->query('select * from project')->fetch_all(MYSQLI_ASSOC);

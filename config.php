<?php
error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED);
session_start();
date_default_timezone_set("Asia/Calcutta");


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


define('BASE_URL', 'http://localhost/html/inhouse/spsoni_crud/');
define('API_BASE_URL', BASE_URL . 'vendor/api/index.php');


define('ROOT_PATH', dirname(__FILE__, 1));
define('TEMPLATE_PATH', ROOT_PATH . '/template/');
define('INDEX_FIELD_COUNT',4);
define('BASE_FOLDER_NAME', 'Base');


define('HOST', 'localhost');
define('USER', 'root');
define('PASSWORD', '1234');
define('APP_DB', 'spsoni_crud');

//--app

$conn_app = mysqli_connect(HOST, USER, PASSWORD, APP_DB) or die('app mysqli not connected');
$_SESSION['conn_app'] = $conn_app;

// project 
$conn = mysqli_connect(HOST, USER, PASSWORD) or die('project mysqli not connected');
$_SESSION['conn'] = $conn;

$aProject = $conn_app->query('select * from project')->fetch_all(MYSQLI_ASSOC);


$aDatabase = array_column($conn_app->query('SHOW DATABASES')->fetch_all(), 0);

//$excludeTables = ['users', 'user', 'user_action'];

$excludeTables = [];

<?php
error_reporting(E_ALL);
session_start();

define('BASE_URL', 'http://localhost:8383/spsoni/products/spitech_crud/');
define('API_BASE_URL', BASE_URL . 'vendor/api/index.php');


define('ROOT_PATH', dirname(__FILE__, 1));
define('OUTPUT_PATH', ROOT_PATH . '/output/');
define('TEMPLATE_PATH', ROOT_PATH . '/template/');

define('HOST', 'localhost');
define('USER', 'root');
define('PASSWORD', '');

$conn = mysqli_connect(HOST, USER, PASSWORD,);
$aDatabase = array_column($conn->query('SHOW DATABASES')->fetch_all(), 0);

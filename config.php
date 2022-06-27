<?php
error_reporting(E_ALL);

define('HOST', 'localhost');
define('USER', 'root');
define('PASSWORD', '');
define('DATABASE', 'product_billing_ci');

define('ROUTE_PREFIX', 'Admin_');

/* * ***********************************************************
  | CUSTOM GLOBAL FUNCTIONS
 * *********************************************************** */

define('BASE_URL', 'http://localhost:8383/spsoni/spitech_crud/');
define('ROOT_PATH', dirname(__FILE__, 1));


function platform_list()
{
    return [
        "codeigniter-3.x",
        "laravel-8.x"
    ];
}

function selected_select($left, $right)
{
    if ($left == $right) {
        echo "selected";
    }
}

function is_localhost()
{
    return $_SERVER['REMOTE_ADDR'] == '::1' || $_SERVER['REMOTE_ADDR'] == '127.0.0.1';
}

function getAppHost()
{
    $hostname = 'http://';
    if (!empty($_SERVER['HTTPS'])) {
        $hostname = "https://";
    }
    $hostname .= $_SERVER['HTTP_HOST'];
    return $hostname . '/';
}

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

<?php
error_reporting(E_ALL);

if (is_localhost()) {
    $base_url = 'http://localhost:8383/spsoni/products/product_billing_ci/';

    $subdomain = 'demobilling-ci';
    $document_root = dirname(__FILE__, 1);
    define("ENVIRONMENT", "local");
} else {
    $subdomain = array_shift((explode('.', $_SERVER['HTTP_HOST'])));
    $document_root = $_SERVER['DOCUMENT_ROOT'];
    $base_url = getAppHost();
    define("ENVIRONMENT", "prod");
}

define("BASE_URL", $base_url);
define("APP_PATH", $document_root . DIRECTORY_SEPARATOR);
define("CLIENT_DIR_PATH", $document_root . DIRECTORY_SEPARATOR . 'clients_data' . DIRECTORY_SEPARATOR . $subdomain . DIRECTORY_SEPARATOR);
define("UPLOAD_PATH", CLIENT_DIR_PATH);
define("MEDIA_URL", BASE_URL . 'clients_data/' . $subdomain . '/');

$conn_file = CLIENT_DIR_PATH . $subdomain . '.php';
if (!file_exists($conn_file)) {
    echo '<b>File</b> : "' . $conn_file . '" not exist. <br>Create seperate folder for client';
    exit;
}

require_once($conn_file);

/* * ***********************************************************
  | CUSTOM GLOBAL FUNCTIONS
 * *********************************************************** */

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
    if ($arg == "qry") {
        $ci = &get_instance();
        echo $ci->db->last_query();
    } else {
        if (is_array($arg) || is_object($arg)) {
            print_r($arg);
        } else {
            echo $arg;
        }
    }
    if ($is_die) {
        echo exit;
    }
}

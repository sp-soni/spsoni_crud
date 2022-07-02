<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

set_error_handler("error_handler", E_ALL);

function error_handler($error_no, $error)
{
    $data = [
        'error_no' => $error_no,
        'error' => $error,
    ];
    send_response($data);
}

function send_response($data)
{
    http_response_code(200);
    echo json_encode($data);
    exit;
}

include_once 'functions.php';

$action = $_GET['action'];
call_user_func($action);

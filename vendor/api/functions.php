<?php
// include database and object files
include_once dirname(__FILE__, 3) . '/config.php';

function get_tables()
{
    global $conn;
    mysqli_select_db($conn, $_POST['db_name']);
    $data = array_column($conn->query('SHOW TABLES')->fetch_all(), 0);
    send_response($data);
}

<?php
// include database and object files
include_once dirname(__FILE__, 3) . '/config.php';
include_once dirname(__FILE__, 3) . '/vendor/generator.php';

function get_tables()
{
    global $conn, $conn_app;

    $project_id = $_POST['project_id'];
    $sql = 'select * from project where id=' . $project_id;
    $aProjectDetails = $conn_app->query($sql)->fetch_object();
    mysqli_select_db($conn, $aProjectDetails->db_name) or die($aProjectDetails->db_name . ' not connecting');

    $data = array_column($conn->query('SHOW TABLES')->fetch_all(), 0);

    $excludeTables = ['module', 'module_group', 'users', 'user', 'user_action'];

    $data = array_diff($data, $excludeTables);
    send_response($data);
}


function get_modules()
{
    global $conn, $conn_app;

    $project_id = $_POST['project_id'];
    $sql = 'select * from project where id=' . $project_id;
    $aProjectDetails = $conn_app->query($sql)->fetch_object();
    mysqli_select_db($conn, $aProjectDetails->db_name) or die($aProjectDetails->db_name . ' not connecting');


    $sql = 'select id,module from project_module where project_id=' . $project_id;
    $data = $conn_app->query($sql)->fetch_all(MYSQLI_ASSOC);
    send_response($data);
}

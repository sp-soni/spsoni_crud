<?php
// include database and object files
include_once dirname(__FILE__, 3) . '/config.php';

function get_tables()
{
    global $conn, $conn_app;

    $project_id = $_POST['project_id'];
    $sql = 'select * from project where id=' . $project_id;
    $aProjectDetails = $conn_app->query($sql)->fetch_object();

    mysqli_select_db($conn, $aProjectDetails->db_name) or die($aProjectDetails->db_name . ' not connecting');
    $data = array_column($conn->query('SHOW TABLES')->fetch_all(), 0);
    send_response($data);
}

<?php

function show_message()
{
    $html = '';
    if (!empty($_SESSION['success'])) {
        foreach ($_SESSION['success'] as $msg) {
            $html .= '<p class="alert alert-success">' . $msg . '</p>';
        }
    }
    if (!empty($_SESSION['error'])) {
        foreach ($_SESSION['error'] as $msg) {
            $html .= '<p class="alert alert-danger">' . $msg . '</p>';
        }
    }
    unset($_SESSION['error']);
    unset($_SESSION['success']);
    echo $html;
}

function empty_directory($dir)
{
    foreach (glob($dir . '*.*') as $v) {
        unlink($v);
    }
}

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

function prepare_url($base_url, $custom_key)
{
    $params = [];
    foreach ($_GET as $key => $value) {
        $params[$key] = $value;
    }
    $params[$custom_key] = '';
    $url = $base_url . '?' . http_build_query($params);
    return $url;
}


function response($data)
{
    if (is_array($data)) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    } else {
        echo "<b>File created at : </b>" . $data . '<br/>';
    }
}

function table_columns($conn, $table)
{
    $columns = [];
    $sql = "SHOW COLUMNS FROM $table";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $columns[] = $row['Field'];
    }
    $result->free_result();
    return $columns;
}

function table_attributes($conn, $table, $platform)
{
    $exclude_fields = ['id', 'company_id', 'created_at', 'created_by', 'updated_at', 'updated_by'];
    $columns = [];
    //$sql = "SHOW COLUMNS FROM $table";
    $sql = "SELECT *
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE 
        TABLE_SCHEMA = Database()
    AND TABLE_NAME = '" . $table . "' ";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        if (!in_array($row['COLUMN_NAME'], $exclude_fields)) {
            $temp = new stdClass();
            $temp->column_name = $row['COLUMN_NAME'];
            $temp->label = ucwords(str_replace('_', ' ', $row['COLUMN_NAME']));
            $temp->type = $row['DATA_TYPE'];
            $temp->rules = get_validation_rules($row, $platform);
            $columns[] = $temp;
        }
    }
    $result->free_result();
    return $columns;
}

function get_validation_rules($row, $platform)
{
    $rules = [];
    if ($row['IS_NULLABLE'] == 'NO') {
        $rules[] = 'required';
    }
    if ($row['CHARACTER_MAXIMUM_LENGTH'] > 0) {
        if ($platform == 'laravel-8.x') {
            $rules[] = 'max:' . $row['CHARACTER_MAXIMUM_LENGTH'];
        } else if ($platform == 'codeigniter-3.x') {
            $rules[] = 'max_length[' . $row['CHARACTER_MAXIMUM_LENGTH'] . ']';
        }
    }
    return implode('|', $rules);
}

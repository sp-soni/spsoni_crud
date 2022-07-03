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

function create_controller_file($file_path, $template_path, $table, $action)
{

    include_once  $template_path;

    $class_name = str_replace(' ', '', ucwords(str_replace('_', ' ', $table)));
    if (PLATFORM == "laravel-8.x") {
        $controller_class_name = CONTROLLER_PREFIX . $class_name . "Controller";
        $model_class_name = $class_name;
    } else if (PLATFORM == "codeigniter-3.x") {
        $controller_class_name = CONTROLLER_PREFIX . $class_name;
        $model_class_name = $class_name . '_model';
    }

    $file_name = $controller_class_name . '.php';
    $file_path .= $file_name;

    if ($action == "generate") {
        $title = ucwords(str_replace('_', ' ', $table));
        $txt = generate_controller($class_name, $model_class_name, $table, $title);
        $file = fopen($file_path, "w");
        fwrite($file, $txt);
        fclose($file);
    }

    return $file_path;
}

function create_view_file($file_path, $template_path, $table, $action)
{

    include_once  $template_path . 'index.php';
    include_once  $template_path . 'form.php';
    $files = [];

    $parent_class_name = str_replace(' ', '', ucwords(str_replace('_', ' ', $table)));
    if (PLATFORM == "laravel-8.x") {
        $class_name = $parent_class_name;
    } else if (PLATFORM == "codeigniter-3.x") {
        $class_name = $parent_class_name . '_model';
    }

    //--index.php
    $file_name = 'index.php';
    $index_path = $file_path . $file_name;
    $files[$table][] = $index_path;
    $txt = generate_index($class_name, $table);

    if ($action == "generate") {
        $file = fopen($index_path, "w");
        fwrite($file, $txt);
        fclose($file);
    }

    //--form.php
    $file_name = 'form.php';
    $form_path = $file_path . $file_name;
    $files[$table][] = $form_path;
    $txt = generate_form($class_name, $table);

    if ($action == "generate") {
        $file = fopen($form_path, "w");
        fwrite($file, $txt);
        fclose($file);
    }

    return $files;
}

function create_model_file($file_path, $template_path, $table, $action)
{

    include_once  $template_path;

    $parent_class_name = str_replace(' ', '', ucwords(str_replace('_', ' ', $table)));
    if (PLATFORM == "laravel-8.x") {
        $class_name = $parent_class_name;
    } else if (PLATFORM == "codeigniter-3.x") {
        $class_name = $parent_class_name . '_model';
    }
    $file_name = $class_name . '.php';
    $file_path .= $file_name;

    $txt = generate_model($class_name, $parent_class_name);

    if ($action == "generate") {
        $file = fopen($file_path, "w");
        fwrite($file, $txt);
        fclose($file);
    }
    return $file_path;
}

function create_base_model_file($file_path, $template_path, $table, $action, $conn)
{

    include_once  $template_path;

    $class_name = BASE_MODEL_PREFIX . str_replace(' ', '', ucwords(str_replace('_', ' ', $table)));
    $file_name =  $class_name . '.php';
    $file_path .= $file_name;

    $columns = table_columns($conn, $table);
    $table_attributes = table_attributes($conn, $table, PLATFORM);
    $txt = generate_base_model($class_name, $columns, $table, $table_attributes);

    if ($action == "generate") {
        $file = fopen($file_path, "w");
        fwrite($file, $txt);
        fclose($file);
    }

    return $file_path;
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

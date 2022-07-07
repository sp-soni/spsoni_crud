<?php

function platform_list()
{
    return [
        'codeigniter-3.x',
        'laravel-8.x'
    ];
}

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

function create_controller_file($conn, $dir_path, $template_path, $table, $action)
{

    include_once  $template_path;

    $class_name = str_replace(' ', '', ucwords(str_replace('_', ' ', $table)));
    $controller_class_name = $class_name . "Controller";
    $model_class_name = $class_name;

    $file_name = $controller_class_name . '.php';
    $file_path = $dir_path . $file_name;

    $form_attributes = table_attributes($conn, $table, PLATFORM);

    if ($action == "generate") {
        $title = ucwords(str_replace('_', ' ', $table));
        $txt = generate_controller($class_name, $model_class_name, $table, $title, $form_attributes);
        create_backup($dir_path, $file_name);
        $file = fopen($file_path, "w");
        fwrite($file, $txt);
        fclose($file);
    }

    return $file_path;
}

function create_backup($dir_path, $file_name)
{
    $path_parts = pathinfo($file_name);
    //debug($path_parts);
    $source = $dir_path . $file_name;
    if (file_exists($source)) { // keep backup
        $backup_dir = $dir_path . '_bkp';
        if (!file_exists($backup_dir)) {
            mkdir($backup_dir);
        }
        $bkp_filename = $path_parts['filename'] . '_' . date('d-M-Y-h-i-s-a') . '.' . $path_parts['extension'];
        $destination = $backup_dir . DIRECTORY_SEPARATOR . $bkp_filename;
        copy($source, $destination);
    }
}

function create_view_file($conn, $dir_path, $template_path, $table, $action)
{

    include_once  $template_path . 'index.php';
    include_once  $template_path . 'form.php';

    $module_url = strtolower(MODULE) . '/' . $table;

    $form_attributes = table_attributes($conn, $table, PLATFORM);

    //--index.php
    $file_name = 'index.php';
    if (PLATFORM == "laravel-8.x") {
        $file_name = 'index.blade.php';
    }
    $index_path = $dir_path . $file_name;
    $files[0] = $index_path;
    $txt = generate_index($form_attributes, $module_url);

    if ($action == "generate") {
        create_backup($dir_path, $file_name);
        $file = fopen($index_path, "w");
        fwrite($file, $txt);
        fclose($file);
    }

    //--form.php
    $file_name = 'form.php';
    if (PLATFORM == "laravel-8.x") {
        $file_name = 'add.blade.php';
    }
    $form_path = $dir_path . $file_name;
    $files[1] = $form_path;
    $txt = generate_form($form_attributes, $module_url);

    if ($action == "generate") {
        create_backup($dir_path, $file_name);
        $file = fopen($form_path, "w");
        fwrite($file, $txt);
        fclose($file);
    }

    return $files;
}

function create_model_file($dir_path, $template_path, $table, $action)
{

    include_once  $template_path;


    $class_name = str_replace(' ', '', ucwords(str_replace('_', ' ', $table)));

    $file_name = $class_name . '.php';
    $file_path = $dir_path . $file_name;

    $table_attributes = table_attributes($_SESSION['conn'], $table, PLATFORM);
    $txt = generate_model($class_name, $table, $class_name . BASE_MODEL_SUFFIX, $table_attributes);

    if ($action == "generate") {
        create_backup($dir_path, $file_name);
        $file = fopen($file_path, "w");
        fwrite($file, $txt);
        fclose($file);
    }
    return $file_path;
}

function create_base_model_file($dir_path, $template_path, $table, $action, $conn)
{

    include_once  $template_path;

    $class_name =  str_replace(' ', '', ucwords(str_replace('_', ' ', $table))) . BASE_MODEL_SUFFIX;
    $file_name =  $class_name . '.php';
    $file_path = $dir_path . $file_name;

    $columns = table_columns($conn, $table);
    $table_attributes = table_attributes($conn, $table, PLATFORM);
    $txt = generate_base_model($class_name, $columns, $table, $table_attributes);

    if ($action == "generate") {
        create_backup($dir_path, $file_name);
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
    AND TABLE_NAME = '" . $table . "' ORDER BY COLUMN_NAME ASC";
    //debug($sql);
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        if (!in_array($row['COLUMN_NAME'], $exclude_fields)) {
            $temp = new stdClass();
            $temp->column_name = $row['COLUMN_NAME'];
            $temp->column_type = $row['COLUMN_TYPE'];
            $temp->label = ucwords(str_replace('_', ' ', $row['COLUMN_NAME']));
            $temp->type = $row['DATA_TYPE'];
            $temp->key = $row['COLUMN_KEY'];
            $temp->comment = $row['COLUMN_COMMENT'];  // used for custom validation like type=email
            $temp->rules = get_validation_rules($row, $platform, $table);
            // $columns[] = $row;
            $columns[] = $temp;
        }
    }
    $result->free_result();
    //debug($columns);
    return $columns;
}

function get_validation_rules($row, $platform, $table_name)
{
    $common_rules = [];
    $laravel8_rules = [];
    $codeignitor3_rules = [];

    // required
    if ($row['IS_NULLABLE'] == 'NO') {
        $common_rules[] = 'required';
    }

    // platform specific rules
    if ($platform == 'laravel-8.x') {
        $laravel8_rules = laravel8_validation_rules($row, $table_name);
    } else if ($platform == 'codeigniter-3.x') {
        $codeignitor3_rules = codeignitor3_validation_rules($row, $table_name);
    }

    $rules = array_merge($common_rules, $laravel8_rules, $codeignitor3_rules);
    return implode('|', $rules);
}


function laravel8_validation_rules($row, $table_name)
{
    //Unique
    if ($row['COLUMN_KEY'] == "UNI") {
        $rules[] = 'unique:' . $table_name;
    }

    //email
    $emailType = ['email', 'email_address', 'email_id'];
    if (in_array($row['COLUMN_COMMENT'], $emailType)) {
        $rules[] = 'email';
    }

    //--max length
    if ($row['CHARACTER_MAXIMUM_LENGTH'] > 0 && $row['CHARACTER_MAXIMUM_LENGTH'] < 400) {
        $rules[] = 'max:' . $row['CHARACTER_MAXIMUM_LENGTH'];
    }

    return $rules;
}

function codeignitor3_validation_rules($row, $table_name)
{
    //trim|xss_clean
    $rules[] = 'trim';
    $rules[] = 'xss_clean';

    //email & phone & IP
    $emailType = ['email', 'email_address', 'email_id'];
    $phoneType = ['mobile', 'mobile_number', 'phone', 'contact'];

    if (in_array($row['COLUMN_COMMENT'], $emailType)) {
        $rules[] = 'valid_unique_email[' . $table_name . ',' . $row['COLUMN_NAME'] . ',id,\'.$pk.\']';
    } else if (in_array($row['COLUMN_COMMENT'], $phoneType)) {
        $rules[] = 'valid_unique_mobile[' . $table_name . ',' . $row['COLUMN_NAME'] . ',id,\'.$pk.\']';
    } else if (strtolower($row['COLUMN_COMMENT']) == 'ip') {
        $rules[] = 'valid_ip';
    }

    //--max length
    if ($row['CHARACTER_MAXIMUM_LENGTH'] > 0 && $row['CHARACTER_MAXIMUM_LENGTH'] < 400) {
        $rules[] = 'max_length[' . $row['CHARACTER_MAXIMUM_LENGTH'] . ']';
    }

    //--decimal/integer
    if ($row['DATA_TYPE'] == 'decimal') {
        $rules[] = 'decimal';
    } else if ($row['DATA_TYPE'] == 'int') {
        $rules[] = 'integer';
    }

    //valid_ip
    if ($row['COLUMN_COMMENT'] == 'ip') {
        $rules[] = 'valid_ip';
    }

    //Unique
    if ($row['COLUMN_KEY'] == "UNI") {
        $rules[] = 'is_unique[' . $table_name . '.' . $row['COLUMN_NAME'] . ']';
    }

    return $rules;
}

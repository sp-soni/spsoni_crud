<?php

function action_generate_routes($aTable, $conn, $platform)
{
    $file_path = $platform . '/output/routes.php';
    include_once  ROOT_PATH . '/' . $platform . '/template/routes.php';
    $route_string = '';
    $count = 1;
    foreach ($aTable as $table) {
        $route_string .= "'" . strtolower(ROUTE_PREFIX) . $table . "',";
        if ($count % 3 == 0) {
            $route_string .= PHP_EOL;
        }
        $count++;
    }
    $txt = generate($route_string);
    $file = fopen($file_path, "w");
    fwrite($file, $txt);
    fclose($file);
    response($file_path);
}

function action_generate_views($aTable, $conn, $platform)
{
    $path = ROOT_PATH . '/' . $platform . '/output/views/';
    if (!file_exists($path)) {
        mkdir($path);
    }
    foreach ($aTable as $table) {

        $folder_name = $table;
        $file_path = $path . $folder_name;
        if (!file_exists($file_path)) {
            mkdir($file_path);
        }

        $text = file_get_contents("template/views/index.php");
        $file = fopen($file_path . '/index.php', "w");
        fwrite($file, $text);
        fclose($file);

        $text = file_get_contents("template/views/form.php");
        $file = fopen($file_path . '/form.php', "w");
        fwrite($file, $text);
        fclose($file);
        response($file_path);
    }
}


function action_generate_controllers($aTable, $conn, $platform)
{
    $path = ROOT_PATH . '/' . $platform . '/output/controllers/';
    if (!file_exists($path)) {
        mkdir($path);
    }

    foreach ($aTable as $table) {

        $class_name = ROUTE_PREFIX . $table;
        $file_name = $class_name . '.php';
        $file_path = $path . $file_name;

        $model_class = str_replace(' ', '', ucwords(str_replace('_', ' ', $table))) . '_model';
        $title = ucwords(str_replace('_', ' ', $table));

        include_once  ROOT_PATH . '/' . $platform . '/template/controller.php';
        $txt = generate($class_name, $model_class, $table, $title);

        $file = fopen($file_path, "w");
        fwrite($file, $txt);
        fclose($file);
        response($file_path);
    }
}

function action_generate_base_models($conn, $tables, $platform, $action = "preview")
{

    $path = ROOT_PATH . '/' . $platform . '/output/models/';
    if (!file_exists($path)) {
        mkdir($path);
    }
    $path .= '_base/';
    if (!file_exists($path)) {
        mkdir($path);
    }
    empty_directory($path);
    $files = [];

    if (!empty($tables) && is_array($tables)) {
        foreach ($tables as $table) {
            $files[] = create_file($conn, $path, $platform, $table, $action);
        }
    } else {
        $files[] = create_file($conn, $path, $platform, $tables, $action);
    }

    return $files;
}

function create_file($conn, $path, $platform, $table, $action)
{
    $class_name = BASE_MODEL_PREFIX . str_replace(' ', '', ucwords(str_replace('_', ' ', $table)));
    $file_name =  $class_name . '.php';
    $file_path = $path . $file_name;

    include_once  ROOT_PATH . '/' . $platform . '/template/_base/model.php';

    $columns = table_columns($conn, $table);
    $table_attributes = table_attributes($conn, $table, $platform);
    $txt = generate($class_name, $columns, $table, $table_attributes);

    if ($action == "generate") {
        $file = fopen($file_path, "w");
        fwrite($file, $txt);
        fclose($file);
    }
    return $file_path;
}

function action_generate_models($aTable, $conn, $platform)
{
    $path = ROOT_PATH . '/' . $platform . '/output/models/';
    if (!file_exists($path)) {
        mkdir($path);
    }
    foreach ($aTable as $table) {

        $parent_class_name = str_replace(' ', '', ucwords(str_replace('_', ' ', $table)));
        $class_name = $parent_class_name . '_model';
        $file_name = $class_name . '.php';
        $file_path = $path . $file_name;

        include_once  ROOT_PATH . '/' . $platform . '/template/model.php';

        $txt = generate($class_name, $parent_class_name);

        $file = fopen($file_path, "w");
        fwrite($file, $txt);
        fclose($file);
        response($file_path);
    }
}

function action_migrate($aTable, $conn)
{

    $migration_queries = [];
    foreach ($aTable as $table) {

        $sql = "CALL drop_column_if_exists('" . $table . "', 'edited_by')";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $migration_queries[] = $sql;

        $sql = "CALL drop_column_if_exists('" . $table . "', 'created_date')";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $migration_queries[] = $sql;

        $sql = "CALL drop_column_if_exists('" . $table . "', 'edited_date')";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $migration_queries[] = $sql;

        $sql = "CALL drop_column_if_exists('" . $table . "', 'created_details')";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $migration_queries[] = $sql;

        $sql = "CALL drop_column_if_exists('" . $table . "', 'edited_details')";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $migration_queries[] = $sql;

        $sql = "CALL add_column_if_not_exists('" . $table . "', 'created_by', 'TINYINT(1) NOT NULL DEFAULT 0')";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $migration_queries[] = $sql;

        $sql = "CALL add_column_if_not_exists('" . $table . "', 'updated_by', 'TINYINT(1) NOT NULL DEFAULT 0')";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $migration_queries[] = $sql;

        $sql = "CALL add_column_if_not_exists('" . $table . "', 'created_at', 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP')";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $migration_queries[] = $sql;

        $sql = "CALL add_column_if_not_exists('" . $table . "', 'updated_at', 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP')";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $migration_queries[] = $sql;

        //---adding company id for multiple company
        $except = [
            'module', 'module_group', 'site_settings', 'user', 'message_templates',
            'user_designation', 'user_compny', 'user_permission', 'setting_company'
        ];
        if (!in_array($table, $except)) {
            $sql = "CALL add_column_if_not_exists('" . $table . "', 'company_id', 'INT DEFAULT 1')";
            mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $migration_queries[] = $sql;
        }
    }
    response($migration_queries);
}

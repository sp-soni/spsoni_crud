<?php

function action_generate_crud($conn, $tables, $platform, $action = "preview")
{

    $files = [
        'Controllers' => [],
        'BaseModels' => [],
        'Models' => [],
        'Views' => [],
        'Routes' => [],
    ];

    $files['Controllers'] = action_generate_controllers($tables, $platform, "preview");
    $files['BaseModels'] = action_generate_base_models($conn, $tables, $platform, "preview");
    $files['Models'] = action_generate_models($tables, $platform, "preview");
    $files['Views'] = action_generate_base_models($conn, $tables, $platform, "preview");
    $files['Routes'] = action_generate_routes($tables, $platform, "preview");

    return $files;
}

function action_generate_models($tables, $platform, $action = "preview")
{
    $path = ROOT_PATH . '/' . $platform;

    $files = [];

    if (!empty($tables) && is_array($tables)) {
        foreach ($tables as $table) {
            $files[] = create_model_file($path, $table, $action);
        }
    } else {
        $files[] = create_model_file($path, $tables, $action);
    }

    return $files;
}

function action_generate_controllers($tables, $platform, $action = "preview")
{
    $files = [];
    $path = ROOT_PATH . '/' . $platform;
    if (!file_exists($path)) {
        mkdir($path);
    }

    if (!empty($tables) && is_array($tables)) {
        foreach ($tables as $table) {
            $files[] = create_controller_file($path, $table, $platform, $action);
        }
    } else {
        $files[] = create_controller_file($path, $tables, $platform, $action);
    }
    return $files;
}


function action_generate_routes($aTable, $platform, $action = "preview")
{
    $path = ROOT_PATH . '/' . $platform . '/output/routes.php';
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
    if ($action == "generate") {
        $txt = generate($route_string);
        $file = fopen($path, "w");
        fwrite($file, $txt);
        fclose($file);
    }
    $files[] = $path;
    return $files;
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
            $files[] = create_base_model_file($conn, $path, $platform, $table, $action);
        }
    } else {
        $files[] = create_base_model_file($conn, $path, $platform, $tables, $action);
    }

    return $files;
}





function action_migrate($conn, $aTable)
{

    $migration_queries = [];
    foreach ($aTable as $table) {

        // Drop Column
        $sql = "CALL drop_column_if_exists('" . $table . "', 'edited_by')";
        $migration_queries[] = $sql;

        $sql = "CALL drop_column_if_exists('" . $table . "', 'created_date')";
        $migration_queries[] = $sql;

        $sql = "CALL drop_column_if_exists('" . $table . "', 'edited_date')";
        $migration_queries[] = $sql;

        $sql = "CALL drop_column_if_exists('" . $table . "', 'created_details')";
        $migration_queries[] = $sql;

        $sql = "CALL drop_column_if_exists('" . $table . "', 'edited_details')";
        $migration_queries[] = $sql;

        $sql = "CALL drop_column_if_exists('" . $table . "', 'company_id')";
        $migration_queries[] = $sql;

        // Add Column
        $sql = "CALL add_column_if_not_exists('" . $table . "', 'created_by', 'TINYINT(1) NOT NULL DEFAULT 0')";
        $migration_queries[] = $sql;

        $sql = "CALL add_column_if_not_exists('" . $table . "', 'updated_by', 'TINYINT(1) NOT NULL DEFAULT 0')";
        $migration_queries[] = $sql;

        $sql = "CALL add_column_if_not_exists('" . $table . "', 'created_at', 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP')";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $migration_queries[] = $sql;

        $sql = "CALL add_column_if_not_exists('" . $table . "', 'updated_at', 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP')";
        $migration_queries[] = $sql;

        //---adding company id for multiple company
        // $except = [
        //     'module', 'module_group', 'site_settings', 'user', 'message_templates',
        //     'user_designation', 'user_compny', 'user_permission', 'setting_company'
        // ];
        // if (!in_array($table, $except)) {
        //     $sql = "CALL add_column_if_not_exists('" . $table . "', 'company_id', 'INT DEFAULT 1')";
        //     $migration_queries[] = $sql;
        // }
    }
    return $migration_queries;
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

<?php

function action_generate_crud($conn, $tables, $action, $choice)
{

    $files = [];
    if (in_array('all', $choice)) {
        $files['controller'] = action_generate_controllers($conn, $tables, $action);
        $files['Base Model'] = action_generate_base_models($conn, $tables, $action);
        $files['model'] = action_generate_models($conn, $tables, $action);
        $files['view'] = action_generate_views($conn, $tables, $action);
    } else {
        if (in_array('controller', $choice)) {
            $files['controller'] = action_generate_controllers($conn, $tables, $action);
        }
        if (in_array('base_model', $choice)) {
            $files['Base Model'] = action_generate_base_models($conn, $tables, $action);
        }
        if (in_array('model', $choice)) {
            $files['model'] = action_generate_models($conn, $tables, $action);
        }
        if (in_array('view', $choice)) {
            $files['view'] = action_generate_views($conn, $tables, $action);
        }
    }

    return $files;
}

function action_generate_views($conn, $tables, $action = "preview")
{
    $path = VIEWS_DIR;
    if (!file_exists($path)) {
        mkdir($path);
    }

    $template_path = TEMPLATE_PATH . PLATFORM . '/views/';

    $file_path = $path . $tables . '/';
    if (!file_exists($file_path)) {
        mkdir($file_path);
    }

    return create_view_file($conn, $file_path, $template_path, $tables, $action);
}

function action_generate_models($conn, $tables, $action = "preview")
{
    $path = MODELS_DIR;
    if (!file_exists($path)) {
        mkdir($path);
    }
    $file_path = $path;
    $template_path = TEMPLATE_PATH . PLATFORM . '/models/model.php';

    return create_model_file($file_path, $template_path, $tables, $action);
}

function action_generate_controllers($conn, $tables, $action = "preview")
{
    $path = CONTROLLERS_DIR;
    if (!file_exists($path)) {
        mkdir($path);
    }

    $file_path = $path;
    $template_path = TEMPLATE_PATH . PLATFORM . '/controller.php';

    return create_controller_file($conn, $file_path, $template_path, $tables, $action);
}


function action_generate_routes($conn, $aTable, $action = "preview")
{
    $files = [];

    $path = OUTPUT_PATH;
    if (!file_exists($path)) {
        mkdir($path);
    }

    $path .= 'routes/';
    if (!file_exists($path)) {
        mkdir($path);
    }
    //empty_directory($path);

    if (PLATFORM == 'laravel-8.x') {
        $file_name = 'web.php';
    } else if (PLATFORM == 'codeigniter-3.x') {
        $file_name = 'routes.php';
    }
    $file_path = $path . $file_name;
    $template_path = TEMPLATE_PATH . PLATFORM . '/' . $file_name;
    include $template_path;


    if ($action == "generate") {
        $txt = generate_routes($aTable);
        $file = fopen($file_path, "w");
        fwrite($file, $txt);
        fclose($file);
    }
    $files[] = $file_path;
    return $files;
}

function action_generate_base_models($conn, $tables, $action = "preview")
{

    $path = MODELS_DIR;
    if (!file_exists($path)) {
        mkdir($path);
    }

    $path .= BASE_FOLDER_NAME.'/';
    if (!file_exists($path)) {
        mkdir($path);
    }

    $file_path = $path;
    $template_path = TEMPLATE_PATH . PLATFORM . '/models/base_model.php';

    return create_base_model_file($file_path, $template_path, $tables, $action, $conn);
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
        $except = [
            'module', 'module_group', 'site_settings', 'user', 'message_templates',
            'user_designation', 'user_compny', 'user_permission', 'setting_company'
        ];
        if (!in_array($table, $except)) {
            $sql = "CALL add_column_if_not_exists('" . $table . "', 'company_id', 'INT DEFAULT 1')";
            $migration_queries[] = $sql;
        }
    }
    return $migration_queries;
}

<?php

function action_generate_crud($conn, $tables, $action = "preview")
{

    $files = [
        'Controllers' => [],
        'BaseModels' => [],
        'Models' => [],
        'Views' => [],
    ];

    $files['Controllers'] = action_generate_controllers($conn, $tables, $action);
    $files['BaseModels'] = action_generate_base_models($conn, $tables, $action);
    $files['Models'] = action_generate_models($conn, $tables, $action);
    $files['Views'] = action_generate_views($conn, $tables, $action);
    if (is_array($tables)) {
        $files['Routes'] = action_generate_routes($conn, $tables, $action);
    } else {
        $files['Routes'] = '<div class="required">For single table routes can\'t be generated</div>';
    }
    return $files;
}

function action_generate_views($conn, $tables, $action = "preview")
{
    $files = [];

    $path = OUTPUT_PATH;
    if (!file_exists($path)) {
        mkdir($path);
    }
    $path .= 'views/';
    if (!file_exists($path)) {
        mkdir($path);
    }
    empty_directory($path);


    $template_path = TEMPLATE_PATH . PLATFORM . '/views/';

    if (!empty($tables) && is_array($tables)) {
        foreach ($tables as $table) {
            $file_path = $path . $table . '/';
            if (!file_exists($file_path)) {
                mkdir($file_path);
            }
            $files[] = create_view_file($conn, $file_path, $template_path, $table, $action);
        }
    } else {
        $file_path = $path . $tables . '/';
        if (!file_exists($file_path)) {
            mkdir($file_path);
        }
        $files[] = create_view_file($conn, $file_path, $template_path, $tables, $action);
    }

    return $files;
}

function action_generate_models($conn, $tables, $action = "preview")
{
    $files = [];

    $path = OUTPUT_PATH;
    if (!file_exists($path)) {
        mkdir($path);
    }
    $path .= 'models/';
    if (!file_exists($path)) {
        mkdir($path);
    }
    empty_directory($path);

    $file_path = $path;
    $template_path = TEMPLATE_PATH . PLATFORM . '/models/model.php';

    if (!empty($tables) && is_array($tables)) {
        foreach ($tables as $table) {
            $files[] = create_model_file($file_path, $template_path, $table, $action);
        }
    } else {
        $files[] = create_model_file($file_path, $template_path, $tables, $action);
    }

    return $files;
}

function action_generate_controllers($conn, $tables, $action = "preview")
{
    $files = [];

    $path = OUTPUT_PATH;
    if (!file_exists($path)) {
        mkdir($path);
    }
    $path .= 'controllers/';
    if (!file_exists($path)) {
        mkdir($path);
    }
    empty_directory($path);

    $file_path = $path;
    $template_path = TEMPLATE_PATH . PLATFORM . '/controller.php';

    if (!empty($tables) && is_array($tables)) {
        foreach ($tables as $table) {
            $files[] = create_controller_file($conn, $file_path, $template_path, $table, $action);
        }
    } else {
        $files[] = create_controller_file($conn, $file_path, $template_path, $tables, $action);
    }
    return $files;
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
    empty_directory($path);

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

    $files = [];

    $path = OUTPUT_PATH;
    if (!file_exists($path)) {
        mkdir($path);
    }
    $path .= 'models/';
    if (!file_exists($path)) {
        mkdir($path);
    }
    $path .= '_base/';
    if (!file_exists($path)) {
        mkdir($path);
    }
    empty_directory($path);

    $file_path = $path;
    $template_path = TEMPLATE_PATH . PLATFORM . '/models/base_model.php';
    if (!empty($tables) && is_array($tables)) {
        foreach ($tables as $table) {
            $files[] = create_base_model_file($file_path, $template_path, $table, $action, $conn);
        }
    } else {
        $files[] = create_base_model_file($file_path, $template_path, $tables, $action, $conn);
    }

    return $files;
}


function action_migrate($conn, $aTable)
{

    $migration_queries = [];
    foreach ($aTable as $table) {

        // Drop Column

        $sql = "CALL drop_column_if_exists('" . $table . "', 'sequence_no')";
        $migration_queries[] = $sql;

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

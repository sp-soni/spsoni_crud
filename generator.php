<?php

function generate_route_file($aTable)
{
    $file_path = 'output/routes.php';
    include_once 'template/routes.php';
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
    echo "Route File created at : " . $file_path . '<br/>';
}

function generate_view_file($aTable, $conn)
{
    $path = 'output/views/';
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
    }
}


function generate_controller_file($aTable)
{
    $path = 'output/controllers/';
    if (!file_exists($path)) {
        mkdir($path);
    }

    foreach ($aTable as $table) {

        $class_name = ROUTE_PREFIX . $table;
        $file_name = $class_name . '.php';
        $file_path = $path . $file_name;

        include_once 'template/controller.php';
        $txt = generate($class_name);

        $file = fopen($file_path, "w");
        fwrite($file, $txt);
        fclose($file);
        echo "File created at :" . $file_path . '<br/>';
    }
}

function generate_base_model_file($aTable, $conn)
{
    $path = 'output/models/';
    if (!file_exists($path)) {
        mkdir($path);
    }
    $path .= '_base/';
    if (!file_exists($path)) {
        mkdir($path);
    }
    foreach ($aTable as $table) {

        $class_name = str_replace(' ', '', ucwords(str_replace('_', ' ', $table)));
        $file_name = $class_name . '.php';
        $file_path = $path . $file_name;

        include_once 'template/_base/model.php';

        $columns = table_columns($conn, $table);
        $txt = generate($class_name, $columns, $table);

        $file = fopen($file_path, "w");
        fwrite($file, $txt);
        fclose($file);
        echo "File created at :" . $file_path . '<br/>';
    }
}

function generate_model_file($aTable, $conn)
{
    $path = 'output/models/';
    if (!file_exists($path)) {
        mkdir($path);
    }
    foreach ($aTable as $table) {

        $parent_class_name = str_replace(' ', '', ucwords(str_replace('_', ' ', $table)));
        $class_name = $parent_class_name . '_model';
        $file_name = $class_name . '.php';
        $file_path = $path . $file_name;

        include_once 'template/model.php';

        $txt = generate($class_name, $parent_class_name);

        $file = fopen($file_path, "w");
        fwrite($file, $txt);
        fclose($file);
        echo "File created at :" . $file_path . '<br/>';
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

function migrate($aTable, $conn)
{
    foreach ($aTable as $table) {

        $sql = "CALL drop_column_if_exists('" . $table . "', 'edited_by')";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));

        $sql = "CALL drop_column_if_exists('" . $table . "', 'created_date')";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));

        $sql = "CALL drop_column_if_exists('" . $table . "', 'edited_date')";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));

        $sql = "CALL drop_column_if_exists('" . $table . "', 'created_details')";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));

        $sql = "CALL drop_column_if_exists('" . $table . "', 'edited_details')";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));

        $sql = "CALL add_column_if_not_exists('" . $table . "', 'created_by', 'TINYINT(1) NOT NULL DEFAULT 0')";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));

        $sql = "CALL add_column_if_not_exists('" . $table . "', 'updated_by', 'TINYINT(1) NOT NULL DEFAULT 0')";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));

        $sql = "CALL add_column_if_not_exists('" . $table . "', 'created_at', 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP')";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));

        $sql = "CALL add_column_if_not_exists('" . $table . "', 'updated_at', 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP')";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
    }
}

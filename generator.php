<?php
function generate_controller_file($aTable, $conn)
{
    $path = 'output/controllers/';
    foreach ($aTable as $table) {

        $class_name = str_replace(' ', '', ucwords(str_replace('_', ' ', $table)));
        $file_name = $class_name . '.php';
        $file_path = $path . $file_name;

        include_once 'template/controller.php';

        $columns = table_columns($conn, $table);
        $txt = generate($class_name, $columns, $table);

        $file = fopen($file_path, "w");
        fwrite($file, $txt);
        fclose($file);
        echo "File created at :" . $file_path . '<br/>';
    }
}

function generate_base_model_file($aTable, $conn)
{
    $path = 'output/models/_base/';
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

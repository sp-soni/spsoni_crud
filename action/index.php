<?php
require_once dirname(__FILE__, 2) . '/layout/header.php';
?>
<?php
$platform = '';
$db_name = '';
$base_model_prefix = '';
$controller_prefix = '';
$table_name = '';
$aTable = [];
$route_prefix = '';
if (!empty($_POST)) {

    $platform = $_POST['platform'];
    $db_name = $_POST['db_name'];
    $base_model_prefix = $_POST['base_model_prefix'];
    $controller_prefix = $_POST['controller_prefix'];
    $table_name = $_POST['table_name'];
    $route_prefix = $_POST['route_prefix'];

    $error = [];
    if (empty($_POST['platform'])) {
        $error[] = 'Platform is required';
    }
    if (empty($_POST['db_name'])) {
        $error[] = 'Database is required';
    }
    $_SESSION['error'] = $error;

    define('BASE_MODEL_PREFIX', $base_model_prefix);
    define('CONTROLLER_PREFIX', $controller_prefix);
    define('ROUTE_PREFIX', $route_prefix);
    //---needed variables
    if (empty($error)) {
        define('PLATFORM', $platform);
        define('DATABASE', $db_name);
        mysqli_select_db($conn, DATABASE);
        $aTable = array_column($conn->query('SHOW TABLES')->fetch_all(), 0);
    }
}
?>
<div class="row">

    <?php show_message(); ?>
    <form method="post">
        <div class="col-md-8">
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-parimary">
                        <th colspan="2">CRUD Generator</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width="30%"><span class="required">Platform (*)</span></td>
                        <td width="70%">
                            <select class="form-control" name="platform">
                                <option value="">--Select--</option>
                                <?php
                                $aPlatform = platform_list();
                                foreach ($aPlatform as $row) { ?>
                                    <option value="<?php echo $row; ?>" <?php selected_select($row, $platform) ?>><?php echo $row; ?></option>

                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">Database (*)</span></td>
                        <td>
                            <select class="form-control" name="db_name" id="db_name" onchange="get_tables(this.value,'table_name')">
                                <option value="">--Select--</option>
                                <?php
                                foreach ($aDatabase as $row) { ?>
                                    <option value="<?php echo $row; ?>" <?php selected_select($row, $db_name) ?>><?php echo $row; ?></option>

                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="required">Table</span></td>
                        <td>
                            <select class="form-control" name="table_name" id="table_name">
                                <option value="">--Select--</option>
                                <?php
                                foreach ($aTable as $row) { ?>
                                    <option value="<?php echo $row; ?>" <?php selected_select($row, $table_name) ?>><?php echo $row; ?></option>

                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Base Model Class Prefix</td>
                        <td>
                            <input type="text" class="form-control" name="base_model_prefix" id="base_model_prefix" value="<?php echo $base_model_prefix; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Controller Class Prefix</td>
                        <td>
                            <input type="text" class="form-control" name="controller_prefix" id="controller_prefix" value="<?php echo $controller_prefix; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Route Prefix</td>
                        <td>
                            <input type="text" class="form-control" name="route_prefix" id="route_prefix" value="<?php echo $route_prefix; ?>">
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>

                        </td>
                        <td>
                            <input type="submit" name="preview" value="Preview" class="btn btn-success">
                        </td>
                    </tr>
                </tfoot>
            </table>

        </div>
        <div class="col-md-8">

            <?php
            if (!empty($_POST)) {
                if (empty($error)) {
                    if (!empty($table_name)) {
                        $aTable = $table_name;
                    }
                    if (!empty($_POST['submit'])) {
                        // generate code
                        $files = action_generate_crud($conn, $aTable, $action = 'generate');
                    } else {
                        // preview code
                        $files = action_generate_crud($conn, $aTable, $action = 'preview');
                    }
            ?>
                    <h3>Output</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Files</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($files as $file) {
                            ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo debug($file, 0); ?></td>
                                </tr>
                            <?php }  ?>
                        </tbody>
                        <?php
                        if ($i > 1) { ?>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td> <input type="submit" name="submit" value="Generate" class="btn btn-success"></td>
                                </tr>
                            </tfoot>
                        <?php
                        }
                        ?>
                    </table>
            <?php
                }
            }
            ?>
        </div>
    </form>

</div>
<?php
require_once dirname(__FILE__, 2) . '/layout/footer.php';
?>
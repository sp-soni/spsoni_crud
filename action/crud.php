<?php
require_once dirname(__FILE__, 2) . '/layout/header.php';

?>
<?php
$platform = '';
$project_id = '';
$base_model_prefix = '';
$controller_prefix = '';
$table_name = '';
$aTable = [];
$route_prefix = '';
$route_path = '';

$controller_path = '';
$model_path = '';
$views_path = '';
if (!empty($_POST)) {

    $project_id = $_POST['project_id'];
    $table_name = $_POST['table_name'];

    $error = [];
    if (!empty($project_id)) {
        $sql = 'select * from project where id=' . $project_id;
        $aProjectDetails = $conn_app->query($sql)->fetch_object();

        $db_name = $aProjectDetails->db_name;
        $platform = $aProjectDetails->platform;
        $base_model_prefix = $aProjectDetails->base_model_prefix;
        $controller_prefix = $aProjectDetails->controller_prefix;
        $route_prefix = $aProjectDetails->route_prefix;
        $controller_path = $aProjectDetails->controller_path;
        $model_path = $aProjectDetails->model_path;
        $view_path = $aProjectDetails->view_path;
        $route_path = $aProjectDetails->route_path;
        //debug($controller_path);
    } else {
        $error[] = 'Project is required';
    }


    //--path
    if (!file_exists($controller_path)) {
        $error[] = 'Controller path not found > ' . $controller_path;
    }

    if (!file_exists($model_path)) {
        $error[] = 'Model path not found > ' . $model_path;
    }

    if (!file_exists($view_path)) {
        $error[] = 'View path not found > ' . $view_path;
    }

    $_SESSION['error'] = $error;

    define('CONTROLLERS_DIR', $controller_path . '/');
    define('MODELS_DIR', $model_path . '/');
    define('VIEWS_DIR', $view_path . '/');
    define('ROUTE_DIR', $route_path . '/');

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
                        <td>Project <span class="required">(*)</span></td>
                        <td>
                            <select class="form-control" name="project_id" id="project_id" onchange="get_tables(this.value,'table_name')">
                                <option value="">--Select--</option>
                                <?php
                                foreach ($aProject as $row) {
                                ?>
                                    <option value="<?php echo $row['id']; ?>" <?php selected_select($row['id'], $project_id) ?>><?php echo $row['project_name']; ?></option>

                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Table</td>
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
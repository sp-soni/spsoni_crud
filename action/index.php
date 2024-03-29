<?php
require_once dirname(__FILE__, 2) . '/layout/header.php';
?>
<?php
$platform = '';
$project_id = '';
$module_id = '';
$base_model_suffix = '';
$table_name = '';
$route_path = '';
$controller_path = '';
$model_path = '';
$view_path = '';
$root_path = '';
$module = '';
$controller_parent_class = '';
$model_parent_class = '';

$aTable = [];
$aModule = [];
$error = [];
$choice = [];
if (!empty($_POST)) {

    $project_id = $_POST['project_id'];
    $module_id = $_POST['module_id'];
    $table_name = $_POST['table_name'];


    if (empty($project_id)) {
        $error[] = 'Project is requried';
    }

    if (empty($module_id)) {
        $error[] = 'Module is requried';
    }

    if (empty($error)) {
        $sql = 'select 
         t1.*,t2.module,t2.base_model_suffix,t2.controller_path,t2.model_path,
         t2.view_path,t2.route_path,t2.controller_parent_class, t2.model_parent_class  
         from project as t1 left join project_module as t2 on t1.id=t2.project_id
         where t1.id=' . $project_id . ' and t2.id=' . $module_id;
        $aProjectDetails = $conn_app->query($sql)->fetch_object();

        $db_name = $aProjectDetails->db_name;
        $platform = $aProjectDetails->platform;
        $base_model_suffix = $aProjectDetails->base_model_suffix;
        $root_path = $aProjectDetails->root_path;

        $module = $aProjectDetails->module;

        $controller_path = $root_path . DIRECTORY_SEPARATOR . $aProjectDetails->controller_path;
        $view_path = $root_path . DIRECTORY_SEPARATOR . $aProjectDetails->view_path;


        if (!empty($module)) {
            $controller_path .= DIRECTORY_SEPARATOR . $module;
            $view_path .= DIRECTORY_SEPARATOR . strtolower($module);
        }

        $model_path = $root_path . DIRECTORY_SEPARATOR . $aProjectDetails->model_path;

        $route_path = $root_path . DIRECTORY_SEPARATOR . $aProjectDetails->route_path;


        $controller_parent_class = $aProjectDetails->controller_parent_class;
        $model_parent_class= $aProjectDetails->model_parent_class;

        define('PLATFORM', $platform);
        define('DATABASE', $db_name);

        mysqli_select_db($conn, DATABASE);
        $aTable = array_column($conn->query('SHOW TABLES')->fetch_all(), 0);

        $aTable = array_diff($aTable, $excludeTables);


        $sql = 'select id,module from project_module where project_id=' . $project_id;
        $aModule = $conn_app->query($sql)->fetch_all(MYSQLI_ASSOC);

        if (empty($table_name)) {
            $error[] = 'Database Table is requried';
        }

        if (empty($module)) {
            $error[] = '$module name is empty for the selected project & module, Check table "project_module" in database.';
        }

        if (empty($controller_parent_class)) {
            $error[] = '$controller_parent_class is empty for the selected project & module, Check table "project_module" in database.';
        }

        if (empty($model_parent_class)) {
            $error[] = '$model_parent_class is empty for the selected project & module, Check table "project_module" in database.';
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

        if (empty($_POST['choice'])) {
            $error[] = 'Choice is requried';
        } else {
            $choice = $_POST['choice'];
        }

        if (empty($table_name)) {
            $error[] = 'Database Table is requried';
        }

        if (empty($error)) {
            define('CONTROLLERS_DIR', $controller_path . '/');
            define('MODELS_DIR', $model_path . '/');
            define('VIEWS_DIR', $view_path . '/');
            define('ROUTE_DIR', $route_path . '/');
            define('BASE_MODEL_SUFFIX', $base_model_suffix);
            define('MODULE', $module);
            define('CONTROLLER_PARENT_CLASS', $controller_parent_class);
            define('MODEL_PARENT_CLASS', $model_parent_class);
        }
    }
    $_SESSION['error'] = $error;
}
?>
<div class="row">

    <?php show_message(); ?>
    <form method="post">
        <div class="col-md-12">
            <table class="table table-bordered">               
                <tbody>
                    <tr>
                        <th>Project <span class="required">(*)</span></th>
                        <th>Project Module<span class="required">(*)</span></th>
                        <th>Table <span class="required">(*)</span></th>
                    </tr>
                    <tr>
                        <td width="35%">
                            <select class="form-control" name="project_id" id="project_id" onchange="load_tables_modules(this.value,'table_name','module_id')">
                                <option value="">--Select--</option>
                                <?php
                                foreach ($aProject as $row) {
                                ?>
                                    <option value="<?php echo $row['id']; ?>" <?php selected_select($row['id'], $project_id) ?>><?php echo $row['project_name']; ?> - <?php echo $row['platform']; ?></option>

                                <?php
                                }
                                ?>
                            </select>
                        </td>
                        <td width="35%">
                            <select class="form-control" name="module_id" id="module_id">
                                <option value="">-Select-</option>
                                <?php
                                foreach ($aModule as $row) { ?>
                                    <option value="<?php echo $row['id']; ?>" <?php selected_select($row['id'], $module_id) ?>><?php echo $row['module']; ?></option>

                                <?php
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" name="table_name" id="table_name">
                                <option value="">-Select-</option>
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
                        <td>File Choice <span class="required">(*)</span></td>
                        <td colspan="2">
                            <ul type="none" class="list-group list-group-flush">
                                <li><input id="checkAll" type="checkbox" name="choice[]" value="all" <?php set_choice('all'); ?>>All</li>
                            </ul>
                            <ul type="none" class="list-group list-group-flush" id="list-wrapper">
                                <li><input type="checkbox" name="choice[]" value="controller" <?php set_choice('controller'); ?>>Controller</li>
                                <li><input type="checkbox" name="choice[]" value="base_model" <?php set_choice('base_model'); ?>>Base Model</li>
                                <li><input type="checkbox" name="choice[]" value="model" <?php set_choice('model'); ?>>Model</li>
                                <li><input type="checkbox" name="choice[]" value="view" <?php set_choice('view'); ?>>Views</li>
                            </ul>

                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">
                            <input type="submit" name="preview" value="Preview" class="btn btn-warning">
                        </td>
                    </tr>
                </tfoot>
            </table>

        </div>
        <div class="col-md-12">

            <?php
            if (!empty($_POST)) {
                if (empty($error)) {
                    if (!empty($_POST['submit'])) {
                        // generate code
                        $files = action_generate_crud($conn, $table_name, 'generate', $_POST['choice']);
                    } else {
                        // preview code
                        $files = action_generate_crud($conn, $table_name, 'preview', $_POST['choice']);
                    }
            ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="3">Generated Files</th>
                            </tr>
                            <tr>
                                <th>SN</th>
                                <th>File Type</th>
                                <th>Files</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            // debug($files, 0);
                            foreach ($files as $key => $file) {
                            ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo ucwords($key); ?></td>
                                    <td>
                                        <?php
                                        if (is_array($file)) {
                                            foreach ($file as $file_name) {
                                                echo '<div>' . $file_name . '<div>';
                                            }
                                        } else {
                                            echo $file;
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php }  ?>
                        </tbody>
                        <?php
                        if ($i > 1) { ?>
                            <tfoot>
                                <tr>
                                    <td colspan="3">
                                        <input type="submit" name="submit" value="Generate" class="btn btn-success">
                                    </td>
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
function set_choice($key)
{
    global $choice;
    if (!empty($choice) && is_array($choice) && in_array($key, $choice)) {
        echo  " checked";
    }
}
?>
<script>
    $(function() {
        // ID selector on Master Checkbox
        var masterCheck = $("#checkAll");
        // ID selector on Items Container
        var listCheckItems = $("#list-wrapper :checkbox");

        // Click Event on Master Check
        masterCheck.on("click", function() {
            var isMasterChecked = $(this).is(":checked");
            listCheckItems.prop("checked", isMasterChecked);
            getSelectedItems();
        });

        // Change Event on each item checkbox
        listCheckItems.on("change", function() {
            // Total Checkboxes in list
            var totalItems = listCheckItems.length;
            // Total Checked Checkboxes in list
            var checkedItems = listCheckItems.filter(":checked").length;

            //If all are checked
            if (totalItems == checkedItems) {
                masterCheck.prop("indeterminate", false);
                masterCheck.prop("checked", true);
            }
            // Not all but only some are checked
            else if (checkedItems > 0 && checkedItems < totalItems) {
                masterCheck.prop("indeterminate", true);
            }
            //If none is checked
            else {
                masterCheck.prop("indeterminate", false);
                masterCheck.prop("checked", false);
            }
            getSelectedItems();
        });

        function getSelectedItems() {
            var getCheckedValues = [];
            getCheckedValues = [];
            listCheckItems.filter(":checked").each(function() {
                getCheckedValues.push($(this).val());
            });
            $("#selected-values").html(JSON.stringify(getCheckedValues));
        }
    });
</script>
<?php
require_once dirname(__FILE__, 2) . '/layout/footer.php';
?>
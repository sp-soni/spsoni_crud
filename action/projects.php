<?php
require_once dirname(__FILE__, 2) . '/layout/header.php';
?>
<?php
$project_name = '';
$platform = '';
$db_name = '';
$base_model_suffix = '';
$controller_prefix = '';
$route_prefix = '';
$controller_path = '';
$model_path =  '';
$view_path = '';
$route_path = '';
if (!empty($_POST)) {

    $project_name = $_POST['project_name'];
    $platform = $_POST['platform'];
    $db_name = $_POST['db_name'];
    $base_model_suffix = $_POST['base_model_suffix'];
    $controller_prefix = $_POST['controller_prefix'];
    $route_prefix = $_POST['route_prefix'];
    $controller_path = $_POST['controller_path'];
    $model_path = $_POST['model_path'];
    $view_path = $_POST['view_path'];
    $route_path = $_POST['route_path'];

    $error = [];
    if (empty($_POST['project_name'])) {
        $error[] = 'Project name is required';
    }
    if (empty($_POST['platform'])) {
        $error[] = 'Platform is required';
    }
    if (empty($_POST['db_name'])) {
        $error[] = 'Database is required';
    }

    //--path
    if (!empty($_POST['controller_path'])) {
        if (!file_exists($_POST['controller_path'])) {
            $error[] = 'Controller path not found > ' . $_POST['controller_path'];
        }
    } else {
        $error[] = 'Controller path is required';
    }

    if (!empty($_POST['model_path'])) {
        if (!file_exists($_POST['model_path'])) {
            $error[] = 'Model path not found > ' . $_POST['model_path'];
        }
    } else {
        $error[] = 'Model path is required';
    }

    if (!empty($_POST['view_path'])) {
        if (!file_exists($_POST['view_path'])) {
            $error[] = 'View path not found > ' . $_POST['view_path'];
        }
    } else {
        $error[] = 'Model path is required';
    }

    if (!empty($_POST['route_path'])) {
        if (!file_exists($_POST['route_path'])) {
            $error[] = 'Route path not found > ' . $_POST['route_path'];
        }
    } else {
        $error[] = 'Route path is required';
    }

    $_SESSION['error'] = $error;
    if (empty($error)) {
        $sql = "INSERT INTO project (`project_name`, `db_name`, `platform`, `base_model_suffix`, `controller_prefix`, `route_prefix`,
         `controller_path`, `model_path`, `view_path`,`route_path`)
        VALUES ('" . $project_name . "','" . $db_name . "','" . $platform . "','" . $base_model_suffix . "','" . $controller_prefix . "',
        '" . $route_prefix . "','" . mysqli_real_escape_string($conn_app, $controller_path) . "','" . mysqli_real_escape_string($conn_app,  $model_path) . "',
        '" . mysqli_real_escape_string($conn_app, $view_path) . "','" . mysqli_real_escape_string($conn_app, $route_path) . "')";
        mysqli_query($conn_app, $sql) or die($conn_app->error);
        $_SESSION['success'][] = 'Project saved successfully';
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
                        <th colspan="2">Project List</th>
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
                        <td>Project Name <span class="required">(*)</span></td>
                        <td>
                            <input type="text" class="form-control" name="project_name" id="project_name" value="<?php echo $project_name; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Database Name <span class="required">(*)</span></td>
                        <td>
                            <input type="text" class="form-control" name="db_name" id="db_name" value="<?php echo $db_name; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Base Model Class Prefix <span class="required">(*)</span></td>
                        <td>
                            <input type="text" class="form-control" name="base_model_suffix" id="base_model_suffix" value="<?php echo $base_model_suffix; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Controller Class Prefix <span class="required">(*)</span></td>
                        <td>
                            <input type="text" class="form-control" name="controller_prefix" id="controller_prefix" value="<?php echo $controller_prefix; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Route Prefix <span class="required">(*)</span></td>
                        <td>
                            <input type="text" class="form-control" name="route_prefix" id="route_prefix" value="<?php echo $route_prefix; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Controller Directory <span class="required">(*)</span></td>
                        <td>
                            <input type="text" class="form-control" name="controller_path" id="controller_path" value="<?php echo $controller_path; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Model Directory <span class="required">(*)</span></td>
                        <td>
                            <input type="text" class="form-control" name="model_path" id="model_path" value="<?php echo $model_path; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Views Directory <span class="required">(*)</span></td>
                        <td>
                            <input type="text" class="form-control" name="view_path" id="view_path" value="<?php echo $view_path; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Route Directory <span class="required">(*)</span></td>
                        <td>
                            <input type="text" class="form-control" name="route_path" id="route_path" value="<?php echo $route_path; ?>">
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>

                        </td>
                        <td>
                            <input type="submit" name="preview" value="Save" class="btn btn-success">
                        </td>
                    </tr>
                </tfoot>
            </table>

        </div>
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td>SN</td>
                        <td>Project Name</td>
                        <td>DB Name</td>
                        <td>Platform</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = 'select 
                    t1.*,t2.module,t2.base_model_suffix,t2.controller_path,t2.model_path,
                    t2.view_path,t2.route_path,t2.controller_parent_class 
                    from project as t1 left join project_module as t2 on t1.id=t2.project_id';
                    $aProject = $conn_app->query($sql)->fetch_all(MYSQLI_ASSOC);
                    if (!empty($aProject) && is_array($aProject)) {
                        $sn = 1;
                        foreach ($aProject as $row) {
                            $row = (object)$row;
                    ?>
                            <tr>
                                <td><?php echo $sn++; ?></td>
                                <td><?php echo $row->project_name; ?></td>
                                <td><?php echo $row->db_name; ?></td>
                                <td><?php echo $row->platform; ?></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </form>

</div>
<?php
require_once dirname(__FILE__, 2) . '/layout/footer.php';
?>
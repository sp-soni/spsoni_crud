<?php
require_once dirname(__FILE__, 2) . '/layout/header.php';

$module_id = 0;
$controller_parent_class = '';
$controller_path = '';
$model_path = '';
$view_path = '';
$project_id = '';

if (!empty($_GET['module_id'])) {
    $sql = 'select * from project_module where id=' . $_GET['module_id'];
    $res = mysqli_query($conn_app, $sql);
    $EDIT_ROW = mysqli_fetch_assoc($res);
    if (!empty($EDIT_ROW['id'])) {
        $module_id = $EDIT_ROW['id'];
        $project_id = $EDIT_ROW['project_id'];
        $controller_path = $EDIT_ROW['controller_path'];
        $model_path =  $EDIT_ROW['model_path'];
        $controller_parent_class =  $EDIT_ROW['controller_parent_class'];
        $view_path =  $EDIT_ROW['view_path'];
    }
}

$aProjectModules = [];
if (!empty($_GET['project_id'])) {
    $sql = 'select * from project_module where project_id=' . $_GET['project_id'];
    $aProjectModules = $conn_app->query($sql)->fetch_all(MYSQLI_ASSOC);
}

$sql = 'select * from project';
$aProject = $conn_app->query($sql)->fetch_all(MYSQLI_ASSOC);

if (!empty($_POST)) {

    $project_id = $_POST['project_id'];
    $controller_path = $_POST['controller_path'];
    $controller_parent_class = $_POST['controller_parent_class'];
    $model_path = $_POST['model_path'];
    $view_path = $_POST['view_path'];

    $error = [];

    if (empty($_POST['controller_parent_class'])) {
        $error[] = 'Controller Parent Class is required';
    }
    if (empty($_POST['controller_path'])) {
        $error[] = 'Controller Path is required';
    }
    if (empty($_POST['model_path'])) {
        $error[] = 'Model Path is required';
    }
    if (empty($_POST['view_path'])) {
        $error[] = 'Views Path is required';
    }

    if (!empty($_POST['controller_path']) && !file_exists($_POST['controller_path'])) {
        $error[] = 'Controller path not found > ' . $_POST['controller_path'];
    }
    if (!empty($_POST['model_path']) && !file_exists($_POST['model_path'])) {
        $error[] = 'Model path not found > ' . $_POST['model_path'];
    }
    if (!empty($_POST['view_path']) && !file_exists($_POST['view_path'])) {
        $error[] = 'View path not found > ' . $_POST['view_path'];
    }

    $_SESSION['error'] = $error;
    if (empty($error)) {
        if ($module_id == 0) { // insert
            $sql = "INSERT INTO project_module (`controller_parent_class`, `controller_path`, `model_path`, `view_path`)
        VALUES ('" . $controller_parent_class . "','" . mysqli_real_escape_string($conn_app, $controller_path) . "',
        '" . mysqli_real_escape_string($conn_app, $model_path) . "','" . mysqli_real_escape_string($conn_app, $view_path) . "')";
        } else { // update
            $sql = "UPDATE project_module set `controller_parent_class`='" . $controller_parent_class . "', 
            `controller_path`='" . mysqli_real_escape_string($conn_app, $controller_path) . "',
            `model_path`='" . mysqli_real_escape_string($conn_app, $model_path) . "',
            `view_path`='" . mysqli_real_escape_string($conn_app, $view_path) . "'
             where id=" . $module_id;
        }
        mysqli_query($conn_app, $sql) or die($conn_app->error);
        $_SESSION['success'][] = 'Project module saved successfully';
        header('Location:' . BASE_URL . 'action/project_modules.php');
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
                        <th colspan="2">Project Manage</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width="30%"><span class="required">Project (*)</span></td>
                        <td width="70%">
                            <select class="form-control" name="project_id" id="project_id">
                                <option value="">--Select--</option>
                                <?php
                                foreach ($aProject as $row) { ?>
                                    <option value="<?php echo $row['id']; ?>" <?php selected_select($row['id'], $project_id) ?>><?php echo $row['project_name']; ?></option>

                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Controller Parent Class <span class="required">(*)</span></td>
                        <td>
                            <input type="text" class="form-control" name="controller_parent_class" id="controller_parent_class" value="<?php echo $controller_parent_class; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Controller Path <span class="required">(*)</span></td>
                        <td>
                            <input type="text" class="form-control" name="controller_path" id="controller_path" value="<?php echo $controller_path; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Model Path <span class="required">(*)</span></td>
                        <td>
                            <input type="text" class="form-control" name="model_path" id="model_path" value="<?php echo $model_path; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>View Path<span class="required">(*)</span></td>
                        <td>
                            <input type="text" class="form-control" name="view_path" id="view_path" value="<?php echo $view_path; ?>">
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
                        <th>SN</td>
                        <th>Module Name</th>
                        <th>Controller Path</th>
                        <th>Model Path</th>
                        <th>View Path</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($aProjectModules) && is_array($aProjectModules)) {
                        $sn = 1;
                        foreach ($aProjectModules as $row) {
                            $row = (object)$row;
                            $url = BASE_URL . 'action/project_modules.php?project_id=' . $row->project_id . '&module_id=' . $row->id;
                    ?>
                            <tr>
                                <td><?php echo $sn++; ?></td>
                                <td><?php echo $row->module; ?></td>
                                <td><?php echo $row->controller_parent_class; ?></td>
                                <td><?php echo $row->controller_path; ?></td>
                                <td><?php echo $row->model_path; ?></td>
                                <td><?php echo $row->view_path; ?></td>
                                <td><a href="<?php echo $url; ?>">Edit</a></td>
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
<?php
require_once dirname(__FILE__, 2) . '/layout/header.php';

$id = 0;
$project_name = '';
$platform = '';
$db_name = '';
$root_path = '';

if (!empty($_GET['project_id'])) {
    $sql = 'select * from project where id=' . $_GET['project_id'];
    $res = mysqli_query($conn_app, $sql);
    $EDIT_ROW = mysqli_fetch_assoc($res);
    if (!empty($EDIT_ROW['id'])) {
        $id = $EDIT_ROW['id'];
        $project_name = $EDIT_ROW['project_name'];
        $platform =  $EDIT_ROW['platform'];
        $db_name =  $EDIT_ROW['db_name'];
        $root_path =  $EDIT_ROW['root_path'];
    }
}

if (!empty($_POST)) {

    $project_name = $_POST['project_name'];
    $platform = $_POST['platform'];
    $db_name = $_POST['db_name'];
    $root_path = $_POST['root_path'];

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

    if (!empty($_POST['root_path'])) {
        if (!file_exists($_POST['root_path'])) {
            $error[] = 'Route path not found > ' . $_POST['root_path'];
        }
    } else {
        $error[] = 'Route path is required';
    }

    $_SESSION['error'] = $error;
    if (empty($error)) {
        if ($id == 0) { // insert
            $sql = "INSERT INTO project (`project_name`, `db_name`, `platform`, `root_path`)
        VALUES ('" . $project_name . "','" . $db_name . "','" . $platform . "','" . mysqli_real_escape_string($conn_app, $root_path) . "')";
        } else { // update
            $sql = "UPDATE project set `project_name`='" . $project_name . "', `db_name`='" . $db_name . "', 
            `platform`='" . $platform . "', `root_path`='" . mysqli_real_escape_string($conn_app, $root_path) . "' 
             where id=" . $id;
        }
        mysqli_query($conn_app, $sql) or die($conn_app->error);
        $_SESSION['success'][] = 'Project saved successfully';
        header('Location:' . BASE_URL . 'action/projects.php');
    }
}

//Duplocate Project
if (!empty($_GET['duplicate'])) {
    //project
    $sql = 'INSERT INTO project (`project_name`, `db_name`, `platform`, `root_path`)
SELECT `project_name`,`db_name`, `platform`, `root_path` FROM project WHERE id = ' . $_GET['project_id'];
    mysqli_query($conn_app, $sql) or die($conn_app->error);
    $_SESSION['success'][] = 'Duplicate project created successfully';
    header('Location:' . BASE_URL . 'action/projects.php');
}
?>
<div class="row">
    <?php show_message(); ?>
    <form method="post">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-parimary">
                        <th colspan="2">Project Management</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th width="15%">Platform <span class="required">(*)</span></th>
                        <th width="20%">Database Name <span class="required">(*)</span></th>
                        <th width="20%">Project Name <span class="required">(*)</span></th>
                        <th width="*">Root Directory Path<span class="required">(*)</span></th>
                    </tr>

                    <tr>
                        <td>
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
                        <td>
                            <select class="form-control" name="db_name" id="db_name">
                                <option value="">--Select--</option>
                                <?php
                                foreach ($aDatabase as $row) { ?>
                                    <option value="<?php echo $row; ?>" <?php selected_select($row, $db_name) ?>><?php echo $row; ?></option>

                                <?php
                                }
                                ?>
                            </select>
                        </td>

                        <td>
                            <input type="text" class="form-control" name="project_name" id="project_name" value="<?php echo $project_name; ?>">
                        </td>
                        <td>
                            <input type="text" class="form-control" name="root_path" id="root_path" value="<?php echo $root_path; ?>">
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right">
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
                        <th width="15%">Project Name</th>
                        <th width="15%">DB Name</th>
                        <th width="15%">Platform</th>
                        <th width="*">Root Path</th>
                        <th>Modules</th>
                        <th width="10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = 'select * from project order by id desc';
                    $aProject = $conn_app->query($sql)->fetch_all(MYSQLI_ASSOC);
                    if (!empty($aProject) && is_array($aProject)) {
                        $sn = 1;
                        foreach ($aProject as $row) {
                            $row = (object)$row;
                            $url = BASE_URL . 'action/projects.php?project_id=' . $row->id;
                            $module_url = BASE_URL . 'action/project_modules.php?project_id=' . $row->id;
                            $duplicate_url = BASE_URL . 'action/projects.php?duplicate=1&project_id=' . $row->id;
                    ?>
                            <tr>
                                <td><?php echo $sn++; ?></td>
                                <td><?php echo $row->project_name; ?></td>
                                <td><?php echo $row->db_name; ?></td>
                                <td><?php echo $row->platform; ?></td>
                                <td><?php echo $row->root_path; ?></td>
                                <td>
                                    <?php
                                    $sql = 'select * from project_module where project_id=' . $row->id;
                                    $aModules = $conn_app->query($sql)->fetch_all(MYSQLI_ASSOC);
                                    foreach ($aModules as $row1) {
                                        $row1 = (object)$row1;
                                        $module_url_edit = $module_url . '&module_id=' . $row1->id;
                                    ?>
                                        <a href="<?php echo $module_url_edit; ?>" class="btn btn-sm btn-warning"><?php echo $row1->module; ?></a>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="<?php echo $url; ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="<?php echo $duplicate_url; ?>" class="btn btn-sm btn-primary">Duplicate</a>
                                    <a href="<?php echo $module_url; ?>" class="btn btn-sm btn-success">Modules</a>
                                </td>
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
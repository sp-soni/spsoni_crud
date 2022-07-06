<?php
require_once dirname(__FILE__, 2) . '/layout/header.php';
?>
<?php
$project_id = '';
if (!empty($_POST)) {
    $project_id = $_POST['project_id'];
    $error = [];
    if (empty($_POST['project_id'])) {
        $error[] = 'Project is required';
    }
    $_SESSION['error'] = $error;

    if (empty($error)) {
        $sql = 'select db_name from project where id=' . $project_id;
        $aProjectDetails = $conn_app->query($sql)->fetch_object();
        //---needed variables
        define('DATABASE', $aProjectDetails->db_name);
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
                        <th colspan="2">Controller Generator</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width="15%">Project <span class="required">(*)</span></td>
                        <td>
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
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>

                        </td>
                        <td>
                            <input type="submit" name="preview" value="Generate Query" class="btn btn-success">
                        </td>
                    </tr>
                </tfoot>
            </table>

        </div>
        <div>

            <?php
            if (!empty($_POST)) {
                if (empty($error)) {
                    $query = action_migrate($conn, $aTable);
                    // debug($query);
                    $sql = '';
                    foreach ($query as $row) {
                        $sql .= $row . ';' . "<br/>";
                    }
            ?>

                    <table class="table table-bordered">
                        <thead>
                            <tr class="bg-parimary">
                                <th width="10%">
                                    <h3>Output</h3>
                                </th>
                                <th width="*">
                                    <a href="#" class="btn btn-success" onclick="copyDivToClipboard('query_div')">Copy Query</a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <div id="query_div">
                                        <?php echo  $sql; ?>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
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
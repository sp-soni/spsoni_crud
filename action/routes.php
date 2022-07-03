<?php
require_once dirname(__FILE__, 2) . '/layout/header.php';
?>
<?php
$platform = '';
$db_name = '';
$route_prefix = '';
if (!empty($_POST)) {

    $platform = $_POST['platform'];
    $db_name = $_POST['db_name'];
    $route_prefix = $_POST['route_prefix'];

    $error = [];
    if (empty($_POST['platform'])) {
        $error[] = 'Platform is required';
    }
    if (empty($_POST['db_name'])) {
        $error[] = 'Database is required';
    }
    $_SESSION['error'] = $error;

    if (empty($error)) {
        //---needed variables
        define('ROUTE_PREFIX', $route_prefix);
        mysqli_select_db($conn, $db_name);
        $aTable = array_column($conn->query('SHOW TABLES')->fetch_all(), 0);
    }
}
?>
<div class="row">

    <?php show_message(); ?>
    <form method="post">
        <div class="col-md-6">
            <table class="table table-bordered">
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
                    <td>Route Prefix</td>
                    <td>
                        <input type="text" class="form-control" name="route_prefix" id="route_prefix" value="<?php echo $route_prefix; ?>">
                    </td>
                </tr>
                <tr>
                    <td>

                    </td>
                    <td>
                        <input type="submit" name="preview" value="Preview" class="btn btn-primary">
                    </td>
                </tr>
            </table>

        </div>
        <div class="col-md-12">

            <?php
            if (!empty($_POST)) {
                if (empty($error)) {

                    if (!empty($_POST['submit'])) {
                        // generate code
                        $files = action_generate_routes($aTable, $platform, $action = 'generate');
                    } else {
                        // preview code
                        $files = action_generate_routes($aTable, $platform, $action = 'preview');
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
                                    <td><?php echo $file; ?></td>
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
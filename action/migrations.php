<?php
require_once dirname(__FILE__, 2) . '/layout/header.php';
?>
<?php
$platform = '';
$db_name = '';
if (!empty($_POST)) {

    $platform = $_POST['platform'];
    $db_name = $_POST['db_name'];

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
                        <th colspan="2">Controller Generator</th>
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
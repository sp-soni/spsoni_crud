<?php
$platform = '';
if (!empty($_GET['platform'])) {
    $platform = $_GET['platform'];
}
$db_name = '';
if (!empty($_GET['db_name'])) {
    $db_name = $_GET['db_name'];
}
?>
<div class="row" style="margin-bottom: 10px;">
    <div class="col-md-1">
        <a href="<?php echo BASE_URL; ?>" class="btn btn-primary">Home</a>
    </div>
    <form>
        <table class="table table-bordered">
            <tr>
                <td><span class="required">Select Platform (*)</span></td>
                <td><span class="required">Select Database (*)</span></td>
                <td>Action</td>
            </tr>
            <tr>
                <td>
                    <select class="form-control" name="platform">
                        <option <?php selected_select('', $platform) ?>>--Select--</option>
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
                    <select class="form-control" name="db_name">
                        <option <?php selected_select('', $db_name) ?>>--Select--</option>
                        <?php
                        foreach ($aDatabase as $row) { ?>
                            <option value="<?php echo $row; ?>" <?php selected_select($row, $db_name) ?>><?php echo $row; ?></option>

                        <?php
                        }
                        ?>
                    </select>
                </td>
                <td><input type="submit" name="btngo" value="Go" class="btn btn-success"></td>
            </tr>
        </table>
    </form>

</div>
<div class="row">
    <div class="col-md-12">
        <?php
        if (empty($_GET['platform']) || !in_array($_GET['platform'], platform_list())) {
            echo '<h1 class="required">Platform is required</h1>';
            return false;
        }
        if (empty($_GET['db_name']) || !in_array($_GET['db_name'], $aDatabase)) {
            echo '<h1 class="required">Database is required</h1>';
            return false;
        }
        if (!empty($_GET['platform']) && !empty($_GET['db_name'])) {
            $url = prepare_url(BASE_URL, 'action');
        ?>
            <a href="<?php echo $url; ?>base_models" class="btn btn-warning">Base Models</a>
            <a href="<?php echo $url; ?>routes" class="btn btn-danger">Routes</a>
            <a href="<?php echo $url; ?>models" class="btn btn-success">Models</a>
            <a href="<?php echo $url; ?>views" class="btn btn-warning">Views</a>
            <a href="<?php echo $url; ?>controllers" class="btn btn-success">Controller</a>
            <a href="<?php echo $url; ?>crud.php" class="btn btn-success">CRUD</a>
        <?php } ?>

    </div>
</div>
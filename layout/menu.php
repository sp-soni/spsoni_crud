<?php
$platform = '';
if (!empty($_GET['platform'])) {
    $platform = $_GET['platform'];
}
?>
<div class="row" style="margin-bottom: 10px;">
    <div class="col-md-1">
        <a href="<?php echo BASE_URL; ?>" class="btn btn-primary">Home</a>
    </div>
    <div class="col-md-2">
        <span class="required">Select Platform (*)</span>
    </div>
    <div class="col-md-3">
        <form>
            <select class="form-control" name="platform" onchange="this.form.submit()">
                <option <?php selected_select('', $platform) ?>>--Select--</option>
                <?php
                $aPlatform = platform_list();
                foreach ($aPlatform as $row) { ?>
                    <option value="<?php echo $row; ?>" <?php selected_select($row, $platform) ?>><?php echo $row; ?></option>

                <?php
                }
                ?>

            </select>
        </form>

    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php
        if (!empty($_GET['platform']) && in_array($_GET['platform'], platform_list())) {
            $url = BASE_URL . '?platform=' . $platform . '&action=';
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
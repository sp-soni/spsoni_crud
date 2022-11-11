<?php
require_once dirname(__FILE__, 2) . '/config.php';
require_once ROOT_PATH . '/vendor/generator.php';
require_once ROOT_PATH . '/vendor/helpers.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>SCG Tool</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>assets/select2/select2.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>assets/css/style.css" rel="stylesheet">
    <script src="<?php echo BASE_URL; ?>assets/js/jquery.min.js"></script>
    <!-- <script src="<?php echo BASE_URL; ?>assets/js/bootstrap.bundle.min.js"></script> -->
    <script src="<?php echo BASE_URL; ?>assets/select2/select2.min.js"></script>
    <script>
        var BASE_URL = '<?php echo BASE_URL; ?>';
        var API_BASE_URL = '<?php echo API_BASE_URL; ?>';
    </script>
    <script src="<?php echo BASE_URL; ?>assets/js/app.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">              
                <div class="btn-group">
                    <a href="<?php echo BASE_URL; ?>action/" class="btn btn-primary">CRUD</a>
                    <a href="<?php echo BASE_URL; ?>action/routes.php" class="btn btn-warning">Routes</a>
                    <a href="<?php echo BASE_URL; ?>action/migrations.php" class="btn btn-danger">MIGRATE</a>
                    <a href="<?php echo BASE_URL; ?>action/projects.php" class="btn btn-success">Project Settings</a>
                </div>
            </div>
        </div>
        <div class="row" style="margin-bottom: 10px;">
            <div class="col-md-12" style="padding-top:20px;">
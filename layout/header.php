<?php
require_once dirname(__FILE__, 2) . '/config.php';
require_once ROOT_PATH . '/vendor/generator.php';
require_once ROOT_PATH . '/vendor/helpers.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>SpiTech CRUD</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
                <h2>SpiTech CRUD Generator</h2>
            </div>
        </div>
        <div class="row" style="margin-bottom: 10px;">
            <div class="col-md-12">
                <a href="<?php echo BASE_URL; ?>" class="btn btn-primary">Home</a>
                <a href="<?php echo BASE_URL; ?>action/base-models.php" class="btn btn-warning">Base Models</a>
                <a href="<?php echo BASE_URL; ?>action/routes.php" class="btn btn-danger">Routes</a>
                <a href="<?php echo BASE_URL; ?>action/models.php" class="btn btn-success">Models</a>
                <a href="<?php echo BASE_URL; ?>action/migrations.php" class="btn btn-success">MIGRATE</a>
                <a href="<?php echo BASE_URL; ?>action/views.php" class="btn btn-warning">Views</a>
                <a href="<?php echo BASE_URL; ?>action/controllers.php" class="btn btn-success">Controller</a>
                <a href="<?php echo BASE_URL; ?>action/crud.php" class="btn btn-success">CRUD</a>
            </div>
        </div>
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
        <?php
        require_once 'menu.php';
        ?>
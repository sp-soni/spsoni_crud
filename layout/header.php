<?php
require_once dirname(__FILE__, 2) . '/config.php';
require_once ROOT_PATH . '/vendor/generator.php';

$conn = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
$aTable = array_column($conn->query('SHOW TABLES')->fetch_all(), 0);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>SpiTech CRUD Generator</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2>Codeigniter 3.X CRUD Generator</h2>
            </div>
        </div>
        <?php
        require_once 'menu.php';
        ?>
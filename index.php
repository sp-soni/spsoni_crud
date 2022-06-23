<?php
require_once 'config.php';
require_once 'generator.php';

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

    <div class="container">
        <h1>SpiTech CRUD Generator</h1>
        <h2>All</h2>
        <form>
            <button type="submit" name="action" class="btn btn-warning" value="base_model">General Base Models</button>
            <button type="submit" name="action" class="btn btn-primary" value="model">General Models</button>
        </form>
        <h2>Parameterized</h2>
        <form>
            <div class="form-group">
                <label for="pwd">Paramerter:</label>
                <input type="text" class="form-control" id="param1" name="param1">
            </div>
            <button type="submit" class="btn btn-success" name="parameterized">Generate</button>
        </form>
    </div>
    <div class="container">
        <?php
        if (!empty($_GET['action'])) {
            $action = $_GET['action'];
            if ($action == "model") {
                generate_model_file($aTable, $conn);
            } else if ($action == "base_model") {
                generate_base_model_file($aTable, $conn);
            } else if ($action == "migrate") {
                migrate($aTable, $conn);
            } else if ($action == "controller") {
                generate_controller_file($aTable, $conn);
            }
        }
        ?>
    </div>

</body>

</html>
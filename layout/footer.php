<?php
if (!empty($_GET['action'])) {
?>
    <div class="row">

        <div class="col-md-12">
            <div class="bg bg-primary" style="margin-top: 10px;padding:5px;">
                Generated Output
            </div>
            <div style="border:1px solid gray;padding:5px;">
                <?php
                $action = $_GET['action'];
                if ($action == "models") {
                    generate_model_file($aTable, $conn);
                } else if ($action == "base_models") {
                    generate_base_model_file($aTable, $conn);
                } else if ($action == "migrate") {
                    migrate($aTable, $conn);
                } else if ($action == "views") {
                    generate_view_file($aTable, $conn);
                } else if ($action == "controllers") {
                    generate_controller_file($aTable);
                } else if ($action == "routes") {
                    generate_route_file($aTable);
                }
                ?>
            </div>

        </div>
    </div>
<?php } ?>

</div>
</body>

</html>
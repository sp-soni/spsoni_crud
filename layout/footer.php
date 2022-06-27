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

                if (empty($_GET['platform']) || !in_array($_GET['platform'], platform_list())) {
                    echo '<h1 class="required">Platform is required</h1>';
                    return false;
                }
                if (empty($_GET['db_name']) || !in_array($_GET['db_name'], $aDatabase)) {
                    echo '<h1 class="required">Database is required</h1>';
                    return false;
                }
                require_once ROOT_PATH . '/vendor/generator.php';
                $action = $_GET['action'];
                if ($action == "models") {
                    action_generate_models($aTable, $conn, $platform);
                } else if ($action == "base_models") {
                    action_generate_base_models($aTable, $conn, $platform);
                } else if ($action == "migrate") {
                    action_migrate($aTable, $conn, $platform);
                } else if ($action == "views") {
                    action_generate_views($aTable, $conn, $platform);
                } else if ($action == "controllers") {
                    action_generate_controllers($aTable, $conn, $platform);
                } else if ($action == "routes") {
                    action_generate_routes($aTable, $conn, $platform);
                }
                ?>
            </div>

        </div>
    </div>
<?php } ?>

</div>
</body>

</html>
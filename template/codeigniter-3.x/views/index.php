<?php

function generate_index($form_attributes)
{
    //--Preparing Search Fields
    $thead = '<tr>';
    $count = 1;
    foreach ($form_attributes as $attribute) {
        $label = $attribute->label;
        $thead .= '<td>' . $label . '</td>' . PHP_EOL;
        if ($count == 5) {
            break;
        }
        $count++;
    }

    $thead .= '<td>Action</td>
    </tr>';

    $tbody = '<tr>';
    $count = 1;
    foreach ($form_attributes as $attribute) {
        $name = $attribute->column_name;
        $label = $attribute->label;
        $tbody .= '<td>
        <?php
            $' . $name . '=\'\';
            if (!empty($_GET[\'' . $name . '\'])) {
                $' . $name . ' = $_GET[\'' . $name . '\'];
            }
        ?>
        <input type="text" name="' . $name . '" class="form-control" value="<?php echo  $' . $name . ';?>">
    </td>' . PHP_EOL;
        if ($count == 5) {
            break;
        }
        $count++;
    }
    $tbody .= '<td class="search-action">   
    <input type="submit" name="search" value="Search" class="btn btn-sm btn-primary">
    <?php if (!empty($_GET[\'search\'])){?>
        <a href="<?php echo config_item(\'module\')->module_url;?>" class="btn btn-sm btn-warning">Reset</a>
    <?php } ?>
    <a href="<?php echo config_item(\'module\')->module_url;?>/add/0" class="btn btn-sm btn-success">+Add</a>
</td>
</tr>';

    $search_fields = '<div class="col-xs-12 no-padding table-search">
    <form method="get">
    <table class="table table-bordered">';
    $search_fields .= $thead . PHP_EOL;
    $search_fields .= $tbody . PHP_EOL;
    $search_fields .= '</table>
    </form>
    </div>';


    $template = '<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo $title; ?></div>
            <div class="panel-body">
                <?php show_message(); ?>
                ' . $search_fields . '
                <!--GRID START-->
                <div class="table-container">
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th width="5%">#</th>';
    $count = 1;
    foreach ($form_attributes as $attribute) {
        $name = $attribute->column_name;
        $label = $attribute->label;
        $template .= '<th width="10%">' . $label . '</th>' . PHP_EOL;
        if ($count == 5) {
            break;
        }
        $count++;
    }

    $template .= '<th width="10%">Action</th>
    </tr>
                        </thead>
                        <tbody>
                            <?php
                            $columns = ' . (count($form_attributes) + 2) . ';
                            if (isset($aGrid->rows) && is_array($aGrid->rows) && !empty($aGrid->rows)) {
                                $i = get_grid_sn();
                                foreach ($aGrid->rows as $row) {
                            ?>
                                    <tr>
                                        <td><?php echo $i ?></td>';

    $count = 1;
    foreach ($form_attributes as $attribute) {
        $name = $attribute->column_name;
        $template .= '<td><?php echo $row->' . $name . '; ?></td>' . PHP_EOL;
        if ($count == 5) {
            break;
        }
        $count++;
    }

    $template .= '<td class="text-center">
                                            <?php html_button(\'edit_delete\', [\'item_name\' => \'Record No :\'.$i, \'id\' => $row->id]); ?>
                                        </td>
                                    </tr>
                                <?php
                                    $i++;
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="<?php echo $columns ?>" class="text-center">No Records Found</td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                    if (isset($aGrid->pages)) {
                        echo $aGrid->pages;
                    }
                    ?>
                </div>
                <!--GRID STOP-->
            </div>
        </div>
    </div>
</div>';
    return $template;
}

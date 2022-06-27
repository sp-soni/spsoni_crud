<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo $title; ?></div>
            <div class="panel-body">
                <?php show_message(); ?>
                <?php get_search_form('', config_item('module')->module_url . '/', 'Search By Caption'); ?>
                <!--GRID START-->
                <div class="table-container">
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="*">Bank Name</th>
                                <th width="20%">Account No</th>
                                <th width="20%">Opening Amount</th>
                                <th width="10%">Create At</th>
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $columns = 6;
                            if (isset($aGrid->rows) && is_array($aGrid->rows) && !empty($aGrid->rows)) {
                                $i = get_grid_sn();
                                foreach ($aGrid->rows as $row) {
                            ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td><?php echo $row->bank ?></td>
                                        <td><?php echo $row->account_no ?></td>
                                        <td><?php echo $row->opening ?></td>
                                        <td><?php echo config_date($row->date) ?></td>
                                        <td class="text-center">
                                            <a class="btn btn-sm btn-primary" href="<?php echo config_item('module')->module_url; ?>/add/<?php echo $row->id ?>">Edit</a>
                                            <a onclick="return confirm('Are you sure want to delete this banner #<?php echo $i; ?>')" class="btn btn-sm btn-danger" href="<?php echo config_item('module')->module_url; ?>/delete/<?php echo $row->id ?>">Delete</a>
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
</div>
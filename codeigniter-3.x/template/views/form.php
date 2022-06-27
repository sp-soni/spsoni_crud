<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo $title; ?></div>
            <div class="panel-body">
                <?php
                $edit_id = 0;
                $activeClass = '';
                if (isset($aContentInfo->id)) {
                    $edit_id = $aContentInfo->id;
                    $activeClass = 'hide';
                }
                $attribute = array("id" => "form1", "method" => "post", "class" => "form-horizontal");
                echo form_open_multipart('', $attribute);
                echo form_hidden('id', $edit_id);
                ?>
                <fieldset>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3"><?php show_message() ?></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Bank<span class="required">*</span></label>
                        <div class="col-md-6">
                            <?php
                            $bank = '';
                            if (isset($_POST['bank'])) {
                                $bank = $_POST['bank'];
                            } else if (isset($aContentInfo->bank)) {
                                $bank = $aContentInfo->bank;
                            }
                            ?>
                            <input id="bank" name="bank" validate="Required" type="text" class="form-control" value="<?php echo $bank ?>">
                            <div class="error" id="error_bank"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Bank Account No<span class="required">*</span></label>
                        <div class="col-md-6">
                            <?php
                            $account_no = '';
                            if (isset($_POST['account_no'])) {
                                $account_no = $_POST['account_no'];
                            } else if (isset($aContentInfo->account_no)) {
                                $account_no = $aContentInfo->account_no;
                            }
                            ?>
                            <input id="account_no" name="account_no" validate="Required" type="text" class="form-control" value="<?php echo $account_no ?>">
                            <div class="error" id="error_account_no"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Opening<span class="required">*</span></label>
                        <div class="col-md-6">
                            <?php
                            $opening = '';
                            if (isset($_POST['opening'])) {
                                $opening = $_POST['opening'];
                            } else if (isset($aContentInfo->opening)) {
                                $opening = $aContentInfo->opening;
                            }
                            ?>
                            <input id="opening" name="opening" validate="Required" type="text" class="form-control" value="<?php echo $opening ?>">
                            <div class="error" id="error_opening"></div>
                        </div>
                    </div>

                    <!-- Form actions -->
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <input type="hidden" name="submitform" id="submitform" value="submit">
                            <button type="button" onclick="formValidate('form1')" class="btn btn-primary btn-md">Save</button>
                            &nbsp;&nbsp;&nbsp;
                            <a class="btn btn-danger btn-md" href="<?php echo config_item('module')->module_url ?>/modules">Cancel</a>
                        </div>
                    </div>
                </fieldset>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
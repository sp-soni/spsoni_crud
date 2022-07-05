<?php

function generate_form($form_attributes, $moude_url)
{
    //debug($form_attributes, 0);
    $form_fields = '';
    foreach ($form_attributes as $attribute) {
        $name = $attribute->column_name;
        $id = $attribute->column_name;
        $label = $attribute->label;
        $required = '';
        $validate = '';
        $rules = explode("|", $attribute->rules);
        if (is_array($rules) && in_array('required', $rules)) {
            $required = ' <span class="required">*</span>';
            $validate = 'validate="Required"';
        }

        //---some custom array to apply validation
        $emailType = ['email', 'email_address', 'email_id'];
        $fileType = ['photo', 'image', 'file', 'profile_photo'];


        $form_fields .= '
        <div class="form-group">
                <label class="col-md-3 control-label">' . $label . ' ' . $required . '</label>
                <div class="col-md-6">
                    <?php
                    $' . $name . ' = \'\';
                    if (isset($_POST[\'' . $name . '\'])) {
                        $' . $name . ' = $_POST[\'' . $name . '\'];
                    } else if (isset($aContentInfo->' . $name . ')) {
                        $' . $name . ' = $aContentInfo->' . $name . ';
                    }
                    ?>';
        if (in_array($attribute->type, ['text', 'mediumtext'])) { // textarea
            $form_fields .= '<textarea id="' . $name . '" name="' . $name . '"  ' . $validate . '  rows="3" class="form-control"><?php echo $' . $name . ' ?></textarea>' . PHP_EOL;
        } else if ($attribute->type == 'enum') { // select
            $enum_list = explode(",", str_replace(array("enum(", ")", "'"), "", $attribute->column_type));
            $form_fields .= '<select class="form-control" id="' . $id . '" name="' . $name . '">' . PHP_EOL;
            foreach ($enum_list as $option_value) {
                $form_fields .= '<option value="' . $option_value . '"  <?php selected_select(\'' . $option_value . '\', $' . $name . '); ?>>' . ucwords($option_value) . '</option>' . PHP_EOL;
            }
            $form_fields .= '</select>' . PHP_EOL;
        } else if ($attribute->type == 'date') {  // date
            $form_fields .= '<input type="date" class="form-control" id="' . $id . '" name="' . $name . '" value="<?php echo $' . $name . ' ?>">' . PHP_EOL;
        } else if ($attribute->type == 'datetime') {  // datetime-local
            $form_fields .= '<input type="datetime-local" class="form-control" id="' . $id . '" name="' . $name . '" value="<?php echo $' . $name . ' ?>">' . PHP_EOL;
        } else if (in_array($attribute->column_name, ['pass', 'password', 'pass_word', 'pass_hash'])) {  // password
            $form_fields .= '<input type="password" class="form-control" id="' . $id . '" name="' . $name . '" value="<?php echo $' . $name . ' ?>">' . PHP_EOL;
        } else if (in_array($attribute->column_name, $emailType) || in_array($attribute->comment, $emailType)) {  // email
            $form_fields .= '<input type="email" class="form-control" id="' . $id . '" name="' . $name . '" value="<?php echo $' . $name . ' ?>">' . PHP_EOL;
        } else if (in_array($attribute->column_name, $fileType) || in_array($attribute->comment, $fileType)) {  // file
            $form_fields .= '<input type="hidden" id="old_' . $id . '" name="old_' . $name . '" value="<?php echo $' . $name . ' ?>">' . PHP_EOL;
            $form_fields .= '<input type="file" class="form-control" id="' . $id . '" name="' . $name . '">' . PHP_EOL;
        } else {
            $form_fields .= '<input id="' . $name . '" name="' . $name . '"  ' . $validate . '  type="text" class="form-control" value="<?php echo $' . $name . ' ?>">' . PHP_EOL;
        }

        $form_fields .= '<div class="error" id="error_' . $name . '"></div>
                </div>
            </div>' . PHP_EOL;
    }

    $template = '<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo $title; ?></div>
            <div class="panel-body">
                <?php
                $edit_id = 0;
                $activeClass = \'\';
                if (isset($aContentInfo->id)) {
                    $edit_id = $aContentInfo->id;
                    $activeClass = \'hide\';
                }
                $attribute = array("id" => "form1", "method" => "post", "class" => "form-horizontal");
                echo form_open_multipart(\'\', $attribute);
                echo form_hidden(\'id\', $edit_id);
                ?>
                <fieldset>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3"><?php show_message() ?></div>
                    </div>' . PHP_EOL;
    $template .= $form_fields;
    $template .= '<div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <?php html_button(); ?>
                        </div>
                    </div>
                </fieldset>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>';
    return $template;
}

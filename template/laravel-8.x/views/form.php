<?php



function generate_form($form_attributes)
{
    // debug($form_attributes, 0);
    $form_fields = '';
    foreach ($form_attributes as $attribute) {
        $name = $attribute->column_name;
        $id = $attribute->column_name;
        $label = $attribute->label;
        $required = '';
        $rules = explode("|", $attribute->rules);
        if (is_array($rules) && in_array('required', $rules)) {
            $required = ' <span class="required">*</span>';
        }
        $form_fields .= '<div class="mb-3 row">
            <label for="' . $name . '" class="col-sm-2 col-form-label">' . $label . $required . '</label>
            <div class="col-sm-6">
                @php
                $' . $name . ' = \'\';
                if (!empty($_POST[\'' . $name . '\'])) {
                $' . $name . ' = $_POST[\'' . $name . '\'];
                } elseif (!empty($model->' . $name . ')) {
                $' . $name . ' = $model->' . $name . ';
                }
                @endphp' . PHP_EOL;
        if ($attribute->type == 'text') { // textarea
            $form_fields .= '<textarea rows="3" class="form-control" id="' . $id . '" name="' . $name . '">{{ $' . $name . ' }}</textarea>' . PHP_EOL;
        } else if ($attribute->type == 'enum') { // select
            $enum_list = explode(",", str_replace(array("enum(", ")", "'"), "", $attribute->column_type));
            $form_fields .= '<select class="form-control" id="' . $id . '" name="' . $name . '">' . PHP_EOL;
            foreach ($enum_list as $option_value) {
                $form_fields .= '<option value="' . $option_value . '">' . ucwords($option_value) . '</option>' . PHP_EOL;
            }
            $form_fields .= '</select>' . PHP_EOL;
        } else if ($attribute->type == 'date') {  // date
            $form_fields .= '<input type="date" class="form-control" id="' . $id . '" name="' . $name . '" value="{{ $' . $name . ' }}">' . PHP_EOL;
        } else if (in_array($attribute->column_name, ['pass', 'password', 'pass_word', 'pass_hash'])) {  // password
            $form_fields .= '<input type="password" class="form-control" id="' . $id . '" name="' . $name . '" value="{{ $' . $name . ' }}">' . PHP_EOL;
        } else if (in_array($attribute->column_name, ['email', 'email_address', 'email_id'])) {  // email
            $form_fields .= '<input type="email" class="form-control" id="' . $id . '" name="' . $name . '" value="{{ $' . $name . ' }}">' . PHP_EOL;
        } else { // text
            $form_fields .= '<input type="text" class="form-control" id="' . $id . '" name="' . $name . '" value="{{ $' . $name . ' }}">' . PHP_EOL;
        }
        $form_fields .= '</div>
        </div>' . PHP_EOL;
    }

    $template = '@extends(\'admin::layouts.admin_layout\')
@section(\'content\')

<div class="conatiner">
<?php showMessage($errors); ?>
    <form method="post">
        ' . $form_fields . '
        <div class="mb-3 row">
            <div class="offset-sm-2 col-sm-6">
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </div>
    </form>
</div>

@endsection';

    return $template;
}

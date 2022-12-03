<?php
function generate_form($form_attributes, $module_url)
{
    //debug($form_attributes, 0);
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

        //---some custom array to apply validation
        $emailType = ['email', 'email_address', 'email_id'];
        $fileType = ['photo', 'image', 'file', 'profile_photo'];

        $form_fields .= '<div class="mb-3 row">
            <label for="' . $name . '" class="col-sm-2 col-form-label">' . $label . $required . '</label>
            <div class="col-sm-6">
                @php
                $' . $name . ' = old(\''. $name .'\');
                if (!empty($model->' . $name . ')) {
                $' . $name . ' = $model->' . $name . ';
                }
                @endphp' . PHP_EOL;

        if (in_array($attribute->type, ['text', 'mediumtext'])) { // textarea
            $form_fields .= '<textarea rows="3" class="form-control" id="' . $id . '" name="' . $name . '">{{ $' . $name . ' }}</textarea>' . PHP_EOL;
        } else if ($attribute->type == 'enum') { // select
            $enum_list = explode(",", str_replace(array("enum(", ")", "'"), "", $attribute->column_type));
            $form_fields .= '<select class="form-control select2" id="' . $id . '" name="' . $name . '">' . PHP_EOL;
            foreach ($enum_list as $option_value) {
                $form_fields .= '<option value="' . $option_value . '"  {{ selected_select(\'' . $option_value . '\', $' . $name . ') }}>' . ucwords($option_value) . '</option>' . PHP_EOL;
            }
            $form_fields .= '</select>' . PHP_EOL;
        } else if ($attribute->type == 'date') {  // date
            $form_fields .= '<input type="date" class="form-control" id="' . $id . '" name="' . $name . '" value="{{ $' . $name . ' }}">' . PHP_EOL;
        } else if ($attribute->type == 'datetime') {  // datetime-local
            $form_fields .= '<input type="datetime-local" class="form-control" id="' . $id . '" name="' . $name . '" value="{{ $' . $name . ' }}">' . PHP_EOL;
        } else if (in_array($attribute->column_name, ['pass', 'password', 'pass_word', 'pass_hash'])) {  // password
            $form_fields .= '<input type="password" class="form-control" id="' . $id . '" name="' . $name . '" value="{{ $' . $name . ' }}">' . PHP_EOL;
        } else if (in_array($attribute->column_name, $emailType) || in_array($attribute->comment, $emailType)) {  // email
            $form_fields .= '<input type="email" class="form-control" id="' . $id . '" name="' . $name . '" value="{{ $' . $name . ' }}">' . PHP_EOL;
        } else if (in_array($attribute->column_name, $fileType) || in_array($attribute->comment, $fileType)) {  // file
            $form_fields .= '<input type="hidden" id="old_' . $id . '" name="old_' . $name . '" value="{{ $' . $name . ' }}">' . PHP_EOL;
            $form_fields .= '<input type="file" class="form-control" id="' . $id . '" name="' . $name . '" value="{{ $' . $name . ' }}">' . PHP_EOL;
        } else { // text
            $form_fields .= '<input type="text" class="form-control" id="' . $id . '" name="' . $name . '" value="{{ $' . $name . ' }}">' . PHP_EOL;
        }
        $form_fields .= '</div>
        </div>' . PHP_EOL;
    }

    $template = '@extends(\'layouts.admin.layout\')
@section(\'content\')

<div class="conatiner">
{{ show_message($errors)}}
    <form method="post" enctype="multipart/form-data">
    @csrf
        ' . $form_fields . '
        <div class="mb-3 row">
            <div class="offset-sm-2 col-sm-6">               
                {{ form_button(["url"=>"' . $module_url . '"]) }}
            </div>
        </div>
    </form>
</div>

@endsection';

    return $template;
}

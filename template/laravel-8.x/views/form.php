<?php

function generate_form($table, $form_attributes)
{
    //debug($form_attributes);
    $form_fields = '';
    foreach ($form_attributes as $attribute) {
        $name = $attribute->column_name;
        $id = $attribute->column_name;
        $label = $attribute->label;
        $required = '';
        if (strpos($attribute->rules, 'required')) {
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
                @endphp
                <input type="text" class="form-control" id="' . $id . '" name="' . $name . '" value="{{ $' . $name . ' }}">
            </div>
        </div>' . PHP_EOL;
    }


    $template = '
@extends(\'admin::layouts.admin_layout\')
@section(\'content\')
<div class="conatiner">
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

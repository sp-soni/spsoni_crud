<?php

function generate_controller($className, $model, $table, $title, $form_attributes)
{
    $module_name = 'admin';
    $module_url = $table;

    $form_fileds = '';
    foreach ($form_attributes as $attribute) {
        $name = $attribute->column_name;
        $form_fileds .= PHP_EOL . '$model->' . $name . ' = $request->' . $name . ';';
    }

    $template = '<?php
namespace Modules\Admin\Http\Controllers;

use App\CustomComponents\AdminAbstractController;
use App\Models\\' . $model . ';' . PHP_EOL;

    $template .= 'use Illuminate\Http\Request;

class ' . $className . 'Controller extends AdminAbstractController
{

    public function index(Request $request)
    {
        $model  = new ' . $model . '();
        $data[\'aGrid\'] = $model->search($request);
        $data[\'module_url\'] = url(\'' . $module_name . '/' . $module_url . '/\');
        $data[\'breadcrumb\'] = ["" => "' . $title . ' List"];
        return view(\'' . $module_name . '::' . $module_url . '.index\', $data);
    }

    public function add(Request $request, $id)
    {
        $model  = ' . $model . '::find($id);
        if ($request->method() == "POST") {
            if (empty($model->id)) {
                $model  = new ' . $model . '();
            }
            $request->validate($model->rules());
            ' . $form_fileds . '
            if ($model->save()) {
                return redirect("/' . $module_name . '/' . $module_url . '")->withSuccess(\'' . $title . ' saved successfully\');
            }
        }
        $data[\'model\'] = $model;
        $data[\'module_url\'] = url(\'' . $module_name . '/' . $module_url . '/add\');
        $data[\'breadcrumb\'] = [
            "' . $module_name . '/' . $module_url . '" => "' . $title . ' List",
            "" => "Add/Edit"
        ];
        return view(\'' . $module_name . '::' . $module_url . '.add\', $data);
    }
}';
    return $template;
}

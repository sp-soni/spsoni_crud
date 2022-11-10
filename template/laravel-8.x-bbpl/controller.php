<?php

function generate_controller($className, $model, $table, $title, $form_attributes)
{
    $module_name = strtolower(MODULE);
    $parent_class = CONTROLLER_PARENT_CLASS;  //'App\CustomComponents\AdminAbstractController';
    $module_url = $table;

    $form_fileds = '';
    foreach ($form_attributes as $attribute) {
        $name = $attribute->column_name;
        $form_fileds .= PHP_EOL . '$model->' . $name . ' = $request->' . $name . ';';
    }

    $template = '<?php
namespace App\\Http\\Controllers\\' . ucwords($module_name).';

use ' . $parent_class . ';
use App\Models\\' . $model . ';' . PHP_EOL;

    $template .= 'use Illuminate\Http\Request;

class ' . $className . 'Controller extends ' . basename($parent_class) . '
{

    public function index(Request $request)
    {
        $model  = new ' . $model . '();
        $data[\'aGrid\'] = $model->search($request);
        $data[\'module_url\'] = url(\'' . $module_name . '/' . $module_url . '/\');
        $data[\'breadcrumb\'] = ["" => "' . $title . ' List"];
        return view(\'' . $module_name . '.' . $module_url . '.index\', $data);
    }

    public function add(Request $request, $id)
    {
        $model  = ' . $model . '::find($id);
        if ($request->method() == "POST") {
            $action = \'' . $title . ' updated\';
            if (empty($model->id)) {
                $model  = new ' . $model . '();
                $action = \'' . $title . ' created\';
            }
            $request->validate($model->rules());
            ' . $form_fileds . '
            if ($model->save()) {
                save_user_action($action, "PK :" . $model->id);
                set_message(\'' . $title . ' saved successfully\');
                return redirect("/' . $module_name . '/' . $module_url . '");
            }
        }
        $data[\'model\'] = $model;
        $data[\'module_url\'] = url(\'' . $module_name . '/' . $module_url . '/add\');
        $data[\'breadcrumb\'] = [
            "' . $module_name . '/' . $module_url . '" => "' . $title . ' List",
            "" => "Add/Edit"
        ];
        return view(\'' . $module_name . '.' . $module_url . '.add\', $data);
    }

    public function delete($id)
    {
        $model  = ' . $model . '::find($id);
        if(!empty($model->id)){
            if($model->delete()){
                save_user_action(\'' . $title . ' deleted\', "PK :" . $model->id);
                set_message(\'' . $title . ' deleted successfully\');
                return redirect("/' . $module_name . '/' . $module_url . '");
            }          
            
        }
    }
}';
    return $template;
}

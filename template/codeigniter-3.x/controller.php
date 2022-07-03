<?php

function generate_controller($className, $model, $table, $title)
{
    //custructor 
    $constructor = "\tfunction __construct()" . PHP_EOL;
    $constructor .= "\t{" . PHP_EOL;
    $constructor .= "\t\tparent::__construct();" . PHP_EOL;
    $constructor .= "\t\t" . "parent::setModule(4);" . PHP_EOL;
    $constructor .= "\t\t" . '$this->load->model(\'' . $model . '\', \'oMainModel\');' . PHP_EOL;
    $constructor .= "\t}
";

    $methods = '
public function index()
{' . PHP_EOL;
    $methods .= "\t" . '$data[\'title\'] = \'' . $title . ' List\';' . PHP_EOL;
    $methods .= "\t" . '$data[\'breadcrumb\'] = array(\'\' => $data[\'title\']);' . PHP_EOL;
    $methods .= "\t" . 'load_admin_view(\'' . $table . '/index\', $data);' . PHP_EOL;
    $methods .= "\t" . 'hide_message();' . PHP_EOL;
    $methods .= '
}' . PHP_EOL;

    $methods .= '
public function add($edit_id=0)
{' . PHP_EOL;
    $methods .= "\t" . '$data[\'title\'] = \'' . $title . ' Manage\';' . PHP_EOL;
    $methods .= "\t" . '$data[\'breadcrumb\'] = array(\'\' => $data[\'title\']);' . PHP_EOL;
    $methods .= "\t" . 'load_admin_view(\'' . $table . '/form\', $data);' . PHP_EOL;
    $methods .= "\t" . 'hide_message();' . PHP_EOL;
    $methods .= '
}' . PHP_EOL;

    $methods .= '
public function delete($delete=0)
{' . PHP_EOL;

    $methods .= '
}' . PHP_EOL;

    //Template Prepearation
    $template = "
<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class $className extends MY_Controller
{" . PHP_EOL;

    $template .= $constructor . $methods;

    $template .= "
}
";
    return $template;
}

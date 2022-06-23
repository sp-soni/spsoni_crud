<?php

function generate($className)
{
    //custructor 
    $constructor = "\tfunction __construct()" . PHP_EOL;
    $constructor .= "\t{" . PHP_EOL;
    $constructor .= "\t\tparent::__construct();" . PHP_EOL;
    $constructor .= "\t\t" . "parent::setModule(4);" . PHP_EOL;
    $constructor .= "\t\t" . '$this->load->model(\'BankDeposit_model\', \'oMainModel\');' . PHP_EOL;
    $constructor .= "\t}
";

    $methods = '
public function index()
{' . PHP_EOL;

    $methods .= '
}';

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

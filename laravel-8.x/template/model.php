<?php

function generate_model($className, $parentClass)
{

    $constructor = '';

    //Template Prepearation
    $template = "
<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');" . PHP_EOL . PHP_EOL;
    $template .= "require APPPATH . '/models/_base/$parentClass.php';" . PHP_EOL . PHP_EOL;
    $template .= "class $className extends $parentClass
{" . PHP_EOL;

    $template .= $constructor;

    $template .= "
}
";
    return $template;
}

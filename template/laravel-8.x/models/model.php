<?php

function generate_model($className, $parentClass)
{

    $template = '<?php

    namespace App\Models;
    
    use App\Models\_base\\' . $parentClass . ';
    
    
    class ' . $className . ' extends ' . $parentClass . '
    {
    }
    ';

    return $template;
}

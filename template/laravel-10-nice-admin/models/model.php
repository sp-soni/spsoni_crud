<?php

function generate_model($className, $table, $parentClass, $table_attributes = [])
{

    $template = '<?php

    namespace App\Models;    
    use App\Models\\'.BASE_FOLDER_NAME.'\\' . $parentClass . ';    
    
    class ' . $className . ' extends ' . $parentClass . '
    {
    }
    ';

    return $template;
}

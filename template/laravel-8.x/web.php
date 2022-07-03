<?php

function generate_routes($tables)
{
    $template = '<?php

    use Illuminate\Support\Facades\Route;
    
    Route::prefix(\'admin\')->group(function () {
        Route::get(\'/\', \'AdminController@index\');
    
        Route::get(\'/change_password\', \'AdminController@changePassword\');
        Route::post(\'/change_password\', \'AdminController@changePasswordPost\');
    
    
        $aRoutes = [';
    foreach ($tables as $tbl_name) {
        $controller = str_replace(' ', '', ucwords(str_replace('_', ' ', $tbl_name)));
        $template .= PHP_EOL . '"' . $tbl_name . '" => "' . $controller . 'Controller",';
    }
    $template .= '];' . PHP_EOL;

    $template .= 'foreach ($aRoutes as $key => $value) {
            Route::get(\'/\' . $key,  $value . \'@index\');
            Route::get(\'/\' . $key . \'/add/{id}\', $value . \'@add\');
            Route::post(\'/\' . $key . \'/add/{id}\', $value . \'@add\');
        }
    });
    ';

    return $template;
}

<?php

function generate_routes($route_string)
{
    $template = "<?php" . PHP_EOL;
    $template .= "defined('BASEPATH') or exit('No direct script access allowed');" . PHP_EOL . PHP_EOL;

    $template .= '$route[\'default_controller\'] = \'admin\';' . PHP_EOL;
    $template .= '$route[\'404_override\'] = \'\';' . PHP_EOL;
    $template .= '$route[\'translate_uri_dashes\'] = FALSE;' . PHP_EOL . PHP_EOL;
    $template .= '$aAdmin = array(' . PHP_EOL;
    $template .= $route_string;
    $template .= ');' . PHP_EOL;

    $template .= '
foreach ($aAdmin as $controller) {
$route["$controller/(:any)"] = "admin/$controller/$1";
$route["$controller"] = "admin/$controller/index/";
$route["$controller/(:any)/(:any)"] = "admin/$controller/$1/$2";
$route["$controller/(:any)/(:any)/(:any)"] = "admin/$controller/$1/$2/$3";
}' . PHP_EOL . PHP_EOL;

    $template .= '$str_admin = implode("|", $aAdmin);' . PHP_EOL;
    $template .= '$route' . "['^(?!'" . '.$str_admin . \').*\'' . "]= 'admin/$0';" . PHP_EOL;

    return $template;
}

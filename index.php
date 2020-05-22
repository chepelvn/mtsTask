<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 21.05.2020
 * Time: 21:43
 */
define('CURRENT_WORKING_DIR', str_replace('\\', '/', dirname(__FILE__)));
require CURRENT_WORKING_DIR.'/libs/utils.php';

spl_autoload_register(function($class){
    $dirApps = CURRENT_WORKING_DIR.'/'.config('dir.apps');
    $pathClass = $dirApps.'/'.$class.'.php';
    if(file_exists($pathClass))
        require $pathClass;
});

$pathExp = explode('/', $_GET['path']);
$app = config('sys.defaultAppPage');
$action = config('sys.defaultAppAction');
$args = [];
if(isset($pathExp[0])){
    if($pathExp[0])
        $app = $pathExp[0];
    if(isset($pathExp[1])){
        $action = $pathExp[1];
        if(count($pathExp) > 1)
            $args = array_slice($pathExp, 2);
    }
}

if(is_callable([$app, $action])){
    call_user_func_array([new $app, $action], $args);
    return ;
}

header("HTTP/1.0 404 Not Found");
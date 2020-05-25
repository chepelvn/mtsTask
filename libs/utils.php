<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 21.05.2020
 * Time: 22:07
 */
$__CONFIG = [];
function config($var = null){
    global $__CONFIG;
    $config = &$__CONFIG;
    if(!$config){
        $path = CURRENT_WORKING_DIR . "/config.ini";
        if(!file_exists($path)){
            trigger_error('Проверьте правильность пути файла конфигурации');
            exit;
        }
        $config = parse_ini_file($path); //Загрузка основной конфигурации системы;
    }
    return getValue($var, $config);
}

function getValue($param, $array){
    $exp = explode(".", $param);
    $data = (array)$array;

    foreach($exp as $key){
        if(!$key && !is_numeric($key)) continue;
        if(isset($data[$key])){
            $data = @$data[$key];
        } else {
            return null;
        }
    }

    return $data;
}

function render($template, $data = array()){
    $template = basename($template, '.php');
    extract($data);
    ob_start();
    require CURRENT_WORKING_DIR.'/'.config('dir.templates').'/'.$template.'.php';
    $content = ob_get_clean();
    require CURRENT_WORKING_DIR.'/'.config('dir.layoutBody');
}

function jsonDisplay($data){
    header("Content-Type: application/json");
    echo json_encode($data);
}

$_SCRIPTS = [];
function addScriptHead($path){
    global $_SCRIPTS;
    $_SCRIPTS[] = $path;
}

function getScriptsHead(){
    global $_SCRIPTS;
    foreach ($_SCRIPTS as $SCRIPT)
        echo "<script type=\"text/javascript\" src=\"$SCRIPT\"></script>";
}
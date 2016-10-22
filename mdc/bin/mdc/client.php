<?php

mdc_init("core.logger");
mdc_init("core.utils");


/**
 * 包含PHP文件
 * @param string $component 组件名称
 * @return mix 失败返回 -1 成功返回组件路径
 */
function mdc_init($compoment){

    $filename = implode("/", array_splice(explode("/", __FILE__), 0, -1)) . 
                    '/' . str_replace(".", "/" , $compoment) . ".php";
    if(!file_exists($filename)){
        mdc_error("$compoment not exist!");
        return -1;
    }

    require_once($filename);
    return $filename;
}

/**
 * 获取mdc根目录
 * @return string 跟目录
 */
function mdc_path_root(){
    global $root_path;
    if(empty($root_path)){
        $root_path = implode("/", array_splice(explode("/", __FILE__), 0, -1));
    }

    return $root_path;
}

/**
 * @param array $params
 */
function ApplicationRun($params){
    $app = mdc_require("core.application");
    call_user_func($app->run, $params);
}

function mdc_path_app(){
    $app_path = implode("/", array_splice(explode("/", __FILE__), 0, -3)) . '/app';
    
    return $app_path;
}

function mdc_path_app_bin($app_name){
    $app_path = mdc_path_app() . '/' . $app_name . '/bin';
    
    return $app_path;
}

?>
<?php

$components = array();

/**
 * 注册组件
 * @param  string $component 需要注册的组件
 * @param  string $filename 自动添加的文件名
 * @return
 */
function mdc_register($filename, $component){
    global $components;

    $root = mdc_path_root();
    $app_root = mdc_path_app();

    if (strstr($filename, $app_root) != null) {
        $comp_filename = substr($filename, strlen($app_root) + 1);
        $comp_filename = str_replace('.php', '', $comp_filename);
        $app_infos = explode('/', $comp_filename);
        $app_name = $app_infos[0];
        $pkgid = array_splice($app_infos, 2);
        $pkgid = implode('.', $pkgid) . '@' . $app_name;
    } else {
        $comp_filename = substr($filename, strlen($root) + 1);
        $comp_filename = str_replace('.php', '', $comp_filename);

        $pkgid = implode('.', explode('/', $comp_filename));
    }

    

    if(isset($components[$pkgid])){
        return;
    }
    $components[$pkgid] = array("file"=>$filename, "reg"=>$component);
    require_once($filename);
}

/**
 * @param  string $pkgid 组件ID
 * @return mix 失败返回-1 成功返回组件
 */
function mdc_require($pkgid){
    global $components;
    if(isset($components[$pkgid])){
        $com = $components[$pkgid];
        require_once($com["file"]);
        return $com["reg"];
    }

    $comp_type = strstr($pkgid, "@")!= null ? true : false;

    // 不存在尝试去初始化
    if(!$comp_type){
        mdc_init($pkgid);
    }else{
        $app_infos = explode('@', $pkgid);
        $path = $app_infos[0];
        $app_name = $app_infos[1];
        $app_root = mdc_path_app_bin($app_name);
        $app_full_path = $app_root. '/' . str_replace('.', '/', $path) . '.php';
        require_once($app_full_path);
    }
    
    if(isset($components[$pkgid])){
        $com = $components[$pkgid];
        require_once($com["file"]);
        return $com["reg"];
    }

    return -1;
}

call_user_func(function(){
    /**
     * 是否是cli
     * @var [type]
     */
    $is_cli = function(){
        if (php_sapi_name() == "cli")
            return true;
        return false;
    };
    $constructor = (object)array(
        "is_cli" =>$is_cli
    );
    mdc_register(__FILE__, $constructor);
});

?>
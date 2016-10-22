<?php

call_user_func(function(){
    $utils = mdc_require("core.utils");
    /**
     * [$ApplicationRun description]
     * 
     * @param mix $params 
     */
    $ApplicationRun = function($params) use($utils){
        $json = "";
        if (call_user_func($utils->is_cli)) {
            $content = @file_get_contents($params[1]);
            if(!empty($content)){
                $json = json_decode($content, true);
            }
        }else{
            $json = json_decode($params, true);
        }
        if(!isset($json["app"]["name"])) return -1;

        $query_app = $json["app"]["name"]; 
        $app = mdc_require($query_app);
        if($app === -1){
            mdc_error("app($query_app) not register" . json_encode($app));
            return -1;
        }
        if(isset($app->construct) || 
            isset($app->execute) ||
            isset($app->destroy)){
            if(0 != call_user_func($app->construct)){
                mdc_error("execute app($query_app) construct error");
                return -1;
            }
            if(0 != call_user_func($app->execute)){
                mdc_error("execute app($query_app) execute error");
                return -1;
            }
            if(0 != call_user_func($app->destroy)){
                mdc_error("execute app($query_app) destroy error");
                return -1;
            }
            return 0;
        }
        mdc_error("app($query_app) not implement functions" . json_encode($app));
        return -1;
    };

    $constructor = (object)array(
        "run" => $ApplicationRun
    );
    mdc_register(__FILE__, $constructor);
});

?>
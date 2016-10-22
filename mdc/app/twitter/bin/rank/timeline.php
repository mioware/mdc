<?php

call_user_func(function(){
    
    $construct = function(){
        mdc_info("run in construct");
    };
    $execute = function(){
        mdc_info("run in execute");
    };

    $destroy = function(){
        mdc_info("run in destroy");
    };

    $constructor = (object) array(
        "construct" => $construct,
        "execute"   => $execute,
        "destroy"   => $destroy
    );

    mdc_register(__FILE__, $constructor);
});


?>
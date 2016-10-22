<?php

function priv_log_func($level, $msg){
    $backtrace = debug_backtrace();
    
    $file = $backtrace[1]["file"];
    $line = $backtrace[1]["line"]; 

    $prefix = "";
    switch ($level) {
        case 'debug':
            $prefix = "[d] ";
            break;
        case 'info':
            $prefix = "[i] ";
            break;
        case 'warn':
            $prefix = "[w] ";
            break;
        case 'error':
            $prefix = "[e] ";
            break;
        
        default:
            return;
            break;
    }
    $prefix = $prefix . $file. ':' . $line . ': ';
    echo $prefix . $msg . PHP_EOL;
};

/**
 * 打印Info日志
 * @param string $msg
 * @return 
 */

function mdc_info($msg){
    priv_log_func("info", $msg);
}

/**
 * 打印Debug日志
 * @param string $msg
 * @return 
 */
function mdc_debug($msg) {
    priv_log_func("debug", $msg);
}

/**
 * 打印Warn日志
 * @param string $msg
 * @return 
 */
function mdc_warn($msg) {
    priv_log_func("warn", $msg);
}

/**
 * 打印Error日志
 * @param string $msg
 * @return 
 */
function mdc_error($msg) {
    priv_log_func("error", $msg);
}


?>
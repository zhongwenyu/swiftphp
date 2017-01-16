<?php
/*
 * 打印函数
 */
function p($arr){
    echo "<pre style='padding:10px;border-radius:5px;background:#f5f5f5;border:1px solid #ccc;font-size:14px'>";
    if(is_bool($arr)){
        var_dump($arr);
    }else if(is_null($arr)){
        var_dump(NULL);
    }else{
        echo print_r($arr,true);
    }
    echo "</pre>";
}

/**
 * name
 * @desc desc
 * @param type value
 * @return type value
 */
function halt($error,$level = "ERROR",$type = 3,$dest = null){
    if(is_array($error)){
        Log::write($error['message'],$level,$type,$dest);
    }else{
        Log::write($error,$level,$type,$dest);
    }

    $e = array();
    if(DEBUG){
        if(!is_array($error)){
            $trace = debug_backtrace();
            $e['message'] = $error;
            $e['file'] = $trace[0]['file'];
            $e['line'] = $trace[0]['line'];
            $e['class'] = isset($trace[0]['class']) ? $trace[0]['class'] : "";
            $e['function'] = isset($trace[0]['function']) ? $trace[0]['function'] : "";
            ob_start();
            debug_print_backtrace();
            $e['trace'] = htmlspecialchars(ob_get_clean());
        }else{
            $e = $error;
        }
    }else{
        if($url = C('ERROR_URL')){
            go($url);
        }else{
            $e['message'] = C('ERROR_MSG');
        }
    }
    include DATA_PATH."/Tpl/halt.html";
    die;
}

/**
 * name
 * @desc desc
 * @param type value
 * @return type value
 */
function go($url,$time = 0){
    if(!headers_sent()){
        $time == 0 ? header('Location:'.$url) : header("refresh:{$time};url={$url}");
    }else{
        echo "<meta http-equiv='Refresh' content='{$time};url={$url}'>";
    }
}

/**
 * C方法
 * $desc 加载、读取、改变配置项
 * @param type $var
 * @param type $value
 * @return type $config
 */
function C($var = null,$value = null){
    static $config = array();
    //加载配置项
    if(is_array($var)){
        $config = array_merge($config,array_change_key_case($var,CASE_UPPER));
        return;
    }
    //读取、改变配置项
    if(is_string($var)){
        $var = strtoupper($var);
        //两个参数传递
        if(!is_null($value)){
            $config[$var] = $value;
            return;
        }
        return isset($config[$var]) ? $config[$var] : null;
    }
    //返回所有配置项
    if(is_null($var) && is_null($value)){
        return $config;
    }
}

/**
 * U方法
 * $desc 获取url地址
 * @param type $url
 * @return type $arr
 */
function U($str,$arr = null){
    $url = "";
    $num = substr_count($str,'/');
    switch($num){
        case 2 : $url .= ROOT_PATH.'/'.$str;
            break;
        case 1 : $url .= APP_PATH.'/'.$str;
            break;
    }
    if(!is_null($arr)){
        foreach($arr as $k => $v){
            $arr[$k] = $k.'='.$v;
        }
        $url .= "?".implode('&',$arr);
    }
    return $url;
}

/**
 * name
 * @desc desc
 * @param type value
 * @return type value
 */
function M($table = null){
    $model = new Model($table);
    return $model;
}
?>
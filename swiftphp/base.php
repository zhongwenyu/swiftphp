<?php
// +----------------------------------------------------------------------
// | SwiftPHP [ JUST DO ONE THING WELL ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2017  http://swiftphp.zhongwenyu.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhongwenyu <zhongwenyu1987@163.com> <http://www.zhongwenyu.com>
// +----------------------------------------------------------------------
// | Times: 2017/1/14 17:35
// +----------------------------------------------------------------------

define('SWIFTPHP_VERSION', '1.0.0');  //swiftphp版本
define('APP_START_TIME', microtime(true));  //应用开始时间戳
define('APP_START_MEM', memory_get_usage());  //获取内存使用情况
define('EXT','.php');  //定义文件后缀
define('DS',DIRECTORY_SEPARATOR);  //路径分隔符
defined('ROOT_PATH') or define('ROOT_PATH',__DIR__.DS);  //定义框架根目录
define('LIB_PATH',ROOT_PATH.'library'.DS);  //定力核心目录
define('CORE_PATH',LIB_PATH.'swift'.DS);  //定义核心类库目录
define('EXTEND_PATH',ROOT_PATH.'extend'.DS);  //定义扩展目录
define('DATA_PATH',ROOT_PATH.'data'.DS);
defined('CONF_PATH') or define('CONF_PATH',APP_PATH);
defined('RUNTIME_PATH') or define('RUNTIME_PATH',ROOT_PATH.'runtime'.DS);  //定义文件目录
defined('LOG_PATH') or define('LOG_PATH',RUNTIME_PATH.'log'.DS);  //定义日记目录
defined('CACHE_PATH') or define('CACHE_PATH',RUNTIME_PATH.'cache'.DS);  //定义缓存目录
defined('TEMP_PATH') or define('TEMP_PATH',RUNTIME_PATH.'temp'.DS);  //定义临时模板目录
define('IS_WIN',strpos(PHP_OS,'WIN') === false ? false : true);  //环境常量，是否win

// 载入Loader类
require CORE_PATH.'Loader.php';

// 注册自动加载
\swift\Loader::register();

// 注册错误处理
\swift\Error::register();

// 加载惯例配置文件
\swift\Config::set(include DATA_PATH.'config.php');

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








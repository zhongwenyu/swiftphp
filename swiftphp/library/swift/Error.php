<?php
// +----------------------------------------------------------------------
// | SwiftPHP [ JUST DO ONE THING WELL ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2017  http://swiftphp.zhongwenyu.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhongwenyu <zhongwenyu1987@163.com> <http://www.zhongwenyu.com>
// +----------------------------------------------------------------------
// | Times: 2017/1/14 22:05
// +----------------------------------------------------------------------
namespace swift;

use swift\exception\ErrorException;
use swift\exception\Handle;

class Error{
    public static function register(){
        error_reporting(E_ALL);
        set_error_handler(array(__CLASS__, 'appError'));
        set_exception_handler(array(__CLASS__, 'appException'));
        register_shutdown_function(array(__CLASS__,'appShutdown'));
    }

    /**
     * 错误处理
     * @param integer $errorcode 错误编号
     * @param integer $errormsg 详细错误信息
     * @param string $errorfile 出错文件
     * @param string $errorline 出错行号
     * @param array $errortext 错误上下文，会包含错误触发处作用域内所有变量的数组
     * @throw ErrorException
     */
    public static function appError($errorcode,$errormsg,$errorfile,$errorline,$errortext = array()){

    }

    public static function appException($e){
        $r = self::getExceptionHandler()->report($e);
    }

    public static function appShutdown(){
        if(!is_null($error = error_get_last()) && self::isFatal($error['type'])){
            $exception = new ErrorException($error['type'], $error['message'], $error['file'], $error['line']);
            self::appException($exception);
        }
    }

    /**
     * 确定错误类型是否致命
     * @param int $type
     * @return bool
     */
    protected static function isFatal($type){
        return in_array($type, [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE]);
    }

    public static function getExceptionHandler(){
        static $handle;
        if(!$handle){
            $handle = new Handle;
        }
        return $handle;
    }
}
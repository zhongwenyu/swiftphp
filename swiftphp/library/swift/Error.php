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
     * ������
     * @param integer $errorcode ������
     * @param integer $errormsg ��ϸ������Ϣ
     * @param string $errorfile �����ļ�
     * @param string $errorline �����к�
     * @param array $errortext ���������ģ���������󴥷��������������б���������
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
     * ȷ�����������Ƿ�����
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
<?php
// +----------------------------------------------------------------------
// | SwiftPHP [ JUST DO ONE THING WELL ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2017  http://swiftphp.zhongwenyu.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhongwenyu <zhongwenyu1987@163.com> <http://www.zhongwenyu.com>
// +----------------------------------------------------------------------
// | Times: 2017/1/15 11:12
// +----------------------------------------------------------------------
namespace swift;

class Log{
    //日记信息
    protected static $log = array();

    /**
     * 记录调试信息
     * @param mixed  $msg  调试信息
     * @return string $type 信息类型
     */
    public static function record($msg,$type = 'log'){
        self::$log[$type][] = $msg;
    }
}
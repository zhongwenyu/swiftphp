<?php
// +----------------------------------------------------------------------
// | SwiftPHP [ JUST DO ONE THING WELL ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2017  http://swiftphp.zhongwenyu.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhongwenyu <zhongwenyu@zhongwenyu.com> <http://www.zhongwenyu.com>
// +----------------------------------------------------------------------
// | Times: 2017/1/13 11:08
// +----------------------------------------------------------------------
class Log{
    static public function write($msg,$level = "ERROR",$type = 3,$dest = null){
        if(!C('SAVE_LOG')) return;
        if(is_null($dest)){
            $dest = LOG_PATH.'/'.date('Y-m-d').'.log';
        }
        if(is_dir(LOG_PATH)) error_log("[TIME]:".date('Y-m-d H:i:s')."{$level}:{$msg}\r\n",$type,$dest);
    }
}
?>
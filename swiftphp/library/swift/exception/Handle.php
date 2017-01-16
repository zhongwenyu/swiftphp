<?php
// +----------------------------------------------------------------------
// | SwiftPHP [ JUST DO ONE THING WELL ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2017  http://swiftphp.zhongwenyu.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhongwenyu <zhongwenyu1987@163.com> <http://www.zhongwenyu.com>
// +----------------------------------------------------------------------
// | Times: 2017/1/15 10:54
// +----------------------------------------------------------------------
namespace swift\exception;

use swift\Exception;
use swift\App;
use swift\Log;

class Handle{
    //不需要报告的错误
    protected $ignoreReport = array(

    );

    /**
     * 错误报告
     * @param \Exception $exception
     * @return array
     */
    public function report($exception){
        if(!$this->isIgnoreReport($exception)){
            //收集异常数据
            if(APP::$debug){
                $data = array(
                    'file'    => $exception->getFile(),
                    'line'    => $exception->getLine(),
                    'message' => $exception->getMessage(),
                    'code'    => $exception->getCode(),
                );
                $log = "[{$data['code']}][{$data['message']}][{$data['file']}:{$data['line']}]";
            }else{
                $data = array(
                    'message' => $exception->getMessage(),
                    'code'    => $exception->getCode(),
                );
                $log = "[{$data['code']}][{$data['message']}]";
            }
            Log::record($log,'error');
        }
    }

    //是否不需报告
    protected function isIgnoreReport(Exception $exception){
        foreach($this->ignoreReport as $class){
            if($exception instanceof $class){
                return true;
            }
            return false;
        }
    }
}
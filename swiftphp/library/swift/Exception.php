<?php
// +----------------------------------------------------------------------
// | SwiftPHP [ JUST DO ONE THING WELL ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2017  http://swiftphp.zhongwenyu.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhongwenyu <zhongwenyu1987@163.com> <http://www.zhongwenyu.com>
// +----------------------------------------------------------------------
// | Times: 2017/1/15 10:23
// +----------------------------------------------------------------------
namespace swift;

class Exception extends \Exception{
    protected $data = array();

    final protected function setData($label, array $data)
    {
        $this->data[$label] = $data;
    }

    final public function getData()
    {
        return $this->data;
    }
}
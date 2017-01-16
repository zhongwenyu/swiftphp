<?php
// +----------------------------------------------------------------------
// | SwiftPHP [ JUST DO ONE THING WELL ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2017  http://swiftphp.zhongwenyu.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhongwenyu <zhongwenyu1987@163.com> <http://www.zhongwenyu.com>
// +----------------------------------------------------------------------
// | Times: 2017/1/15 10:42
// +----------------------------------------------------------------------
namespace swift;
class Config{
    public static function show(){
        p("Config");
    }

    //配置参数
    private static $config = array();

    //参数作用域
    private static $range = "_sys_";

    /**
     * 初始化应用或模块
     * @access public
     * @param string $module 模块名
     * @return array
     */
    public static function load($file,$name = null,$range = null){
        $range = is_null($range) ? self::$range : $range;
        if (!isset(self::$config[$range])) {
            self::$config[$range] = [];
        }
        if(file_exists($file)){
            $name = strtolower($name);
            return self::set(include $file,$name,$range);
        }else{
            return self::$config[$range];
        }
    }

    /**
     * 检测配置是否存在
     * @param string    $name 配置参数名（支持二级配置 .号分割）
     * @param string    $range  作用域
     * @return bool
     */
    public function has($name,$range = null){
        $range = is_null($range) ? self::$range : $range;
        if(!strpos($name,'.')){
            return isset(self::$config[$range][$name]);
        }else{
            $str = explode('.',$name);
            return isset(self::$config[$range][$str[0]][$str[1]]);
        }
    }

    /**
     * 获取配置参数 为空则获取所有配置
     * @param string    $name 配置参数名（支持二级配置 .号分割）
     * @param string    $range  作用域
     * @return mixed
     */
    public static function get($name = null,$range = null){
        $range = is_null($range) ? self::$range : $range;
        // 为空直接返回 已有配置
        if(is_null($name)){
            return self::$config[$range];
        }else{
            $name = strtolower($name);
            if(!strpos($name,'.')){
                return isset(self::$config[$range][$name]) ? self::$config[$range][$name] : null;
            }else{
                $str = explode('.',$name);
                return isset(self::$config[$range][$str[0]][$str[1]]) ? self::$config[$range][$str[0]][$str[1]] : null;
            }
        }
    }

    /**
     * 设置配置参数 name为数组则为批量设置
     * @param string|array  $name 配置参数名（支持二级配置 .号分割）
     * @param mixed         $value 配置值
     * @param string        $range  作用域
     * @return array
     */
    public static function set($name,$value = null,$range = null){
        $range = is_null($range) ? self::$range : $range;
        if(!isset(self::$config[$range])){
            self::$config[$range] = array();
        }

        if(is_string($name)){
            if(!strpos($name,'.')){
                self::$config[$range][strtolower($name)] = $value;
            }else{
                $str = explode('.',$name);
                self::$config[$range][strtolower($str[0])][$str[1]] = $value;
            }
            return;
        }elseif(is_array($name)){
            $name = array_change_key_case($name);
            foreach($name as $k => $v){
                if(isset(self::$config[$range][$k])){
                    array_merge(self::$config[$range][$k],$v);
                }else{
                    self::$config[$range][$k] = $v;
                }
            }
            return;
        }else {
            // 为空直接返回 已有配置
            return self::$config[$range];
        }
    }
}
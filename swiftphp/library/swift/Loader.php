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
namespace swift;

class Loader{
    //类名映射
    protected static $map = array();

    //命名空间别名
    protected static $namespaceAlias = array();

    // PSR-4
    private static $prefixDirsPsr4 = array();

    //自动加载的文件
    private static $autoLoadFiles = array();

    //自动加载
    private static function _autoload($class){
        // 检测命名空间别名
        if (!empty(self::$namespaceAlias)) {
            $namespace = dirname($class);
            if (isset(self::$namespaceAlias[$namespace])) {
                $original = self::$namespaceAlias[$namespace] . '\\' . basename($class);
                if (class_exists($original)) {
                    return class_alias($original, $class, false);
                }
            }
        }
        if($file = self::findFile($class)){
            include_file($file);
        }
    }

    public static function findFile($class){
        //查找类库映射
        if(!empty(self::$map[$class])){
            return self::$map[$class];
        }

        // 查找 PSR-4
        $logicalPathPsr4 = ltrim(strtr($class, '\\', DS),DS) . EXT;
        $prefix = substr($logicalPathPsr4,0,strpos($logicalPathPsr4,DS) + 1);
        if(isset(self::$prefixDirsPsr4[$prefix])){
            return dirname(self::$prefixDirsPsr4[$prefix]).DS.$logicalPathPsr4;
        }
        return false;
    }

    public static function register($autoload = null){
        // 注册系统自动加载
        spl_autoload_register(array(__CLASS__,is_null($autoload) ? '_autoload' : $autoload));

        // 注册命名空间定义
        self::addNamespace([
            'swift'    => LIB_PATH . 'swift' . DS,
        ]);
    }

    // 注册命名空间
    public static function addNamespace($namespace, $path = '')
    {
        if (is_array($namespace)) {
            foreach ($namespace as $prefix => $paths) {
                self::addPsr4($prefix . '\\', rtrim($paths, DS), true);
            }
        } else {
            self::addPsr4($namespace . '\\', rtrim($path, DS), true);
        }
    }

    // 注册classmap
    public static function addClassMap($class, $map = '')
    {
        if(is_array($class)) {
            self::$map = array_merge(self::$map, $class);
        } else {
            self::$map[$class] = $map;
        }
    }

    // 添加Psr4空间
    private static function addPsr4($prefix, $paths,$prepend = false)
    {
        if(!isset(self::$prefixDirsPsr4[$prefix])){
            $length = strlen($prefix);
            if(DS !== $prefix[$length - 1]){
                halt("A non-empty PSR-4 prefix must end with a namespace separator.");
            }
            self::$prefixDirsPsr4[$prefix] = $paths;
        }
    }

    //注册命名空间别名
    public static function addNamespaceAlias($namespace,$original = null){
        if(is_array($namespace)){
            self::$namespaceAlias = array_merge(self::$namespaceAlias, $namespace);
        }else{
            self::$namespaceAlias[$namespace] = $original;
        }
    }
}

function include_file($file){
    return include $file;
}

function require_file($file)
{
    return require $file;
}

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
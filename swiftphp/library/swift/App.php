<?php
// +----------------------------------------------------------------------
// | SwiftPHP [ JUST DO ONE THING WELL ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2017  http://swiftphp.zhongwenyu.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhongwenyu <zhongwenyu1987@163.com> <http://www.zhongwenyu.com>
// +----------------------------------------------------------------------
// | Times: 2017/1/15 13:38
// +----------------------------------------------------------------------
namespace swift;

use swift\Request;
use think\Exception;

class App
{

    //是否初始化过
    protected static $init = false;

    //应用调试模式
    public static $debug = true;

    //应用类库命名空间
    public static $namespace = 'app';

    protected static $dispatch;

    /**
     * 执行应用程序
     * @param Request $request Request对象
     * @return Response
     */
    public static function run(Request $request = null)
    {
        is_null($request) && $request = Request::instance();

        try{
            $config = self::initcommon();
            $request->filter($config['default_filter']);

            // 获取应用调度信息
            $dispatch = self::$dispatch;

            if (empty($dispatch)) {
                // 进行URL路由检测
                $dispatch = self::routeCheck($request, $config);
                p($dispatch);
            }

        }catch(Exception $e){

        }

    }

    /**
     * 初始化应用
     * @param string
     * @return array
     */
    public static function initcommon()
    {
        if (self::$init == false) {
            $config = self::init();

            //调试模式
            if(!self::$debug){
                ini_get('display_errors','Off');
            }

            //注册命名空间
            self::$namespace = $config['app_namespace'];

            // 设置系统时区
            date_default_timezone_set($config['default_timezone']);

            self::$init = true;

            return $config;
        }
    }

    /**
     * 初始化模块，读取配置
     * @param string
     * @return array
     */
    public static function init($module = '')
    {
        // 定位模块目录
        $module = $module ? $module . DS : '';
        // 加载模块配置
        $path = APP_PATH.$module;
        $config = Config::load(CONF_PATH.$module.'config'.EXT);
        // 读取数据库配置文件
        Config::load(CONF_PATH.$module.'database'.EXT);
        // 读取扩展配置文件
        if(is_dir(CONF_PATH.$module.'extra')){
            $dir = CONF_PATH.$module.'extra';
            $files = scandir($dir);
            foreach($files as $file){
                if(strpos($file,EXT)){
                    $filename = $dir . DS . $file;
                    Config::load($filename);
                }
            }
        }

        // 加载公共文件
        if (is_file($path . 'common' . EXT)) {
            include $path . 'common' . EXT;
        }
        return Config::get();
    }

    /**
     * URL路由检测（根据PATH_INFO)
     * @access public
     * @param  \think\Request $request
     * @param  array          $config
     * @return array
     * @throws \think\Exception
     */
    public static function routeCheck($request, array $config){
        $path   = $request->path();
        return $path;
    }
}
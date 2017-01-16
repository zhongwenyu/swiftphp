<?php
// +----------------------------------------------------------------------
// | SwiftPHP [ JUST DO ONE THING WELL ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2017  http://swiftphp.zhongwenyu.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhongwenyu <zhongwenyu@zhongwenyu.com> <http://www.zhongwenyu.com>
// +----------------------------------------------------------------------
// | Times: 2017/1/12 17:23
// +----------------------------------------------------------------------
final class Application{
    public static function run(){
        self::_init();
        set_error_handler(array(__CLASS__,'error'));
        register_shutdown_function(array(__CLASS__,"fatal_error"));
        self::_user_import();
        self::_set_url();
        spl_autoload_register(array(__CLASS__,'_autoload'));
        self::_create_demo();
        self::_app_run();
    }

    public static function fatal_error(){
        echo 222;
    }

    public static function error($errorcode,$error,$file,$line){
        echo "处理了";
    }

    /*
     * 自动载入功能
     */
    private static function _autoload($className){
        switch(true){
            case strlen($className) > 10 && substr($className,-10) == "Controller":
                $path = APP_CONTROLLER_PATH.'/'.$className.'.class.php';
                if(!file_exists($path)) halt($path." 控制器未找到");
                include $path;
                break;
            case strlen($className) > 5 && substr($className,-5) == "Model":
            default:
                $path = COMMON_MODEL_PATH.'/'.$className.'.class.php';
                if(!file_exists($path)) halt($path." 类未找到");
                include $path;
                break;
        }
    }

    /*
     * 初始化框架
     */
    private static function _init(){
        //加载配置项
        C(include CONFIG_PATH.'/config.php');
        //公共配置项
        $commonPath = COMMON_CONFIG_PATH.'/config.php';
        $commonConfig = <<<str
<?php
return array(
    //配置项 => 配置值
);
str;
        file_exists($commonPath) || file_put_contents($commonPath,$commonConfig);
        //加载公共配置项
        C(include $commonPath);

        //用户配置项
        $userPath = APP_CONFIG_PATH.'/config.php';
        $userConfig = <<<str
<?php
return array(
    //配置项 => 配置值
);
str;
        file_exists($userPath) || file_put_contents($userPath,$userConfig);
        //加载用户配置项
        C(include $userPath);
        //设置默认时区
        date_default_timezone_set(C('DEFAULT_TIME_ZONE'));
        //开启session
        C('SESSION_AUTO_START') && session_start();
    }

    /*
     * 设置外部路径
     */
    private static function _set_url(){
        $is_http = empty($_SERVER['HTTPS']) ? "http" : "https";
        $path = $is_http."://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
        $path = str_replace('\\','/',$path);
        define('__APP__',$path);
        define('__ROOT__',dirname(__APP__));
        define('__TPL__',__ROOT__.'/'.APP_NAME.'/Tpl');
        define('__PUBLIC__',__TPL__.'/Public');
    }

    /*
     * 创建默认控制器
     */
    private static function _create_demo(){
        $path = APP_CONTROLLER_PATH.'/IndexController.class.php';
        $str = <<<str
<?php
class IndexController extends Controller{
    public function index(){
        echo "OK";
    }
}
?>
str;
        file_exists($path) || file_put_contents($path,$str);
    }

    /*
     * 实例化控制器
     */
    private static function _app_run(){
        $c = isset($_GET[C('VAR_CONTROLLER')]) ? $_GET[C('VAR_CONTROLLER')] : 'Index';
        $a = isset($_GET[C('VAR_ACTION')]) ? $_GET[C('VAR_ACTION')] : 'index';
        define('CONTROLLER',$c);
        define('ACTION',$a);
        $c .= "Controller";
        $obj = new $c();
        $obj->$a();
    }

    /**
     * 载入自定义类库
     * @desc desc
     * @param type value
     * @return type value
     */
    private static function _user_import(){
        $fileArr = C('AUTO_LOAD_FILES');
        if(is_array($fileArr) && !empty($fileArr)){
            foreach($fileArr as $v){
                require_once COMMON_LIB_PATH.'/'.$v;
            }
        }
    }
}
?>
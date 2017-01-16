<?php
// +----------------------------------------------------------------------
// | SwiftPHP [ JUST DO ONE THING WELL ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2017  http://swiftphp.zhongwenyu.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhongwenyu <zhongwenyu@zhongwenyu.com> <http://www.zhongwenyu.com>
// +----------------------------------------------------------------------
// | Times: 2017/1/12 16:40
// +----------------------------------------------------------------------
final class swiftphp{
    public static function run(){
        self::_set_const();
        defined('DEBUG') || define('DEBUG',false);
        if(DEBUG){
            self::_create_dir();
            self::_import_file();
        }else{
            include TEMP_PATH.'/~boot.php';
            error_reporting(0);
        }
        Application::run();
    }

    /*
     * 设置框架所需常量
     */
    private static function _set_const(){
        $path = str_replace("\\","/",dirname(__FILE__));
        //定义框架目录
        define('SWIFTPHP_PATH',$path);
        define('CONFIG_PATH',SWIFTPHP_PATH."/Config");
        define('DATA_PATH',SWIFTPHP_PATH."/Data");
        define('LIB_PATH',SWIFTPHP_PATH."/Lib");
        define('CORE_PATH',LIB_PATH."/Core");
        define('FUNCTION_PATH',LIB_PATH."/Function");
        define('ROOT_PATH',dirname(SWIFTPHP_PATH));
        //扩展目录
        define('EXTENDS_PATH',SWIFTPHP_PATH.'/Extends');
        define('EXTENDS_ORG_PATH',EXTENDS_PATH.'/Org');
        define('EXTENDS_TOOL_PATH',EXTENDS_PATH.'/Tool');
        //临时目录
        define('TEMP_PATH',SWIFTPHP_PATH.'/Temp');
        //日记目录
        define('LOG_PATH',TEMP_PATH.'/Log');
        //应用目录
        define('APP_PATH',ROOT_PATH."/".APP_NAME);
        define('APP_CONFIG_PATH',APP_PATH."/Config");
        define('APP_CONTROLLER_PATH',APP_PATH."/Controller");
        define('APP_TPL_PATH',APP_PATH."/Tpl");
        define('APP_PUBLIC_PATH',APP_TPL_PATH."/Public");
        //公共目录
        define('COMMON_PATH',ROOT_PATH."/Common");
        //公共配置目录
        define('COMMON_CONFIG_PATH',COMMON_PATH."/Config");
        //公共模型目录
        define('COMMON_MODEL_PATH',COMMON_PATH."/Model");
        //公共库目录
        define('COMMON_LIB_PATH',COMMON_PATH."/Lib");

        define('IS_POST',($_SERVER['REQUEST_METHOD'] == 'POST') ? true : false);
        define('IS_GET',($_SERVER['REQUEST_METHOD'] == 'GET') ? true : false);
        define('IS_AJAX',(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') ? true : false);

        //smarty编译目录
        define('COMPILE_PATH',ROOT_PATH."/Runtime/Temp/".APP_NAME);
        //smarty缓存目录
        define('CACHE_PATH',ROOT_PATH."/Runtime/Cache/".APP_NAME);
    }

    /*
     * 创建应用目录
     */
    private static function _create_dir(){
        $arr = array(
            APP_PATH,
            APP_CONFIG_PATH,
            APP_CONTROLLER_PATH,
            APP_TPL_PATH,
            APP_PUBLIC_PATH,
            TEMP_PATH,
            LOG_PATH,
            COMMON_PATH,
            COMMON_CONFIG_PATH,
            COMMON_MODEL_PATH,
            COMMON_LIB_PATH,
            ROOT_PATH.'/Runtime',
            COMPILE_PATH,
            CACHE_PATH
        );
        foreach($arr as $v){
            is_dir($v) || mkdir($v,0777,true);
        }
    }

    /*
     * 载入框架所需文件
     */
    private static function _import_file(){
        $fileArr = array(
            CORE_PATH.'/Log.class.php',
            FUNCTION_PATH.'/function.php',
            EXTENDS_ORG_PATH.'/Smarty/Smarty.class.php',
            CORE_PATH.'/SmartyView.class.php',
            CORE_PATH.'/Controller.class.php',
            CORE_PATH.'/Application.class.php',
        );
        $str = "";
        foreach($fileArr as $v){
            $str .= substr(trim(file_get_contents($v)),5,-2);
            require_once $v;
        }
        $str = "<?php\r\n".$str."?>";

        file_put_contents(TEMP_PATH."/~boot.php",$str) || die('access not allow');

        file_exists(APP_TPL_PATH.'/success.html') || copy(DATA_PATH.'/Tpl/success.html',APP_TPL_PATH.'/success.html');
        file_exists(APP_TPL_PATH.'/error.html') || copy(DATA_PATH.'/Tpl/error.html',APP_TPL_PATH.'/error.html');
    }
}

swiftphp::run();

?>
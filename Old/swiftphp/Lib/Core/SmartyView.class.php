<?php
// +----------------------------------------------------------------------
// | SwiftPHP [ JUST DO ONE THING WELL ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2017  http://swiftphp.zhongwenyu.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhongwenyu <zhongwenyu@zhongwenyu.com> <http://www.zhongwenyu.com>
// +----------------------------------------------------------------------
// | Times: 2017/1/14 15:03
// +----------------------------------------------------------------------
class SmartyView{
    private static $smarty = null;
    public function __construct(){
        if(!is_null(self::$smarty)) return;
        $smarty = new Smarty();
        //模板目录
        $smarty->setTemplateDir(APP_TPL_PATH.'/'.CONTROLLER.'/');
        //编译目录
        $smarty->setCompileDir(COMPILE_PATH);
        //缓存目录
        $smarty->setCacheDir(CACHE_PATH);
        //定界符
        $smarty->left_delimiter = C('LEFT_DELIMITER');
        $smarty->right_delimiter = C('RIGHT_DELIMITER');
        //缓存时间
        $smarty->cache_lifetime = C('CACHE_TIME');
        //是否开启缓存
        $smarty->caching = C('CACHE_ON');
        self::$smarty = $smarty;
    }

    /**
     * 载入模板
     * @desc desc
     * @param type value
     * @return type value
     */
    protected function display($tpl = null){
        $path = is_null($tpl) ? ACTION.'.html' : $tpl.'.html';
        $tpl_path = APP_TPL_PATH.'/'.CONTROLLER.'/'.$path;
        if(!file_exists($tpl_path)) halt($tpl_path.' 模板目录不存在！');
        self::$smarty->display($path,$_SERVER['REQUEST_URI']);
    }

    protected function assign($var,$value){
        self::$smarty->assign($var,$value);
    }

    /**
     * 是否存在缓存
     * @desc desc
     * @param type value
     * @return type value
     */
    protected function isCached($tpl = null){
        $path = is_null($tpl) ? ACTION.'.html' : $tpl.'.html';
        return self::$smarty->isCached($path,$_SERVER['REQUEST_URI']);
    }

    /**
     * 清楚指定模板缓存
     * @desc desc
     * @param type value
     * @return type value
     */
    protected function clearCache($tpl = null){
        $path = is_null($tpl) ? ACTION.'.html' : $tpl.'.html';
        return self::$smarty->clearCache($path);
    }

    /**
     * 清楚所有模板缓存
     * @desc desc
     * @param type value
     * @return type value
     */
    protected function clearAllCache(){
        return self::$smarty->clearAllCache();
    }
}
?>
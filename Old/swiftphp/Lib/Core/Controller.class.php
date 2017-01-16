<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/12
 * Time: 22:29
 */
class Controller extends SmartyView{
    private $var = array();
    /**
     * 构造函数
     * @param type value
     * @return type value
     */
    public function __construct(){
        parent::__construct();
        //构造初始化方法
        if(method_exists($this,'__init')){
            $this->__init();
        }
        if(method_exists($this,'__auto')){
            $this->__auto();
        }
    }
    /**
     * name
     * @param type value
     * @return type value
     */
    protected function success($url = null,$msg = "",$time = 3){
        $url = is_null($url) ? "window.history.back(-1)" : "window.location.href='".$url."'";
        include APP_TPL_PATH.'/success.html';
    }

    /**
     * name
     * @param type value
     * @return type value
     */
    protected function error($url = null,$msg = "",$time = 3){
        $url = is_null($url) ? "window.history.back(-1)" : "window.location.href='".$url."'";
        include APP_TPL_PATH.'/error.html';
    }
}
?>
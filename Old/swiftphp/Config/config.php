<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/12
 * Time: 18:40
 */
return array(
    //自动开启session
    'SESSION_AUTO_START' => true,
    //默认时区
    'DEFAULT_TIME_ZONE' => 'PRC',
    'VAR_CONTROLLER' => 'c',
    'VAR_ACTION' => 'a',
    //是否开启日记
    'SAVE_LOG' => true,
    //验证码位数
    'CODE_LEN' => 4,
    'ERROR_URL' => "",
    'ERROR_MSG' => "网站出错了......",
    //数据库配置参数
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => '', // 服务器地址
    'DB_NAME'   => '', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => '', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => '', // 数据库表前缀
    'DB_CHARSET'=> 'utf8',  // 字符集
    //smarty定界符
    'LEFT_DELIMITER' => '{',
    'RIGHT_DELIMITER' => '}',
    'CACHE_TIME' => 60, //缓存时间
    'CACHE_ON' => false,
);
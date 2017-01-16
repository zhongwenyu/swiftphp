<?php
// +----------------------------------------------------------------------
// | SwiftPHP [ JUST DO ONE THING WELL ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2017  http://swiftphp.zhongwenyu.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhongwenyu <zhongwenyu@zhongwenyu.com> <http://www.zhongwenyu.com>
// +----------------------------------------------------------------------
// | Times: 2017/1/14 9:05
// +----------------------------------------------------------------------
class Model{
    public static $link = null;

    public function __construct($table = null){
        $this->table = is_null($table) ? C('DB_PREFIX').$this->table : C('DB_PREFIX').$table;
        $this->__connect();
        $this->_opt();
    }

    protected $table = null;

    //保存sql语句
    private $opt = null;
    //记录sql语句，以备检查
    public static $sqls = array();

    private function _opt(){
        $this->opt = array(
            'field' => '*',
            'where' => '',
            'having' => '',
            'order' => '',
            'group' => '',
            'limit' => ''
        );
    }

    private function __connect(){
        if(is_null(self::$link)){
            $db = C('DB_TYPE').":host=".C('DB_HOST').";dbname=".C('DB_NAME').";charset=".C('DB_CHARSET');
            try{
                $pdo = new PDO($db,C('DB_USER'),C('DB_PWD'));
                //$pdo->query("set names ".C('DB_CHARSET'));
            }catch(PDOException $e){
                halt($e->getMessage());
            }
            self::$link = $pdo;
        }
    }

    public function find(){
        $result = $this->select();
        return current($result);
    }

    public function add($arr){
        $keys = "";
        $values = "";
        if(is_array($arr)){
            foreach($arr as $k => $v){
                $keys .= '`'.$this->_safe_str($k).'`,';
                $values .= is_string($v) ? "'".$this->_safe_str($v)."'," : $this->_safe_str($v).",";
            }
            $keys = trim($keys,',');
            $values = trim($values,',');
            $sql = "insert into {$this->table} ({$keys}) values ({$values})";
            return $this->execute($sql);
        }
    }

    public function select(){
        $sql = "select ".$this->opt['field']." from ".$this->table.$this->opt['where'].$this->opt['group'].$this->opt['having'].$this->opt['order'].$this->opt['limit'];
        return $this->query($sql);
    }

    public function delete(){
        if(empty($this->opt['where'])) halt("删除语句必须有where条件");
        $sql = "delete from ".$this->table.$this->opt['where'];
        return $this->execute($sql);
    }

    public function where($str = null){
        if(!is_null($str)){
            $this->opt['where'] = " where ".$this->_safe_str($str);
        }
        return $this;
    }

    public function order($str = null){
        if(!is_null($str)){
            $this->opt['order'] = " order by ".$this->_safe_str($str);
        }
        return $this;
    }

    public function limit($str = null){
        if(!is_null($str)){
            $this->opt['limit'] = " limit ".$this->_safe_str($str);
        }
        return $this;
    }

    public function query($sql){
        self::$sqls[] = $sql;
        $link = self::$link;
        $obj = $link->query($sql);
        if($obj == false){
            $this->error($link->errorInfo());
        }
        if(!is_object($obj)) halt("请用execute方法");
        $result = $obj->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function execute($sql){
        self::$sqls[] = $sql;
        $link = self::$link;
        $num = $link->exec($sql);
        if($num == false){
            $this->error($link->errorInfo());
        }
        if(is_object($num)) halt("请用query方法");
        $result = $link->lastInsertId() ? $link->lastInsertId() : $num;
        return $result;
    }

    public function error($error){
        $sql = array_pop(self::$sqls);
        $message = "SQLSTATE[{$error[0]}]：{$error[1]} SQL语句 {$sql} 错误：{$error[2]}";
        halt($message);
    }

    private function _safe_str($str){
        return $str;
    }
}
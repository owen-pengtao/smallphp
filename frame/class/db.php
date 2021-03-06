<?php
/**
 * mysql数据库操作 db类
 * @author yytcpt(无影) 2008-6-10 <yytcpt@gmail.com>
 * @link http://www.d5s.cn/ 无影的博客
 */
class db {
  /**
   * 是否使用持久连接
   * @var boolean true使用持久连接，false不使用
   */
  public $pconnect = false;
  /**
   * 是否启用调试信息
   * @var boolean true启用，false不启用
   */
  public $debug;
  private $db;
  /**
   * sql语句数组，页面输出完毕后被执行
   * @var array
   */
  private $shutdown_queries;
  /**
   * sql语句数组
   * @var array
   */
  private $queries;
  private $query_id;
  /**
   * SQL查询次数
   * @var int
   */
  private $query_count;
  private $database;
  /**
   * query执行sql并缓存查询结果，query_unbuffered执行sql不缓存查询结果，query_shutdown页面输出完毕再执行sql语句
   * @var array query, query_unbuffered, query_shutdown
   */
  private $q_arr;
  private $query_log;
  /**
   * 是否开启事务
   * @var boolean true开启，false默认关闭
   */
  private $transaction;

  /**
   * db类初始化
   * 把 close_db()方法放入register_shutdown_function() 中执行 (页面输出完毕，执行close_db())<br/>
   * q_arr query执行sql并缓存查询结果，query_unbuffered执行sql不缓存查询结果，query_shutdown页面输出完毕再执行sql语句
   */
  function __construct() {
    $this->debug  = DEBUG==true ? true : true;
    $this->pconnect    = false;
    $this->transaction  = false;
    $this->query_count  = 0;
    $this->queries    = array();
    $this->query_log  = array();
    $this->shutdown_queries    = array();
    $this->q_arr  = array('query', 'query_unbuffered', 'query_shutdown');
    register_shutdown_function(array($this, "close_db"));
  }
  /**
   * connect mysql database
   * @param array 数据库参数 hostname, username, password, database, charset
   * @return boolean 是否连接mysql成功
   * @author owen 2008-6-10
   */
  function connect($db_config){
    $this->database = $db_config['database'];
    $this->db = new mysqli($db_config["hostname"], $db_config["username"], $db_config["password"], $db_config["database"]);
    $this->db->query("SET NAMES 'utf8'");
    return $this->db ? true : false;
  }
  /**
   * 新增加一条记录
   * @param string $tab 表名
   * @param array $row 被插入数据 键(字段) => 值(数据)
   * @return boolean $q_num=0时，返回 insert_id()
   * @author owen 2008-6-10
   */
  function row_insert($tab, $row){
    $sql = $this->sql_insert($tab, $row);
    $this->db->query($sql);
    return $this->insert_id();
  }
  /**
   * 取得上一步 INSERT 操作产生的 ID
   * @return int INSERT 操作产生的 ID
   * @author owen 2008-6-10
   */
  function insert_id(){
    return $this->db->insert_id;
  }
  /**
   * 更新指定记录
   * @param string $tab 表名
   * @param array $row 被更新数据 键(字段) => 值(数据)
   * @param string $where 更新条件
   * @return boolean sql语句是否执行成功，判断update所影响的记录数，用affected_rows()
   * @author owen 2008-6-10
   */
  function row_update($tab, $row, $where){
    $sql = $this->sql_update($tab, $row, $where);
    return $this->db->query($sql);
  }
  /**
   * 删除指定记录
   * @param string $tab 表名
   * @param string $where 更新条件
   * @return boolean sql语句是否执行成功，判断delete所影响的记录数，用affected_rows()
   * @author owen 2008-6-10
   */
  function row_delete($tab, $where){
    $sql = $this->sql_delete($tab, $where, $q_num=0);
    return $this->db->query($sql);
  }
  /**
   * 根据条件查询，返回所有记录
   * @param string $tab 表名
   * @param string $where 查询条件
   * @param int $limit 返回记录条数
   * @param string $fields 返回字段
   * @param string $orderby 排序字段
   * @param string $sort DESC/ASC 排列顺序
   * @return array 返回所查询的数据记录
   * @author owen 2008-6-10
   */
  function row_select($tab, $where="", $limit=0, $fields="*", $orderby="id", $sort="DESC"){
    $sql = $this->sql_select($tab, $where, $limit, $fields?$fields:'*', $orderby, $sort);
    return $this->row_query($sql);
  }
  /**
   * 根据where条件，查询查询一条数据库记录
   * @param string $tab 表名
   * @param string $where 查询条件
   * @param string $fields 返回字段
   * @return array 返回所查询的一条数据记录
   * @author owen 2008-6-10 <yytcpt@gmail.com>
   */
  function row_select_one($tab, $where, $fields="*"){
    $sql = $this->sql_select($tab, $where, 1, $fields?$fields:'*');
    return $this->row_query_one($sql);
  }
  /**
   * 执行sql语句，查询结果是多条数据
   *
   * @param string $sql sql 语句
   * @return array 查询结果
   * @author owen 2008-6-10
   */
  function row_query($sql){
    $rs     = $this->db->query($sql);
    $rs_num = $rs->num_rows;
    $rows = array();
    for($i=0; $i<$rs_num; $i++){
      $rows[] = $rs->fetch_array(MYSQLI_ASSOC);
    }
    $rs->free_result();
    $rows = stripslashes_str($rows);
    return $rows;
  }
  /**
   * 执行sql语句，查询结果是一条数据
   * @param string $sql sql 语句
   * @return array 查询结果
   * @author owen 2008-6-6
   */
  function row_query_one($sql){
    $rs   = $this->db->query($sql);
    $row  = $rs->fetch_array(MYSQLI_ASSOC);
    $rs->free_result();
    $row = stripslashes_str($row);
    return $row;
  }
  /**
   * 发送SQL 查询，并不获取和缓存结果的行
   * @param string 一条完整的sql语句
   * @return boolean 是否执行成功
   * @author owen 2008-6-10
   */
  function query_unbuffered($sql){
    return $this->query($sql, 'mysql_unbuffered_query');
  }
  /**
   * 把sql放入数组中，页面输出完毕后，执行sql语句
   * @param string 一条完整的sql语句
   * @return void
   * @author owen 2008-6-10
   */
  function query_shutdown($sql){
    $this->shutdown_queries[] = $sql;
  }
  /**
   * 取得一条SQL语句对数据库记录的影响条数，仅对 INSERT，UPDATE 或者 DELETE 有效
   * @return int 影响条数
   * @author owen 2008-6-10
   */
  function affected_rows() {
    return $this->db->affected_rows;
  }
    /**
   * 某表，某字段，加减 N
   * @param string $tab 表名
   * @param string $field 字段名
   * @param +,- $op 运算符
   * @param int $num 被加、减的数值
   * @param string $where 修改条件
   * @return boolean sql语句是否执行成功，判断delete所影响的记录数，用affected_rows()
   * @author owen 2008-6-10
   */
  function update_op($tab, $field, $op, $where, $num=1){
    $sql = "UPDATE `$tab` SET $field=$field $op $num WHERE ".$where;
    return $this->db->query($sql);
  }
  /**
   * 根据条件对某个表做总数统计
   * @param string $tab 表名
   * @param string $where 统计条件
   * @param string $auto_id 主键id
   * @return int 记录总数
   * @author owen 2008-6-10
   */
  function row_count($tab, $where="", $auto_id='id'){
    $sql = 'SELECT count('.$auto_id.') as row_sum FROM `'.$tab.'` '.($where?' WHERE '.$where:'');
    $row = $this->row_query_one($sql);
    return $row['row_sum'];
  }
  /**
   * 关闭 MySQL 连接
   * @return boolean 是否成功关闭mysql连接
   * @author owen 2008-6-10
   */
  function close_db(){
    $bool = false;
    if ($this->db){
      $this->_shutdown_db();
      $this->queries = array();
      $this->shutdown_queries = array();
      $bool = $this->db->close();
      $this->db = false;
    }
    return $bool;
  }
    /**
   * 获取数据库中所有表名
   * @return array 数据库中所有表名
   * @author owen 2008-6-10
   */
  function get_all_tables(){
    //兼容PHP5.3
    $rs = $this->db->query("SHOW TABLES FROM $this->database");
    $arr = array();
    for ($i=0; $i<$rs->num_rows; $i++) {
      $arr[] = $rs->fetch_array(MYSQLI_NUM)[0];
    }
    $rs->free_result();
    return $arr;
  }
  function sql_select($tab, $where="", $limit=0, $fields="*", $orderby="id", $sort="DESC"){
    $sql = "SELECT ".$fields." FROM `".$tab."` ".($where?" WHERE ".$where:"");
    $sql.= $limit==1 ? '' : ' ORDER BY '.$orderby." ".$sort.($limit ? " limit ".$limit:"");
    return $sql;
  }
  function sql_insert($tab, $row){
    $row = addslashes_str($row);
    $str_filed = "";
    $str_value = "";
    foreach ($row as $key=>$value) {
      $str_filed .= $key.",";
      $str_value .= "'".$value."',";
    }
    return "INSERT INTO `".$tab."`(".substr($str_filed, 0, -1).") VALUES (".substr($str_value, 0, -1).")";
  }
  function sql_update($tab, $row, $where){
    $row = addslashes_str($row);
    $str = "";
    foreach ($row as $key=>$value) {
      $str .= $key."= '".$value."',";
    }
    return "UPDATE `".$tab."` SET ".substr($str, 0, -1)." WHERE ".$where;
  }
  function sql_delete($tab, $where){
    return "DELETE FROM `".$tab."` WHERE ".$where;
  }
  function _get_microtime(){
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
  }
  /**
   * 执行shutdown_queries数组中的sql语句
   * @author owen 2008-6-10
   */
  function _shutdown_db() {
    foreach((array)$this->shutdown_queries as $query) {
      $this->query_unbuffered($query);
    }
  }
  /**
   * 执行SQL语句，并且返回结果集
   * @param string $query_id sql语句
   * @param mysql_query,mysql_unbuffered_query $query_type 查询函数
   * @return boolean 成功时返回一个资源标识符，失败时返回false
   * @author owen 2008-6-10
   */
  function query($query_id){
    $before_time  = $this->_get_microtime();
    $this->query_id = $this->db->query($query_id);
    $after_time  = $this->_get_microtime();
    $this->queries[] = $query_id;
      if (!$this->query_id) {
        $this->_halt($query_id);
    }
    $this->query_count++;
    return $this->query_id;
  }
  function __destruct(){
    $this->close_db();
  }
}
?>
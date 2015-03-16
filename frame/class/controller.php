<?php
class controller{
  public $is_include_head= 1;    //是否只包含模板  1包含 top、end文件, 0不包含
  public $is_connect_db  = 1;    //是否连接数据库  1连库， 0不连库
  public $tpl;
  public $db;
  public $meta;
  public $no_cdb;
  function meta(){
    include(PATH_CONFIG.'meta.php');
    $this->meta  = new meta();
  }
  function connect_db(){
    include(SITE_PATH.'db_config.php');
    $db_config  = new db_config();

    $this->db = new db();
    $this->db->connect($db_config->db_config);
    unset($db_config);
    return $this->db;
  }
  function head_start(){
    $this->head = new head($this->meta);
    return $this->head->head_start();
  }
  function head_end(){
    return $this->head->head_end();
  }
}
?>
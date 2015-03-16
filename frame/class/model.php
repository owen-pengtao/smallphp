<?php
class model{
  function __construct(){
    $this->t_db_error         = 'db_error';
    $this->t_address          = T.'address';
    $this->t_address_modify   = T.'address_modify';
    $this->t_address_custom   = T.'address_custom';
    $this->t_address_categories   = T.'address_categories';
    $this->t_admins           = T.'admins';
    $this->t_cache            = T.'cache';
    $this->t_feedbacks        = T.'feedbacks';
    $this->t_helps            = T.'helps';
    $this->_init_param();
  }
  function _init_param(){
    global $CONFIG;
    $this->CONFIG = $CONFIG;
    $this->where  = $this->_get_where();
    $this->by   = $_GET['by'];
    $this->order  = $_GET['order']; //DESC or ASC
  }
  function get_items_op($tab){
    $this->tab = $tab;
    if (isset($_POST['items'])){
      $items    = $_POST['items'];
      $item_op  = $_POST['item_op'];
      $where    = 'id IN ('.join(',', $items).')';

      if ($item_op=='del'){
        $this->db->row_delete($this->tab, $where);
      }else{
        $row = array();
        if ($item_op){
           list($field, $value) = explode('-', $item_op);
           $row[$field] = $value;
        }
        if (!empty($row)){
          $this->db->row_update($this->tab, $row, $where);
        }
      }
    }
  }
  function _get_where(){
    $where = array();
    if (isset($_GET['search_type']) AND isset($_GET['search_key'])){
      $search_type= $_GET['search_type'];
      $search_key = str_replace(array('%', '"', "'"), '', $_GET['search_key']);
      if ($search_type=='id'){
        $where[] = $search_type.'='.intval($search_key);
      }else{
        $where[] = $search_type.' LIKE "%'.$search_key.'%"';
      }
    }
    if (isset($_GET['other_where'])){
      foreach((array)$_GET['other_where'] AS $v){
        $where[] = $v;
      }
    }
    if (isset($_GET['where'])){
      $where[] = $_GET['where'];
    }
    return join(' AND ', $where);
  }
}
?>
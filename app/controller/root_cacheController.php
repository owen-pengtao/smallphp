<?php
class root_cacheController{

  function getAction() {
    $type = $_GET['type'];
    $row = $this->cache->getCacheByType($type);

    $tpl = new stdClass;
    $tpl->type = $type;
    $tpl->row = $row;

    if($type == 'index_page' && $row){
      $tpl->rows = $this->cache->getIndexPage($row);
    }
    return $tpl;
  }
  function saveAction() {
    $type = $_POST['type'];
    $this->is_save_file = !isset($_POST['is_save_file']) || $_POST['is_save_file']==1 ? true : false;

    $is_string = intval($_POST['is_string']);
    $cache_file = 'array_'.$type.'.php';
    if($is_string){
      $this->_save_to_cache($cache_file, $type, $_POST['content']);
    }else{
      $_POST['sortorder'] = $_POST['sortorder'] ? $_POST['sortorder'] : array();
      $delete_empty_row = intval($_POST['delete_empty_row']);
      $sortorder = array_flip($_POST['sortorder']);
      ksort($sortorder);
      unset($_POST['type'], $_POST['sortorder'], $_POST['delete_empty_row'], $_POST['is_save_file']);
      $_temp_post = $_POST;
      unset($_POST);
      if(empty($sortorder)){
        foreach($_temp_post AS $k=>$v){
          if($delete_empty_row == 1){
            foreach($v['title'] AS $kk=>$vv){
              if($vv == ''){
                foreach($v AS $_k=>$_v){
                  unset($_temp_post[$k][$_k][$kk]);
                }
              }
            }
          }
          $_POST[$k] = $_temp_post[$k];
        }
      }else{
        foreach($sortorder AS $v){
          foreach($_temp_post AS $kk=>$vv){
            $_v = $_temp_post[$kk][$v];
            if(($delete_empty_row == 1 && $_v) || $delete_empty_row != 1){
              $_POST[$kk][] = $_v;
            }
          }
        }
      }
      $this->_save_to_cache($cache_file, $type);
    }
  }

  function _save_to_cache($file, $type, $string='') {
    $cache = new cache();
    $cache->cache_file  = PATH_CACHES.$file;

    if($string){
      if($this->is_save_file){
        $cache->save_string($string);
      }
      $data = $string;
    }else{
      $cache->cache_is_str= 0;
      if($this->is_save_file){
        $cache->save_array($_POST, 0);
      }
      $data = serialize($_POST);
    }
    unset($cache);
    $this->_save_to_db($type, $data);
    header_go($_SERVER['PHP_SELF'].'?a=get&bool=1&type='.$type);
  }
  function _save_to_db($type, $data){
    $row = array(
        'content' => $data,
        'is_string' => intval($_POST['is_string']),
      );
    if($this->cache->getCacheByType($type)){
      $this->cache->updateCacheByType($row, $type);
    }else{
      $row['type'] = $type;
      $this->cache->insertCache($row);
    }
  }
  function _get_from_db($type){
    return $this->db->row_select_one(T.'cache', 'type="'.$type.'"');
  }
}
?>
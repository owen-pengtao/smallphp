<?php
class cacheModel extends model{
  function getCacheByType($type){
    $row = $this->db->row_select_one($this->t_cache, 'type="'.$type.'"');
    if($row['is_string']){
      $array = $row;
    }else{
      $array = unserialize($row['content']);
    }
    return $array;
  }
  function updateCacheByType($row, $type){
    return $this->db->row_update($this->t_cache, $row, 'type="'.$type.'"');
  }
  function insertCache($row){
    return $this->db->row_insert($this->t_cache, $row);
  }
  function getIndexPage($row){
    $article  = use_model('article');
    $topic    = use_model('topic');
    $rows   = array();
    foreach($row['id'] AS $k=>$v){
      if($row['row_type'][$k] == 1){
        $_row   = $article->getArticleById($v);
        $row_type = 1;
      }else{
        $_row   = $topic->getTopicById($v);
        $row_type = 2;
      }
      $_v = array(
        'id'	      => $_row['id'],
        'title'	    => $_row['title'],
        'row_type'	=> 1,
        'create_time'	  => $_row['create_time'],
        'last_operator'	=> $_row['last_operator'],
      );
      $_v['row_type'] = $row_type;
      $rows[] = $_v;
    }
    return $rows;
  }
}
?>

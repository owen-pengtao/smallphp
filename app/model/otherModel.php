<?php
class otherModel extends model{
  function getCacheByType($type){
    $row = $this->db->row_select_one($this->t_cache, "type='$type'");
    $str = '';
    if($row){
      if($row['is_string']==1){
        $str = $row['content'];
      }else{
        $arr = unserialize($row['content']);
        $str = $arr[$type];
      }
    }
    return $str;
  }
}
?>

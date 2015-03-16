<?php
class helpModel extends model{
 function __construct(){
    parent::__construct();
    $this->_allChildHelpIds = array();
  }
  function getHelpList(){
    $this->get_items_op($this->t_helps);

    $pl = new pagelist($this->db);
    $arr = $pl->get_rows($this->t_helps, $this->where, $this->by, $this->order);
    return $arr;
  }
  function getHelpTopicList(){
    $pl = new pagelist($this->db);
    $where = 'root_id=0';
    $arr = $pl->get_rows($this->t_helps, $where);

    return $arr;
  }
  function getMyHelpList($uid){
    $pl = new pagelist($this->db);
    $where = 'root_id=0 and uid='.$uid;
    $arr = $pl->get_rows($this->t_helps, $where);

    return $arr;
  }
  function getHelpListByPid($pid){
    $pl = new pagelist($this->db);
    $where = 'pid='.$pid;
    $arr = $pl->get_rows($this->t_helps, $where);

    return $arr;
  }
  function getHelpListByRootId($root_id){
    $pl = new pagelist($this->db);
    $where = 'root_id='.$root_id;
    $arr = $pl->get_rows($this->t_helps, $where);

    return $arr;
  }

  function getHelpById($id){
    return $this->db->row_select_one($this->t_helps, 'id='.$id);
  }
  function getHelpByPid($pid){
    return $this->db->row_select($this->t_helps, 'pid='.$pid);
  }
  function updateHelpById($row, $id){
    return $this->db->row_update($this->t_helps, $row, 'id='.$id);
  }
  function insertHelp($row){
    return $this->db->row_insert($this->t_helps, $row);
  }
  function getReplySumByRootId($id){
    return $this->db->row_count($this->t_helps, 'root_id='.$id);
  }
  function updateReplySumById($id, $op){
    return $this->db->update_op($this->t_helps, "reply_sum", $op, 'id='.$id);
  }

  function deleteHelpById($id){
    $row = $this->getHelpById($id);
    if($row){
      if($row['root_id']==0){
        $this->deleteHelpByRootId($row['id']);  //主贴，删除所有回复
        $this->db->row_delete($this->t_helps, 'id='.$id);
      }else{
        $this->resetAllChildArr();
        $this->getAllChildById($row['id']);
        $this->deleteHelpByIds($this->getAllChildArr());

        $this->db->row_delete($this->t_helps, 'id='.$id);

        $sum = $this->getReplySumByRootId($row['root_id']);
        $arr = array(
          "reply_sum" => $sum,
        );
        $this->db->row_update($this->t_helps, $arr, "id=".$row['root_id']);
      }
    }
  }
  function deleteHelpByIds($ids){
    if($ids){
      $this->db->row_delete($this->t_helps, "id IN (".join(",", $ids).")");
    }
  }
  function deleteHelpByPid($pid){
    return $this->db->row_delete($this->t_helps, 'pid='.$pid);
  }
  function deleteHelpByRootId($root_id){
    return $this->db->row_delete($this->t_helps, 'root_id='.$root_id);
  }
  function getAllChildById($id){
    if($this->isHasChild($id)){
      $rows = $this->getHelpByPid($id);
      foreach ($rows AS $v){
        $this->_allChildHelpIds[$v['id']] = $v['id'];
        $this->getAllChildById($v['id']);
      }
    }else{
      $this->_allChildHelpIds[$id] = $id;
    }
  }
  function resetAllChildArr(){
    $this->_allChildHelpIds = array();
  }
  function getAllChildArr(){
    return $this->_allChildHelpIds;
  }
  function isHasChild($id){
    return $this->db->row_count($this->t_helps, "pid=".$id);
  }
  function getSearchHelpList($search_text){
    $pl = new pagelist($this->db);
    $where = 'pid=0 AND (title LIKE "%'.$search_text.'%" OR reply_content LIKE "%'.$search_text.'%")';
    $arr = $pl->get_rows($this->t_helps, $where);

    return $arr;
  }
}
?>

<?php
class dberrorModel extends model{
  function getDbErrorList(){
    $this->get_items_op($this->t_db_error);

    $pl = new pagelist($this->db);
    $arr = $pl->get_rows($this->t_db_error, $this->where, $this->by, $this->order);
    return $arr;
  }
  function deleteErrorById($id){
    return $this->db->row_delete($this->t_db_error, 'id='.$id);
  }
}
?>

<?php
class addressCustomModel extends model{
  function getAddressCustomList(){
    $this->get_items_op($this->t_addressCustom);

    $pl = new pagelist($this->db);
    $arr = $pl->get_rows($this->t_addressCustom, $this->where, $this->by, $this->order);
    return $arr;
  }
  function getAddressCustomById($id){
    return $this->db->row_select_one($this->t_addressCustom, 'id='.$id);
  }
  function updateAddressCustomById($row, $id){
    return $this->db->row_update($this->t_addressCustom, $row, 'id='.$id);
  }
  function insertAddressCustom($row){
    return $this->db->row_insert($this->t_addressCustom, $row);
  }
  function deleteAddressCustomById($id){
    return $this->db->row_delete($this->t_addressCustom, 'id='.$id);
  }
}
?>

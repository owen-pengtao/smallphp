<?php
class adminModel extends model{
  function getAdminList(){
    $this->get_items_op($this->t_admins);

    $pl = new pagelist($this->db);
    $arr = $pl->get_rows($this->t_admins, $this->where, $this->by, $this->order);
    return $arr;
  }
  function getAdminByUsernameAndPassword($username, $password){
    return $this->db->row_select_one($this->t_admins, 'username="'.$username.'" AND password="'.md5($password).'"');
  }
  function getAdminById($id){
    return $this->db->row_select_one($this->t_admins, 'id='.$id);
  }
  function updateAdminById($row, $id){
    return $this->db->row_update($this->t_admins, $row, 'id='.$id);
  }
  function insertAdmin($row){
    return $this->db->row_insert($this->t_admins, $row);
  }
  function deleteAdminById($id){
    return $this->db->row_delete($this->t_admins, 'id='.$id);
  }
}
?>

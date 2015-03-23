<?php
class userModel extends model{
  function getUserList(){
    $this->get_items_op($this->t_users);

    $pl = new pagelist($this->db);
    $arr = $pl->get_rows($this->t_users, $this->where, $this->by, $this->order);
    return $arr;
  }
  function getUserByUsernameAndPassword($username, $password){
    return $this->db->row_select_one($this->t_users, 'username="'.$username.'" AND password="'.md5($password).'"');
  }
  function getUserById($id){
    return $this->db->row_select_one($this->t_users, 'id='.$id);
  }
  function updateUserById($row, $id){
    return $this->db->row_update($this->t_users, $row, 'id='.$id);
  }
  function insertUser($row){
    return $this->db->row_insert($this->t_users, $row);
  }
  function deleteUserById($id){
    return $this->db->row_delete($this->t_users, 'id='.$id);
  }
}
?>

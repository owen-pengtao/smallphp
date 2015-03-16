<?php
class loginModel extends model{
  function getAdminByUsernameAndPassword($username, $password){
    return $this->db->row_select_one($this->t_admins, 'username="'.$username.'" AND password="'.md5($password).'"');
  }
  function log_login($username){
    $row = array(
      'last_login_ip'    => get_ip(),
      'last_login_time'  => time(),
    );
    return $this->db->row_update($this->t_admins, $row, 'username="'.$username.'"');
  }
}
?>

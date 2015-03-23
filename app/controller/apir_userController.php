<?php
class apir_userController extends apiController{
  function getUserListAction(){
    $rows = $this->user->getUserList();
    unset($rows['page']);
    echo $this->pushSuccessMessage($rows);
  }
  function addAction(){
    if ($_POST) {
      $row = array(
        "username"    => trim($_POST["username"]),
        "password"    => md5($_POST["password"]),
        "email"       => trim($_POST["email"]),
        "is_disable"  => intval($_POST["is_disable"]),
        "edit_time"   => time(),
        "create_time" => time(),
      );
      $this->user->insertUser($row);
      echo $this->pushSuccessMessage();
    }else{
      echo $this->pushErrorMessage(0);
    }
  }
}
?>
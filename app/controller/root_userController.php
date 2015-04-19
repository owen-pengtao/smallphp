<?php
class root_userController{
  function indexAction(){
    $tpl = new stdClass;
    $tpl->page_list = $this->user->getUserList();
    return $tpl;
  }
  function addAction(){
    $tpl = new stdClass;
    return $tpl;
  }
  function editAction(){
    $id = intval($_GET['id']);
    $tpl = new stdClass;
    $tpl->row = $this->user->getUserById($id);
    return $tpl;
  }
  function saveAction(){
    $id = intval($_POST['id']);
    $page = intval($_POST['page']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $email    = trim($_POST['email']);
    $is_disable = intval($_POST['is_disable']);

    $row = array(
          'username'   => $username,
          'email'      => $email,
          'is_disable' => $is_disable,
        );
    if($password){
      $row['password'] = md5($password);
    }

    if($id){
      $this->user->updateUserById($row, $id);
    }else{
      $this->user->insertUser($row);
    }
    go_url($_SERVER['PHP_SELF'].'?page='.$page);
  }
  function delAction(){
    $id = intval($_GET['id']);
    $page = intval($_GET['page']);
    $this->user->deleteUserById($id);
    go_url($_SERVER['PHP_SELF'].'?page='.$page);
  }
}
?>
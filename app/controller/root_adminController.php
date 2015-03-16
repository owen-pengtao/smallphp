<?php
class root_adminController{
  function indexAction(){
    $tpl = new stdClass;
    $tpl->page_list = $this->admin->getAdminList();
    return $tpl;
  }
  function addAction(){
    $tpl = new stdClass;
    return $tpl;
  }
  function editAction(){
    $id = intval($_GET['id']);
    $tpl = new stdClass;
    $tpl->row = $this->admin->getAdminById($id);
    return $tpl;
  }
  function saveAction(){
    $id = intval($_POST['id']);
    $page = intval($_POST['page']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $is_disable = intval($_POST['is_disable']);
    $grade = intval($_POST['grade']);

    $row = array(
          'username' => $username,
        );
    if($password){
      $row['password'] = md5($password);
    }
    if($_SESSION['is_root']){
      //$row['grade'] = $grade ? 9 : 1;
      $row['grade'] = 9;
      $row['is_disable'] = $is_disable;
    }

    if($id){
      $this->admin->updateAdminById($row, $id);
    }else{
      $this->admin->insertAdmin($row);
    }
    go_url($_SERVER['PHP_SELF'].'?page='.$page);
  }
  function delAction(){
    $id = intval($_GET['id']);
    $page = intval($_GET['page']);
    $this->admin->deleteAdminById($id);
    go_url($_SERVER['PHP_SELF'].'?page='.$page);
  }
}
?>
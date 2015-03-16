<?php
class root_addressController{
  function indexAction(){
    $tpl = new stdClass;
    $tpl->page_list = $this->address->getAddressList();
    return $tpl;
  }
  function addAction(){
    $tpl = new stdClass;
    return $tpl;
  }
  function editAction(){
    $id = intval($_GET['id']);
    $tpl = new stdClass;
    $tpl->row = $this->address->getAddressById($id);
    return $tpl;
  }
  function saveAction(){
    $id = intval($_POST['id']);
    $page = intval($_POST['page']);

    $title       = trim($_POST['title']);
    $address     = trim($_POST['address']);
    $tel         = trim($_POST['tel']);

    $x           = trim($_POST['x']);
    $y           = trim($_POST['y']);
    $remark      = trim($_POST['remark']);

    $row = array(
          'title'   => $title,
          'address' => $address,
          'tel'     => $tel,
          'x'       => $x,
          'y'       => $y,
          'remark'  => $remark,
        );

    if($id){
      $this->address->updateAddressById($row, $id);
    }else{
      $this->address->insertAddress($row);
    }
    go_url($_SERVER['PHP_SELF'].'?page='.$page);
  }
  function delAction(){
    $id = intval($_GET['id']);
    $page = intval($_GET['page']);
    $this->address->deleteAddressById($id);
    go_url($_SERVER['PHP_SELF'].'?page='.$page);
  }
}
?>
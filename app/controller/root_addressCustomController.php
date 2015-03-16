<?php
class root_addressCustomController{
  function indexAction(){
    $tpl = new stdClass;
    $tpl->page_list = $this->addressCustom->getAddressCustomList();
    return $tpl;
  }
  function approvalFixAction(){
    $id = intval($_POST['id']);
    $page = intval($_POST['page']);

    $row = array(
          'is_read'  		  => 1,
          'is_approval'   => 1,
        );

    if($id){
      $this->addressCustom->updateAddressCustomById($row, $id);
      $row = $this->addressCustom->getAddressCustomById($id);
      $arr = array(
        'title'   => $row['title'],
        'address' => $row['address'],
        'tel'     => $row['tel'],

        'x'       => $row['x'],
        'y'    	  => $row['y'],
        'is_custom'   => 1,
        'remark' 	    => $row['remark'],
        'source_data'	=> '',
        'create_time' => $row['create_time'],
      );
      $address = use_model('address');
      $address->updateAddressById($arr, $row['source_id']);
    }
    go_url($_SERVER['PHP_SELF'].'?page='.$page);
  }
  function approvalNewAction(){
    $id = intval($_POST['id']);
    $page = intval($_POST['page']);

    $row = array(
          'is_read'  		  => 1,
          'is_approval'   => 1,
        );

    if($id){
      $this->addressCustom->updateAddressCustomById($row, $id);
      $row = $this->addressCustom->getAddressCustomById($id);
      $arr = array(
        'cid' 	  => $row['cid'],  //??
        'title'   => $row['title'],
        'address' => $row['address'],
        'tel'     => $row['tel'],

        'x'       => $row['x'],
        'y'    	  => $row['y'],
        'is_custom'   => 1,
        'remark' 	    => $row['remark'],
        'source_data'	=> '',
        'create_time' => $row['create_time'],
      );
      $address = use_model('address');
      $address->insertAddress($arr);
    }
    go_url($_SERVER['PHP_SELF'].'?page='.$page);
  }
  function delAction(){
    $id = intval($_GET['id']);
    $page = intval($_GET['page']);
    $this->addressCustom->deleteAddressCustomById($id);
    go_url($_SERVER['PHP_SELF'].'?page='.$page);
  }
}
?>
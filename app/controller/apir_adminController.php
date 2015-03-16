<?php
class apir_adminController extends apiController{
  function getAdminListAction(){
    $rows = $this->admin->getAdminList();
    unset($rows['page']);
    echo $this->pushSuccessMessage($rows);
  }
}
?>
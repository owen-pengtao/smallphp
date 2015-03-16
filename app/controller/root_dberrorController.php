<?php
class root_dberrorController{
  function indexAction(){
    $tpl = new stdClass;
    $tpl->page_list = $this->dberror->getDbErrorList();
    return $tpl;
  }
  function delAction(){
    $id = intval($_GET['id']);
    $page = intval($_GET['page']);
    $this->dberror->deleteErrorById($id);
    go_url($_SERVER['PHP_SELF'].'?page='.$page);
  }
}
?>
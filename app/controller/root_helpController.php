<?php
class root_helpController{
  function indexAction(){
    $tpl = new stdClass;
    $tpl->page_list = $this->help->getHelpList();
    return $tpl;
  }
  function delAction(){
    $id = intval($_GET['id']);
    $page = intval($_GET['page']);
    $this->help->deleteHelpById($id);
    go_url($_SERVER['PHP_SELF'].'?page='.$page);
  }
}
?>
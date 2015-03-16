<?php
class root_feedbackController{
  function indexAction(){
    $tpl = new stdClass;
    $tpl->page_list = $this->feedback->getFeedbackList();
    return $tpl;
  }
  function delAction(){
    $id = intval($_GET['id']);
    $page = intval($_GET['page']);
    $this->feedback->deleteFeedbackById($id);
    go_url($_SERVER['PHP_SELF'].'?page='.$page);
  }
}
?>
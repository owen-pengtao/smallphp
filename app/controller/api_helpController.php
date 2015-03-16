<?php
class api_helpController extends apiController{
  function getHelpListAction(){
    $rows = $this->help->getHelpTopicList();
    unset($rows['page']);
    echo $this->pushSuccessMessage($rows);
  }
  function getMyHelpListAction(){
    $uid = intval($_REQUEST['uid']);
    if($uid){
      $rows = $this->help->getMyHelpList($uid);
      unset($rows['page']);
      echo $this->pushSuccessMessage($rows);
    }else{
      echo $this->pushErrorMessage(2);
    }
  }
  function getHelpListByPidAction(){
    $pid = intval($_REQUEST['pid']);
    if($pid){
      $rows = $this->help->getHelpListByPid($pid);
      unset($rows['page']);
      echo $this->pushSuccessMessage($rows);
    }else{
      echo $this->pushErrorMessage(2);
    }
  }
  function getHelpListByRootIdAction(){
    $root_id = intval($_REQUEST['root_id']);
    if($root_id){
      $rows = $this->help->getHelpListByRootId($root_id);
      unset($rows['page']);
      echo $this->pushSuccessMessage($rows);
    }else{
      echo $this->pushErrorMessage(2);
    }
  }
  function addHelpAction(){
    $root_id      = intval($_REQUEST['root_id']);
    $pid      = intval($_REQUEST['pid']);
    $title    = trim($_REQUEST['title']);
    $uid      = intval($_REQUEST['uid']);
    $username = $_REQUEST['username'];
    $reply_uid      = intval($_REQUEST['reply_uid']);
    $reply_username = $_REQUEST['reply_username'];

    $reply_content  = trim($_REQUEST['reply_content']);
    $row = array(
			'root_id'  => $root_id,
			'pid' 	   => $pid,
      'title'    => $title,
      'reply_content'   => $reply_content,
      'uid'	            => $uid,
      'username'        => $username,
      'reply_uid'	      => $reply_uid,
      'reply_username'  => $reply_username,
    	'create_time'     => time(),
    );
    if($root_id>0 && $pid==0){
      echo $this->pushCustomErrorMessage("11", "回复时，pid不能为0, 缺少被回复的帖子id");
      exit;
    }else if($root_id==0 && $pid>0){
      echo $this->pushCustomErrorMessage("12", "回复时，root_id不能为0, 缺少主贴id");
      exit;
    }else if($uid==0){
      echo $this->pushCustomErrorMessage("13", "请先登录。");
      exit;
    }

    if($this->help->insertHelp($row)){
      $this->help->updateReplySumById($pid, "+");
      if($pid && $pid != $root_id){
        $this->help->updateReplySumById($root_id, "+");
      }
      echo $this->pushSuccessMessage();
    }else{
      echo $this->pushErrorMessage(0);
    }
  }
  function searchHelpAction(){
    $search_text = trim($_REQUEST['search_text']);
    if($search_text){
      $rows = $this->help->getSearchHelpList($search_text);
      unset($rows['page']);
      echo $this->pushSuccessMessage($rows);
    }else{
      echo $this->pushErrorMessage(2);
    }
  }
  function testAction(){
    $this->help->getAllChildById(19, $arr);
  }
}
?>
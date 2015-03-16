<?php
class api_feedbackController extends apiController{
  function submitFeedbackAction(){
    $content  = trim($_REQUEST['content']);
    $contact  = trim($_REQUEST['contact']);
    $uid      = intval($_REQUEST['uid']);
    $username = $_REQUEST['username'];
    $row = array(
      'content'  => $content,
			'contact'  => $contact,
      'uid'	     => $uid,
      'username' => $username,
      'create_time' => time(),
    );
    if($this->feedback->insertFeedback($row)){
      echo $this->pushSuccessMessage();
    }else{
      echo $this->pushErrorMessage(0);
    }
  }
}
?>
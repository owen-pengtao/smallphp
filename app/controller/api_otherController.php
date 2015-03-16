<?php
class api_otherController extends apiController{
  function getSoftwareNewVersionAction(){
    //$client_type: 0 iphone, 1 android
    $client_type = intval($_REQUEST['client_type']);
    $arr = $this->other->getCacheByType('soft_version');
    $arr_client = $arr[$client_type];

    $current_version = $arr_client[0];
    $client_version = $_REQUEST['version'];
    $is_update = 0;
    if($current_version != $client_version){
      $is_update = 1;
    }
    $arr = array(
      'is_update' => (String)$is_update,
      'url' => $arr_client[1],
      'current_version' => $current_version,
    );
    echo $this->pushSuccessMessage($arr);
  }
}
?>
<?php
class apiController{
  function __construct(){
    $this->arr_message = array(
      '0' => "失败",
      '1' => "成功",
      '2' => "参数错误",
      '3' => "数据操作错误",
      '4' => "没有权限，请先登录。",
      '5' => "数据不存在",
    );
  }
  function pushSuccessMessage($arr=array()){
    $arr['result'] = $this->_getResultMessage(1);
    if(strstr($_SERVER['SERVER_ADMIN'], 'owen@') && !isset($_GET['json'])){
      pre($arr);
    }else if(isset($_GET['array'])){
      pre($arr);
    }
    return json_cn($arr);
  }
  function pushErrorMessage($code){
    $arr = array(
      "result" => $this->_getResultMessage($code)
    );
    return json_cn($arr);
  }
  function _getResultMessage($code){
    $arr = array(
      "code" => (String)$code,
      "message" => $this->arr_message[$code],
    );
    return $arr;
  }
  function pushCustomErrorMessage($error_code, $error_msg){
    $arr = array(
      "result" => array(
        "code" => (String)$error_code,
        "message" => $error_msg,
      )
    );
    return json_cn($arr);
  }
  function pushCustomMessage($error_code, $error_msg){
    return $this->pushCustomErrorMessage($error_code, $error_msg);
  }
}
?>
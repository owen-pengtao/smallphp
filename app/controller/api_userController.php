<?php
class api_userController extends apiController{
  function loginAction(){
    $phone_no   = trim($_REQUEST['phone_no']);
    $password   = trim($_REQUEST['password']);
    $login_type = intval($_REQUEST['login_type']);  //1 服务密码登录，2 动态密码登录

    $response = $this->getUserFromApi($phone_no, $password, $login_type);
    if($response && $response['result'] == 1){
      echo $this->pushSuccessMessage($response);
    }else{
      echo $this->pushCustomErrorMessage($response['code'], $response['message']);
    }
  }
  function getDynamicPasswordAction(){
    $phone_no = trim($_REQUEST['phone_no']);
    $response = $this->getDynamicPassword($phone_no);
    if($response && $response['result'] == 1){
      echo $this->pushSuccessMessage($response);
    }else{
      echo $this->pushCustomErrorMessage($response['code'], $response['message']);
    }
  }

  /**
   * login_type	必选	登录类型	1服务密码登录,2动态密码登录
   * 登录到移动平台
   * @param int $mobile
   * @param string $passowrd
   * @param int $login_type
   */
  private function getUserFromApi($mobile,$passowrd,$login_type){
    $responseList=array(
      '200'=>'验证成功',
      '401'=>'参数不全',
      '402'=>'ip不在认证列表',
      '404'=>'系统繁忙',
      '406'=>'Auth认证错误',
      '100'=>'密码错误',
      '101'=>'无此用户',
      '201'=>'动态密码登录超过每天的限定次数',
      '500'=>'系统繁忙'
    );
    $api_id   = $this->_getConfig('api_user_id');
    $api_auth = $this->_getConfig('api_user_auth');
    $api_url  = $this->_getConfig('api_user_api');
    $url      = $api_url.'login_3rd.php?auth='.$api_auth.'&id='.$api_id.'&mobile='.$mobile.'&password='.$passowrd.'&login_type='.$login_type;
    $result   = file_get_contents($url);
    $rs=explode('|',$result);
    $uid=intval($rs[0]);
    if(is_array($rs) && count($rs)==2 && $uid>0){
      $code=200;
    }else{
      $code=intval($result);
    }
    if(!array_key_exists($code, $responseList)){
      $code=500;
    }
    $response=array(
      'result'=> (String)$code==200?1:0,
      'code'  => (String)$code,
      'message'   => (String)$responseList[$code],
      'uid'       => (String)$rs[0],
      'username'  => (String)$mobile,  //TODO high: get username
      'token'     => (String)$rs[1],
    );

    return $response;
  }
  function getDynamicPassword($mobile){
    $response=array();
    $responseList=array(
      '200'=>'获取成功',
      '401'=>'参数不全',
      '402'=>'ip不在认证列表',
      '405'=>'手机号码不合法',
      '406'=>'Auth认证错误',
      '500'=>'系统繁忙'
    );
    $api_id   = $this->_getConfig('api_user_id');
    $api_auth = $this->_getConfig('api_user_auth');
    $api_url  = $this->_getConfig('api_user_api');
    $url      = $api_url.'Dynamic_password_create.php?auth='.$api_auth.'&id='.$api_id.'&mobile='.$mobile;
    $result   = file_get_contents($url);
    $rs=explode('|',$result);
    $code=intval($result);
    if(!array_key_exists($code, $responseList)){
      $code=500;
    }
    $response=array(
      'result'   => (String)$code==200?1:0,
      'code'     => (String)$code,
      'message'  => (String)$responseList[$code],
    	'uid'      => (String)$mobile,
      'username' => (String)$mobile,
      'token'    => (String)$rs[1],
    );

    return $response;
  }
  private function _getConfig($key){
    $arr = array(
      'api_user_id'    => 16,
      'api_user_auth'  => '9a036616eaa4c585c5390c0f260b3ee9',
      'api_user_api'   => 'http://wap.szicity.com/api/',
      'api_voice_traffic_api'=> 'http://112.95.174.20:8100/SZXTInterface/getWen',
      'api_139_id'     => '90603',
      'api_139_auth'   => '918086eaae9cbc5876640dfe1c52986e',
      'api_139_api'    => 'http://wap.139.10086.cn:85/shenz/api.do?do=MBlog.addPost',
    );
    return $arr[$key];
  }
}
?>
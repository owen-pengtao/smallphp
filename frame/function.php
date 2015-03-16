<?php
  function t(){
    return get_microtime();
  }
  function get_microtime() {
    list($usec, $sec) = explode(' ', microtime());
    return ((float)$usec + (float)$sec);
  }
  $TIME_START = get_microtime();
  /*
   *  自动加载类文件
   *  $obj：类文件名    php5以上支持
   */
  function __autoload($obj) {
    $class_file = PATH_CLASS.$obj.'.php';
    if (file_exists($class_file)){
      include_once($class_file);
    }elseif(file_exists(PATH_CONTROLLER.$obj.'.php')){
      include_once(PATH_CONTROLLER.$obj.'.php');
    }elseif(file_exists(PATH_MODEL.$obj.'.php')){
      include_once(PATH_MODEL.$obj.'.php');
    }
  }
  function use_model($model){
    global $db;
    $model_file = PATH_MODEL.$model.'Model.php';
    include_once($model_file);
    $Obj = $model.'Model';
    $modelObj = new $Obj();
    $modelObj->db = $db;

    return $modelObj;
  }
  function pr($arr){
    echo '<pre style="text-align:left">';
    print_r($arr);
    echo "</pre>\n\n";
  }
  function pre($arr){
    pr($arr);exit;
  }
  function br($str){
    echo($str."<br/>\n\n");
  }
  function bre($str){
    br($str);exit;
  }
  function vr($arr){
    echo '<pre style="text-align:left">';
    var_dump($arr);
    echo "</pre>\n\n";
  }
  function vre($str){
    vr($str);exit;
  }
  function is_login($back_url=''){
    $url = SITE_URL.'user/guest.php'.($back_url ? '?back_url='.rawurlencode($back_url) : '');
    if (validate_cookie()) {
      return true;
    }else{
      header_go($url);
    }
  }
  function get_hash($uid, $email){
    return md5($uid.$email.HASH_KEY);
  }
  function go_login(){
    $url = SITE_URL.'index.php?m=user&a=login&back_url='.rawurlencode(get_current_url());
    header_go($url);
  }
  function validate_cookie(){
    $bool = false;
    if (isset($_COOKIE['hash'])) {
      $bool = ($_COOKIE['hash'] == get_hash($_COOKIE['uid'], $_COOKIE['email']));
    }
    return $bool;
  }
  function is_owner($uid){
    $bool = false;
    if (validate_cookie() && $uid==$_COOKIE['uid']) {
      $bool = true;
    }
    return $bool;
  }
  /**
   * 获取分类 排序数组
   * @param string $channel 分类栏目
   * @return array
   * @author owen 2008-8-13
   */
  function get_cat_arr($channel){
    $array = array();
    include(PATH_CACHES.$channel.'_cat_arr.php');
    return $array;
  }
  /**
   * 获取分类 数据
   * @param string $channel 分类栏目
   * @return array
   * @author owen 2008-8-13
   */
  function get_cat_row($channel){
    $array = array();
    include(PATH_CACHES.$channel.'_cat_row.php');
    return $array;
  }
  function get_from_validate($class='f_form') {
    $str = '<script type="text/javascript">
      <!--
        $(document).ready(function() {
          $(".'.$class.'").validate();
        });
      //-->
      </script>';
    return $str;
  }
  function get_ip(){
    if (getenv('HTTP_CLIENT_IP')){
      $ip = getenv('HTTP_CLIENT_IP');
    }elseif (getenv('HTTP_X_FORWARDED_FOR')){
      $ip = getenv('HTTP_X_FORWARDED_FOR');
    }elseif (getenv('HTTP_X_FORWARDED')){
      $ip = getenv('HTTP_X_FORWARDED');
    }elseif (getenv('HTTP_FORWARDED_FOR')){
      $ip = getenv('HTTP_FORWARDED_FOR');
    }elseif (getenv('HTTP_FORWARDED')){
      $ip = getenv('HTTP_FORWARDED');
    }else{
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
  }
  /*  保存远程图片到本地
   *  $url 图片URL，$filename 本地图片路径
   *  保存成功，返回true，失败返回false
   */
  function save_image($url, $filename=""){
    $ext = strtolower(get_end_str(get_end_str($url, '/'), '.'));
    $ext = in_array($ext, array("jpeg", "jpg", "png", "gif", "bmp")) ? $ext : 'jpg';
    $f = new file();
    $str = $f->f_read($url);
    $path = dirname($filename).DS;
    $tmp_file = $path.'tmp.'.$ext;

    if ($str) {
      $file_w = $ext=='jpg' ? $filename : $tmp_file;
      $f->f_write($file_w, $str);
    }

    if ($ext!='jpg') {
      $pic = new pic();
      $pic->change_format($tmp_file);
      if (file_exists($path.'tmp.jpg')) {
        @unlink($tmp_file);
        @unlink($filename);
        @rename($path.'tmp.jpg', $filename);
      }
    }
    return file_exists($filename);
  }
  //$num 例子：21 = 2^4 + 2^2 + 2^1, return $arr = array(4, 2, 1)
  function num_to_pow($num){
    $bit_num = base_convert($num, 10, 2);
    settype($bit_num, "string");
    $len_num = strlen($bit_num);
    $arr = array();
    for ($i=0; $i<$len_num; $i++){
      $n = substr($bit_num, $len_num-$i-1, 1);
      ($n=="1" ? $arr[] = pow(2, $i):0);
    }
    return $arr;
  }

  function get_current_url(){
    return SITE_URL.substr($_SERVER['REQUEST_URI'], 1);
  }
  function get_current_path(){
    return dirname($_SERVER['SCRIPT_FILENAME']).DS;
  }
  function send_mail($to, $subject, $message, $from=''){
    $subject = "=?UTF-8?B?".base64_encode($subject)."?=";
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers.= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers.= 'From: '. ($from ? $from : SYSTEM_MAIL) . "\r\n" .
        'Reply-To: '. ($from ? $from : SYSTEM_MAIL) . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    @mail($to, $subject, $message, $headers);
  }
  function url2filepath($theURL) {
    strstr ( PHP_OS, "WIN" ) ? $slash = "\\" : $slash = "/";
    $physical = getcwd ();
    $AtheFile = explode ( "/", $theURL );
    $theFileName = array_pop ( $AtheFile );
    $AwimpyPathWWW = explode ( "/", SITE_URL );
    $AtheFilePath = array_values ( array_diff ( $AtheFile, $AwimpyPathWWW ) );
    if ($AtheFilePath) {
      $theFilePath = $slash . implode ( $slash, $AtheFilePath ) . $slash . $theFileName;
    } else {
      $theFilePath = implode ( $slash, $AtheFilePath ) . $slash . $theFileName;
    }
    return ($physical . $theFilePath);
  }
  function get_url_code($url, $widhtHeight ='80', $EC_level='L',$margin='0'){
    return 'http://chart.apis.google.com/chart?chs='.$widhtHeight.'x'.$widhtHeight.'&cht=qr&chld='.$EC_level.'|'.$margin.'&chl='.$url;
  }


  define('PI', 3.1415926535898);
  define('R', 6378.137);
  function rad($d){
     return $d * PI / 180.0;
  }
  //获取两个经纬度之间的距离（公里）
  function get_distance($lng1, $lat1, $lng2, $lat2){
    $EARTH_RADIUS = R;
    $radLat1 = rad($lat1);
    $radLat2 = rad($lat2);
    $a = $radLat1 - $radLat2;
    $b = rad($lng1) - rad($lng2);
    $s = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)));
    $s = $s *$EARTH_RADIUS;
    $s = round($s * 10000) / 10000;
    return $s;
  }
  function get_area_longtitude($lng, $lat, $s=5){
    $EARTH_RADIUS = R;
    $cha = $lng - (rad($lng) - asin(sin($s/($EARTH_RADIUS*2))/cos(rad($lat)))*2)*180.0/PI;
    $min = $lng - $cha;
    $max = $lng + $cha;
    return array($min, $max);
  }
  function get_area_latitude($lng, $lat, $s=5){
    $EARTH_RADIUS = R;
    $cha = $lat - (rad($lat) - asin(sin($s/($EARTH_RADIUS*2)))*2)*180.0/PI;
    $min = $lat - $cha;
    $max = $lat + $cha;
    return array($min, $max);
  }
?>
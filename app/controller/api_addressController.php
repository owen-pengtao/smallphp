<?php
class api_addressController extends apiController{
  function getGDAddressTypeAction(){
    $category = use_model('category');
    $rows = $category->getAllCategory();
    if($rows){
      $arr = array(
        'rows' => $rows,
      );
      echo $this->pushSuccessMessage($arr);
    }else{
      echo $this->pushErrorMessage(5);
    }
  }
  function getGDAddressAction(){
    $x = trim($_REQUEST['x']);
    $y = trim($_REQUEST['y']);
    $searchType  = trim($_REQUEST['search_type']);
    $search_name = trim($_REQUEST['search_name']);
    $number     = intval($_REQUEST['page_size']);
    $number     = $number ? $number : 10;
    $batch      = intval($_REQUEST['page']);
    $batch      = $batch ? $batch : 1;

    $url = 'http://map.wxcs.cn:8084/sisserver?';
    $url.= 'config=BELSBXY&resType=json&cityCode=0755';
    $url.= $searchType ? '&searchType='.rawurlencode($searchType) : '';
    $url.= '&searchName='.rawurlencode($search_name).'&number='.$number.'&batch='.$batch;
    $url.= '&cenX='.$x.'&cenY='.$y;
    $url.= '&enc=utf-8&range=3000&sr=1&srctype=POI&a_k=38e706a36af710d69d0b657a94d5f41f717048010286dd552c9bea9a69ecb3759e7b94777635514b';

    //TODO high: remove this line.
    //$url = 'http://map.wxcs.cn:8084/sisserver?&config=BELSBXY&resType=json&cityCode=0755&cenX=114.091125&cenY=22.538183&searchName=%E9%A4%90%E9%A5%AE%E6%9C%8D%E5%8A%A1&number=10&batch=1&enc=utf-8&range=3000&sr=1&srctype=POI&a_k=38e706a36af710d69d0b657a94d5f41f717048010286dd552c9bea9a69ecb3759e7b94777635514b';

    $str = file_get_contents($url);
    $rows = array();
    if($str){
      $list = json_decode($str);
      if($list){
        foreach($list->poilist AS $v){
          $rows[] = array(
            'id'      => '0',  //$v->pguid
            'title'   => $v->name,
            'address' => $v->address,
            'tel'     => comma_str_to_array($v->tel),
            'x'       => $v->x,
            'y'       => $v->y,
            'distance'    => $v->distance/1000,
            'pguid'       => $v->pguid,
            'remark'      => '',
          );
        }
      }
    }
    $arr = array(
      'sum'  => $list->count ? $list->count : 0,
      'rows' => $rows,
    );
    echo $this->pushSuccessMessage($arr);
  }
  function getMyAddressAction(){
    $x = $_REQUEST['x'];  //经度
    $y = $_REQUEST['y'];    //纬度
    $uid = intval($_REQUEST['uid']);
    if($uid){
      $list = $this->address->getMyAddressList($uid);
      $rows = array();
      foreach((array)$list['rows'] AS $v){
        $rows[] = array(
          'id'      => $v['id'],
          'title'   => $v['title'],
          'address' => $v['address'],
          'tel'     => comma_str_to_array($v['tel']),
          'x'       => $v['x'],
          'y'       => $v['y'],
        	'distance'    => ($x && $y) ? get_distance($x, $y, $v['x'], $v['y']) : '0',
          'pguid'       => '',
          'remark'      => $v['remark'],
        );
      }
      $arr = array(
        'rows' => $rows,
        'sum'  => (String)intval($list['sum']),
      );
      echo $this->pushSuccessMessage($arr);
    }else{
      echo $this->pushErrorMessage(2);
    }
  }
  function getUserAddressAction(){
    $x = $_REQUEST['x'];  //经度
    $y = $_REQUEST['y'];    //纬度
    $s = intval($_REQUEST['s']) ? intval($_REQUEST['s']) : 5;  //默认5公里范围

    $search_name = trim($_REQUEST['search_name']);
    $search_type = trim($_REQUEST['search_type']);
    if($x && $y){
      $area_longtitude = get_area_longtitude($x, $y, $s);
      $area_latitude = get_area_latitude($x, $y, $s);

      $list = $this->address->getAreaAddress($search_name, $search_type, $area_longtitude, $area_latitude, array($x, $y), $s);

      $rows = array();
      foreach((array)$list['rows'] AS $v){
        $rows[] = array(
          'id'      => $v['id'],
          'title'   => $v['title'],
          'address' => $v['address'],
          'tel'     => comma_str_to_array($v['tel']),
          'x'       => $v['x'],
          'y'       => $v['y'],
        	'distance'    => get_distance($x, $y, $v['x'], $v['y']),
          'pguid'       => '',
        	'remark'      => $v['remark'],
        );
      }
      $arr = array(
        'rows' => $rows,
        'sum'  => (String)intval($list['sum']),
      );
      echo $this->pushSuccessMessage($arr);
    }else{
      echo $this->pushErrorMessage(2);
    }
  }
  function addUserAddressAction(){
    $modify_id   = trim($_REQUEST['modify_id']);
    $title   = trim($_REQUEST['title']);
    $address = trim($_REQUEST['address']);
    $tel     = trim($_REQUEST['tel']);

    $x       = $_REQUEST['x'];
    $y       = $_REQUEST['y'];

    $uid      = intval($_REQUEST['uid']);
    $username = $_REQUEST['username'];
    $remark   = trim($_REQUEST['remark']);
    $search_type      = trim($_REQUEST['search_type']);
    $search_type_code = trim($_REQUEST['search_type_code']);

    $row = array(
      'pguid'   => "",
      'title'   => $title,
      'address' => $address,
      'tel'     => $tel,

      'x'        => $x,
      'y'        => $y,
      'uid'	     => $uid,
      'username' => $username,

      'remark'      => $remark,
      'search_type'      => $search_type,
      'search_type_code' => $search_type_code,
    	'create_time' => time(),
    );
    if($modify_id){
      $row['modify_id'] = $modify_id;
      $bool = $this->address->insertModifyAddress($row);
    }else{
      $bool = $this->address->insertAddress($row);
    }
    if($bool){
      echo $this->pushSuccessMessage();
    }else{
      echo $this->pushErrorMessage(0);
    }
  }
  function getAddressByIdAction(){
    $id = intval($_REQUEST['id']);
    $row = $this->address->getAddressById($id);
    if($row){
      $arr = array(
        'id'      => $row['id'],
        'title'   => $row['title'],
        'address' => $row['address'],
        'tel'     => comma_str_to_array($row['tel']),
        'x'       => $row['x'],
        'y'       => $row['y'],
        'distance'    => '0',
        'pguid'       => $row['pguid'],
        'remark'      => $row['remark'],
      );
      echo $this->pushSuccessMessage($arr);
    }else{
      echo $this->pushErrorMessage(0);
    }
  }
  function markItHelpAction(){
    $id = intval($_REQUEST['id']);
    if($this->address->markItHelp($id)){
      echo $this->pushSuccessMessage();
    }else{
      echo $this->pushErrorMessage(0);
    }
  }
  function markItWrongAction(){
    $id = intval($_REQUEST['id']);
    if($this->address->markItWrong($id)){
      echo $this->pushSuccessMessage();
    }else{
      echo $this->pushErrorMessage(0);
    }
  }
}
?>
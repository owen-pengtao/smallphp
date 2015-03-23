<?php
  $str_link_cat = '<a href="'.show_link('api.php?m=api_address&a=getGDAddressType', 0).'" class="ts_u">获取高德地址分类</a>';
  $t = new table();
  $str = '';
  $arr_type = array('2'=>'table_api');
  $str.= $t->table_start($arr_type);

  $str.= $t->caption('接口列表');
    $str_info = '<ol>';
    $str_info.= '</ol>';
    $arr_td = array(
        array('说明', $str_info),
        array('<h3 class="tc_red">用户相关接口</h3>',''),
        array('添加用户', show_link('api.php?m=apir_user&a=add').
        			'<br/>必选： username: 用户名, password: 密码, email: 邮箱, is_disable: 是否禁用, '),
        array('修改用户', show_link('api.php?m=apir_user&a=edit').
        			'<br/>必选： id: 用户id, username: 用户名, password: 密码, email: 邮箱'),
        array('删除用户', show_link('api.php?m=apir_user&a=delete&id=1').
              '<br/>必选： id: 用户id'),
        array('获取单个用户', show_link('api.php?m=apir_user&a=get&id=1').
          '<br/>必选： id: 用户id'),
        array('获取一组用户', show_link('api.php?m=apir_user&a=getList').
          '<br/>必选： id: 用户id, page: 当前页数
           <br/>可选： pageSize: 10 每页现实条数,'),
        array(''),

        array('<h3 class="tc_red">其他接口</h3>',''),
        array('版本是否更新', show_link('api.php?m=api_other&a=getSoftwareNewVersion&version=1.00&client_type=0').
        			'<br/>client_type: 0 iphone, 1 android'),
      );
    $arr_td_width = array('25%', '75%');
    foreach ($arr_td AS $v) {
      $str.= $t->tr_td($v, array('t_td_left', 't_td_left'), $arr_td_width);
    }
  $str.= $t->table_end();
  echo $str;

  function show_link($link, $includeTag=1){
    $link = strstr($link, 'http://') ? $link : SITE_URL.$link;
    return $includeTag ? '<a href="'.$link.'" target="_blank">'.$link.'</a>' : $link;
  }
?>
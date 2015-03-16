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
        array('获取动态密码', show_link('api.php?m=api_user&a=getDynamicPassword&phone_no=15889457465').
        			'<br/>必选： phone_no: 手机号'),
        array('用户登陆', show_link('api.php?m=api_user&a=login&phone_no=15889457465&password=99988811&login_type=1').
        			'<br/>必选： phone_no: 手机号, password: 密码, login_type: 1用服务密码登录，2用动态密码登录'),
        array(''),

        array('<h3 class="tc_red">用户反馈接口</h3>',''),
        array('提交用户反馈', show_link('api.php?m=api_feedback&a=submitFeedback&content=I_Love_It '.date("Y-m-d H:i:s").'&contact=13800138000&uid=1&username=Itotem').
        			'<br/>必选： content: 内容，contact: 联系方式'.
        			'<br/>可选： uid: 用户id，username: 用户名'),
        array(''),

        array('<h3 class="tc_red">互助详情接口</h3>',''),
        array('添加互助详情', show_link('api.php?m=api_help&a=addHelp&title=I_Need_Help '.date("Y-m-d H:i:s").'&reply_content=回复的内容&root_id=0&pid=0&uid=1&username=Itotem').
        			'<br/>必选： title: 详情信息， uid: 用户id'.
        			'<br/>可选： root_id: 详情根ID, pid: 被回复的详情id，reply_content: 回复的详情， username: 用户名， reply_uid: 被回复的帖子uid， reply_username: 被回复的帖子username'.
              '<br/><strong>回复时：root_id, pid 都必须大于0，root_id为详情根ID, pid为被回复的那条详情的id</strong>'),
        array('获取互助详情列表', show_link('api.php?m=api_help&a=getHelpList&page_size=10&page=1').
        			'<br/>必选： '.
        			'<br/>可选： page_size: 默认 10， page: 默认 1'),
        array('获取我的互助', show_link('api.php?m=api_help&a=getMyHelpList&uid=1&page_size=10&page=1').
        			'<br/>必选： uid: 用户id'.
        			'<br/>可选： page_size: 默认 10， page: 默认 1'),
        array('获取某个互助的回复', show_link('api.php?m=api_help&a=getHelpListByPid&pid=1&page_size=10&page=1').
        			'<br/>必选： pid: 被回复的帖子id'.
        			'<br/>可选： page_size: 默认 10， page: 默认 1'),
        array('获取某个互助的所有回复', show_link('api.php?m=api_help&a=getHelpListByRootId&root_id=1&page_size=10&page=1').
        			'<br/>必选： root_id: 主贴的id'.
        			'<br/>可选： page_size: 默认 10， page: 默认 1'),
        array('搜索回复', show_link('api.php?m=api_help&a=searchHelp&search_text=hello&page_size=10&page=1').
        			'<br/>必选： search_text: 搜索的内容'.
        			'<br/>可选： page_size: 默认 10， page: 默认 1'),
        array(''),

        array('<h3 class="tc_red">地址相关接口</h3>',''),
        array('添加用户发现，我要修正', show_link('api.php?m=api_address&a=addUserAddress&uid=1&modify_id=a1b2c3d4f5&title=This_is_'.date("Y-m-d H:i:s").'&address=中山路241号&tel=13800138000&x=114.091125&y=22.538183&remark=备注信息&search_type=餐饮服务&search_type_code=05').
        			'<br/>必选： uid: 用户id, title: 地址名称, address: 地址, x,y: 经纬度'.
        			'<br/>可选： modify_id: 被修正的id(pguid或id，我要修正时，需要传入此参数), remark: 备注, tel: 电话，多个电话以逗号,隔开. '.
							'<br/>      search_type: 搜索类别, search_type_code: 类别编码, 都参考 '.$str_link_cat),
        array('获取高德地址分类', show_link('api.php?m=api_address&a=getGDAddressType').
        			'<br/>提示：返回结果中的title， 就是获取高德地址列表时需要传入的 search_type.'.
              '<br/>search_code 就是“添加用户发现，我要修正”, 需要传入的 search_type_code'),
        array('获取高德地址列表', show_link('api.php?m=api_address&a=getGDAddress&search_type=餐饮服务&search_name=煌上煌&x=114.091125&y=22.538183&page_size=10&page=1').
        			'<br/>必选： search_name: 搜索的关键字，x: 经度， y: 纬度'.
        			'<br/>可选： search_type: 参考 '.$str_link_cat.', page_size: 默认 10， page: 默认 1'),
        array('获取用户添加的地址列表', show_link('api.php?m=api_address&a=getUserAddress&search_type=餐饮服务&search_name=中山路&x=114.091125&y=22.538183&page_size=10&page=1').
        			'<br/>必选： search_name: 搜索的关键字，x: 经度， y: 纬度'.
        			'<br/>可选： search_type: 参考 '.$str_link_cat.', page_size: 默认 10， page: 默认 1，s: 默认5公里范围'),
        array('获取某用户添加的地址列表', show_link('api.php?m=api_address&a=getMyAddress&uid=1&page_size=10&page=1').
        			'<br/>必选： uid: 用户id'.
        			'<br/>可选： x,y: 经纬度(当经纬度参数为空时，则返回值 distance 为0), page_size: 默认 10， page: 默认 1'),
        array('获取某个地址信息', show_link('api.php?m=api_address&a=getAddressById&id=1').
        			'<br/>必选： id: 地址id'),
        array('标记有帮助', show_link('api.php?m=api_address&a=markItHelp&id=1').
        			'<br/>必选： id: 地址id'),
        array('标记地址有误', show_link('api.php?m=api_address&a=markItWrong&id=1').
        			'<br/>必选： id: 地址id'),
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
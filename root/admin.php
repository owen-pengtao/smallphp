<?php
    include_once('global.php');
    if ($_SESSION['is_root'] != 1){
        exit;
    }
    include('head.php');
?>
<?php
  if ($action=='add' OR $action=='edit') {
    $t = new table();
    $f = new form();
    $str = '';
    $str.= $f->form_start('?a=save');
    $str.= $t->table_start();

    $str.= $t->caption('后台管理员');
      $arr_td = array(
          array('用户名', $f->text(array('username', 'required', '', 't_text'), array($tpl->row['username']))),
          array('密码', $f->password(array('password', ($action=='add' ? 'password' : ''), '', 't_text'), '', ''), false),
          //array('超级管理员', $f->radio(array('grade', 'required'), array('否', '是'), (isset($tpl->row['grade']) && $tpl->row['grade'] == 9) ? 1 : 0)),
          //array('禁止登录', $f->radio(array('is_disable', 'required'), array('否', '是'), isset($tpl->row['is_disable']) ? intval($tpl->row['is_disable']) : 0)),
        );
      if($action=='edit'){
        array_push($arr_td, array('最后登陆IP', long2ip($tpl->row['last_login_ip'])));
        array_push($arr_td, array('最后登陆时间', date("Y-m-d H:i:s", $tpl->row['last_login_time'])));
      }
      $arr_td_width = array('12%', '88%');
      foreach ($arr_td AS $v) {
        $str.= $t->tr_td($v, array('', 't_td_left'), $arr_td_width);
      }
    $str.= $t->tr_td_submit();
    $str.= $f->hidden('id', $tpl->row['id']);
    $str.= $f->hidden('page', $_GET['page']);
    $str.= $t->table_end();
    $str.= $f->form_end();
    echo $str;
  }else{
    $t = new table();
    $t->set_op();

    $td_width  = array('8%', '26%', '20%', '20%');
    $td_class  = array('', 't_td_left');
    $tr_th    = array('ID', '用户名', '最后登陆IP', '最后登陆时间');
    $t->set_table($td_width, $td_class, $tr_th);

    $str = $t->table_start();
    $str.= $t->caption('后台管理员');
    $str.= $t->tr_th();

    foreach ($tpl->page_list['rows'] as $v) {
      $arr = array(
          $v['id'], $v['username'],
          long2ip($v['last_login_ip']), date("Y-m-d H:i:s", $v['last_login_time'])
        );
      $str.= $t->tr_td_row($arr);
    }
    $str.= $t->tr_one_op();
    $str.= $t->tr_one($tpl->page_list['page']);
    $str.= $t->table_end();
    echo $str;
  }
?>
<?php include('end.php');?>
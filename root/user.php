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

  $str.= $t->caption('用户管理');
  $arr_td = array(
    array('用户名', $f->text(array('username', 'required', '', 't_text'), array($tpl->row['username']))),
    array('密码', $f->password(array('password', ($action=='add' ? 'password' : ''), '', 't_text'), '', ''), false),
    array('邮箱', $f->text(array('email', 'required', '', 't_text'), array($tpl->row['email']))),
    array('是否禁止登陆', $f->radio(array('is_disable', 'required', '', 't_text'), array('1' => '是', '0' => '否'), intval($tpl->row['is_disable']))),
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
  $arr_form_group = array(
    array('用户名', '<input type="text" class="form-control" name="username" value="'.$tpl->row['username'].'"/>'),
    array('密码', '<input type="password" class="form-control" name="password" value="'.$tpl->row['password'].'"/>'),
    array('禁止用户', array(
                    '<input type="radio" name="is_disable" value="1">Yes',
                    '<input type="radio" name="is_disable" value="0">No',
                    )),
  );
?>
  <div class="panel panel-primary">
    <div class="panel-heading">用户管理</div>
    <div class="panel-body">
      <form class="form-horizontal" role="form" action="?a=save" method="post" enctype="multipart/form-data">
        <?php
          $str = "";
        foreach($arr_form_group as $v){
          $str.= '<div class="form-group">';
          $str.= '<label class="col-sm-2 control-label">'.$v[0].'：</label><div class="col-sm-8">';
          if (is_array($v[1])) {

          }else{
            $str.= $v[1];
          }
          $str.= '</div></div>';
        }
        echo $str;
        ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">用户名：</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="username" value="<?= $tpl->row['username']; ?>" required=""/>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">密码：</label>
          <div class="col-sm-8">
            <input type="password" class="form-control" name="password"/>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">邮箱：</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="email" value="<?= $tpl->row['email']; ?>" required=""/>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">禁止用户：</label>
          <div class="col-sm-8">
            <label class="radio-inline">
              <input type="radio" name="is_disable" value="1" <?= $tpl->row['is_disable']==="1" ? "checked" : ""; ?>>Yes
            </label>
            <label class="radio-inline">
              <input type="radio" name="is_disable" value="0" <?= $tpl->row['is_disable']==="0" ? "checked" : ""; ?>>No
            </label>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">上次登陆IP：</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" readonly/>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">上次登陆时间：</label>
          <div class="col-sm-8">
            <p class="form-control-static">2005-01-01 12:12:00</p>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">注册时间：</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" readonly/>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Checkboxes</label>
          <div class="col-sm-8">
            <div class="checkbox">
              <label>
                <input type="checkbox" value="">Checkbox 1
              </label>
            </div>
            <div class="checkbox">
              <label>
                <input type="checkbox" value="">Checkbox 2
              </label>
            </div>
            <div class="checkbox">
              <label>
                <input type="checkbox" value="">Checkbox 3
              </label>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Inline Checkboxes</label>
          <div class="col-sm-8">
            <label class="checkbox-inline">
              <input type="checkbox">1
            </label>
            <label class="checkbox-inline">
              <input type="checkbox">2
            </label>
            <label class="checkbox-inline">
              <input type="checkbox">3
            </label>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Selects</label>
          <div class="col-sm-8">
            <select class="form-control">
              <option>1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
              <option>5</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-8">
            <input type="submit" class="btn btn-primary" id="submit" value="Submit" />
          </div>
        </div>
        <input type="hidden" ng-model="form.id">
        <input type="hidden" ng-model="form.page">
      </form>
    </div>
  </div>
<?php
}else{
?>
  <div class="row">
    <div class="col-md-3">
      <h4>用户管理
      <a class="btn btn-success btn-xs" href="?a=add"><span class="glyphicon glyphicon-plus"></span> 添加</a>
      </h4>
    </div>
    <div class="col-md-9">
      <form class="sp-form-search form-inline text-center" action="?a=index" method="get" enctype="application/x-www-form-urlencoded">
        <div class="form-group">
          <select class="form-control" name="search_type">
            <option value="username">用户名</option>
            <option value="email">邮箱</option>
          </select>
        </div>
        <div class="form-group">
          <input name="search_key" type="text" required="" class="form-control" placeholder="请输入搜索关键词">
        </div>
        <div class="form-group">
          <select name="order" class="form-control">
            <option value="DESC">降序↓</option>
            <option value="ASC">升序↑</option>
          </select>
        </div>
        <input name="a" type="hidden" value="index" />
        <input class="btn btn-success" type="submit" value="Search"/>
      </form>
    </div>
  </div>
<?php
  $t = new table();
  $t->set_op();

  $td_width  = array('8%', '26%', '10%', '10%', '20%');
  $tr_th    = array('ID', '用户名', '是否禁用', '最后登陆IP', '最后登陆时间');
  $t->set_table($td_width, $tr_th);

  $str = $t->table_start(array("table-hover"));
  $str.= $t->tr_th();

  foreach ($tpl->page_list['rows'] as $v) {
    $arr = array(
      $v['id'], $v['username'],
      $v['is_disable'] ? "Yes" : "No",
      $v['last_login_ip'], date("Y-m-d H:i:s", $v['last_login_time'])
    );
    $str.= $t->tr_td_row($arr);
  }
  $str.= $t->tr_one_op(array('is_disable-0'=>"启用", 'is_disable-1'=>"禁止"));
  $str.= $t->table_end();
  echo $str;
}
?>
<div class="row text-center sp-pagination">
  <?php echo $tpl->page_list['page'];?>
</div>
<?php include('end.php');?>
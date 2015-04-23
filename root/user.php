<?php
    include_once('global.php');
    if ($_SESSION['is_root'] != 1){
        exit;
    }
    include('head.php');
?>
<?php
if ($action=='add' OR $action=='edit') {
?>
  <div class="panel panel-default">
    <div class="panel-heading">用户管理</div>
    <div class="panel-body">
      <form class="form-horizontal" action="?a=save" method="post" enctype="multipart/form-data">
        <?php
          $f = new formB();
          $f->setColumn(array(2, 8));
          $f->setRequireList(array("username", "email"));
          $f->addInput("text", "username", $tpl->row['username'], "用户名：");
          $f->addHtmlFor("password", '<p class="help-block">Your password must contain 6 characters min. and and 15 characters max.</p>');
          $f->addInput("password", "password", "", "密码：");
          $f->addInput("email", "email", $tpl->row['email'], "邮箱：");
          $f->addRadio("is_disable", intval($tpl->row['is_disable']), "禁止用户：", array(
            1 => "Yes",
            0 => "No"
          ));
          if($action=='edit'){
            $f->addStaticHtml(long2ip($tpl->row['last_login_ip']), "上次登陆IP：");
            $f->addStaticHtml(date("Y-m-d H:i:s", $tpl->row['last_login_time']), "最后登陆时间：");
            $f->addStaticHtml($tpl->row['id'], "ID");
          }
          $f->addGroupBtn(array(
            array("submit", "Submit", " class='btn btn-primary'"),
            array("button", "Cancel", " class='btn'")
          ));
          $f->addHidden("id", $tpl->row['id']);
          $f->addHidden("page", $_GET['page']);
          $f->render();
        ?>
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
      <?php
      $f = new formB();
      $f->setRequireList(array("search_key"));
      $f->addSelect("search_type", "", "", array(
        "username" => "用户名",
        "email"    => "邮箱"
      ));
      $f->addInput("text", "search_key", $_GET['search_key'], "", ' placeholder="请输入搜索关键词"');
      $f->addSelect("order", "", "", array(
        "DESC" => "降序↓",
        "ASC"  => "升序↑"
      ));
      $f->addHidden("a", "index");
      $f->addSingleInput("submit", "Search", 'class="btn btn-success"');
      $f->render();
      ?>
      </form>
    </div>
  </div>
<?php
  $t = new table();
  $t->set_op();

  $td_width  = array('8%', '26%', '10%', '10%', '20%');
  $tr_th    = array('ID', '用户名', '是否启用', '最后登陆IP', '最后登陆时间');
  $t->set_table($td_width, $tr_th);

  $str = $t->table_start(array("table-hover"));
  $str.= $t->tr_th();

  foreach ($tpl->page_list['rows'] as $v) {
    $arr = array(
      $v['id'], $v['username'],
      $v['is_disable'] ? "No" : "Yes",
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
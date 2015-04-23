<?php
  include('global.php');
?>
<?php include('head.php');?>
  <div class="row">
    <form class="sp-form-search form-inline text-center" action="?a=index" method="get" enctype="application/x-www-form-urlencoded">
      <?php
      $f = new formB();
      $f->setRequireList(array("search_key"));
      $f->addSelect("search_type", "", $_GET['search_type'], array(
        "error_str" => "错误信息",
        "id"        => "ID"
      ));
      $f->addInput("text", "search_key", $_GET['search_key'], "", ' placeholder="请输入搜索关键词"');
      $f->addSelect("by", "", $_GET['by'], array(
        'id'        => '默认排序',
        'page_name' => '页面文件'
      ));
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
<?php
  $t = new table();
  $t->set_op(0, 0);

  $td_width  = array('8%', '46%', '15%', '15%');
  $tr_th    = array('ID', '错误信息', '页面文件', '时间');
  $t->set_table($td_width, $tr_th);

  $str = $t->table_start(array("table-hover"));
  $str.= $t->caption('所有数据库错误管理');
  $str.= $t->tr_th();

  foreach ($tpl->page_list['rows'] as $v) {
    $arr = array(
        $v['id'], $v['error_str'],
        '<a href="'.$v['url'].'" target="_blank">'.$v['page_name'].'</a>', date('Y-m-d H:i', $v['create_time'])
      );
    $str.= $t->tr_td_row($arr);
  }

  $str.= $t->tr_one_op();
  $str.= $t->tr_one($tpl->page_list['page']);
  $str.= $t->table_end();
  echo $str;
?>
  <div class="row text-center sp-pagination">
    <?php echo $tpl->page_list['page'];?>
  </div>
<?php include('end.php');?>
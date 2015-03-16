<?php
  include('global.php');
?>
<?php include('head.php');?>
<?php
  $cat_title = '分类';

  $t = new table();
  $f = new form();

  if ($action=='add' OR $action=='edit') {
    $str = $f->form_start('?a=save&channel='.$tpl->channel);
    $str.= $t->table_start();
    $str.= $t->caption($cat_title.'管理');
    $arr_td = array(
        array('父级分类', $f->select(array('pid'), $tpl->arr_opt, intval($_GET['pid'])).'如果为空，说明添加的是第一级分类。'),
        array('名称', $f->text(array('title', 'required', '', 't_text'), array(html_decode($tpl->row['title'])))),
        array('查询代码', $f->text(array('search_code', 'required', '', 't_text'), array($tpl->row['search_code'])).''),
      );
    if($action == 'edit'){
      array_unshift($arr_td, array('栏目ID', $tpl->row['id']));
    }
    $arr_td_width = array('20%', '80%');
    foreach ($arr_td AS $v) {
      $str.= $t->tr_td($v, array('', 't_td_left'), $arr_td_width);
    }
    $str.= $f->hidden('id', $tpl->row['id']);
  }else{
    $f->is_validate = 0;
    $str = $f->form_start('?a=save_ranking&channel='.$tpl->channel);
    $str.= $t->table_start();
    $str.= $t->caption($cat_title.'管理'.' &nbsp; &nbsp;  <a class="a_red" href="?channel='.$tpl->channel.'&a=add">添加记录</a>');
    $str_ul = $controller->get_cat_ul(intval($_GET['cid']));
    $str.= $t->tr_one($str_ul);
  }

  $str.= $t->tr_one($f->submit());
  $str.= $t->table_end();
  $str.= $f->form_end();
  echo $str;
?>
<script type="text/javascript">
<!--
$(document).ready(function(){
  $('td > ul.cat > li').addClass('close');
  $('td ul.cat ul.cat').hide();
  $('td > ul.cat > li > a.cat_title').click(function(){
    var childUL = $(this).parents('ul').eq(0).find('ul');
    if($(this).parent().hasClass('open')){
      $(this).css('color', '');
      $(this).parent().removeClass('open').addClass('close');
      childUL.hide();
    }else{
      $(this).css('color', 'red');
      $(this).parent().removeClass('close').addClass('open');
      childUL.show();
    }
  });
  var url = window.location.href.split('#');
  var cat_id = url[1];
  if(cat_id){
    var a = $('td > ul.cat > li > a.cat_title[href="#' + cat_id + '"]');
    a.css('color', 'red');
    var childUL = a.parents('ul').eq(0).find('ul');
    a.parent().removeClass('close').addClass('open');
    childUL.show();
  }
});
//-->
</script>
<?php include('end.php');?>
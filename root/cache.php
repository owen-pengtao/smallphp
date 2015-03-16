<?php
  include('global.php');
?>
<?php include('head.php');?>
<?php
  $t = new table();
  $str = $t->table_start();
  $arr_title = array(
      'soft_version'    => '版本管理',
      'default_images'  => '默认图片管理',
    );
  $arr_td = array();
  foreach($arr_title AS $k=>$v){
    $arr_td[] = '<a href="?a=get&type='.$k.'"'.($tpl->type==$k ? ' class="a_red"':'').'>'.$v.'</a>';
  }

  $str.= $t->tr_td($arr_td);
  $str.= $t->table_end();
  echo $str;

  $t = new table();
  $f = new form();
  $str = $f->form_start('?a=save');
  $str.= $t->table_start();

  $str.= $t->caption($arr_title[$tpl->type]);
  $str.= $f->hidden('type', $tpl->type);
  if ($tpl->type=="soft_version"){
    $arr_td_width = array('20%', '80%');
    $arr_tmp = array(
            array('iPhone版本: ',
              '版本：'.$f->text(array('soft_version[0][]', '', '', 't_text'), array($tpl->row[$tpl->type][0][0])).'<br/>'.
              'URL：'.$f->text(array('soft_version[0][]', '', '', 't_text'), array($tpl->row[$tpl->type][0][1])),
            ),
            array('Android版本: ',
              '版本：'.$f->text(array('soft_version[1][]', '', '', 't_text'), array($tpl->row[$tpl->type][1][0])).'<br/>'.
              'URL：'.$f->text(array('soft_version[1][]', '', '', 't_text'), array($tpl->row[$tpl->type][1][1])),
            ),
      );
    foreach ($arr_tmp AS $v){
      $str.= $t->tr_td($v, array('', 't_td_left'), $arr_td_width);
    }
  }elseif ($tpl->type=="default_images"){
    $arr_td_width = array('20%', '40%', '40%');
    $arr_tmp = array(
            array('图片尺寸120 X 30: ', $f->text(array('default_images[]', 'required', '', 't_text'), array($tpl->row[$tpl->type][0])),
              ($tpl->row[$tpl->type][0] ? '<img src="'.$tpl->row[$tpl->type][0].'" />' : '')
            ),
            array('图片尺寸240 X 60: ', $f->text(array('default_images[]', 'required', '', 't_text'), array($tpl->row[$tpl->type][1])),
              ($tpl->row[$tpl->type][1] ? '<img src="'.$tpl->row[$tpl->type][1].'" />' : '')
            ),
            array('图片尺寸360 X 90: ', $f->text(array('default_images[]', 'required', '', 't_text'), array($tpl->row[$tpl->type][2])),
              ($tpl->row[$tpl->type][2] ? '<img src="'.$tpl->row[$tpl->type][2].'" />' : '')
            ),
      );
    foreach ($arr_tmp AS $v){
      $str.= $t->tr_td($v, array('', 't_td_left'), $arr_td_width);
    }
  }
  $str.= $t->tr_td_submit();
  if($_GET['bool']==1){
    $str.= $t->tr_one('<span style="color:#F00">保存成功。</span>');
  }
  $str.= $t->table_end();
  $str.= $f->form_end();
  echo $str;
?>
<script type="text/javascript">
<!--
$(document).ready(function(){
  $('input.update_cache').click(function(){
    var bool = 0;
    if($(this).is(":checked")){
      bool = 1;
    }
    $(this).parent().next().val(bool);
  });
});
//-->
</script>
<?php include('end.php');?>
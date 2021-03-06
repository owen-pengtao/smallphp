<?php
/**
 * 表格类，和 form 类一起工作
 * @author yytcpt(无影) 2008-6-11
 * @link http://www.d5s.cn/
 */
class table{
  /**
   * 表格的初始化属性参数
   * @var public
   */
  public $tab_type;
  public $td_sum;
  public $is_js;

  private $admin_page;
  private $is_add;
  private $is_edit;
  private $is_del;
  private $is_select;

  private $_n;
  private $td_width;
  private $td_class;
  private $tr_th;
  function __construct(){
    $this->tab_type  = array('table', '', '');  //表格Class，id，style

    $this->is_mutil_select = true;
    $this->_n    = "\r\n";
    $this->td_sum  = 0;
    $this->td_width  = array();
    $this->td_class  = array();
    $this->tr_th  = array();

    $this->f = new form();
    $this->f->tab_i = 100;    //设定表单的 tabindex 起始值
    $this->f->is_validate = 0;  //设定表单的 js检测 不输出
  }
  /**
   * 设置表格中，添加、编辑、删除链接，复选框，添加/编辑页面的文件名
   * @param boolean $is_add 1显示添加
   * @param boolean $is_edit 1显示编辑，并且支持js验证
   * @param boolean $is_del 1显示删除
   * @param boolean $is_select 1显示复选框
   * @param string $admin_page 添加/编辑页面的文件名
   * @return void()
   * @author owen 2008-6-12
   */
  function set_op($is_add=1, $is_edit=1, $is_del=1, $is_select=1, $admin_page='') {
    $this->is_add  = $is_add;
    $this->is_edit  = $is_edit;
    $this->is_del  = $is_del;
    $this->is_select  = $is_select;
    $this->admin_page = $admin_page ? $admin_page : basename($_SERVER['PHP_SELF']);
  }
  /**
   * 设置表格参数，每一列的宽度、样式、标题
   * 当 $this->is_select=1 时，左边增加一列 宽度为 5%<br/>
   * 当 $this->is_edit=1 或 $this->is_del=1 时，最右边增加一列 宽度为 10%
   * @param array $td_width 每列的宽度，总和=85%, 90%, 95%, 100%
   * @return array $td_class 每列的class样式
   * @return array $tr_th 每列的标题
   * @author owen 2008-6-12
   */
  function set_table($td_width, $tr_th=array(), $td_class=array()) {
    $this->td_width  = $td_width;
    $this->td_class  = $td_class;
    $this->tr_th  = $tr_th;

    if ($this->is_select) {
      array_unshift($this->td_width, '5%');
      array_unshift($this->td_class, '');
      array_unshift($this->tr_th, '选择');
    }

    if ($this->is_edit or $this->is_del) {
      $this->td_width[]  = '10%';
      $this->td_class[]  = '';
      $this->tr_th[]  = ($this->is_edit ? '修改':'').(($this->is_edit and $this->is_del)?' / ':'').($this->is_del ? '删除':'');
    }
  }
  /**
   * 设置表格属性
   * @param array $arr_type array('width', 'bordercolor', 'class', 'id', 'style')
   * @param boolean $border 是否显示表格边框
   * @return string <table>标签
   * @author owen 2008-6-12
   */
  function table_start($arr_type=array(), $border=1){
    $class    = $arr_type[0] ? $arr_type[0].' '.$this->tab_type[0] : $this->tab_type[0];
    $str_tmp = $arr_type[1] ? ' id="'.$arr_type[1].'"' : '';
    $str_tmp.= $arr_type[2] ? ' style="'.$arr_type[2].'"' : '';

    if ($this->is_edit or $this->is_del or $this->is_select) {
      $str = $this->f->form_start($_SERVER['PHP_SELF'].'?a=index', array("form_class"));
    }
    $str.= '<table class="'.$class.'" '.$str_tmp.'>'.$this->_n;
    return $str;
  }
  /**
   * 输出表格尾部代码
   * @return string </table>标签
   * @author owen 2008-6-12
   */
  function table_end(){
    $str = '</tbody>'.$this->_n;
    $str.= '</table>'.$this->_n;
    if ($this->is_edit or $this->is_del or $this->is_select) {
      $str.= $this->f->form_end().$this->_n;
    }
    $str.= $this->is_js ? $this->_js().$this->_n:'';
    return $str;
  }
  /**
   * 设置表格表头标题
   * @param string $caption 表头标题
   * @return string <caption>表头标题</caption>
   * @author owen 2008-6-12
   */
  function caption($caption='') {
    $str = $caption ? '  <caption>'.$caption.'</caption>'.$this->_n : '';
    return $str;
  }
  /**
   * 设置表格的标题 <th>
   * 生成标题行的代码
   * @return string <th>标题</th>
   * @author owen 2008-6-12
   */
  function tr_th($arr_css=array()) {
    $this->_th_init($this->tr_th);
    $str = '<thead>'.$this->_n;
    $str.= '  <tr>'.$this->_n;
    foreach ((array)$this->tr_th as $k=>$v) {
      $str.= '    <th'.($arr_css[$k] ? ' class="'.$arr_css[$k].'"' : '').' width="'.$this->td_width[$k].'">'.$v.'</th>'.$this->_n;
    }
    $str.= '  </tr>'.$this->_n;
    $str.= '</thead>'.$this->_n;
    $str.= '<tbody>'.$this->_n;
    return $str;
  }
  /**
   * 输出表格的一行
   * 当 $this->is_select=1 时，$arr_td[0] 为自增/唯一id
   * @param array $arr_td 数组中的每个值，分别显示在不同的列中
   * @return string 表格的一行<tr>代码</tr>
   * @author owen 2008-6-12
   */
  function tr_td_row($arr_td) {
    $id = $arr_td[0];
    if ($this->is_select) {
      array_unshift($arr_td, '<input type="'.($this->is_mutil_select ? 'checkbox' : 'radio').'" name="items[]" value="'.$id.'" />');
    }
    if ($this->is_edit or $this->is_del) {
      $arr_op = array();
      $arr_op[] = $this->is_edit ? '<a href="'.$this->_link_edit($id).'">修改</a>':'';
      $arr_op[] = ($this->is_edit and $this->is_del) ? ' &nbsp; ':'';
      $arr_op[] = $this->is_del ? '<a href="javascript:if(confirm(\'确认要删除吗？\'))document.location.href=\''.$this->_link_del($id).'\'">删除</a>':'';
      $arr_td[] = join('', $arr_op);
    }
    $str = $this->tr_td($arr_td);
    $this->is_js = 1;
    return $str;
  }
  /**
   * 输出表格的一行
   * @param array $arr_td 数组中的每个值，分别显示在不同的列中
   * @param array $arr_class 每列的样式
   * @param array $arr_width 每列的宽度
   * @param array $rowspan	可横跨的行数
   * @return string 表格的一行<tr>代码</tr>
   * @author owen 2008-6-12
   */
  function tr_td($arr_td, $rowspan=0){
    if (empty($this->td_sum)){
      $this->_td_sum($arr_td);
    }
    $str = '<tr>'.$this->_n;
    foreach ((array)$arr_td as $k=>$v) {
      $str.= '  <td';
      if($rowspan && count($arr_td) == $k+1){
        $str.= ' rowspan='.$rowspan;
      }
      $str.= '>';
      $str.= $v;
      $str.= '</td>'.$this->_n;
    }
    $str.= '</tr>'.$this->_n;
    return $str;
  }
  /**
   * 显示一个通行，此行只有一列
   * @param string $td_str 要显示在此行中的字符串
   * @param string $class 此行的样式
   * @param int $colspan 总列数
   * @return string 表格的一行，只有一列<tr>代码</tr>
   * @author owen 2008-6-12
   */
  function tr_one($td_str, $class='', $colspan=0) {
    if ($td_str) {
      $str = '<tr'.($class ? ' class="'.$class.'"' : '').'>'.$this->_n;
      $str.= '  <td colspan="'.($colspan ? $colspan : $this->td_sum).'">';
      $str.= $td_str;
      $str.= '</td>'.$this->_n;
      $str.= '</tr>'.$this->_n;
    }
    return $str;
  }
  /**
   * 返回功能处理行的代码
   * @param array $arr_op array('is_pass-0'=>"不通过", 'is_pass-1'=>"通过");
   * @param array $link_add <a href="$link_add">添加记录</a>
   * @return string
   * @author owen 2008-6-12
   */
  function tr_one_op($arr_op=array(), $link_add="", $link_str='') {
    $this->is_del ? $arr_op['del'] = '删除':'';

    $str = "";
    if ($arr_op) {
      if($this->is_mutil_select){
        $str.= $this->f->label($this->f->checkbox(array(), array('全选')));
      }
      $str.= str_repeat(' &nbsp; ', 5);

      $str.= $this->f->label(($link_str ? '<span style="padding:0 6px;">'.$link_str.'</span>' : '').$this->f->radio(array('item_op'), $arr_op), '选中项');

      $str.= str_repeat(' &nbsp; ', 5);
      $str.= $this->f->submit();
    }
    return $str ? $this->tr_one($str, 'tr_one_op'):'';
  }
  /**
   * 输出表格中的提交按钮
   * @return string 表格的一行，显示提交按钮
   * @author owen 2008-6-12
   */
  function tr_td_submit($is_back=1){
    $str = $this->f->submit();
    if ($is_back) {
      $str.= $this->f->back();
    }
    return $this->tr_one($str, 'tr_one');
  }
  function print_js(){
    $str = '

          ';
		return $str;
  }
  /**
   * 表格间隔分隔符
   * @return string <hr/>标签
   * @author owen 2008-6-12
   */
  function hr(){
    $str = '<hr style="width:95%;margin:10px auto;"/>';
    return $str;
  }
  /**
   * 输出 “编辑” 链接
   * @param int 自增id
   * @return string  “编辑” 链接
   * @author owen 2008-6-12
   */
  private function _link_edit($id){
    unset($_GET['a']);
    $query_string = http_build_query($_GET);
    return $this->admin_page.'?a=edit&id='.$id.($query_string ? '&'.$query_string : '');
  }
  /**
   * 输出 “删除” 链接
   * @param int 自增id
   * @return string  “删除” 链接
   * @author owen 2008-6-12
   */
  private function _link_del($id){
    unset($_GET['a']);
    $query_string = http_build_query($_GET);
    return $_SERVER['PHP_SELF'].'?a=del&id='.$id.($query_string ? '&'.$query_string : '');
  }
  /**
   * 初始化表头的 width、class
   * 当 $this->td_width 为空时 每列平均分配宽度
   * @param array $arr_td 数组中的值，显示到每一列中
   * @return void()
   * @author owen 2008-6-12
   */
  private function _th_init($arr_td) {
    $this->_td_sum($arr_td);
    if (empty($this->td_width)) {
      $this->td_width = array_fill(0, ($this->td_sum-1), floor(100/$this->td_sum).'%');
    }
    if (!empty($this->td_class)) {
      foreach ((array)$this->td_class as $k=>$v) {
        $this->td_class[$k] = $v ? $v : '';
      }
    }
  }
  /**
   * 统计总列数
   * @param array $arr_td 数组中的值，显示到每一列中
   * @return int 一共多少数据列
   * @author owen 2008-6-12
   */
  private function _td_sum($arr_td){
    $this->td_sum = count($arr_td);
    return $this->td_sum;
  }
  /**
   * 输出table所用的js
   * @return js 代码
   * @author owen 2008-6-12
   */
  private function _js() {
    $str = '
      <script type="text/javascript">
      <!--
        $(document).ready(function(){
          '.
          $this->print_js()
          .'
            $(".table tr[class!=\'tr_one_op\'] td").find("a, input[type=checkbox], input[type=radio]").click(
              function(e){if (e){  e.stopPropagation();}else{window.event.cancelBubble = true;}}
            );
          ';
    if ($this->is_edit or $this->is_del or $this->is_select) {
      $str.= '
        $(".table tr.tr_one_op td input[type=radio]").parent().dblclick(function(){$(this).children().attr("checked", false);});
        $(".table tr.tr_one_op td input[type=checkbox]").click(
          function(){
            var bool = this.checked;
            $(this).parents("table").find("input[name=\'items[]\']").each(function(){this.checked = bool});
          }
        );
      ';
    }
    $str.= '
        });
      //-->
      </script>
    ';
    return $str;
  }
}
?>
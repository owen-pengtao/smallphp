<?php
/**
 * 缓存类
 * 调用示例：
 * <code>
 * $cache = new cache();
 * $cache->cache_file = 文件完整路径;
 * $cache->cache_time = 缓存时间XX秒;
 * $cache->cache_is_str= 1;
 *
 * if (!$cache->cache_is_valid()){
 *  $cache->start();  //被缓存的文件 start
 *  echo 'some html string';
 *  $cache->end();  //被缓存的文件 end
 *
 *  $arr = array()  //some array
 *  $cache->save_array($arr);
 * }
 * echo '<pre style="text-align:left">';
 * print_r($cache->cache_content);
 * echo '</pre>';
 * </code>
 * @author yytcpt(无影) 2008-6-10 <yytcpt@gmail.com>
 * @link http://www.d5s.cn/ 无影的博客
 */
class cache{
  /**
   * 缓存文件全地址路径
   */
  public $cache_file;
  /**
   * 缓存文件有效时间
   * -1: 只要缓存文件存在, 永远使用缓存, 0: 永远不使用缓存(调试时使用), N: 有缓存过期时间
   */
  public $cache_time;
  /**
   * 缓存文件是否是字符串，1是字符串，0数组, 2是对象
   */
  public $cache_is_str;
  /**
   * 缓存数据
   */
  public $cache_content;
  function __construct(){
    $this->cache_file = '';
    $this->cache_time = 0;
    $this->cache_is_str = 1;
    $this->cache_content= '';
  }
  function start() {
    ob_start();
  }
  function end() {
    $this->cache_content    = ob_get_contents();
    ob_end_clean();
    $this->_save_cache_string();
  }
  function get_cache($type){
    $file = PATH_CACHES.'array_'.$type.'.php';
    $content = '';
    if(file_exists($file)){
      $this->cache_file = $file;
      $content = $this->_get_cache();
    }
    return $content;
  }
  /**
   * 把数组保存到缓存文件中
   * @param array $arr 被缓存数组
   * @return boolean 是否保存成功
   * @author owen 2008-6-16
   */
  function save_array($arr, $is_blank=1) {
    $this->cache_content = $arr;
    return $this->_save_file('<?php $array = '.preg_replace("/".($is_blank ? "\s" : "\n|\r")."/i", "", var_export($arr, TRUE)).';?>');
  }
  function save_string($str){
    return $this->_save_file($str);
  }
  function save_object($obj){
    $str = serialize($obj);
    return $this->_save_file($str);
  }
  /**
   * 缓存是否有效
   * @return boolean true有效  false无效
   */
  function cache_is_valid(){
    $bool_file  = file_exists($this->cache_file);
    $bool = false;
    if ($bool_file) {
      if($this->cache_time>=0){
        $bool_time  = ((time()-filemtime($this->cache_file)) < $this->cache_time);
        $bool_clear = (isset($_GET['clear']) && $_GET['clear']==1) ? false : true;
        if ($bool_time && $bool_clear) {  //缓存不过期 且 缓存存在
          $this->_get_cache();
          $bool = true;
        }
      }elseif(!isset($_GET['clear'])){  //缓存永不过期
        $this->_get_cache();
        $bool = true;
      }
    }
    return $bool;
  }
  /**
   * 获取缓存文件
   * @return array 被缓存数据
   */
  private function _get_cache() {
    if ($this->cache_is_str==1) {
      $this->cache_content = file_get_contents($this->cache_file);
    }elseif ($this->cache_is_str==2) {
      $this->cache_content = unserialize(file_get_contents($this->cache_file));
    }else{
      $array = array();
      include($this->cache_file);
      $this->cache_content = $array;
    }
    return $this->cache_content;
  }
  /**
   * 保存数据到缓存文件
   * @return void()
   */
  private function _save_cache_string() {
    if ($this->cache_file) {
      if($this->_save_file($this->cache_content)==0) {
        exit("缓存错误！");
      }
    }else{
      exit('需指定缓存文件全路径。');
    }
  }
  /**
   * 保存数据到缓存文件$this->cache_file中
   * @param string $string 被保存数据
   * @return boolean 是否被保存成功
   * @author owen 2008-6-16
   */
  private function _save_file($string) {
    $this->_mk_dir(dirname($this->cache_file));
    return file_put_contents($this->cache_file, $string);
  }
  /**
   * 递归创建目录
   * @param string $path 目录路径
   * @return void()
   * @author owen 2008-6-16
   */
  function _mk_dir($path){
    if (!file_exists($path)){
      $this->_mk_dir(dirname($path));
      mkdir($path, 0777);
      chmod($path, 0777);
    }
  }
}
?>
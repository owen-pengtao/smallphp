<?php
  include('config.php');
  $str = '<?php
class db_config{
  var $db_config = array(
            "hostname" => "localhost",
            "username" => "root",
            "password" => "",
            "database" => "a_db",
          );
}
?>
';
  if(!file_exists('db_config.php')){
    file_put_contents('db_config.php', $str);
  }
  $arr = array(
         PATH_TMP, PATH_CACHES
      );
  foreach ($arr AS $v){
    if(!file_exists($v)){
      mkdir($v, 0777);
      chmod($v, 0777);
      echo $v.str_repeat(' &nbsp; ', 10).' create successful.<br/>';
    }else{
      echo $v.str_repeat(' &nbsp; ', 10).' is exists.<br/>';
    }
  }
  $c = new controller();
  $db = $c->connect_db();

  init_category();

  function init_category(){
    global $db;
    $cat = new root_categoryController();
    $cat->db = $db;
    $cat->indexAction();
    print_successful($cat->path_row);
    print_successful($cat->path_arr);
  }
  function print_successful($file){
    echo $file.str_repeat(' &nbsp; ', 10).' create successful.<br/>';
  }
?>

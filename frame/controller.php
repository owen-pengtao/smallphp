<?php
/*
  $action    = $_GET['a'] ? $_GET['a'] : 'index';      //方法名称
  $controller = $_GET['c'] ? $_GET['c'] : basename(strtolower($_SERVER['PHP_SELF']), '.php');      //控制器
  $view    = isset($_GET['v']) ? $_GET['v'] : $controller;    //获取模板文件名

  $controller = new $controller();
  if ($controller->no_cdb[$action]==0) {
    $controller->connect_db();
  }
  $controller->meta();
  
  if (method_exists($controller, $action)) {
    $controller->$action();
  }else{
    $controller->index();
  }
  if (validate_cookie() && !isset($_SESSION['power'])) {
    header_go(SITE_URL.'api/api.php?c=user&a=set_session&back_url='.rawurlencode(get_url()));
  }
  $tpl = (object)$controller->tpl;
  */
?>
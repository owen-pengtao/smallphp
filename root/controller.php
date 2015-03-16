<?php
  include(SITE_PATH.'connect_db.php');

  $m = basename($_SERVER['PHP_SELF'], '.php');
  $action = trim($_GET['a']);
  if($action == ''){
    header_go($_SERVER['PHP_SELF'].'?a=index');
  }

  $model = $m.'Model';
  $control = 'root_'.$m.'Controller';
  $action = $action ? $action : 'index';

  $model_file = PATH_MODEL.$model.'.php';
  $controller_file = PATH_CONTROLLER.$control.'.php';

  if(file_exists($model_file)){
    include($model_file);
    $modelObj = new $model();
    $modelObj->db = $db;
  }
  if(file_exists($controller_file)){
    include($controller_file);
    $controller = new $control();
    $controller->$m = $modelObj;
    $action_name = $action.'Action';
    if(in_array($action_name, get_class_methods($controller))){
      $tpl = $controller->$action_name();
    }
  }
?>
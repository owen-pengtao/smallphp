<?php
  include('config.php');

  $col = strtolower(trim($_GET['m']));
  $action = trim($_GET['a']);

  $_model = explode("_", $col);
  $model = $_model[1];

  $model = $model ? $model : 'index';
  $action = $action ? $action : 'index';

  $model_file = PATH_MODEL.$model.'Model.php';
  $controller_file = PATH_CONTROLLER.$col.'Controller.php';
  $view_file = PATH_VIEWS.$model.DS.$action.'.php';

  include(SITE_PATH.'connect_db.php');
  if(file_exists($model_file)){
    include($model_file);
    $Obj = $model.'Model';
    $m = new $Obj();
    $m->db = $db;
  }else{
    $m = '';
  }

  if(file_exists($controller_file)){
    include($controller_file);
    $Obj = $col.'Controller';
    $controller = new $Obj();
    if($m!=''){
      $controller->$model = $m;
    }
    $action_function = $action.'Action';
    $tpl = $controller->$action_function();
  }else{
    exit;
  }

  if(file_exists($view_file)){
    include($view_file);
  }
?>
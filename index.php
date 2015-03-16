<?php
  include('config.php');

  $model = isset($_GET['m']) ? strtolower(trim($_GET['m'])) : '';
  $action = isset($_GET['a']) ? trim($_GET['a']) : '';

  if(array_shift(explode("_", $model)) == "root"){
    header_go('root/login.php');
  }

  $model = $model ? $model : 'index';
  $action = $action ? $action : 'index';

  $model_file = PATH_MODEL.$model.'Model.php';
  $controller_file = PATH_CONTROLLER.$model.'Controller.php';
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

  include($controller_file);
  $Obj = $model.'Controller';
  $controller = new $Obj();
  if($m!=''){
    $controller->$model = $m;
  }
  $action_function = $action.'Action';
  $tpl = $controller->$action_function();

  if(file_exists($view_file)){
    include($view_file);
  }
?>
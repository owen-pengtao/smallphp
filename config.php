<?php
  //error_reporting(0);
  error_reporting(E_ALL ^ E_NOTICE);
  session_start();
  define('DEBUG', false);
  define('DS', DIRECTORY_SEPARATOR);
  define('DSU', '/');
  define('APP_DIR', 'app');
  define('API_DIR', 'api');
  define('DIR_ADMIN', 'root');
  define('DOMAIN', isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'smallphp.local.d5s.cn');
  define('T', 'sp_');
  define('HASH_KEY', '65&*TUF$Cqs(%YOI');
  define('SITE_DIR', '');

  define('SITE_PATH', dirname(__FILE__).DS);
  define('SITE_URL', 'http://'.DOMAIN.DSU.SITE_DIR);

  define('PATH_API', SITE_PATH.API_DIR.DS);
  define('PATH_APP', SITE_PATH.APP_DIR.DS);
  define('PATH_FRAME', SITE_PATH.'frame'.DS);
  define('PATH_CLASS', PATH_FRAME.'class'.DS);
  define('PATH_TMP', SITE_PATH.'tmp'.DS);
  define('PATH_CACHES', PATH_TMP.'caches'.DS);
  define('PATH_CONTROLLER', SITE_PATH.APP_DIR.DS.'controller'.DS);
  define('PATH_MODEL', SITE_PATH.APP_DIR.DS.'model'.DS);
  define('PATH_VIEWS', SITE_PATH.APP_DIR.DS.'views'.DS);
  define('PATH_VIEWS_COMMON', PATH_VIEWS.DS.'common'.DS);
  define('PATH_CONFIG', SITE_PATH.APP_DIR.DS.'config'.DS);
  define('PATH_ROOT', SITE_PATH.DIR_ADMIN.DS);

  define('URL_APP', SITE_URL.APP_DIR.DSU);
  define('URL_JS', URL_APP.'js'.DSU);
  define('URL_STYLES', URL_APP.'styles'.DSU);
  define('URL_IMAGES', URL_APP.'images'.DSU);
  define('URL_ROOT', SITE_URL.DIR_ADMIN.DSU);

  define('CHARSET', 'utf-8');

  $CONFIG = array(
    'DEFAULT_IMG' => URL_IMAGES.'default_image.gif',
  );

  header("content-type:text/html;charset=".CHARSET);
  include_once(PATH_FRAME.'function.php');
  include_once(PATH_FRAME.'function_string.php');
?>
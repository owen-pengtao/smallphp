<?php
  include(SITE_PATH.'db_config.php');
  $db_config  = new db_config();

  $db = new db();
  $is_connect = $db->connect($db_config->db_config);
  unset($db_config);
?>
<?php
  include("db_config.php");
  include("config.php");
  include("frame/class/db.php");
  $db_config = new db_config();
  $db = new db();
  $db->connect($db_config->db_config);


$row = array(
    "edit_time" => time()
);
$id = $db->get_all_tables();
pr($id);
echo md5("owen");
?>

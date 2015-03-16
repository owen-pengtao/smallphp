<?php
  include('../config.php');
  if (empty($_SESSION['admin']) && $_SESSION["is_root"]!=1) {
    header_go('login.php');
  }
  include('controller.php');
?>
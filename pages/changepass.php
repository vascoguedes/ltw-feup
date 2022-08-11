<?php
  declare(strict_types = 1);

  session_start();

  require_once('templates/common.tpl.php');  
  require_once('templates/change_pass.tpl.php');

  if ($_SESSION['logedin']) {
    header('Location: index.php?page=feed.php');
  }

  drawHeader(NULL, NULL);
  drawChangePass();
  drawFooter();
?>
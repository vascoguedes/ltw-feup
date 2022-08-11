<?php
  declare(strict_types = 1);

  session_start();
  
  require_once('templates/common.tpl.php');  
  require_once('templates/login.tpl.php');

  if ($_SESSION['logedin']) {
    header('Location: index.php?page=feed');
  }

  drawHeader(NULL, NULL);
  drawLogin();
  drawFooter();
?>
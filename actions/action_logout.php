<?php
  declare(strict_types = 1);

  session_start();

  if ($_SESSION['csrf'] !== $_GET['csrf']) {
    header('Location: ../index.php');
  }
  
  session_destroy();

  header('Location: ../index.php?page=login');
?>
<?php 
  session_start();

  require_once('../database/connection.db.php');
  require_once('../database/user.class.php');

  if ($_SESSION['csrf'] !== $_GET['csrf']) {
    header('Location: ../index.php');
  }

  $db = getDatabaseConnection();
  
  User::changePassword($db, $_GET['token'], hash('sha256', $_GET['password']));

  header('Location: ../index.php?page=login');
?>
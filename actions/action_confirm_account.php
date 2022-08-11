<?php 
  session_start();

  require_once('../database/connection.db.php');
  require_once('../database/user.class.php');

  $db = getDatabaseConnection();

  User::confirmAccount($db, $_GET['token']);
  header('Location: ../index.php?page=login');
?>
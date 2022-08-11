<?php
  declare(strict_types = 1);

  session_start();

  require_once('../database/connection.db.php');
  require_once('../database/user.class.php');

  if ($_SESSION['csrf'] !== $_GET['csrf']) {
    header('Location: ../index.php');
  }
  
  $db = getDatabaseConnection();
  
  if ($_FILES["Picture"]["name"] != '') {
    $filename = str_replace(' ', '', $_FILES["Picture"]["name"]);
    $tempname = str_replace(' ', '', $_FILES["Picture"]["tmp_name"]);   
    $folder = "uploads/".$filename;

    move_uploaded_file($tempname, $folder);
  }

  User::updateUserInfo($db, $_SESSION['id'], htmlspecialchars($_POST['Username']), htmlspecialchars($_POST['Email']), htmlspecialchars($_POST['Address']), htmlspecialchars($_POST['Phone_number']), htmlspecialchars($_POST['Birthdate']), password_hash($_POST['Password'], PASSWORD_DEFAULT), str_replace(' ', '', $_FILES["Picture"]["name"]));

  header('Location: ../index.php?page=profile&id=' . $_SESSION['id']);
?>
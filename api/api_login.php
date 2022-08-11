<?php 
  session_start();

  require_once('../database/connection.db.php');
  require_once('../database/user.class.php');

  $db = getDatabaseConnection();

  if ($_SESSION['csrf'] === $_GET['csrf'])
  $user = User::getUserIdAndPassword($db, htmlspecialchars($_GET['email']), $_GET['password']);

  if (password_verify($_GET['password'], $user[2]) && $user && $user[0] != 'NULL') {

    if ($user[1] == true) {
      $_SESSION['id'] = $user[0];
      $_SESSION['logedin'] = true;
      echo json_encode('SUCCESS');
    } else {
      echo json_encode('NOT VERIFIED');
    }    
  } else {
    echo json_encode('NULL');
  }
?>
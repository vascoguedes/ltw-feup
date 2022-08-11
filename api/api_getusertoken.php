
<?php 
  session_start();

  require_once('../database/connection.db.php');
  require_once('../database/user.class.php');

  $db = getDatabaseConnection();

  if ($_SESSION['csrf'] === $_GET['csrf'])
  $token = User::getToken($db, htmlspecialchars($_GET['email']));

  echo json_encode($token);
?>


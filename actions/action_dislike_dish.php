<?php 
  session_start();

  require_once('../database/connection.db.php');
  require_once('../database/userfavoritedishes.class.php');

  if ($_SESSION['csrf'] !== $_GET['csrf']) {
    header('Location: ../index.php');
  }

  $db = getDatabaseConnection();

  UserFavoriteDishes::dislikeDish($db, $_GET['Dish_id'], $_SESSION['id']);
?>
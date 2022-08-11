<?php 
  session_start();

  require_once('../database/connection.db.php');
  require_once('../database/userfavoriterestaurants.class.php');

  if ($_SESSION['csrf'] !== $_GET['csrf']) {
    header('Location: ../index.php');
  }

  $db = getDatabaseConnection();

  UserFavoriteRestaurants::dislikeRestaurant($db, $_GET['rest_id'], $_SESSION['id']);
  header('Location: ../index.php?page=profile&id=' . $_SESSION['id']);
?>
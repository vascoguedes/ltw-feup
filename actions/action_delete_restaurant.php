<?php 
  session_start();

  require_once('../database/connection.db.php');
  require_once('../database/restaurant.class.php');

  if ($_SESSION['csrf'] !== $_GET['csrf']) {
    header('Location: ../index.php');
  }

  $db = getDatabaseConnection();

  Restaurant::deleteRestaurant($db, $_GET['id']);
  header('Location: ../index.php?page=profile&id=' . $_SESSION['id']);
?>
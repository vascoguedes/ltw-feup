<?php 
  session_start();

  require_once('../database/connection.db.php');
  require_once('../database/reviewrestaurant.class.php');

  $db = getDatabaseConnection();

  if ($_SESSION['csrf'] !== $_GET['csrf']) {
    header('Location: ../index.php');
  }

  ReviewRestaurant::addReview($db, $_GET['id'], htmlspecialchars($_GET['opinion']), $_GET['rating']);

  header('Location: ../index.php?page=profile&id=' . $_SESSION['id']);
?>
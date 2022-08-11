<?php
  declare(strict_types = 1);

  session_start();

  require_once('../database/connection.db.php');
  require_once('../database/restaurant.class.php');

  $db = getDatabaseConnection();

  if (htmlspecialchars($_GET['search'])) {
    $search = htmlspecialchars($_GET['search']);
  } else {
    $search = "";
  }
  if ($_GET['option1']) {
    $option1 = $_GET['option1'];
  } else {
    $option1 = "";
  }
  if ($_GET['option2']) {
    $option2 = $_GET['option2'];
  } else {
    $option2 = "";
  }
  if ($_GET['option3']) {
    $option3 = (int) $_GET['option3'];
  } else {
    $option3 = (int) "";
  }


  if ($_SESSION['csrf'] === $_GET['csrf'])
    $restaurants = Restaurant::searchRestaurants($db, $search, $option1, $option2, $option3, $_SESSION['id']);


  echo json_encode($restaurants);
?>
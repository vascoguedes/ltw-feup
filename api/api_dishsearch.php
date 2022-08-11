<?php
  declare(strict_types = 1);

  session_start();

  require_once('../database/connection.db.php');
  require_once('../database/dish.class.php');

  $db = getDatabaseConnection();

  if ($_GET['search']) {
    $search = $_GET['search'];
  } else {
    $search = "";
  }
  $rest_id = $_GET['rest_id'];

  $dishes = Dish::searchDishes($db, $search, $rest_id, $_SESSION['id']);


  echo json_encode($dishes);
?>
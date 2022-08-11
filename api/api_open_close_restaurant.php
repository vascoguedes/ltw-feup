<?php
  declare(strict_types = 1);

  session_start();

  require_once('../database/connection.db.php');
  //require_once('./restaurant.class.php');
  require_once('../database/restaurant.class.php');

  $db = getDatabaseConnection();
  if ($_SESSION['csrf'] === $_GET['csrf']) {
  if ($_GET['Action'] == 'Open') {
    Restaurant::openRestaurant($db, $_GET['Restaurant_id']);
  } else {
    Restaurant::closeRestaurant($db, $_GET['Restaurant_id']);
  }}
?>
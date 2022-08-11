<?php 
  session_start();

  require_once('../database/connection.db.php');
  require_once('../database/shoppingcart.class.php');

  $db = getDatabaseConnection();

  ShoppingCart::nextState($db, $_GET['cart_id']);
  echo json_encode(ShoppingCart::getState($db, $_GET['cart_id']));
?>
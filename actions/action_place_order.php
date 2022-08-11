
<?php 
  session_start();

  require_once('../database/connection.db.php');
  require_once('../database/shoppingcart.class.php');
  require_once('../database/restaurant.class.php');

  if ($_SESSION['csrf'] !== $_GET['csrf']) {
    header('Location: ../index.php');
  }

  $db = getDatabaseConnection();

  $restaurantState = Restaurant::getStateByRestaurantId($db, $_GET['rest_id']);

  if ($restaurantState == 1) {
    ShoppingCart::placeOrder($db, $_GET['id']);
    header('Location: ../index.php?page=order_sucessful');
  } else {
    header('Location: ../index.php?page=order_unsucessful');
  } 
  
?>
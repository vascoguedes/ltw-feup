<?php
  declare(strict_types = 1);

  session_start();

  require_once('../database/connection.db.php');
  require_once('../database/shoppingcart.class.php');

  $db = getDatabaseConnection();
  
  if ($_SESSION['csrf'] === $_GET['csrf'])
  echo json_encode(ShoppingCart::editDishToShoppingCarts($_SESSION['id'], $_GET['rest_id'], $_GET['dish_id'], htmlspecialchars($_GET['value']), $_GET['operation']));
  
?>
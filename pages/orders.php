<?php
  declare(strict_types = 1);

  session_start();

  require_once('database/connection.db.php');
  require_once('database/user.class.php');
  require_once('database/restaurant.class.php');
  require_once('database/dish.class.php');
  require_once('database/shoppingcart.class.php');

  require_once('templates/common.tpl.php');
  require_once('templates/restaurant.tpl.php');
  require_once('templates/orders.tpl.php');
  require_once('templates/profile.tpl.php');

  if ($_SESSION['logedin']) {
    $db = getDatabaseConnection();
    $restaurant = Restaurant::getRestaurantsById($db, $_GET['id']);
    
    if (!($restaurant['Rest_owner'] == $_SESSION['id'])) {
      header('Location: index.php?page=feed');
    } else {
      $username = User::getUserName($db, $_SESSION['id']);
      $numOpenCarts =  ShoppingCart::numberOpenCartsUserId($db, $_SESSION['id']);
    }
  } else {
    header('Location: index.php?page=feed');
  }

  drawHeader($username, $numOpenCarts);
  drawRestaurantForm($restaurant);
  drawReceiptPopUp($db);
  drawRestaurantOrdersBars($db, $_GET['id']);
  drawFooter();
?>
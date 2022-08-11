<?php
  declare(strict_types = 1);
  
  session_start();

  require_once('database/connection.db.php');
  require_once('database/user.class.php');
  require_once('database/restaurant.class.php');
  require_once('database/restaurantcategory.class.php');
  require_once('database/restaurantlocation.class.php');
  require_once('database/shoppingcart.class.php');
  require_once('templates/common.tpl.php');
  require_once('templates/profile.tpl.php');

  $db = getDatabaseConnection();  

  if ($_SESSION['logedin']) {
    $db = getDatabaseConnection();
    $username = User::getUserName($db, $_SESSION['id']);
    $user = User::getUserProfileInfo($db, $_GET['id']);
    $numOpenCarts =  ShoppingCart::numberOpenCartsUserId($db, $_SESSION['id']);
  } else {
    header('Location: index.php?page=feed');
  }

  drawHeader($username, $numOpenCarts);
  drawProfileForm($user);
  drawAddRestaurantForm($db);
  drawAddRestaurantReviewForm($db);
  drawReceiptPopUp($db);
  drawSectionBar(['My orders']);
  drawOrdersBars($db, $_SESSION['id']);
  drawSectionBar(['My restaurants', "addRestaurantPopUp()"]);
  drawRestaurantBars($db, $_GET['id']);
  drawFooter();
?>
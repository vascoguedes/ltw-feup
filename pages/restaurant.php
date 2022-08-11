<?php
  declare(strict_types = 1);

  session_start();

  require_once('database/connection.db.php');
  require_once('database/user.class.php');
  require_once('database/restaurant.class.php');
  require_once('database/dish.class.php');
  require_once('database/shoppingcart.class.php');
  require_once('database/reviewrestaurant.class.php');
  require_once('database/dishcategory.class.php');

  require_once('templates/common.tpl.php');
  require_once('templates/restaurant.tpl.php');

  if ($_SESSION['logedin']) {
    $db = getDatabaseConnection();
    $username = User::getUserName($db, $_SESSION['id']);
    $restaurant = Restaurant::getRestaurantsById($db, $_GET['id']);
    $numOpenCarts =  ShoppingCart::numberOpenCartsUserId($db, $_SESSION['id']);
  } else {
    header('Location: index.php?page=feed');
  }

  drawHeader($username, $numOpenCarts);
  drawRestaurantForm($restaurant);

  if ($restaurant['Rest_owner'] == $_SESSION['id']) {
    drawSectionBar(["Received orders"]);
    drawOrdersSection($db, $_GET['id']);
  } else {
    drawSectionBar(["Last review"]);
    $review = ReviewRestaurant::getLastReviewByRestaurantID($db, $_GET['id']);
    drawComment($review, $restaurant['Rest_owner']);
  }

  drawDishesMenuBar($restaurant['Rest_owner'] == $_SESSION['id'], $restaurant['Restaurant_id']);
  drawAddDishForm($db);
  drawRestaurantDishes($db, $_GET['id'], $restaurant['Rest_owner']);
  drawSectionBar(["Reviews"]);
  drawComments($db, $_GET['id'], $restaurant['Rest_owner']);

  drawFooter();
?>
<?php 
  session_start();

  require_once('../database/connection.db.php');
  require_once('../database/restaurant.class.php');
  require_once('../database/restaurantcategory.class.php');
  require_once('../database/restaurantlocation.class.php');

  if ($_SESSION['csrf'] !== $_GET['csrf']) {
    header('Location: ../index.php');
  }

  $db = getDatabaseConnection();

  $Category_id = RestaurantCategory::getCategoryId($db, htmlspecialchars($_GET['Category']));
  
  if($Category_id == 'NULL') {
    RestaurantCategory::createCategory($db, htmlspecialchars($_GET['Category']));
    $Category_id = RestaurantCategory::getCategoryId($db, htmlspecialchars($_GET['Category']));
  }

  $Location_id = RestaurantLocation::getLocationId($db, htmlspecialchars($_GET['Location']));
  
  if($Location_id == 'NULL') {
    RestaurantLocation::createLocation($db, htmlspecialchars($_GET['Location']));
    $Location_id = RestaurantLocation::getLocationId($db, htmlspecialchars($_GET['Location']));
  }
  
  Restaurant::createRestaurant($db, $_SESSION['id'], htmlspecialchars($_GET['Rest_name']), $Location_id, htmlspecialchars($_GET['Address']), htmlspecialchars($_GET['Phone_number']), $Category_id);

  header('Location: ../index.php?page=profile&id=' . $_SESSION['id']);
?>
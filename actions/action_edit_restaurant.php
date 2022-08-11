<?php
  declare(strict_types = 1);

  session_start();

  require_once('../database/connection.db.php');
  require_once('../database/restaurant.class.php');
  require_once('../database/restaurantcategory.class.php');
  require_once('../database/restaurantlocation.class.php');

  if ($_SESSION['csrf'] !== $_GET['csrf']) {
    header('Location: ../index.php');
  }

  $db = getDatabaseConnection();

  $Category_id = RestaurantCategory::getCategoryId($db, htmlspecialchars($_POST['Category']));
  
  if($Category_id == 'NULL') {
    RestaurantCategory::createCategory($db, htmlspecialchars($_POST['Category']));
    $Category_id = RestaurantCategory::getCategoryId($db, htmlspecialchars($_POST['Category']));
  }

  $Location_id = RestaurantLocation::getLocationId($db, htmlspecialchars($_POST['Location']));
  
  if($Location_id == 'NULL') {
    RestaurantLocation::createLocation($db, htmlspecialchars($_POST['Location']));
    $Location_id = RestaurantLocation::getLocationId($db, htmlspecialchars($_POST['Location']));
  }

  if ($_FILES["Picture"]["name"] != '') {
    $filename = $_FILES["Picture"]["name"];
    $tempname = $_FILES["Picture"]["tmp_name"];   
    $folder = "../uploads/".$filename;

    move_uploaded_file($tempname, $folder);
  }
  
  Restaurant::updateRestaurantInfo($db, $_GET['id'], htmlspecialchars($_POST['Rest_name']), $Location_id, $Category_id, htmlspecialchars($_POST['Address']), htmlspecialchars($_POST['Phone_number']), $_FILES["Picture"]["name"]);
  
  header('Location: ../index.php?page=restaurant&id=' . $_GET['id']);
?>
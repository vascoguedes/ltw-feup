<?php 
  session_start();

  require_once('../database/connection.db.php');
  require_once('../database/dish.class.php');
  require_once('../database/dishcategory.class.php');
  require_once('../database/dishname.class.php');

  $db = getDatabaseConnection();

  if ($_SESSION['csrf'] !== $_GET['csrf']) {
    header('Location: ../index.php');
  }

  if ($_FILES["Picture"]["name"] != '') {
    $filename = str_replace(' ', '', $_FILES["Picture"]["name"]);
    $tempname = str_replace(' ', '', $_FILES["Picture"]["tmp_name"]);   
    $folder = "../uploads/".$filename;

    move_uploaded_file($tempname, $folder);
  }

  $Category_id = DishCategory::getCategoryId($db, htmlspecialchars($_POST['Category']));
  
  if($Category_id == 'NULL') {
    DishCategory::createCategory($db, htmlspecialchars($_POST['Category']));
    $Category_id = DishCategory::getCategoryId($db, htmlspecialchars($_POST['Category']));
  }

  $Name_id = DishName::getNameId($db, htmlspecialchars($_POST['Dish_name']));
  
  if($Name_id == 'NULL') {
    DishName::createName($db, htmlspecialchars($_POST['Dish_name']));
    $Name_id = DishName::getNameId($db, htmlspecialchars($_POST['Dish_name']));
  }
  
  Dish::createDish($db, htmlspecialchars($_POST['Rest_id']), $Category_id, $Name_id, htmlspecialchars($_POST['Price']),  str_replace(' ', '', $_FILES["Picture"]["name"]));

  header('Location: ../index.php?page=restaurant&id=' . htmlspecialchars($_POST['Rest_id']));
?>

<?php 
  session_start();

  require_once('../database/connection.db.php');
  require_once('../database/shoppingcart.class.php');

  $db = getDatabaseConnection();

  if ($_SESSION['csrf'] === $_GET['csrf']) {
    ShoppingCart::cancelOrder($db, $_GET['cart_id']);

    header('Location: ../index.php?page=orders&id=' . $_GET['id']); 
  } else {
    header('Location: ../index.php');
  }
   
?>
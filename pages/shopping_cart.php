<?php
  declare(strict_types = 1);

  session_start();

  require_once('database/connection.db.php');
  require_once('database/user.class.php');
  require_once('database/shoppingcart.class.php');
  require_once('templates/common.tpl.php');
  require_once('templates/shopping_cart.tpl.php');

  if ($_SESSION['logedin']) {
    $db = getDatabaseConnection();
    $Username = User::getUserName($db, $_SESSION['id']);
    $numOpenCarts =  ShoppingCart::numberOpenCartsUserId($db, $_SESSION['id']);
  } else {
    header('Location: index.php?page=feed');
  }

  drawHeader($Username, $numOpenCarts);
  drawPageTitle();
  drawShoppingCarts($db, $_SESSION['id']);
  drawFooter();
?>
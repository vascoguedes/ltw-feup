<?php
  declare(strict_types = 1);

  session_start();

  $page = $_GET['page'];

  if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(32));
  }

  if ($page == NULL || $page == 'landing_page') include('pages/landing_page.php');
  if ($page == 'feed') include('pages/feed.php');
  if ($page == 'login') include('pages/login.php');
  if ($page == 'changepass') include('pages/changepass.php');
  if ($page == 'order_sucessful') include('pages/order_sucessful.php');
  if ($page == 'order_unsucessful') include('pages/order_unsucessful.php');
  if ($page == 'orders') include('pages/orders.php');
  if ($page == 'profile') include('pages/profile.php');  
  if ($page == 'recoverpass') include('pages/recoverpass.php');
  if ($page == 'register') include('pages/register.php');
  if ($page == 'restaurant') include('pages/restaurant.php');
  if ($page == 'shopping_cart') include('pages/shopping_cart.php');
?>
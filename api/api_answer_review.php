<?php
  declare(strict_types = 1);

  session_start();

  require_once('../database/connection.db.php');
  require_once('../database/reviewrestaurantanswer.class.php');

  $db = getDatabaseConnection();
  
  if ($_SESSION['csrf'] === $_GET['csrf'])
  ReviewRestaurantAnswer::answerReview($db, $_GET['Answer_id'], htmlspecialchars($_GET['Answer_text']));
  
?>
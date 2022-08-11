<?php
  declare(strict_types = 1);

  class UserFavoriteDishes {

    function likeDish($db, $Dish_id, $User_id) {
      $stmt = $db->prepare('INSERT INTO UserFavoriteDishes (Dish_id, User_id) values (:Dish_id, :User_id);');
      $stmt->bindParam(':Dish_id', $Dish_id);
      $stmt->bindParam(':User_id', $User_id);

      $stmt->execute();
    }

    function dislikeDish($db, $Dish_id, $User_id) {
      $stmt = $db->prepare('DELETE FROM UserFavoriteDishes WHERE Dish_id = :Dish_id and User_id = :User_id;');
      $stmt->bindParam(':Dish_id', $Dish_id);
      $stmt->bindParam(':User_id', $User_id);

      $stmt->execute();
    }
  } 

?>
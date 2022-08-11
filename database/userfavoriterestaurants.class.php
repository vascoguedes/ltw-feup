<?php
  declare(strict_types = 1);

  class UserFavoriteRestaurants {

    function likeRestaurant($db, $Restaurant_id, $User_id) {
      $stmt = $db->prepare('INSERT INTO UserFavoriteRestaurants (Restaurant_id, User_id) values (:Restaurant_id, :User_id);');
      $stmt->bindParam(':Restaurant_id', $Restaurant_id);
      $stmt->bindParam(':User_id', $User_id);

      $stmt->execute();
    }

    function dislikeRestaurant($db, $Restaurant_id, $User_id) {
      $stmt = $db->prepare('DELETE FROM UserFavoriteRestaurants WHERE Restaurant_id = :Restaurant_id and User_id = :User_id;');
      $stmt->bindParam(':Restaurant_id', $Restaurant_id);
      $stmt->bindParam(':User_id', $User_id);

      $stmt->execute();
    }
  } 

?>
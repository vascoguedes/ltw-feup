<?php
  declare(strict_types = 1);

  class ReviewRestaurant {

    function getAllReviewsByRestaurantID($db, $Restaurant_id) {
      $stmt = $db->prepare('select review_text as Comment, username, ShoppingCart.user_id, Review_id, Answer_text as Answer from ReviewRestaurant left join ShoppingCart on ReviewRestaurant.Review_id = ShoppingCart.Cart_id left join user on user.User_id = ShoppingCart.User_id left join ReviewRestaurantAnswer on ReviewRestaurantAnswer.Answer_id = Review_id where ShoppingCart.Restaurant_id = :Restaurant_id order by date_time;');
      $stmt->bindParam(':Restaurant_id', $Restaurant_id);

      $stmt->execute();
      $reviews = $stmt->fetchAll();

      return $reviews;
    }

    function addReview($db, $Review_id, $Review_text, $Rating) {
      $stmt = $db->prepare('insert into ReviewRestaurant (Review_id, Review_text, Rating) values (:Review_id, :Review_text, :Rating);');
      $stmt->bindParam(':Review_id', $Review_id);
      $stmt->bindParam(':Review_text', $Review_text);
      $stmt->bindParam(':Rating', $Rating);

      $stmt->execute();
    }

    function getLastReviewByRestaurantID($db, $Restaurant_id) {
      $stmt = $db->prepare('select review_text as Comment, username, ShoppingCart.user_id  from ReviewRestaurant left join ShoppingCart on ReviewRestaurant.Review_id = ShoppingCart.Cart_id left join user on user.User_id = ShoppingCart.User_id where ShoppingCart.Restaurant_id = :Restaurant_id order by date_time;');
      $stmt->bindParam(':Restaurant_id', $Restaurant_id);

      $stmt->execute();
      $review = $stmt->fetch();

      return $review;
    }    
  }

?>
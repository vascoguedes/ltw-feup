<?php
  declare(strict_types = 1);

  class ReviewRestaurantAnswer {

    static function answerReview(PDO $db, string $Answer_id, string $Answer_text) : void {
      $stmt = $db->prepare('INSERT INTO ReviewRestaurantAnswer (Answer_id, Answer_text) values (:Answer_id, :Answer_text);');
      $stmt->bindParam(':Answer_id', $Answer_id);
      $stmt->bindParam(':Answer_text', $Answer_text);

      $stmt->execute();
    }    
  }
?>
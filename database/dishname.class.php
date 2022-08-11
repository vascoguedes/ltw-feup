<?php
  declare(strict_types = 1);

  class DishName {

    static function getNameId(PDO $db, string $Dish_name) : string {
      $stmt = $db->prepare('SELECT Name_ID FROM DishName where Dish_name = :Dish_name;');
      $stmt->bindParam(':Dish_name', $Dish_name);

      $stmt->execute();      
      $id = $stmt->fetch();

      if ($id) {
        return $id['Name_ID'];
      } else {
        return 'NULL';
      }
    }

    static function createName(PDO $db, string $Dish_name) : void {
      $stmt = $db->prepare('INSERT INTO DishName (Dish_name) values (:Dish_name);');
      $stmt->bindParam(':Dish_name', $Dish_name);

      $stmt->execute();
    }
    
  }
?>
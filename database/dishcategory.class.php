<?php
  declare(strict_types = 1);

  class DishCategory {

    static function getCategories(PDO $db) : Array {
      $stmt = $db->prepare('SELECT * FROM DishCategory;');

      $stmt->execute();
      $categories = $stmt->fetchAll();
      
      return $categories;
    }

    static function getCategoryId(PDO $db, string $Category_name) : string {
      $stmt = $db->prepare('SELECT Category_id FROM DishCategory where Category_name = :Category_name;');
      $stmt->bindParam(':Category_name', $Category_name);

      $stmt->execute();      
      $id = $stmt->fetch();

      if ($id) {
        return $id['Category_id'];
      } else {
        return 'NULL';
      }
    }

    static function createCategory(PDO $db, string $Category_name) : void {
      $stmt = $db->prepare('INSERT INTO DishCategory (Category_name) values (:Category_name);');
      $stmt->bindParam(':Category_name', $Category_name);

      $stmt->execute();
    }
    
  }
?>
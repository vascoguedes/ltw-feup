<?php
  declare(strict_types = 1);

  class RestaurantLocation {
    static function getLocations(PDO $db) : Array {
        $stmt = $db->prepare('SELECT * FROM RestaurantLocation Order by Location_name;');
  
        $stmt->execute();
        $categories = $stmt->fetchAll();
        
        return $categories;
    }

    static function getLocationId(PDO $db, string $Location_name) : string {
      $stmt = $db->prepare('SELECT Location_id FROM RestaurantLocation where Location_name = :Location_name;');
      $stmt->bindParam(':Location_name', $Location_name);

      $stmt->execute();      
      $id = $stmt->fetch();

      if ($id) {
        return $id['Location_id'];
      } else {
        return 'NULL';
      }
    }

    static function createLocation(PDO $db, string $Location_name) : void {
      $stmt = $db->prepare('INSERT INTO RestaurantLocation (Location_name) values (:Location_name);');
      $stmt->bindParam(':Location_name', $Location_name);

      $stmt->execute();
    }
  }
?>
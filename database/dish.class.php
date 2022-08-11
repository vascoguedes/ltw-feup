<?php
  declare(strict_types = 1);

  class Dish {

    static function getDishesByRestaurantId(PDO $db, string $Rest_id, string $User_id) : Array {
      $stmt = $db->prepare('select * from (select Cart_state, DishName.Dish_name as Name, Category_name as Category, Price, ifnull(quantity, 0) as Quantity, Dish.Dish_id as Dish_id, Dish.Restaurant_id as Restaurant_id, UserFavoriteDishes.User_id as LIKE, Dish.Photo from Dish left join DishesInCart on Dish.dish_id = DishesInCart.Dish_id left join UserFavoriteDishes on UserFavoriteDishes.Dish_id = Dish.Dish_id and UserFavoriteDishes.User_id = :User_id left join ShoppingCart on ShoppingCart.Restaurant_id = :Rest_id and ShoppingCart.Cart_id = DishesInCart.Cart_id and ShoppingCart.Cart_state = 6 and ShoppingCart.User_id = :User_id left join DishName on Dish.Dish_name = DishName.Name_ID left join DishCategory on DishCategory.Category_id = Dish.Category_id where Dish.Restaurant_id = :Rest_id) as dados1 where dados1.cart_state = 6 or not (select count(*) from (select Cart_state, DishName.Dish_name as Name, Category_name as Category, Price, ifnull(quantity, 0) as Quantity, Dish.Dish_id as Dish_id, Dish.Restaurant_id as Restaurant_id from Dish left join DishesInCart on Dish.dish_id = DishesInCart.Dish_id left join ShoppingCart on ShoppingCart.Restaurant_id = :Rest_id and ShoppingCart.Cart_id = DishesInCart.Cart_id and ShoppingCart.Cart_state = 6 and ShoppingCart.User_id = :User_id left join DishName on Dish.Dish_name = DishName.Name_ID left join DishCategory on DishCategory.Category_id = Dish.Category_id where Dish.Restaurant_id = :Rest_id) as dados2 where dados2.cart_state = 6 and dados2.name = dados1.name) group by name order by category, LIKE DESC;');
      $stmt->bindParam(':User_id', $User_id);
      $stmt->bindParam(':Rest_id', $Rest_id);

      $stmt->execute();
      $dishes = $stmt->fetchAll();
      
      return $dishes;
    }

    static function createDish(PDO $db, string $Restaurant_id, string $Category_id, string $Dish_name, string $Price, string $Photo) : void {
      
      if ($Photo != '') {
        $sql = 'INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price, Photo) values (:Restaurant_id, :Category_id, :Dish_name, :Price, :Photo);';
      } else {
        $sql = 'INSERT INTO Dish (Restaurant_id, Category_id, Dish_name, Price) values (:Restaurant_id, :Category_id, :Dish_name, :Price);';
      }
      
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':Restaurant_id', $Restaurant_id);
      $stmt->bindParam(':Category_id', $Category_id);
      $stmt->bindParam(':Dish_name', $Dish_name);
      $stmt->bindParam(':Price', $Price);

      if ($Photo != '') {
        $stmt->bindParam(':Photo', $Photo);
      }      

      $stmt->execute();
    }

    static function searchDishes(PDO $db, string $search, string $rest_id, $id) : array {
      $query = 'SELECT DishName.Dish_name as Name, Dish.Dish_id, Price, Quantity, (UserFavoriteDishes.User_id is :id) as Liked, Dish.Restaurant_id, DishCategory.Category_name AS Category FROM Dish LEFT JOIN DishName ON DishName.Name_ID = Dish.Dish_name LEFT JOIN (SELECT ShoppingCart.User_id as User_ID, DishesInCart.Quantity AS Quantity, DishesInCart.Dish_id AS Dish_ID FROM ShoppingCart, DishesInCart WHERE DishesInCart.Cart_id = ShoppingCart.Cart_id and User_ID = :id and ShoppingCart.Cart_state = 6) AS Dishes ON Dishes.Dish_ID = Dish.Dish_id LEFT JOIN UserFavoriteDishes ON (UserFavoriteDishes.Dish_id = Dish.Dish_id AND UserFavoriteDishes.User_id = :id) LEFT JOIN DishCategory ON DishCategory.Category_id = Dish.Category_id LEFT JOIN Restaurant ON Restaurant.Restaurant_id = Dish.Restaurant_id WHERE Dish.Restaurant_id = :Restaurant_id ';
      
      if ($search != "" ) {
        $query = $query . "AND Name LIKE :Name ";
      }
      $query = $query . "GROUP BY DishName.Dish_name ORDER BY Category";

      $stmt = $db->prepare($query);
      if ($search != "") {
        $search = "$search%";
        $stmt->bindParam(':Name', $search);
      }
      $stmt->bindParam(':Restaurant_id', $rest_id);
      $stmt->bindParam(':id', $id);

      $stmt->execute();
      $dishes = $stmt->fetchAll();
      
      return $dishes;
    }
    
  }
?>
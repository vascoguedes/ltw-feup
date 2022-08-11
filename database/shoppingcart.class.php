<?php
  declare(strict_types = 1);

  class ShoppingCart {

    function numberActiveOrdersByRestaurantId($db, $Restaurant_id) {
      $stmt = $db->prepare('SELECT COUNT(*) as num FROM ShoppingCart where Restaurant_id = :Restaurant_id and Cart_state < 4');
      $stmt->bindParam(':Restaurant_id', $Restaurant_id);

      $stmt->execute();
      $num = $stmt->fetch();

      return $num;
    }

    function numberOpenCartsUserId($db, $User_id) {
        $stmt = $db->prepare('SELECT COUNT(*) as num FROM ShoppingCart where User_id = :User_id and Cart_state == 6');
        $stmt->bindParam(':User_id', $User_id);
  
        $stmt->execute();
        $num = $stmt->fetch();
  
        return $num;
    }

    function getShoppingCartsByUserId($db, $User_id) {
        $stmt = $db->prepare('SELECT ShoppingCart.Cart_id, rest_name as Restaurant, DishName.dish_name as Name, DishName.Name_ID, Quantity, Price, ShoppingCart.Restaurant_id as Restaurant_id FROM ShoppingCart left join Restaurant on ShoppingCart.Restaurant_id = Restaurant.Restaurant_id left join DishesInCart on ShoppingCart.Cart_id = DishesInCart.Cart_id left join Dish on Dish.Dish_id = DishesInCart.Dish_id left join DishName on Dish.Dish_name = DishName.Name_ID where User_id = :User_id and Cart_state == 6 order by Date_time');
        $stmt->bindParam(':User_id', $User_id);
  
        $stmt->execute();
        $items = $stmt->fetchAll();
  
        return $items;
    }

    function getShoppingCartById($db, $Id) {
      $stmt = $db->prepare('SELECT ShoppingCart.Cart_id, rest_name as Restaurant, DishName.dish_name as Name, Quantity, Price FROM ShoppingCart left join Restaurant on ShoppingCart.Restaurant_id = Restaurant.Restaurant_id left join DishesInCart on ShoppingCart.Cart_id = DishesInCart.Cart_id left join DishName on DishesInCart.Dish_id = DishName.Name_ID LEFT join Dish on Dish.Dish_id = DishesInCart.Dish_id where ShoppingCart.Cart_id = :Id order by Date_time');
      $stmt->bindParam(':Id', $Id);

      $stmt->execute();
      $items = $stmt->fetchAll();

      return $items;
    }

    function getShoppingCartIdByUserIdRestaurantId($db, $User_id, $Restaurant_id) {
      $stmt = $db->prepare('SELECT Cart_id AS ID FROM ShoppingCart WHERE Restaurant_id = :Restaurant_id AND User_id = :User_id AND Cart_state = 6');
      $stmt->bindParam(':User_id', $User_id);
      $stmt->bindParam(':Restaurant_id', $Restaurant_id);

      $stmt->execute();
      $id = $stmt->fetch();

      return $id;
    }

    function getMyOrdersByUserId($db, $User_id) {
      $stmt = $db->prepare('Select Restaurant.Restaurant_id as ID, Restaurant.Rest_name as Restaurant, Date_time as Date, ShoppingState.State_name as State, ShoppingCart.Cart_id, Review_id from ShoppingCart left join Restaurant on ShoppingCart.Restaurant_id = Restaurant.Restaurant_id left join ShoppingState on ShoppingState.State_id = ShoppingCart.Cart_state left join ReviewRestaurant on ReviewRestaurant.Review_id = ShoppingCart.Cart_id where user_id = :User_id and ShoppingCart.cart_state != 6 order by date;');
      $stmt->bindParam(':User_id', $User_id);

      $stmt->execute();
      $orders = $stmt->fetchAll();

      return $orders;
    }

    function getRestaurantOrdersByRestID($db, $Restaurant_id) {
      $stmt = $db->prepare('Select Restaurant.Restaurant_id as ID, Restaurant.Rest_name as Restaurant, Date_time as Date, ShoppingState.State_name as State, ShoppingCart.Cart_id, Review_id from ShoppingCart left join Restaurant on ShoppingCart.Restaurant_id = Restaurant.Restaurant_id left join ShoppingState on ShoppingState.State_id = ShoppingCart.Cart_state left join ReviewRestaurant on ReviewRestaurant.Review_id = ShoppingCart.Cart_id where Restaurant.Restaurant_id = :Restaurant_id and ShoppingCart.cart_state != 6 order by cart_state, date;');
      $stmt->bindParam(':Restaurant_id', $Restaurant_id);

      $stmt->execute();
      $orders = $stmt->fetchAll();

      return $orders;
    }

    function createShoppingCartIdByUserIdRestaurantId($db, $User_id, $Restaurant_id) {
      $stmt = $db->prepare('INSERT INTO ShoppingCart (Restaurant_id, User_id, Cart_state) values (:Restaurant_id, :User_id, 6);');
      $stmt->bindParam(':User_id', $User_id);
      $stmt->bindParam(':Restaurant_id', $Restaurant_id);

      $stmt->execute();
    }

    function checkIfExistsDishesInCart($db, $Cart_id, $Dish_id) {
      $stmt = $db->prepare('SELECT * FROM DishesInCart WHERE Cart_id = :Cart_id AND Dish_id = :Dish_id');
      $stmt->bindParam(':Cart_id', $Cart_id);
      $stmt->bindParam(':Dish_id', $Dish_id);

      $stmt->execute();
      $DishesInCart = $stmt->fetchAll();

      return $DishesInCart;
    }

    function editDishToShoppingCarts($User_id, $Restaurant_id, $Dish_id, $Value, $Operation) {  //NAO ESTA NADA BEM

      $db = getDatabaseConnection(); 
      $Cart_id = ShoppingCart::getShoppingCartIdByUserIdRestaurantId($db, $User_id, $Restaurant_id)['ID'];
      $return = 0;

      if (!$Cart_id) {
        ShoppingCart::createShoppingCartIdByUserIdRestaurantId($db, $User_id, $Restaurant_id)['ID'];
        $Cart_id = ShoppingCart::getShoppingCartIdByUserIdRestaurantId($db, $User_id, $Restaurant_id)['ID'];
        $return = 1;
      }

      if ($Value > 1 || ($Value > 0 && !$Operation)) {
        $stmt = $db->prepare('UPDATE DishesInCart SET Quantity = :Value WHERE Cart_id = :Cart_id and Dish_id = :Dish_id;');
        $stmt->bindParam(':Cart_id', $Cart_id);
        $stmt->bindParam(':Dish_id', $Dish_id);
        $stmt->bindParam(':Value', $Value);

        $stmt->execute();
        return 0;

      } else if ($Operation) {
        $stmt = $db->prepare('INSERT INTO DishesInCart (Cart_id, Dish_id, Quantity) values (:Cart_id, :Dish_id, 1);');
        $stmt->bindParam(':Cart_id', $Cart_id);
        $stmt->bindParam(':Dish_id', $Dish_id);

        $stmt->execute();
        return $return;

      } else {
        $stmt = $db->prepare('DELETE FROM DishesInCart WHERE Cart_id = :Cart_id and Dish_id = :Dish_id;');
        $stmt->bindParam(':Cart_id', $Cart_id);
        $stmt->bindParam(':Dish_id', $Dish_id);

        $stmt->execute();


        $stmt = $db->prepare('SELECT * FROM DishesInCart WHERE Cart_id = :Cart_id');
        $stmt->bindParam(':Cart_id', $Cart_id);

        $stmt->execute();
        $dishes = $stmt->fetchAll();

        if (count($dishes) == 0) {
          $stmt = $db->prepare('DELETE FROM ShoppingCart WHERE Cart_id = :Cart_id');
          $stmt->bindParam(':Cart_id', $Cart_id);

          $stmt->execute();
          return 1;
        } else {return 0;}
      }
    }

    function placeOrder($db, $Cart_id) {
      $stmt = $db->prepare('UPDATE ShoppingCart SET Cart_state = 1 WHERE Cart_id = :Cart_id');
      $stmt->bindParam(':Cart_id', $Cart_id);

      $stmt->execute();
    }


    function nextState($db, $Cart_id) {
      $stmt = $db->prepare('UPDATE ShoppingCart SET Cart_state = Cart_state + 1 WHERE Cart_id = :Cart_id');
      $stmt->bindParam(':Cart_id', $Cart_id);

      $stmt->execute();
    }

    function getState($db, $Cart_id) {
      $stmt = $db->prepare('Select State_name from ShoppingCart left join ShoppingState on ShoppingCart.Cart_state = ShoppingState.State_id where ShoppingCart.Cart_id = :Cart_id');
      $stmt->bindParam(':Cart_id', $Cart_id);
      

      $stmt->execute();
      $state = $stmt->fetch();
      return $state['State_name'];
    }

    function cancelOrder($db, $Cart_id) {
      $stmt = $db->prepare('UPDATE ShoppingCart SET Cart_state = 5 WHERE Cart_id = :Cart_id');
      $stmt->bindParam(':Cart_id', $Cart_id);
      
      $stmt->execute();
    }
  } 

?>

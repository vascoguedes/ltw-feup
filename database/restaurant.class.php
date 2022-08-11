<?php
  declare(strict_types = 1);

  require_once('restaurantcategory.class.php');
  require_once('restaurantlocation.class.php');

  class Restaurant {
    public string $Restaurant_id;
    public string $Rest_owner;
    public string $Rest_name;
    public string $Address;
    public string $Phone_number;
    public string $Category;

    public function __construct(string $Restaurant_id, string $Rest_owner, string $Rest_name, string $Address, string $Phone_number, string $Category)
    {
      $this->Restaurant_id = $Restaurant_id;
      $this->Rest_owner = $Rest_owner;
      $this->Rest_name = $Rest_name;
      $this->Address = $Address;
      $this->Phone_number = $Phone_number;
      $this->Category = $Category;
    }

    static function getRestaurants(PDO $db, $id) : Array {

      $stmt = $db->prepare('SELECT Restaurant.Restaurant_id, Restaurant.Picture, Rest_name, address, category_name, (UserFavoriteRestaurants.User_id is :id) as Liked, Average FROM Restaurant left join RestaurantCategory on Restaurant.Category = RestaurantCategory.Category_id left join UserFavoriteRestaurants on (Restaurant.Restaurant_id = UserFavoriteRestaurants.Restaurant_id AND UserFavoriteRestaurants.User_id = :id) left join (select restaurant_id, AVG(Rating) as Average from ReviewRestaurant left join ShoppingCart on ReviewRestaurant.Review_id = ShoppingCart.Cart_id group by restaurant_id) as Ratings on Ratings.restaurant_id = Restaurant.Restaurant_id where State != 3 order by Liked DESC;');

      $stmt->bindParam(':id', $id);

      $stmt->execute();
      $restaurants = $stmt->fetchAll();

      return $restaurants;
    }

    static function getRestaurantsFromUser(PDO $db, string $id) : Array {
      $stmt = $db->prepare('SELECT Rest_name, Restaurant_id FROM Restaurant where Rest_owner = :id and State != 3;');
      $stmt->bindParam(':id', $id);

      $stmt->execute();
      $restaurants = $stmt->fetchAll();
      
      return $restaurants;
    }
    
    static function getRestaurantsById(PDO $db, string $id) : Array {
      $stmt = $db->prepare('SELECT * FROM Restaurant  left join (select AVG(Rating) as Rating from ReviewRestaurant left join ShoppingCart on ReviewRestaurant.Review_id = ShoppingCart.Cart_id where ShoppingCart.Restaurant_id = :id group by restaurant_id) as Rating left join RestaurantCategory on Restaurant.Category = RestaurantCategory.Category_id left join RestaurantLocation on Restaurant.Location = RestaurantLocation.Location_id where Restaurant_id = :id;');
      $stmt->bindParam(':id', $id);

      $stmt->execute();
      $restaurant = $stmt->fetch();
    
      return $restaurant;
    }

    static function getDishesFromRestaurant(PDO $db, string $id) : Array {
      $stmt = $db->prepare('SELECT DishName.Dish_name as Name, Category_name as Category, Price FROM Dish left join DishCategory on Dish.Category_id = DishCategory.Category_id left join DishName on Dish.Dish_name = DishName.Name_ID where Restaurant_id = :id;');
      $stmt->bindParam(':id', $id);

      $stmt->execute();
      $dishes = $stmt->fetchAll();
      
      return $dishes;
    }

    static function createRestaurant(PDO $db, string $Rest_owner, string $Rest_name, string $Location, string $Address, string $Phone_number, string $Category) : void {
      $stmt = $db->prepare('INSERT INTO Restaurant (Rest_owner, Rest_name, Location, Address, [phone number], Category, State) values (:Rest_owner, :Rest_name, :Location, :Address, :Phone_number, :Category, 1);');
      $stmt->bindParam(':Rest_owner', $Rest_owner);
      $stmt->bindParam(':Rest_name', $Rest_name);
      $stmt->bindParam(':Location', $Location);
      $stmt->bindParam(':Address', $Address);
      $stmt->bindParam(':Phone_number', $Phone_number);
      $stmt->bindParam(':Category', $Category);

      $stmt->execute();
    }

    static function updateRestaurantInfo(PDO $db, string $Restaurant_id, string $Restaurant_name, string $Location, string $Category, string $Address, string $Phone_number, string $Picture) : void {
      $sql = 'UPDATE Restaurant Set Rest_name = :Rest_name, Location = :Location, Category =:Category, Address = :Address, [phone number] = :Phone_number';
      if ($Picture != '') {
        $sql =  $sql . ', Picture = :Picture';
      }
      $sql = $sql . ' Where Restaurant_id = :Restaurant_id;';
      
      $stmt = $db->prepare($sql);
      
      if ($Picture != '') {
        $stmt->bindParam(':Picture', $Picture);
      }
      $stmt->bindParam(':Restaurant_id', $Restaurant_id);
      $stmt->bindParam(':Rest_name', $Restaurant_name);
      $stmt->bindParam(':Address', $Address);
      $stmt->bindParam(':Phone_number', $Phone_number);
      $stmt->bindParam(':Location', $Location);
      $stmt->bindParam(':Category', $Category);


      $stmt->execute();

    }

    static function openRestaurant(PDO $db, string $Restaurant_id) : void {
      $sql = 'UPDATE Restaurant Set State = 1 where Restaurant_id = :Restaurant_id';      
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':Restaurant_id', $Restaurant_id);
      $stmt->execute();
    }

    static function closeRestaurant(PDO $db, string $Restaurant_id) : void {
      $sql = 'UPDATE Restaurant Set State = 2 where Restaurant_id = :Restaurant_id';      
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':Restaurant_id', $Restaurant_id);
      $stmt->execute();
    }

    static function deleteRestaurant(PDO $db, string $Restaurant_id) : void {
      $sql = 'UPDATE Restaurant Set State = 3 where Restaurant_id = :Restaurant_id';      
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':Restaurant_id', $Restaurant_id);
      $stmt->execute();
    }

    static function getStateByRestaurantId(PDO $db, string $Restaurant_id) : string {
      $sql = 'Select State from Restaurant where Restaurant_id = :Restaurant_id';      
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':Restaurant_id', $Restaurant_id);
      $stmt->execute();

      $state = $stmt->fetch();
      
      return $state['State'];
    }
    
    static function searchRestaurants(PDO $db, string $search, string $option1, string $option2, int $option3, $id) : array {
      $query = 'SELECT Restaurant.Restaurant_id, Rest_name, Address, RestaurantCategory.Category_name AS Category, Average, (UserFavoriteRestaurants.User_id is :id) as Liked, Dish_name FROM Restaurant left join (select restaurant_id, AVG(Rating) as Average from ReviewRestaurant left join ShoppingCart on ReviewRestaurant.Review_id = ShoppingCart.Cart_id group by restaurant_id) as Ratings on Ratings.restaurant_id = Restaurant.Restaurant_id left join UserFavoriteRestaurants on (Restaurant.Restaurant_id = UserFavoriteRestaurants.Restaurant_id AND UserFavoriteRestaurants.User_id = :id) left join (SELECT restaurant_id, DishName.Dish_Name AS Dish_name FROM DishName LEFT JOIN Dish ON Dish.Dish_Name = DishName.Name_ID) as Dishes ON Dishes.restaurant_id = Restaurant.Restaurant_id LEFT JOIN RestaurantCategory ON Restaurant.Category = RestaurantCategory.Category_id WHERE State != 3 ';

      $locationID = RestaurantLocation::getLocationId($db, $option1);
      $categoryID = RestaurantCategory::getCategoryId($db, $option2);

      if ($search != "" ) {
        $query = $query . "AND (Rest_name LIKE :Rest_name OR Dish_name LIKE :Dish_name) ";
      }
      if($option1 != "" && $option1 != "All"){
        $query = $query . "AND Location = :Location ";
      }

      if($option2 != "" && $option2 != "All"){
        $query = $query . "AND Category = :Category ";
      }

      if($option3 != "" && $option3 != "All"){
        $query = $query . "AND Average >= :Average ";
      }
      $query = $query . "GROUP BY Restaurant.Restaurant_id ORDER BY Liked DESC";

      $stmt = $db->prepare($query);
      if ($search != "") {
        $search = "$search%";
        $stmt->bindParam(':Rest_name', $search);
        $stmt->bindParam(':Dish_name', $search);
      }
      //$stmt->bindParam(':LIMIT', $count);
      if($option1 != "" && $option1 != "All"){
        $stmt->bindParam(':Location', $locationID);
      }
      if($option2 != "" && $option2 != "All"){
        $stmt->bindParam(':Category', $categoryID);
      }
      if($option3 != "" && $option3 != "All"){
        $stmt->bindParam(':Average', $option3, PDO::PARAM_INT);
      }
      $stmt->bindParam(':id', $id);
      
      $stmt->execute();
  
      //$Restaurants = array();

      $restaurants = $stmt->fetchAll();

      return $restaurants;
    }
  }
?>
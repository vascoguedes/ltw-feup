<?php declare(strict_types = 1); ?>


<?php function drawProfileForm($user) { ?>
  <section id="profileform">

    <img class='profileImage' src= <?php if ($user['Picture']) {echo 'uploads/' . $user['Picture'];} else {echo 'pages/images/avatar_default.png';}?>/>

    <section id="profilename">
      <form  action="/actions/action_edit_profile.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        <h2> 
          <input class='profileFormInput' disabled type='text' name='Username' value=<?php echo $user['Username'] ?> ?>
          <?php
            if ($_GET['id'] == $_SESSION['id']) 
              echo "<button class='editProfile' type='reset' onclick='editInformation()'><i class='fa-solid fa-pen'></i></button>"
          ?>
        </h2>      
      
        <input class='profileFormInput' disabled type='text' name='Email' value=<?php echo $user['Email'] ?> /> <br>
        <input class='profileFormInput' disabled type='text' name='Address' value="<?php echo $user['Address'] ?>" /> <br>
        <input class='profileFormInput' disabled type='number' min='900000000' max='999999999' name='Phone_number' value=<?php echo $user['Phone_number'] ?> /> <br>
        <input class='profileFormInputHidden' hidden type='date' name='Birthdate' value=<?php echo $user['Birthdate'] ?> /> <br>
        <input class='profileFormInputHidden' hidden type='password' name='Password' placeholder="New password..." value='' /> <br>
        <input type="file" class='profileFormInputHidden' hidden name="Picture" value=''> <br>
        <button type='submit' id='profileFormSave'>Save</button>
      </form>
    </section>

  </section>

  <script>
    function editInformation() {
      var inputs = document.querySelectorAll('input[class=profileFormInput]');
      inputs.forEach((input) => input.disabled = !input.disabled);

      var inputs = document.querySelectorAll('input[class=profileFormInputHidden]');
      inputs.forEach((input) => input.hidden = !input.hidden);

      var save = document.getElementById("profileFormSave");
      save.classList.toggle("show");
    }
  </script>
<?php } ?>

<?php function drawAddRestaurantForm($db) { ?>

  <popup id='addRestaurantPopup'>

    <container>
      <h1>Add a new restaurant</h1>
      <button onclick="addRestaurantPopUp()"><i class="fa-solid fa-x"></i></button>
    </container>

    <form  action="/actions/action_create_restaurant.php"  method="get">
      <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
      <input type="text" required placeholder="Restaurant name" name="Rest_name" /> <br>

      <input list="restaurant-locations" required name="Location" placeholder="Restaurant location...">
      <datalist id="restaurant-locations">
        <?php
            $locations = RestaurantLocation::getLocations($db);

            foreach($locations as $location) {
                echo "<option " . "'>" . $location['Location_name'] . "</option>";
            }                
        ?>        
      </datalist><br>
      
      <input type="text" required placeholder="Adress" name="Address" /> <br>
      <input type="text" required placeholder="Phone number" name="Phone_number" /> <br>

      <input list="restaurant-categories" required name="Category" placeholder="Restaurant category...">
      <datalist id="restaurant-categories">
        <?php
            $categories = RestaurantCategory::getCategories($db);

            foreach($categories as $category) {
                echo "<option " . "'>" . $category['Category_name'] . "</option>";
            }                
        ?>        
      </datalist><br>

      <button>Criar</button>

    </form>
  </popup>

  <script>
    function addRestaurantPopUp() {
      var popup = document.getElementById("addRestaurantPopup");
      popup.classList.toggle("show");
    }
  </script>

<?php } ?>

<?php function drawRestaurantBar($data) { ?>
  <container>
    <restaurant_bar class='container'>
      <h3><?php echo "<a href='index.php?page=restaurant&id=" . $data[1] . "'>" . $data[0] . "</a>"?></h3>

      <a href='/actions/action_delete_restaurant.php?csfr=<?=$_SESSION['csrf']?>&id=<?php echo $data[1]?>'><i class="fa-solid fa-xmark emoji_button"></i></a>
    </restaurant_bar>
  </container>
<?php } ?>


<?php function drawRestaurantBars($db, $userId) { ?>

  <?php

    $restaurants = Restaurant::getRestaurantsFromUser($db, $userId);

    if (count($restaurants) == 0) {
      drawNoItemsBar('restaurants');
    }

    foreach( $restaurants as $restaurant) {
      drawRestaurantBar([$restaurant["Rest_name"], $restaurant["Restaurant_id"]]);
    }

  ?>

<?php } ?>


<?php function drawAddRestaurantReviewForm($db) { ?>

  <popup id='addReviewPopup'>

    <container>
      <h1>Add a review</h1>
      <button onclick="addRestaurantReviewPopUp()"><i class="fa-solid fa-x"></i></button>
    </container>

    <form  action="/actions/action_create_restaurant_review.php"  method="get">
      <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">      
      <input type="text" required placeholder="Your opinion" name="opinion" /> <br>  
      <input class="rating" required type="range" min="0" max="5" name="rating" /> <br>
      <label for="rating">Rating (between 0 and 5):</label> <br>
      <input hidden id="shoppingCartIdReview" name="id"/>

      <button>Criar</button>

    </form>
  </popup>

  <script>
    function addRestaurantReviewPopUp(id) {
      var id_input = document.getElementById("shoppingCartIdReview");
      id_input.value = id;
      var popup = document.getElementById("addReviewPopup");
      popup.classList.toggle("show");
    }
  </script>

<?php } ?>


<?php function drawReceiptPopUp($db) { ?>
  <popup id='receiptPopup'>
  </popup>

  <script>
    async function receiptPopup(id) {
      var popup = document.getElementById("receiptPopup");
      popup.classList.toggle("show");
      popup.innerHTML = "<container> <h1>LOADING...</h1> </container>";
      const response = await fetch('/api/api_shoppingcart.php?csrf=<?=$_SESSION['csrf']?>&id=' + id);
      const items = await response.json();

      popup.innerHTML = "<container> <h1>Receipt</h1> <button onclick='receiptPopup()'><i class='fa-solid fa-x'></i></button> </container>";

      total = 0;
      items.map((item) => {
        popup.innerHTML += "<item class='container'> <p class='left'>" + item['Name'] + "</p> <p class='right'>" + item['Price'] + "€ x " + item['Quantity'] + " = " + item['Price'] * item['Quantity'] + "€ </p></item>";
        total += item['Price'] * item['Quantity'];
      })
      popup.innerHTML += '<item class="container total"><p class="left">Total: </p> <strong class="right">' + total + "€" + '</strong> </item>';
    }
  </script>
<?php } ?>


<?php function drawOrderBar($data) { ?>
  <container>
    <order_bar>
      <main_part class='container'>
        <h3><?php echo "<a href='index.php?page=restaurant&id=" . $data[5] . "'>" . $data[0] . "</a>"?></h3>
        <order_state><strong><?php echo $data[1]?></strong></order_state>
        <button class="showMoreOrderInfo" id= <?php echo $data[3]; ?>><i id= <?php echo "showMoreInfoButton" . $data[3]; ?> class="fa-solid fa-angle-down"></i></button>
      </main_part>

      <order_details id= <?php echo "order_details" . $data[3]; ?> class='hidden margin'>
        <?php if(!$data[4] && $data[1] == 'Received') { echo "<button onclick='addRestaurantReviewPopUp(" . $data[3] . ")'>Add review<i class='fa-solid fa-envelope-open-text'></i></button>";} ?>
        <date><?php echo $data[2]?></date>
        <button onclick="receiptPopup(<?php echo $data[3]; ?>)"><i class="fa-solid fa-receipt"></i></button>
      </order_details>
    </order_bar>
  </container>

<?php } ?>


<?php function drawOrdersBars($db, $User_id) { ?>

  <?php
    $orders = ShoppingCart::getMyOrdersByUserId($db, $User_id);

    if (!$orders) {
      drawNoItemsBar('orders');
    } else {
      foreach($orders as $order) {
        drawOrderBar([$order['Restaurant'], $order['State'], $order['Date'], $order['Cart_id'], $order['Review_id'], $order['ID']]);
      }
    }
  ?>

  <script type="text/javascript">
    const info_buttons = document.getElementsByClassName("showMoreOrderInfo")

    for (let button of info_buttons) {
        button.addEventListener('click', async function(event){
          
          const moreInfoButton = document.getElementById("showMoreInfoButton" + button.id)
          moreInfoButton.classList.toggle("fa-angle-up");

          const order_details = document.getElementById("order_details" + button.id)
          order_details.classList.toggle("show");
          order_details.classList.toggle("container");
          order_details.classList.toggle("margin");
      })
    }
  </script>

<?php } ?>
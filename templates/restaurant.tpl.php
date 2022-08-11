<?php declare(strict_types = 1); ?>


<?php function drawRestaurantForm($restaurant) { ?>
  <section id="profileform">

    <div class='rest_image_open_close'>
      <img class='profileImage' src= <?php if ($restaurant['Picture']) {echo 'uploads/' . $restaurant['Picture'];} else {echo '/pages/images/restaurant.jpg';}?>/>
      <?php
        if($restaurant['State'] == 1) {
          echo "<open_close id='open_close_button'>Open</open_close>";
        } else {
          echo "<open_close id='open_close_button'>Close</open_close>";
        }          
      ?>      
    </div>
  
    <section id="profilename">
      <form  action= <?php echo "/actions/action_edit_restaurant.php?id=" . $_GET['id'] ?>  method="post" enctype="multipart/form-data">
        <h2> 
          <input class='profileFormInput' disabled type='text' name='Rest_name' value="<?php echo $restaurant['Rest_name'] ?>" ?>
          <?php
            if ($restaurant['Rest_owner'] == $_SESSION['id']) 
              echo "<button class='editProfile' type='reset' onclick='editInformation()'><i class='fa-solid fa-pen'></i></button>"
          ?>
          <br>

          <?php
            for ($i = 0; $i < 5; $i++) {
              if ($i < $restaurant['Rating']) {
                echo "<i class='fa-solid fa-star'></i>";
              } else {
                echo "<i class='fa-regular fa-star'></i>";
              }              
            }          
          ?>
        </h2>
      
        <input class='profileFormInput' disabled type='text' name='Location' value="<?php echo $restaurant['Location_name'] ?>" /> <br>
        <input class='profileFormInput' disabled type='text' name='Address' value="<?php echo $restaurant['Address'] ?>" /> <br>
        <input class='profileFormInput' disabled type='text' name='Category' value="<?php echo $restaurant['Category_name'] ?>" /> <br>
        <input class='profileFormInput' disabled type='tel' name='Phone_number' value=<?php echo $restaurant['phone number'] ?> /> <br>
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
    <?php
      if ($restaurant['Rest_owner'] == $_SESSION['id']) {
    ?>
      const open_close = document.getElementById("open_close_button")
      open_close.addEventListener("click", async function() {
        if (open_close.innerHTML == 'Open') {
          const response = await fetch('../api/api_open_close_restaurant.php?csrf=<?=$_SESSION['csrf']?>&Action=Close&Restaurant_id=' + <?php echo $_GET['id']; ?>)
          open_close.innerHTML = 'Close'
        } else {
          const response = await fetch('../api/api_open_close_restaurant.php?csrf=<?=$_SESSION['csrf']?>&Action=Open&Restaurant_id=' + <?php echo $_GET['id']; ?>)
          open_close.innerHTML = 'Open'
        }
      })
    <?php }?>
    
  </script>
<?php } ?>

<?php function drawDishesMenuBar($owner, $rest_id) { ?>
  <dishesMenuBar class='container'>

    <addDishBar class="container">
      <h3>Dishes</h3>
      <?php if($owner) echo "<button onclick='addDishPopUp()'><i class='fa-solid fa-plus'></i></button>"; ?>
    </addDishBar>

    <select id='orderBy'>
      <option value="Order by" disabled>Order by</option>
      <option selected >Category</option>
    </select>

    <input type="text" id='searchDishesInput' placeholder="Dish name, ..."/>
    <i class="fa-solid fa-magnifying-glass"></i>

  </dishesMenuBar>

  <script>
    const searchDishInput = document.querySelector('#searchDishesInput')
    var rest_id = "<?php echo $rest_id; ?>";

    async function AsyncFunc(input, rest_id){
        const response = await fetch('../api/api_dishsearch.php?csrf=<?=$_SESSION['csrf']?>&search=' + input + '&rest_id=' + rest_id)
        const dishes = await response.json()  
        
        const section = document.querySelector('#restaurantDishes')
        section.innerHTML = ''

        var count = 0;
        for (const data of dishes) {
          if (count == 0 || data.Category != previous_data.Category) {
              const container = document.createElement('container');
              container.id = 'CategoryBar';
              const h2 = document.createElement('h2');
              h2.innerHTML = data.Category;
              container.appendChild(h2);
              section.appendChild(container);
            }
            const container1 = document.createElement('container');
            const dishBar = document.createElement('dishBar');
            dishBar.className = 'container';
            const container2 = document.createElement('container');
            const p1 = document.createElement('p');
            p1.innerHTML = data.Name + ' (' + data.Price + '€) ';
            container2.appendChild(p1);
            const i1 = document.createElement('i');
            var session = '<?php echo $_SESSION['logedin'];?>';
            if (session){
                if(data.Liked == "1"){
                    i1.onclick = () => likeDish(i1, data.Dish_id);
                    i1.className = "fa-solid fa-star";
                }
                else{
                    i1.onclick = () => likeDish(i1, data.Dish_id);
                    i1.className = "fa-regular fa-star";
                }
            }
            container2.appendChild(i1);
            dishBar.appendChild(container2);
            const i2 = document.createElement('i');
            const p2 = document.createElement('p');
            var rem_id = 'dishRem' + data.Dish_id;
            var id = 'dishQuantity' + data.Dish_id;

            if (session){
                if(data.Quantity != "0"){
                    i2.className = "fa-solid fa-minus removeDishToCart";
                    i2.id = rem_id;
                    i2.Restaurant_id = data.Restaurant_id;
                    i2.Dish_id = data.Dish_id;
                    p2.class = "quantity";
                    p2.id = id;
                    p2.innerHTML = data.Quantity;
                }
                else{
                    i2.className = "fa-solid fa-minus removeDishToCart hidden";
                    i2.id = rem_id;
                    i2.Restaurant_id = data.Restaurant_id;
                    i2.Dish_id = data.Dish_id;
                    p2.class = "quantity";
                    p2.id = id;
                }
            }
            dishBar.appendChild(i2);
            dishBar.appendChild(p2);
            const i3 = document.createElement('i');
            var session = '<?php echo $_SESSION['id'];?>';
            var client = '<?php echo $_GET['id'];?>';
            if(session != client){
                i3.className = "fa-solid fa-plus addDishToCart";
                i3.Restaurant_id = data.Restaurant_id;
                i3.Dish_id = data.Dish_id;
            }
            dishBar.appendChild(i3);
            container1.appendChild(dishBar);
            section.appendChild(container1);
            count++;
            var previous_data = data;
        }

        const add_buttons = document.getElementsByClassName("addDishToCart")
        
        for (let button of add_buttons) {
          button.addEventListener('click', async function(event){
            const quantity = document.getElementById("dishQuantity" + button.Dish_id)
            rest_id = button.Restaurant_id;
            dish_id = button.Dish_id;

            if (parseInt(quantity.innerText) > 0) {
              value = parseInt(quantity.innerText) + 1
              quantity.innerText = value
              const response = await fetch('../api/api_dish.php?csrf=<?=$_SESSION['csrf']?>&rest_id=' + rest_id + "&dish_id=" + dish_id + "&value=" + value + "&operation=1");
            } else {
              const response = await fetch('../api/api_dish.php?csrf=<?=$_SESSION['csrf']?>&rest_id=' + rest_id + "&dish_id=" + dish_id + "&value=1&operation=1");
              const op = await response.json()
              if (op) {
                const numOpenCarts = document.getElementById("numOpenCarts")
                numOpenCarts.innerText = parseInt(numOpenCarts.innerText) + 1
              }
              quantity.innerText = 1;
              const remove = document.getElementById("dishRem" + button.Dish_id)
              remove.classList.remove('hidden')
            }        
          })
          
        }

        const rem_buttons = document.getElementsByClassName("removeDishToCart")

        for (let button of rem_buttons) {
          button.addEventListener('click', async function(event){
            const quantity = document.getElementById("dishQuantity" + button.Dish_id)
            rest_id = button.Restaurant_id;
            dish_id = button.Dish_id;
            
            if (parseInt(quantity.innerText) > 1) {
              value = parseInt(quantity.innerText) - 1
              quantity.innerText = value
              const response = await fetch('../api/api_dish.php?csrf=<?=$_SESSION['csrf']?>&rest_id=' + rest_id + "&dish_id=" + dish_id + "&value=" + value + "&operation=0");
            } else {
              const remove = document.getElementById("dishRem" + button.Dish_id)

              remove.classList.add('hidden')
              quantity.innerText = ''
              const response = await fetch('../api/api_dish.php?csrf=<?=$_SESSION['csrf']?>&rest_id=' + rest_id + "&dish_id=" + dish_id + "&value=0&operation=0");
              const op = await response.json()
              if (op) {
                const numOpenCarts = document.getElementById("numOpenCarts")
                numOpenCarts.innerText = parseInt(numOpenCarts.innerText) -1
              }
            }        
          })
        }
    }

    if (searchDishInput) {

        searchDishInput.addEventListener('input', () => AsyncFunc(searchDishInput.value, rest_id));
      
    }
  </script>

<?php } ?>


<?php function drawCategoryBar($Category) { ?>

  <container id='CategoryBar'>
    <h2><?php echo $Category; ?></h2>
  </container>
<?php } ?>


<?php function drawOrdersSection($db, $rest_id) { ?>

  <ordersSection class='container'>
    <p> <?php echo ShoppingCart::numberActiveOrdersByRestaurantId($db, $rest_id)['num']; ?> active orders</p>
    <a href= <?php echo 'index.php?page=orders&id=' . $rest_id; ?>><i class="fa-solid fa-up-right-from-square emoji_button"></i></a>
  </ordersSection>

<?php } ?>


<?php function drawComment($review, $Rest_owner) { ?>

  <comment class='container'>
    <p><?php echo $review['Comment'] ?> <br> by: <strong> <?php echo $review['Username'] ?> </strong></p>

    <?php
      if (!$review['Answer']) {
        if ($_SESSION['id'] == $Rest_owner) {
          echo "<answer id='AnswerComment" . $review['Review_id'] . "'><input id='inputAnswerComment" . $review['Review_id'] . "' type='text' placeholder='Answer comment' /><i id='" . $review['Review_id'] . "' class='fa-solid fa-chevron-right answerReviewInput'></i></answer>";
        }
      } else {
        echo "<answer> <strong>Restaurant answer:</strong> <br>" . $review['Answer'] . "</answer>";
      }
    ?>

  </comment>

<?php } ?>


<?php function drawComments($db, $Rest_id, $Rest_owner) { ?>

  <?php

    $reviews = ReviewRestaurant::getAllReviewsByRestaurantID($db, $Rest_id);
    foreach ($reviews as $review) {
      drawComment($review, $Rest_owner);
    }
    
  ?>

  <script type="text/javascript">
      const reviews = document.getElementsByClassName("answerReviewInput")
      
      for(let review of reviews) {
        review.addEventListener('click', async function(){

          const inputAnswerComment = document.getElementById("inputAnswerComment" + review.id);

          if (inputAnswerComment.value) {
            const response = await fetch('../api/api_answer_review.php?csrf=<?=$_SESSION['csrf']?>&Answer_text=' + inputAnswerComment.value + "&Answer_id=" + review.id);
            const AnswerComment = document.getElementById("AnswerComment" + review.id);
            AnswerComment.innerHTML = "<strong>Restaurant answer:</strong> <br>" + inputAnswerComment.value + "</answer>";
          }            
        })
      }
      
  </script>

<?php } ?>


<?php function drawDishBar($Dish, $client) { ?>

  <container>
    <dishBar>

      <top_information class='container'>
        <container>
          <button <?php echo "onclick=open_close_image('" . $Dish['Photo'] . "')"; ?>><?php echo $Dish['Name'] . " (" . $Dish['Price'] . "€) "; ?></button>
          
          <?php 
            if($client) {
              if($Dish['LIKE']) {
                echo "<i class='fa-solid fa-star' onclick='likeDish(this, " . $Dish['Dish_id'] . ")'></i>";
              } else {
                echo "<i class='fa-regular fa-star' onclick='likeDish(this, " . $Dish['Dish_id'] . ")'></i>";
              }
            }
          ?>
          
        </container>

        <?php 
          $rem_id = 'dishRem' . $Dish['Dish_id'];
          $id = 'dishQuantity' . $Dish['Dish_id'];

          if( $Dish['Quantity'] > 0 and $Dish['Cart_state'] == 6) {
            echo "<i class='fa-solid fa-minus removeDishToCart' id = " . $rem_id . " Restaurant_id = " . $Dish['Restaurant_id'] ." Dish_id = " . $Dish['Dish_id'] . "></i>";
            echo "<p class='quantity' id= ".$id." >" . $Dish['Quantity'] . "</p>";
          }
          else {
            echo "<i class='fa-solid fa-minus removeDishToCart hidden' id = " . $rem_id . " Restaurant_id = " . $Dish['Restaurant_id'] ." Dish_id = " . $Dish['Dish_id'] . "></i>";
            echo "<p class='quantity' id= ".$id." > </p>";
          }

          if ($client) {
            echo "<i class='fa-solid fa-plus addDishToCart' Restaurant_id = " . $Dish['Restaurant_id'] . " Dish_id = " . $Dish['Dish_id'] . " ></i>";
          }
        
        ?>
      </top_information>
      
      <?php
        if ($Dish['Photo'])
          echo "<img hidden class='dishPhoto' id='" . $Dish['Photo'] . "' src='../uploads/" . $Dish['Photo'] . "'>";
      ?>      
      
    </dishBar>
  </container>

  <script>
    async function likeDish(like, dish_id) {
        if (like.className == "fa-solid fa-star") {
            like.className = "fa-regular fa-star";
            const response = await fetch('/actions/action_dislike_dish.php?csfr=<?=$_SESSION['csrf']?>&Dish_id=' + dish_id);
        } else {
            like.className = "fa-solid fa-star";
            const response = await fetch('/actions/action_like_dish.php?csfr=<?=$_SESSION['csrf']?>&Dish_id=' + dish_id);
        }
    }

    async function open_close_image(image) {
      var img = document.getElementById(image);     
      img.hidden = !img.hidden 
    }
  </script>
<?php } ?>


<?php function drawAddDishForm($db) { ?>

  <popup id='addDishPopup'>

    <container>
      <h1>Add a new dish</h1>
      <button onclick="addDishPopUp()"><i class="fa-solid fa-x addDishPopUpButton"></i></button>
    </container>

    <form  action="/actions/action_create_dish.php"  method="post" enctype="multipart/form-data">
      <input type="text" required placeholder="Name" name="Dish_name" /> <br>

      <input required list="restaurant-categories" name="Category" placeholder="Dish category...">
      <datalist id="restaurant-categories">
        <?php
            $categories = DishCategory::getCategories($db);

            foreach($categories as $category) {
                echo "<option " . "'>" . $category['Category_name'] . "</option>";
            }                
        ?>        
      </datalist><br>
      <input hidden name="Rest_id" value=<?php echo $_GET['id']; ?> />
      
      <input required type="number" min="0" placeholder="Price" name="Price" /> <br>
      <input type="file" name="Picture" /> <br>

      <button>Criar</button>

    </form>
  </popup>

  <script>
    function addDishPopUp() {
      var popup = document.getElementById("addDishPopup");
      popup.classList.toggle("show");
    }
  </script>

<?php } ?>



<?php function drawRestaurantDishes($db, $rest_id, $owner_id) { ?>
  <?php

    $dishes = Dish::getDishesByRestaurantId($db, $rest_id, $_SESSION['id']);?>
    

    <section id=restaurantDishes>
      <?php
        if (count($dishes) == 0) {
          drawNoItemsBar('dishes'); 
        } else {

          for ($i = 0; $i < count($dishes); $i++) {
            
            if ($i == 0 || $dishes[$i]['Category'] != $dishes[$i - 1]['Category']) {
              drawCategoryBar($dishes[$i]['Category']);
            }

            drawDishBar($dishes[$i], $owner_id != $_SESSION['id']);
          }

        }
      ?>
    </section>

  <script type="text/javascript">
    const add_buttons = document.getElementsByClassName("addDishToCart")

    for (let button of add_buttons) {
      button.addEventListener('click', async function(event){
        const quantity = document.getElementById("dishQuantity" + button.attributes.dish_id.value)
        rest_id = button.attributes.restaurant_id.value;
        dish_id = button.attributes.dish_id.value;

        if (parseInt(quantity.innerText) > 0) {
          value = parseInt(quantity.innerText) + 1
          quantity.innerText = value
          const response = await fetch('../api/api_dish.php?csrf=<?=$_SESSION['csrf']?>&rest_id=' + rest_id + "&dish_id=" + dish_id + "&value=" + value + "&operation=1");
        } else {
          const response = await fetch('../api/api_dish.php?csrf=<?=$_SESSION['csrf']?>&rest_id=' + rest_id + "&dish_id=" + dish_id + "&value=1&operation=1");
          const op = await response.json()
          if (op) {
            const numOpenCarts = document.getElementById("numOpenCarts")
            numOpenCarts.innerText = parseInt(numOpenCarts.innerText) + 1
          }
          quantity.innerText = 1;
          const remove = document.getElementById("dishRem" + button.attributes.dish_id.value)
          remove.classList.remove('hidden')
        }        
      })
    }


    const rem_buttons = document.getElementsByClassName("removeDishToCart")

    for (let button of rem_buttons) {
      button.addEventListener('click', async function(event){
        const quantity = document.getElementById("dishQuantity" + button.attributes.dish_id.value)
        rest_id = button.attributes.restaurant_id.value;
        dish_id = button.attributes.dish_id.value;
        
        if (parseInt(quantity.innerText) > 1) {
          value = parseInt(quantity.innerText) - 1
          quantity.innerText = value
          const response = await fetch('../api/api_dish.php?csrf=<?=$_SESSION['csrf']?>&rest_id=' + rest_id + "&dish_id=" + dish_id + "&value=" + value + "&operation=0");
        } else {
          const remove = document.getElementById("dishRem" + button.attributes.dish_id.value)

          remove.classList.add('hidden')
          quantity.innerText = ''
          const response = await fetch('../api/api_dish.php?csrf=<?=$_SESSION['csrf']?>&rest_id=' + rest_id + "&dish_id=" + dish_id + "&value=0&operation=0");
          const op = await response.json()
          if (op) {
            const numOpenCarts = document.getElementById("numOpenCarts")
            numOpenCarts.innerText = parseInt(numOpenCarts.innerText) -1
          }
        }        
      })
    }
    
  </script>

<?php } ?>
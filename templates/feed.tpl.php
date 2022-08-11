<?php declare(strict_types = 1); ?>

<?php function drawListOfRestaurantsMenu($db) { ?>
  <section id="feedMenu" class='container'>
    <div>
        <h1>List of restaurants</h1>

        <menu>

            <select id='searchRestaurantsByRating'>
                <option value="" disabled selected hidden>Review score</option>

                <?php
                    $categories = RestaurantCategory::getCategories($db);
                    
                    echo "<option value='All'>All Ratings</option>";
                    echo "<option value='1'>>=1</option>";
                    echo "<option value='2'>>=2</option>";
                    echo "<option value='3'>>=3</option>";
                    echo "<option value='4'>>=4</option>";
                    echo "<option value='5'>=5</option>";          
                ?>

            </select>


            <select id='searchRestaurantsByCategory'>
                <option value="" disabled selected hidden>Categories</option>

                <?php
                    $categories = RestaurantCategory::getCategories($db);
                    
                    echo "<option value='All'>All Categories</option>";
                    foreach($categories as $category) {
                        echo "<option value='" . $category['Category_name'] . "'>" . $category['Category_name'] . "</option>";
                    }                
                ?>
                
            </select>


            <select id='searchRestaurantsByLocation'>
                <option value="" disabled selected hidden>Locations</option>

                <?php
                    $categories = RestaurantLocation::getLocations($db);
                    
                    echo "<option value='All'>All Locations</option>";
                    foreach($categories as $category) {
                        echo "<option value='" . $category['Location_name'] . "'>" . $category['Location_name'] . "</option>";
                    }                
                ?>
                
            </select>

            <input type="text" id='searchRestaurantsInput' placeholder="Restaurant name, ..."/>
            <i class="fa-solid fa-magnifying-glass"></i>


        </menu>
    </div>
  </section>

  <script>
    const searchRestaurantInput = document.querySelector('#searchRestaurantsInput')
    const searchRestaurantLocation = document.querySelector('#searchRestaurantsByLocation')
    const searchRestaurantCategory = document.querySelector('#searchRestaurantsByCategory')
    const searchRestaurantRating = document.querySelector('#searchRestaurantsByRating')

    async function AsyncFunc(input, option1, option2, option3){
        const response = await fetch('../api/api_restaurants.php?csrf=<?=$_SESSION['csrf']?>&search=' + input + '&option1=' + option1 + '&option2=' + option2 + '&option3=' + option3)
        const restaurants = await response.json()     
        
        const section = document.querySelector('#feedRestaurants')
        section.innerHTML = ''

        for (const data of restaurants) {
            const container = document.createElement('container');
            const restaurantCard = document.createElement('restaurantCard');
            const img1 = document.createElement('img');
            img1.className = "restaurant-photo";
            img1.alt="Photo of the restaurant";
            img1.src = "pages/images/restaurant.jpg";
            const information = document.createElement('information');
            const container2 = document.createElement('container');
            const a = document.createElement('a');
            a.href = "index.php?page=restaurant&id=" + data.Restaurant_id;
            const h3 = document.createElement('h3');
            h3.innerHTML = data.Rest_name;
            const i2 = document.createElement('i');
            var session = '<?php echo $_SESSION['logedin'];?>';
            if (session){
                if(data.Liked == "1"){
                    i2.onclick = () => likeRestaurant(i2, data.Restaurant_id);
                    i2.className = "fa-solid fa-star";
                }
                else{
                    i2.onclick = () => likeRestaurant(i2, data.Restaurant_id);
                    i2.className = "fa-regular fa-star";
                }
            }
            a.appendChild(h3);
            container2.appendChild(a);
            container2.appendChild(i2);
            const p1 = document.createElement('p');
            p1.innerHTML += '<strong>Address: </strong>' + data.Address;
            information.appendChild(container2);
            information.appendChild(p1);
            const p2 = document.createElement('p');
            p2.innerHTML += '<strong>Type of food: </strong>' + data.Category;
            information.appendChild(p2);
            const p3 = document.createElement('p');
            if(data.Average == null){
                p3.innerHTML = '<strong>Review score: </strong>' + 'Review Score not available';
            }
            else{
                p3.innerHTML = '<strong>Review score: </strong>' + data.Average + '/5';
            }
            information.appendChild(p3);
            restaurantCard.appendChild(img1);
            restaurantCard.appendChild(information);
            const img2 = document.createElement('img');
            img2.className = "restaurant-logo";
            img2.alt="Logo of the restaurant";
            img2.src = "pages/images/logo.png";
            restaurantCard.appendChild(img2);
            container.appendChild(restaurantCard);
            section.appendChild(container);
        }
    }

    if (searchRestaurantInput || searchRestaurantLocation || searchRestaurantCategory || searchRestaurantRating) {

        searchRestaurantInput.addEventListener('input', () => AsyncFunc(searchRestaurantInput.value, searchRestaurantLocation.value, searchRestaurantCategory.value, searchRestaurantRating.value))

        searchRestaurantLocation.addEventListener('change', () => AsyncFunc(searchRestaurantInput.value, searchRestaurantLocation.value, searchRestaurantCategory.value, searchRestaurantRating.value))

        searchRestaurantCategory.addEventListener('change', () => AsyncFunc(searchRestaurantInput.value, searchRestaurantLocation.value, searchRestaurantCategory.value, searchRestaurantRating.value))
        
        searchRestaurantRating.addEventListener('change', () => AsyncFunc(searchRestaurantInput.value, searchRestaurantLocation.value, searchRestaurantCategory.value, searchRestaurantRating.value))
    }
  </script>
<?php } ?>


<?php function drawRestaurantCard($data) { ?>
  <container>
    <restaurantCard>

        <img class="restaurant-photo" alt="Photo of the restaurant" src= <?php if ($data[6]) {echo 'uploads/' . $data[6];} else {echo 'pages/images/restaurant.jpg';}?> />
        <information>

            <container><a href='index.php?page=restaurant&id=<?php echo $data[5]?>'><h3><?php echo $data[0] . "</h3></a>";
            
            if($_SESSION['logedin']){
                if ($data[4]) {
                    echo "<i onclick='likeRestaurant(this, " . $data[5] . ")' class='fa-solid fa-star'></i>";
                } else {
                    echo "<i onclick='likeRestaurant(this, " . $data[5] . ")' class='fa-regular fa-star'></i>";
                }
            }

            ?></container>
            
            <p><strong>Address: </strong> <?php echo $data[1]?></p>
            <p><strong>Type of food: </strong> <?php echo $data[2]?></p>
            <?php
                if ($data[3]) {
                    echo "<p><strong>Review score: </strong>" . $data[3] . " /5</p>";
                }
                else{
                    echo "<p><strong>Review score: </strong>Review Score not available</p>";
                }
            ?>            

        </information>

        <img class="restaurant-logo" alt="Logo of the restaurant" src="pages/images/logo.png" />
        
    </restaurantCard>
  </container>
  <script>
    async function likeRestaurant(like, rest_id) {        
        if (like.className == "fa-solid fa-star") {
            like.className = "fa-regular fa-star";
            const response = await fetch('/actions/action_dislike_restaurant.php?csfr=<?=$_SESSION['csrf']?>&rest_id=' + rest_id);
        } else {
            like.className = "fa-solid fa-star";
            const response = await fetch('/actions/action_like_restaurant.php?csfr=<?=$_SESSION['csrf']?>&rest_id=' + rest_id);
        }
    }
  </script>
<?php } ?>

<?php function drawRestaurantCards($db) { ?>
  
    <?php 

        $restaurants = Restaurant::getRestaurants($db, $_SESSION['id']);?>
        <section id=feedRestaurants>
            <?php
                foreach ($restaurants as $restaurant) {
                    drawRestaurantCard([$restaurant['Rest_name'], $restaurant['Address'], $restaurant['Category_name'], $restaurant['Average'], $restaurant['Liked'], $restaurant['Restaurant_id'], $restaurant['Picture']]);
                }
            ?>
        </section>

<?php } ?>
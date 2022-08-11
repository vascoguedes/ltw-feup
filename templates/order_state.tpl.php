<?php function drawOrderPlacedForm() { ?>
    <container id="ordersform">
        <order_sucessful_bar>
          <p class='container'>
            <order_sucessful_ellipse class = "fa-solid fa-order-placed"> 
                  <i class="fa-solid fa-check"></i>
              </order_sucessful_ellipse>
          </p>
          <p class='container'> 
            <h2>
                <p>ORDER PLACED</p>
            </h2>
            <h3> 
              <u><a href= <?php echo "index.php?page=profile&id=" . $_SESSION["id"] ?>>MY ORDERS</a></u>
            </h3>
          </p>
        </order_sucessful_bar>
    </container>
<?php } ?>

<?php function drawOrderFailedForm() { ?>
    <container id="ordersfailedform">
        <order_unsucessful_bar>
          <p class='container'>
            <order_unsucessful_ellipse class = "fa-solid fa-order-placed"> 
                  <i class="fa-solid fa-times"></i>
              </order_unsucessful_ellipse>
          </p>
          <p class='container'> 
            <h2>
                <p>WE ARE SORRY</p>
                <h4>THE RESTAURANT CAN'T TAKE YOUR ORDER RIGHT NOW</h4>
            </h2>
            <h3> 
              <u><a href="index.php?page=feed">Other restaurants</a></u>
            </h3>
          </p>
        </order_unsucessful_bar>
    </container>
<?php } ?>
<?php function drawRestaurantOrderBar($data) { ?>
  <container>
    <order_bar>
      <main_part class='container'>
        <h3><?php echo "#" . $data[6]; ?></h3>
        <order_state class='order_state' id=<?php echo $data[3];?> ><strong><?php echo $data[1];?></strong></order_state>
        <button class="showMoreRestaurantOrderInfo" id= <?php echo $data[3]; ?>><i id= <?php echo "showMoreRestaurantInfoButton" . $data[3]; ?> class="fa-solid fa-angle-down"></i></button>
      </main_part>

      <order_details id= <?php echo "order_details" . $data[3]; ?> class='hidden margin'>
        <?php
        if (!($data[1] == 'Delivered' || $data[1] == 'Canceled'))
          echo"<a href='/actions/action_cancel_order.php?csrf=". $_SESSION['csrf'] . "&id=" . $_GET['id'] . "&cart_id=" . $data[3] . "'>Cancel order</a>"; ?>
        <date><?php echo $data[2]?></date>
        <button onclick="receiptPopup(<?php echo $data[3]; ?>)"><i class="fa-solid fa-receipt"></i></button>
      </order_details>
    </order_bar>
  </container>

<?php } ?>


<?php function drawRestaurantOrdersBars($db, $id) { ?>

    <?php
        $orders = ShoppingCart::getRestaurantOrdersByRestID($db, $id);

        drawSectionBar(["Active orders"]);

        if (!$orders) {
            drawNoItemsBar('orders');
            drawSectionBar(["Past orders"]);
            drawNoItemsBar('orders');
        } else {
            for ($i = 0; $i < count($orders); $i++) {
                if ($orders[$i]['State'] == 'Delivered' || $orders[$i]['State'] == 'Canceled') {
                  drawSectionBar(["Past orders"]);
                  for ($j = $i; $j < count($orders); $j++) {
                    drawRestaurantOrderBar([$orders[$j]['Restaurant'], $orders[$j]['State'], $orders[$j]['Date'], $orders[$j]['Cart_id'], $orders[$j]['Review_id'], $orders[$j]['ID'], $j]);
                  }
                  break;
                }
                drawRestaurantOrderBar([$orders[$i]['Restaurant'], $orders[$i]['State'], $orders[$i]['Date'], $orders[$i]['Cart_id'], $orders[$i]['Review_id'], $orders[$i]['ID'], $i]);
                if ($i == count($orders) - 1) {
                  drawSectionBar(["Past orders"]);
                  drawNoItemsBar('orders');
                }
            }
        }
    ?>

    <script type="text/javascript">
        const info_buttons = document.getElementsByClassName("showMoreRestaurantOrderInfo")

        for (let button of info_buttons) {
            button.addEventListener('click', async function(event){
                
                const moreInfoButton = document.getElementById("showMoreRestaurantInfoButton" + button.id)
                moreInfoButton.classList.toggle("fa-angle-up");

                const order_details = document.getElementById("order_details" + button.id)
                order_details.classList.toggle("show");
                order_details.classList.toggle("container");
                order_details.classList.toggle("margin");
            })
        }

        const order_states = document.getElementsByClassName("order_state")

        for (let order_state of order_states) {
            order_state.addEventListener('click', async function(event){
                
              const response = await fetch('/api/api_order_nextState.php?csrf=<?=$_SESSION['csrf']?>&cart_id=' + order_state.id);
              const newState = await response.json();
              order_state.innerHTML = "<strong>" + newState + "</strong>";
            })
        }

    </script>

<?php } ?>


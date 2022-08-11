<?php function drawPageTitle() { ?>
    
    <container>
        <shopping_cart_bar class="container">
            <h2>SHOPPING CART <i class="fa-solid fa-cart-shopping"></i></h2>
        </shopping_cart_bar>
    </container>
    
<?php } ?>


<?php function drawShoppingCart($data) { ?>
    <container>
        <shopping_cart>
            <h2 class='container'><?php echo($data[0])?></h2>

            <?php
                $total = 0;
                
                foreach ($data[1] as $product) {
                    echo('<item class="container"> <p class="left">');
                    echo($product[0]);
                    echo('</p> <p class="right">');
                    echo($product[2] . "€ x " . $product[1] . " = " . $product[2] * $product[1] . "€");
                    $total += $product[2] * $product[1];
                    echo('</p> </item>');
                }

                echo('<item class="container total"><p class="left">Total: </p> <strong class="right">');
                echo($total . "€");
                echo('</strong></item>');
            ?>

            <a href= <?php echo '/actions/action_place_order.php?csfr=' . $_SESSION['csrf'] . '&id=' . $data[2] . '&rest_id=' . $data[3]; ?>>Order<i class="fa-solid fa-arrow-right"></i></a>
        </shopping_cart>
    </container>
    
<?php } ?>


<?php function drawShoppingCarts($db, $id) { ?>
    
    <?php 

        $items = ShoppingCart::getShoppingCartsByUserId($db, $id);

        if (count($items) > 0) {

            $cartItems = [[$items[0]['Name'], $items[0]['Quantity'], $items[0]['Price']]];
            for($i = 1 ; $i < count($items); $i++) {

                if($items[$i]['Restaurant'] ==  $items[$i - 1]['Restaurant']) {
                    array_push($cartItems, [$items[$i]['Name'], $items[$i]['Quantity'], $items[$i]['Price']]);
                } else {
                    drawShoppingCart([$items[$i - 1]['Restaurant'], $cartItems, $items[$i - 1]['Cart_id'], $items[$i - 1]['Restaurant_id']]);
                    $cartItems = [[$items[$i]['Name'], $items[$i]['Quantity'], $items[$i]['Price']]];
                }
            }

            drawShoppingCart([$items[$i-1]['Restaurant'], $cartItems, $items[$i - 1]['Cart_id'], $items[$i - 1]['Restaurant_id']]);
        }
    ?>
    
<?php } ?>
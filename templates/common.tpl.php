<?php declare(strict_types = 1); ?>

<?php function drawLandPageNavbar() { ?>
  <nav class="topnav" >
    <a class="title" href="index.php?page=landing_page">THE MENU</a>

    <container>
      <a href="index.php?page=feed">Restaurants List</a>
    </container>

    <container class="LoginLogout">
      <a href="index.php?page=login">Sign In</a>
      <a href="index.php?page=register">Start Free</a>
    </container>
  </nav>
<?php } ?>

<?php function drawAuthNavbar($Username, $numOpenCarts) { ?>
  <nav class="topnav">
    <a class="title" href="index.php?page=feed">THE MENU</a>

    <container class="UserInformation">
      <a href=<?php echo 'index.php?page=profile&id=' . $_SESSION['id']?> > <?php echo $Username; ?></a>
      <a href="index.php?page=shopping_cart"><i class="fa-solid fa-cart-shopping emoji_button" id='numOpenCarts'> <?php echo $numOpenCarts['num']; ?> </i></a>
      <a href="/actions/action_logout.php?csrf=<?=$_SESSION['csrf']?>"><i class="fa-solid fa-arrow-right-from-bracket emoji_button"></i></a>
    </container>
  </nav>
<?php } ?>

<?php function drawNavbar($Username, $numOpenCarts) { ?>
  <?php
    ($_SESSION['logedin'] ?
    drawAuthNavbar($Username, $numOpenCarts) : drawLandPageNavbar())
  ?>
<?php } ?>



<?php function drawHeader($Username, $numOpenCarts) { ?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>The Menu</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="pages/css/style.css">
    <link rel="stylesheet" href="pages/css/layout.css">
    <link rel="stylesheet" href="pages/css/responsiveness.css">
    <script src="https://kit.fontawesome.com/37bef53143.js" crossorigin="anonymous"></script>
  </head>
  <body>

    <header>
      <?php drawNavbar($Username, $numOpenCarts)?>
    </header>
  
    <main>
<?php } ?>


<?php function drawFooter() { ?>
    </main>

    <footer>
      <table class='container'>
        <tr>
          <th>THE MENU</th>
          <th>Restaurants</th>
        </tr>

        <tr>
          <td rowspan="2">Finding the best restaurant <br> has never been easier</td>
          <td><a href='index.php?page=feed'>List</a></td>
        </tr>
      </table>

      <p>Copyright @ THE MENU 2022. All Rights Reserved.</p>
    </footer>
  </body>
</html>
<?php } ?>

<?php function drawLoginForm() { ?>
  <form action="/actions/action_login.php" method="post" class="login">
    <input type="email" name="email" placeholder="email">
    <input type="password" name="password" placeholder="password">
    <a href="index.php?page=register">Register</a>
    <button type="submit">Login</button>
  </form>
<?php } ?>

<?php function drawLogoutForm(string $name) { ?>
  <form action="/actions/action_logout.php" method="post" class="logout">
    <a href="index.php?page=profile"><?=$name?></a>
    <button type="submit">Logout</button>
  </form>
<?php } ?>


<?php function drawSectionBar($data) { ?>
  <container>
    <section_bar class='container'>
      <h3><?php echo $data[0]?></h3>

      <button onclick=<?php echo $data[1]?>><i class="fa-solid fa-plus emoji_button" <?php if (!$data[1]){?>style="display:none"<?php } ?>></i></button>
    </section_bar>
  </container>
<?php } ?>


<?php function drawNoItemsBar($word) { ?>
  <container>
    <noitems_bar class='container'>
      <h3>You don’t have any <?php echo $word?> registed...</h3>
    </noitems_bar>
  </container>
<?php } ?>
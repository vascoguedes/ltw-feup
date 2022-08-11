
<?php function drawCover() { ?>

  <section id="cover">
    <div>
      <h1>Finding the best restaurant has never been easier</h1>
      <p>Join us today and discover new restaurants!</p>

      <benefits>
        <i class="fa-solid fa-circle-check"></i>
        <label>Free register</label>
        <i class="fa-solid fa-circle-check"></i>
        <label>Great service</label>
      </benefits>
    </div>

    <img src='pages/images/cover.jpg' alt='decorative picture of a restaurant menu' />
  </section>
<?php } ?>


<?php function drawAffiliatedRestaurants() { ?>

  <section id="affiliatedRestaurants" class='container'>
    <div>
      <h3>Over 20+ restaurants already registed</h3>

      <logos>
        <img src='pages/images/logo.png' alt='restaurant logo' />
        <img src='pages/images/logo.png' alt='restaurant logo' />
        <img src='pages/images/logo.png' alt='restaurant logo' />
        <img src='pages/images/logo.png' alt='restaurant logo' />
        <img src='pages/images/logo.png' alt='restaurant logo' />
        <img src='pages/images/logo.png' alt='restaurant logo' />
        <img src='pages/images/logo.png' alt='restaurant logo' />
        <img src='pages/images/logo.png' alt='restaurant logo' />
        <img src='pages/images/logo.png' alt='restaurant logo' />
      </logos>
    </div>
  </section>
<?php } ?>

<?php function drawPlatformBenefits() { ?>

<section id="platformBenefits" class="container">
  <div>
    <h2>We help your business grow faster.</h2>
    <h3>Join us today and start selling to a brand new market!</h3>

    <benefits>
        <card>
          <i class="fa-solid fa-arrow-up-right-dots"></i>
          <p class='title'>Promote your restaurant</p>
          <p>Show your restaurant to <br> a brand new audience.</p>
        </card>

        <card>
          <i class="fa-solid fa-list-check"></i>
          <p class='title'>Receive orders</p>
          <p>Receive orders from your <br> new clients</p>
        </card>
      
      
    </benefits>

    <a href="index.php?page=register">Sign up today</a>
  </div>
</section>
<?php } ?>
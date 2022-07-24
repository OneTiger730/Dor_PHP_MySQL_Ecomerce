<?php

session_start();

if (!isset($_SESSION['logged_in'])) {
  $nav ='includes/nav.php';
}
else {
  $nav ='includes/navconnected.php';
  $idsess = $_SESSION['id'];
}


require 'includes/header.php';
require $nav; ?>

<div class="container-fluid home" id="top">
  <div class="container search">
    <nav class="animated slideInUp wow">
      <div class="nav-wrapper">
        <form method="GET" action="search.php">
          <div class="input-field">
            <input id="search" class="searching" type="search" name='searched' required>
            <label for="search"><i class="material-icons">search</i></label>
            <i class="material-icons">close</i>
          </div>

          <div class="center-align">
            <button type="submit" name="search" class="blue waves-light miaw waves-effect btn hide">Search</button>
          </div>
        </form>
      </div>
    </nav>
  </div>
</div>

<div class="container most">
  <div class="row">
    <?php

      include 'db.php';

      $queryfirst = "SELECT

        product.id as 'id',
        product.name as 'name',
        product.price as 'price',
        product.thumbnail as 'thumbnail',
        SUM(command.quantity) as 'total',
        command.statut,
        command.id_produit
        FROM product, command
        WHERE product.id = command.id_produit AND command.statut = 'paid'
        GROUP BY product.id
        ORDER BY SUM(command.quantity) DESC LIMIT 9";

      $resultfirst = $connection->query($queryfirst);

      if ($resultfirst->num_rows > 0) {
        // output data of each row
        while($rowfirst = $resultfirst->fetch_assoc()) {
          $id_best = $rowfirst['id'];
          $name_best = $rowfirst['name'];
          $price_best = $rowfirst['price'];
          $thumbnail_best = $rowfirst['thumbnail'];
          $totalsold = $rowfirst['total'];
    ?>

    <div class="col s12 m4">
      <div class="card hoverable animated slideInUp wow">
        <div class="card-image">
          <a href="product.php?id=<?= $id_best;  ?>"><img src="products/<?= $thumbnail_best; ?>"></a>
          <span class="card-title red-text"><?= $name_best; ?></span>
          <a href="product.php?id=<?= $id_best; ?>" class="btn-floating red halfway-fab waves-effect waves-light right"><i class="material-icons">add</i></a>
        </div>
          <div class="card-content">
            <div class="container">
              <div class="row">
                <div class="col s6">
                  <p class="white-text"><i class="left fa fa-dollar"></i> <?= $price_best; ?></p>
                </div>
                <div class="col s6">
                  <p class="white-text"><i class="left fa fa-shopping-basket"></i> <?= $totalsold; ?></p>
                </div>
              </div>
            </div>

          </div>

        </div>
      </div>
      <?php }} ?>


    </div>
  </div>

  <div class="container-fluid center-align categories">
    <a href="#category" class="button-rounded btn-large waves-effect waves-light">Categories</a>
    <div class="container" id="category">
      <div class="row">
        <?php

          //get categories
          $querycategory = "SELECT id, name, icon FROM category";
          $total = $connection->query($querycategory);
          if ($total->num_rows > 0) {
            // output data of each row
            while($rowcategory = $total->fetch_assoc()) {
              $id_category = $rowcategory['id'];
              $name_category = $rowcategory['name'];
              $icon_category = $rowcategory['icon'];
        ?>

        <div class="col s12 m4">
          <div class="card hoverable animated slideInUp wow">
            <div class="card-image">
              <a href="category.php?id=<?= $id_category; ?>"><img src="src/img/<?= $icon_category; ?>.png" alt=""></a>
              <span class="card-title black-text"><?= $name_category; ?></span>
            </div>
          </div>
        </div>

        <?php }} ?>
      </div>
    </div>
  </div>


  <div class="container-fluid about" id="about">
    <div class="container">
      <div class="row">
        <div class="col s12 m6">
          <div class="card animated slideInUp wow">
            <div class="card-image">
              <!-- <img src="src/img/about.jpg" alt=""> -->
              <div id="map"></div>
            </div>
          </div>
        </div>

        <div class="col s12 m6">
          <h3 class="animated slideInUp wow">About Us</h3>
          <div class="divider animated slideInUp wow"></div>
          <p class="animated slideInUp wow">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
            sed do eiusmodtempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
            nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
            deserunt mollit anim id est laborum.
          </p>
        </div>
      </div>
    </div>
  </div>

  <div class="container contact" id="contact">
    <div class="row">
      <!-- <form class="col s12 animated slideInUp wow">
        <div class="row">
          <div class="input-field col s12 m6">
            <i class="material-icons prefix">account_circle</i>
            <input id="icon_prefix" type="text" class="validate">
            <label for="icon_prefix">Full Name</label>
          </div>
          <div class="input-field col s12 m6">
            <i class="material-icons prefix">email</i>
            <input id="email" type="email" class="validate">
            <label for="email" data-error="wrong" data-success="right">Email</label>
          </div>



          <div class="input-field col s12 ">
            <i class="material-icons prefix">message</i>
            <textarea id="icon_prefix2" class="materialize-textarea" type="text" name="message" rows="8" style="resize: vertical;min-height: 16rem;" required></textarea>
            <label for="icon_prefix2">Your message</label>
          </div>

          <div class="center-align">
            <button type="submit" name="contact" class="button-rounded btn-large waves-effect waves-light">Submit</button>
          </div>
        </div>
      </form> -->
      <form action="https://postmail.invotes.com/send" method="post" id="email_form" class="col s12 animated slideInUp wow">
        <h3 class="animated slideInUp wow">Contact Us</h3>
        <div class="row">
            <div class="input-field col s12 m6">
                <i class="material-icons prefix">account_circle</i>
                <input id="icon_prefix" name="subject" type="text" class="validate">
                <label for="icon_prefix">Subject</label>
            </div>
            <div class="input-field col s12 m6">
                <i class="material-icons prefix">email</i>
                <input id="email" name="reply_to" type="email" class="validate">
                <label for="email" data-error="wrong" data-success="right">Email</label>
            </div>
            <div class="input-field col s12 ">
                <i class="material-icons prefix">message</i>
                <textarea id="icon_prefix2" class="materialize-textarea" type="text" name="text" rows="4"" style=" resize: vertical;min-height: 8rem;" required></textarea>
                <label for="icon_prefix2">Your message</label>
            </div>
            <!-- Go to https://postmail.invotes.com/ to get an access token -->
            <input type="hidden" name="access_token" value="" />
            <input type="hidden" name="success_url" value="." />
            <input type="hidden" name="error_url" value=".?err=1" />
            <div class="center-align">
                <button id="submit_form" type="submit" name="contact" value="Send" class="button-rounded btn-large waves-effect waves-light">Submit</button>
            </div>
            <p>Powered by <a href="https://postmail.invotes.com" target="_blank">PostMail</a></p>
        </div>
      </form>
    </div>
  </div>

  <?php
    require 'includes/secondfooter.php';
    require 'includes/footer.php'; 
  ?>  

  <script>
    var submitButton = document.getElementById("submit_form");
    var form = document.getElementById("email_form");
    form.addEventListener("submit", function(e) {
        setTimeout(function() {
            submitButton.value = "Sending...";
            submitButton.disabled = true;
        }, 1);
    });
  </script>
  <script
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkuGJruqd9MlTlr48ArHKbPIGoO4inzcs&callback=initMap&v=weekly"

    defer
  ></script>
<div class="jumbotron_mini" id="hero_img"  style="padding-top: 0px;margin-bottom: 0px;">
  <?php
    $this->load->view('template/navigation.php');
  ?>
  <div class="Jumbotron_container">
    <h1>Thank you for your order!</h1> 
  </div>
</div>
<div class="row contact_description">
  <h1>Your order is confirmed. Have a great time</h1>  
  <br>
  <div>
    <h3>Thank you for choosing Truck & Trailer Equipment</h3>
    <p><?= $about['aboutDescription']?></p>
    <ul>
      <li><i class="fa fa-bullseye" aria-hidden="true"></i>&nbsp;&nbsp;<?= $about['bullet1']?></li>
      <li><i class="fa fa-truck" aria-hidden="true"></i>&nbsp;&nbsp;<?= $about['bullet2']?></li>
      <li><i class="fa fa-fast-forward" aria-hidden="true"></i></i>&nbsp;&nbsp;<?= $about['bullet3']?></li>
    </ul>  
  </div>
</div>
<div class="row contact_location" style="color: #252362;background-color: #efefef;">
  <h1>Our Locations</h1>
  <ul class="clearfix">
    <li>
      <article>
        <img src="/assets/img/about/<?= $location['firstImage']?>">
        <h3><?= $location['firstHeader']?></h3>
        <p class=""><?= $location['firstDescription']?></p>
        <ul class="bullet_point clearfix">
          <li>
            <p>
              <i class="fa fa-home" aria-hidden="true"></i> 
              <?= $location['firstbullet1']?>
            </p>
          </li>
          <li>
            <p>
              <i class="fa fa-check" aria-hidden="true"></i> 
              <?= $location['firstbullet2']?>
            </p>
          </li>
        </ul>
      </article>
    </li>
    <li>
      <article>
        <img src="/assets/img/about/<?= $location['secondImage']?>">
        <h3><?= $location['secondHeader']?></h3>
        <p class=""><?= $location['secondDescription']?></p>
        <ul class="bullet_point clearfix">
          <li>
            <p>
              <i class="fa fa-home" aria-hidden="true"></i> 
              <?= $location['secondbullet1']?>
            </p>
          </li>
          <li>
            <p>
              <i class="fa fa-check" aria-hidden="true"></i> 
              <?= $location['secondbullet2']?>
            </p>
          </li>
        </ul>
      </article>
    </li>
    <li>
      <article>
        <img src="/assets/img/about/<?= $location['deliveryImage']?>">
        <h3><?= $location['deliveryHeader']?></h3>
        <p class=""><?= $location['deliveryDescription']?></p>
      </article>
    </li>
</div>
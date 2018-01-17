<div class="jumbotron_mini" id="hero_img"  style="padding-top: 0px;margin-bottom: 0px;">
  <?php
    $this->load->view('template/navigation.php');
  ?>
  <div class="Jumbotron_container">
    <h1>Truck & Trailer Equipment</h1> 
    <p>No. 1 for makes of truck and trailer parts</p> 
  </div>
</div>

<section class="row one_side home-offers">
  <a href="<?php echo site_url()."offers_page" ?>" >
    <h1>Special Offers</h1>
  </a>
  <ul class="clearfix">
    <?php
      foreach ($offers as $item) {
    ?>
        <li class="partproduct home-offers--list" id="part_<?= $item['id'] ?>">
          <a href="part/<?= $item['slug'] ?>/<?= $item['pnumber'] ?>"  style="color:white;">
            <div class="home-offers--list--image" style="background-image:url(<?= site_url()?>inc/img/parts/l/<?= $item['img'] ?>);">
            </div>
          </a>
          <div class="text-left padding-05 clearfix">  
            <h4 class="ptitle"><?= $item['title'] ?></h4>
            <strong  class="pnumber"><?= $item['pnumber'] ?></strong>
            <p>
              <?= $item['type'] ?>
              <a href="#" data-toggle="tooltip" title="RECYCLED: Used parts refurbished, 
FACTOR: Parts directly from the aftermarket manufacturers,
OEM: Genuine original equipment manufacturer" 
                data-placement="right">
                <i class="fa fa-info-circle" aria-hidden="true"></i>
              </a>
            </p>
            <p class="text-center">
              <?php if( isset($item['offer']) ): ?>
                <span class="c-tertiary line-through"> 
                  £<?= number_format($item['price'],2) ?>
                </span>    
                <span class=" c-tertiary"> 
                  &nbsp;&nbsp;£<?= number_format($item['offer'],2) ?>
                </span>
              <?php else: ?>
                <span class="c-tertiary"> 
                  £<?= number_format($item['price'],2) ?>
                </span>    
              <?php endif ?>
            </p>
          </div>
          <div class="home-offers--list--action" style="" class="clearfix" >
            <a href="part/<?= $item['slug'] ?>/<?= $item['pnumber'] ?>"  style="color:white;">
              <span class="home-offers--list--action--link" style="">
                <i class="fa fa-external-link" aria-hidden="true"></i>
              </span>    
            </a>
            <form class="cart" role="form" style="margin:0;padding: 0;height: 100%">
              <span  class="home-offers--list--action--quantity" style="">
                <input type="text" name="qty" value="1" class="quantity form-control" style="">
              </span>    
              <span class="home-offers--list--action--button" style="">
                <input type="submit" name="my-add-button" value="Add" id="addButton_<?=$item['id']?>" style='' class=" btn-ghost-full" onclick="addedCart(this.id)">
              </span>    
            </form>
          </div>
        </li>  
    <?php
      }
    ?>
  </ul>
  <a href="<?php echo site_url()."offers_page" ?>" class='btn-ghost cta'>
    more offers
  </a>
  <a class="btn-ghost-full" href="<?php echo site_url()."checkout/cart" ?>">
    Go To Checkout
  </a>
</section>  

<div class="row two_side">
  <section class="home-manufacturer">
    <a href="<?php echo site_url()."vehicles" ?>" >
      <h1>Manufacturer</h1>
    </a>
    <ul class="clearfix ">
      <?php
        foreach ($manufacturers as $manufacturer){
      ?>
          <li class="home-manufacturer--list">
            <a href="trucks/<?= $manufacturer['name'] ?>">
              <img class="home-manufacturer--img" src="assets/img/manufacturer/<?= $manufacturer['image'] ?>" alt="<?=$manufacturer['name']?>">
              <?=$manufacturer['name']?> 
            </a>
          </li>
      <?php
        }
      ?>
    </ul>
    <a href="<?php echo site_url()."vehicles" ?>" class='btn-ghost cta'>
      see more
    </a>
  </section>
  <section class="home-category">
    <a href="<?php echo site_url()."categories" ?>" >
      <h1>Categories</h1>
    </a>
    
    <ul class="clearfix">
      <?php
        foreach ($categories as $category){
      ?>
          <li class="home-category--list">
            <a href="categories/<?= $category['addr'] ?>">
              <img src="assets/img/category/<?= $category['img'] ?>" alt="<?=$category['name']?>">
              <?=ucfirst($category['name'])?> 
            </a>
          </li>
      <?php
        }
      ?>
    </ul>
    <a href="<?php echo site_url()."categories" ?>" class='btn-ghost cta'>
      see more
    </a>
  </section>
</div>





<section class="row one_side home-featured">
  <a href="<?php echo site_url()."featured_page" ?>" >
    <h1>Featured</h1>
  </a>
  <ul class="clearfix">
    <?php
      foreach ($featured as $item) {
    ?>
        <li class="partproduct home-featured--list" id="part_<?= $item['id'] ?>">
          <a href="part/<?= $item['slug'] ?>/<?= $item['pnumber'] ?>"  style="color:white;">
            <div class="home-featured--list--image" style="background-image:url(<?= site_url()?>inc/img/parts/l/<?= $item['img'] ?>);">
            </div>
          </a>
          <div class="text-left padding-05 clearfix">  
            <h4 class="ptitle"><?= $item['title'] ?></h4>
            <strong  class="pnumber"><?= $item['pnumber'] ?></strong>
            <p>
              <?= $item['type'] ?>
              <a href="#" data-toggle="tooltip" title="RECYCLED: Used parts refurbished, 
FACTOR: Parts directly from the aftermarket manufacturers,
OEM: Genuine original equipment manufacturer" 
                data-placement="right">
                <i class="fa fa-info-circle" aria-hidden="true"></i>
              </a>
            </p>
            <p class="text-center">
              <?php if( isset($item['offer']) ): ?>
                <span class="c-tertiary line-through"> 
                  £<?= number_format($item['price'],2) ?>
                </span>    
                <span class=" c-tertiary"> 
                  &nbsp;&nbsp;£<?= number_format($item['offer'],2) ?>
                </span>
              <?php else: ?>
                <span class="c-tertiary"> 
                  £<?= number_format($item['price'],2) ?>
                </span>    
              <?php endif ?>
            </p>
          </div>
          <div class="home-featured--list--action" style="" class="clearfix" >
            <a href="part/<?= $item['slug'] ?>/<?= $item['pnumber'] ?>"  style="color:white;">
              <span class="home-featured--list--action--link" style="">
                <i class="fa fa-external-link" aria-hidden="true"></i>
              </span>    
            </a>
            <form class="cart" role="form" style="margin:0;padding: 0;height: 100%">
              <span  class="home-featured--list--action--quantity" style="">
                <input type="text" name="qty" value="1" class="quantity form-control" style="">
              </span>    
              <span class="home-featured--list--action--button" style="">
                <input type="submit" name="my-add-button" value="Add" id="addButtonfe_<?=$item['id']?>" style='' class=" btn-ghost-full" onclick="addedCart(this.id)">
              </span>    
            </form>
          </div>
        </li>  
      <?php
        }
      ?>
    </ul>
  </div>
  <a href="<?php echo site_url()."featured_page" ?>" class='btn-ghost cta'>
    see more
  </a>
  <a class="btn-ghost-full" href="<?php echo site_url()."checkout/cart" ?>">
    Go To Checkout
  </a>
</section>  

<div class="row two_side">
  <section class="home-newest">
    <a href="<?php echo site_url()."latest_page" ?>" >
     <h1>Latest Products</h1>
    </a>
      <ul class="clearfix">
        <?php
          foreach ($latest as $item) {
        ?>
            <li class="partproduct home-newest--list" id="part_<?= $item['id'] ?>">
              <a href="part/<?= $item['slug'] ?>/<?= $item['pnumber'] ?>"  style="color:white;">
                <div class="home-newest--list--image" style="background-image:url(<?= site_url()?>inc/img/parts/l/<?= $item['img'] ?>);">
                </div>
              </a>
              <div class="text-left padding-05 clearfix">  
                <h4 class="ptitle"><?= $item['title'] ?></h4>
                <strong  class="pnumber"><?= $item['pnumber'] ?></strong>
                <p>
                  <?= $item['type'] ?>
                  <a href="#" data-toggle="tooltip" title="RECYCLED: Used parts refurbished, 
FACTOR: Parts directly from the aftermarket manufacturers,
OEM: Genuine original equipment manufacturer" 
                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                  </a>
                </p>
                <p class="text-center">
                  <?php if( isset($item['offer']) ): ?>
                    <span class="c-tertiary line-through"> 
                      £<?= number_format($item['price'],2) ?>
                    </span>    
                    <span class=" c-tertiary"> 
                      &nbsp;&nbsp;£<?= number_format($item['offer'],2) ?>
                    </span>
                  <?php else: ?>
                    <span class="c-tertiary"> 
                      £<?= number_format($item['price'],2) ?>
                    </span>    
                  <?php endif ?>
                </p>
              </div>
              <div class="home-newest--list--action" style="" class="clearfix" >
                <a href="part/<?= $item['slug'] ?>/<?= $item['pnumber'] ?>"  style="color:white;">
                  <span class="home-newest--list--action--link" style="">
                    <i class="fa fa-external-link" aria-hidden="true"></i>
                  </span>    
                </a>
                <form class="cart" role="form" style="margin:0;padding: 0;height: 100%">
                  <span  class="home-newest--list--action--quantity" style="">
                    <input type="text" name="qty" value="1" class="quantity form-control" style="">
                  </span>    
                  <span class="home-newest--list--action--button" style="">
                    <input type="submit" name="my-add-button" value="Add" id="addButton_<?=$item['id']?>" style='' class=" btn-ghost-full home-newest--list--action--button--input" onclick="addedCart(this.id)">
                  </span>    
                </form>
              </div>
            </li>   
        <?php
          }
        ?>
      </ul>
    <a href="<?php echo site_url()."latest_page" ?>" class='btn-ghost cta'>
      see more
    </a>
    <a class="btn-ghost-full" href="<?php echo site_url()."checkout/cart" ?>">
      Go To Checkout
    </a>
  </section>
  <section class="home-bestSeller">
      <a href="<?php echo site_url()."bestseller_page" ?>" >
        <h1>Best Sellers</h1>
      </a>
      <ul class="clearfix">
      <?php
          foreach ($bestSeller as $item) {
        ?>
            <li class="partproduct home-bestSeller--list" id="part_<?= $item['id'] ?>">
              <a href="part/<?= $item['slug'] ?>/<?= $item['pnumber'] ?>"  style="color:white;">
                <div class="home-bestSeller--list--image" style="background-image:url(<?= site_url()?>inc/img/parts/l/<?= $item['img'] ?>);">
                </div>
              </a>
              <div class="text-left padding-05 clearfix">  
                <h4 class="ptitle"><?= $item['title'] ?></h4>
                <strong  class="pnumber"><?= $item['pnumber'] ?></strong>
                <p>
                  <?= $item['type'] ?>
                  <a href="#" data-toggle="tooltip" title="RECYCLED: Used parts refurbished, 
FACTOR: Parts directly from the aftermarket manufacturers,
OEM: Genuine original equipment manufacturer" 
                    data-placement="right">
                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                  </a>
                  </p>
                  <p class="text-center">
                    <?php if( isset($item['offer']) ): ?>
                      <span class="c-tertiary line-through"> 
                        £<?= number_format($item['price'],2) ?>
                      </span>    
                      <span class=" c-tertiary"> 
                        &nbsp;&nbsp;£<?= number_format($item['offer'],2) ?>
                      </span>
                    <?php else: ?>
                      <span class="c-tertiary"> 
                        £<?= number_format($item['price'],2) ?>
                      </span>    
                    <?php endif ?>
                  </p>
              </div>
              <div class="home-bestSeller--list--action" style="" class="clearfix" >
                <a href="part/<?= $item['slug'] ?>/<?= $item['pnumber'] ?>"  style="color:white;">
                  <span class="home-bestSeller--list--action--link" style="">
                    <i class="fa fa-external-link" aria-hidden="true"></i>
                  </span>    
                </a>
                <form class="cart" role="form" style="margin:0;padding: 0;height: 100%">
                  <span  class="home-bestSeller--list--action--quantity" style="">
                    <input type="text" name="qty" value="1" class="quantity form-control" style="">
                  </span>    
                  <span class="home-bestSeller--list--action--button" style="">
                    <input type="submit" name="my-add-button" value="Add" id="addButtonbs_<?=$item['id']?>" style='' class=" btn-ghost-full home-bestSeller--list--action--button--input" onclick="addedCart(this.id)">
                  </span>    
                </form>
              </div>
            </li>   
        <?php
          }
        ?>
    </ul>
    <a href="<?php echo site_url()."bestseller_page" ?>" class='btn-ghost cta'>
      see more
    </a>
    <a class="btn-ghost-full"  href="<?php echo site_url()."checkout/cart" ?>">
      Go To Checkout
    </a>
  </section>
</div>




<div class="row two_side">
  <section class="col-xs-12 col-sm-6 home-aboutUs">
    <h1>About Us</h1>
    <h4><?= $about['aboutHeader']?></h4>
    <p><?= $about['aboutDescription']?></p>
    <ul class="services clearfix">
      <li>
        <i class="fa fa-bullseye" aria-hidden="true"></i>
        <p><b><?= $about['bullet1']?></b><br></p>
      </li>
      <li>
        <i class="fa fa-truck" aria-hidden="true"></i>
        <p><b><?= $about['bullet2']?></b><br></p>
      </li>
      <li>
        <i class="fa fa-fast-forward" aria-hidden="true"></i>
        <p><b><?= $about['bullet3']?></b><br></p>
      </li>
    </ul>
    <div class="left_list clearfix">
      <div>
        <img src="/assets/img/about/<?= $location['firstImage']?>">
        <h4><?= $location['firstHeader']?></h4>
        <p><?= $location['firstDescription']?></p>
        <ul class="">
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
      </div>
      <div>
        <img src="/assets/img/about/<?= $location['secondImage']?>">
        <h4><?= $location['secondHeader']?></h4>
        <p><?= $location['secondDescription']?></p>
        <ul class="">
          <li>
            <p>
              <i class="fa fa-home" aria-hidden="true"></i> 
              <?= $location['secondbullet1']?></p>
          </li>
          <li>
            <p>
              <i class="fa fa-check" aria-hidden="true"></i> 
              <?= $location['secondbullet2']?></p>
            </p>
          </li>
          
        </ul>
      </div>
    </div>
    <a href="<?php echo site_url().'contact#contact_form' ?>" class='btn-ghost cta'>
      contact us
    </a>
  </section>
  <section class="col-xs-12 col-sm-6 wideimage home-delivery">
    <h1>Delivery</h1>
    <img src="/assets/img/about/<?= $location['deliveryImage']?>">
    <div class="text-left">
      <h4><?= $location['deliveryHeader']?></h4>
      <p><?= $location['deliveryDescription']?></p>
    </div>
    <a href="<?php echo site_url().'contact' ?>" class='btn-ghost cta'>
      see more
    </a>
  </section>
</div>

<div class="row one_side mailing_list" >
  <h1>Join our Mailing List</h1>
  <p>Join Our Mailing List
    Get all the latest prices and deals first! Simply enter your details in the boxes and press submit.
  </p>
  <form method="POST" action="<?php echo site_url('/') ?>">
    <div class="input-group">
      <input type="email" class="form-control" name="SignUpMessage" placeholder="your@email.co.uk">

      <span class="input-group-addon">
        <input type="submit" name="Subscribe" value="Subscribe">
      </span>
    </div>
  </form>  
  <?php
    if(isset($_POST["SignUpMessage"])) {
      $message = "The user with email " . $_POST["SignUpMessage"] . " just sign up to the TTE work";  
      mail("sales@trucktrailerequip.co.uk", "Form to email message", $message, "From: noreplay@sbcommercials.co.uk");
    }
  ?>
</div> 

<div class="row one_side enquiryDiv" >
  <h1>Enquiries</h1>
  <div class="enquiryDiv--div">
    <span class="enquiryDiv--div--span">
      <p>
        If you need parts anywhere in the UK, you can rely on Truck & Trailer Equipment. Call us to discuss your needs.
      </p>
    </span>
    <a href="/enquiry">
      Send us an enquiry
      <br>
      <i class="fa fa-question-circle-o" aria-hidden="true"></i>
    </a>
  </div>
</div> 

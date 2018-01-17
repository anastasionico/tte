
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">
        <img src="/assets/img/tteLogo-white.png" alt="TTE">
      </a>
    </div>



    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Parts
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?= site_url().'vehicles'?>">Manufacturers</a></li>
            <li><a href="<?= site_url().'categories'?>">Categories</a></li>
            <li><a href="<?= site_url().'offers_page'?>">Offers</a></li>
            <li><a href="<?= site_url().'latest_page'?>">Latest</a></li>
            <li><a href="<?= site_url().'bestseller_page'?>">Best sellers</a></li>
            <li><a href="<?= site_url().'featured_page'?>">Featured</a></li>
          </ul>
        </li>
        <li>
          <!-- <form action="store/searchbar" method="post"> -->
          <?php echo form_open("store/searchbar") ?>
              <div class="input-group">
                <input type="text" name="keyword" class="form-control" placeholder="Search">
                <div class="input-group-btn">
                  <button class="btn btn-default" type="submit">
                    <i class="glyphicon glyphicon-search"></i>
                  </button>
                </div>
              </div>
          </form>
        </li>
        <li class="nav-phone2">
          <a href="tel:01215523541" >
            <i class="fa fa-phone fa-2x" aria-hidden="true">
              <span class="nav-phone">0121 552 3541</span>
            </i>
            
            
          </a>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li>   
          <?php
            if(empty($this->cart->contents())){
          ?>
              <a href="<?= site_url('checkout/cart')?>">
                <i  id="totalQty" class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i>
              </a>
          <?php    
            }else{
          ?>
              <a href="<?= site_url('checkout/cart')?>">
                <i id="totalQty" class="fa fa-shopping-cart fa-2x" aria-hidden="true">
                  <? 
                    $cart_content = $this->cart->contents();
                    $cart_qty = 0;
                    foreach ($cart_content as $cart_item) {
                      $cart_qty += $cart_item['qty'];
                    }
                    echo $cart_qty;
                  ?>  
                </i>
              </a>
          <?php    
            }
          ?>    
        </li>

      </ul>
    </div>
  </div>
</nav>
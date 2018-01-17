<?php //echo "<pre>"; print_r($this->data['similar']); echo "</pre>"; ?>

<div class="jumbotron_mini" id="hero_img"  style="padding-top: 0px;margin-bottom: 0px;">
  <?php
    $this->load->view('template/navigation.php');
  ?>
  <div class="Jumbotron_container">
    <h1>Truck & Trailer Equipment</h1> 
    <p>No. 1 for makes of truck and trailer parts</p> 
  </div>
</div>
<div class="row">
  <section class="col-xs-12 col-sm-8 two_thirds partproduct " id="part_<?=$part['id']?>"  >
    <h1>Item Description</h1>
    <div class="main_item clearfix">
      <div class="main_item--details">
        <h2 class="ptitle"><?= $part['title']?></h2>
        <strong  class="pnumber"><?= $part['pnumber']?></strong>
        <?php
          if( $part['availability'] != 1  ):
        ?>
          <br><a href="/enquiry" class="btn btn-danger">Out of Stock (Send us an enquiry about this part)</a><br>
        <?php 
          endif;
        ?>
        <h4><?= ucfirst($part['name']) ?><span class="main_item--details--type">
          <?php
            switch ($part['type']) {
              case 'Recycled':
                echo "<a href='/recycled'><i class='fa fa-envira' aria-hidden='true'></i> Recycled</a>";
                break;
              case 'OEM':
                echo "<a href='/oem'><i class='fa fa-cogs' aria-hidden='true'></i> OEM</a>";
                break;
              case 'Factor':
                echo "<a href='/factor'><i class='fa fa-industry' aria-hidden='true'></i> Factor</a>";
                break;
            }
          ?>
          <a href="#" data-toggle="tooltip" title="RECYCLED: Used parts refurbished, 
FACTOR: Parts directly from the aftermarket manufacturers, 
OEM: Genuine original equipment manufacturer" 
              data-placement="right">
              <i class="fa fa-info-circle" aria-hidden="true"></i>
            </a>
        </span></h4>
        <ul class="main_item--details--list">
          <li>
            <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
            <?= $part['count_sold']?> Sold
          </li>
          <?php
            if(isset($part['offer'])){
              echo "<li><i class='fa fa-gift' aria-hidden='true'></i> On Offer</li>";
            }
          ?>
          <li>
            <i class="fa fa-truck" aria-hidden="true"></i>
            Free Delivery
          </li>
        </ul>
      </div>
      <div class="main_item--divprice text-center">
        <h2>
          <?php if(isset($part['offer'])): ?>
              <span class='c-tertiary line-through'>£<?= number_format($part['price'],2) ?></span>
              <br>
              <span class='c-tertiary'>£<?= number_format($part['offer'],2) ?></span>
          <?php else: ?>
              <span class='c-tertiary'>£<?= number_format($part['price'],2) ?></span>
          <?php endif ?>
        </h2>
        <br>
        <p>
          <?php
            if(isset($part['offer'])){
              $incVat = number_format($part['offer'] * 1.20,2);  
              echo "£ $incVat  (Inc. VAT)";  
            }else{
              $incVat = $part['price'] * 1.20;  
              echo "£ $incVat  (Inc. VAT)";  
            }
          ?>
        </p>
        <form class="form-inline cart" role="form">
          <input type="text" name="qty" value="1" class="quantity form-control" style="display: inline-block;width: 40px;">
          <input type="submit" name="my-add-button" value="Add" class=" btn-ghost-full" id="addButton_<?=$part['id']?>" onclick="addedCart(this.id)">
        </form>
        <a class="btn-ghost" href="<?php echo site_url()."checkout/cart" ?>">
          Go To Checkout
        </a>
      </div>
      <div class="main_item--image" style="text-align: right;">
        <img class="imageGetModal" style='width: 100%;'src="/inc/img/parts/l/<?= $part['img']?>"  alt=" <h2><?= $part['title']?></h2>">
      </div>
      <div class="main_item--description">
        <h4>Product Information</h4>
        <p>
          <?= $part['description']?></p>
        <div class="main_item--description--list">
          <h4>Fits</h4>

          <ul>
            <?php foreach ($VehiclesFitted as $vehicle):?>
              <li><strong><?= $vehicle['manufacturer'] ?></strong> <?= $vehicle['vehicle_text'] ?></li>
            <?php endforeach ?>
          </ul>
        </div>
        
      </div>
    </div>
    <?php 
      
      
      if( !empty($additionalImages['additional_images'])):
    ?>
        <div class="row additionalImagesContainer" >
          <h1>Additional Images</h1>
          <ul>
    <?php
            foreach ($additionalImages['additional_images'] as $image) :
    ?>
              <li>
                <img class="imageGetModal" src="<?= base_url() ?>inc/img/parts/additional/<?= $image['image'] ?>">
              </li>
    <?php
            endforeach
    ?>      
          </ul>
        </div> 
    <?php
      endif
    ?>

    <div class="row enquiryDiv" >
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
  </section>  
  <aside class="col-xs-12 col-sm-4 one_thirds">
    <h1>Similar Parts</h1>
    <ul>
      <?php
        foreach($similar as $similar_item) {
          $linkSimilarPart = "/part/". url_title($similar_item['title'])."/".$similar_item['pnumber']; 
          $linkSimilarPart = str_replace(' ', '_', $linkSimilarPart);
          //var_dump($linkSimilarPart);
        ?>  
          <li>
            <section class="similarObject partproduct" id="part_<?= $similar_item['id'] ?>">
              <a href="<?= $linkSimilarPart ?>">
                <div class="similarObject--image" style='background-image: url(/inc/img/parts/l/<?= $similar_item["img"] ?>);' ></div>
              </a>  
              <div style="display:inline-block;float: left;width: 50%;">
                <div class="similarObject--description">
                <h3 class="ptitle"><?= $similar_item['title']?></h3>
                <strong  class="pnumber"><?= $similar_item['pnumber']?></strong>
                <p>£
                  <?php if(isset($similar_item['offer'])): ?>
                      <span class='c-tertiary'><?= number_format($similar_item['offer'],2) ?></span>
                      <span class='c-tertiary line-through'><?= number_format($similar_item['price'],2) ?></span>
                  <?php else: ?>
                      <span class='c-tertiary'><?= number_format($similar_item['price'],2) ?></span>
                  <?php endif ?>
                <p>
                  <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                  <?= $similar_item['count_sold']?> Sold
                </p>
              </div>
              <div class="similarObject--action" style="" class="clearfix" >
                  <span class="similarObject--action--link" style="">
                    <a href="<?= $linkSimilarPart ?>"  style="color:white;">
                      <i class="fa fa-external-link" aria-hidden="true"></i>
                    </a>
                  </span>    
                  <form class="cart" role="form" style="margin:0;padding: 0;height: 100%">
                    <span  class="similarObject--action--quantity" style="">
                      <input type="text" name="qty" value="1" class="quantity form-control" style="">
                    </span>    
                    <span class="similarObject--action--button" style="">
                      <input type="submit" name="my-add-button" value="Add" id="addButton_<?= $similar_item['id'] ?>" style='' class="similarObject--action--button--input btn-ghost-full" onclick="addedCart(this.id)">
                    </span>    
                  </form>
                </div>
              </div>
            </section>
          </li>
      <?php
        }
      ?>
    </ul>
  </aside>  
</div>




<!-- The Modal -->

<div id="divGetModal" class="Divmodal" >
  
  <!-- The Close Button -->
  <span id="closeButton" style="position: absolute;top:25px;right: 25px;font-size: 5em; color: #fff;cursor: pointer;z-index: 50" onclick="document.getElementById('divGetModal').style.display='none'">&times;</span>

  <!-- Modal Content (The Image) -->
  <img class="modal-content" id="img01">

  <!-- Modal Caption (Image Text) -->
  <div id="caption"></div>
  
</div>



<script type="text/javascript">
  // Get the modal
  var modal = document.getElementById('divGetModal');

  // Get the image and insert it inside the modal - use its "alt" text as a caption
  var img = document.getElementsByClassName('imageGetModal');
  var modalImg = document.getElementById("img01");
  var captionText = document.getElementById("caption");
  
  for (var i = img.length - 1; i >= 0; i--) {
    img[i].onclick = function(){
      modal.style.display = "block";
      modalImg.src = this.src;
      captionText.innerHTML = this.alt;
    } 
  }
  

  // Get the <span> element that closes the modal
  var span = document.getElementById("closeButton");

  // When the user clicks on <span> (x), close the modal
  span.onclick = function() { 
    modal.style.display = "none";
  }


  function next(img) {
    console.log(img.attr);
  }
</script>


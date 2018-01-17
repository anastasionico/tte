<?php
  //echo "<pre>"; print_r($parts);echo "</pre>"; 
?>

<div class="jumbotron_mini" id="hero_img"  style="padding-top: 0px;margin-bottom: 0px;">
  <?php
    $this->load->view('template/navigation.php');
  ?>
  <div class="Jumbotron_container">
    <h1><?php echo ucfirst($keyword) ?></h1> 
    <p></p> 
  </div>
</div>
<div class="row">
  <aside class="col-xs-12 col-sm-4 one_thirds">
   
    <div>
      <?php echo form_open("bestseller_page/filter"); ?>
        <div class="form-group">
          <label for="category">Choose a Category</label>
          <select name="inputGroup" class="selectpicker form-control">
            <?php
              foreach($groups as $group){
                if($group['parent_id'] == 0){
            ?>
                  <optgroup label="<?= ucfirst($group['name'])?>">
            <?php
                    $father_id = $group['id'];
                    foreach($groups as $group){
                      if($group['parent_id'] == $father_id){
                        echo "<option value=\"" . $group['id'] . "\"";
                        echo ">" . $group['name'] . "</option>";
                      }
                    }  
            ?>
                  </optgroup>
            <?php        
                }
              }
            ?>
          </select>
        </div>
        <input type="submit" name="filter" value="Filter" class="btn-ghost cta">
      </form>
    </div>
  </aside>  
  <section class="col-xs-12 col-sm-8 two_thirds">
    <div class="wideimage part_item--container"  id="part_list" >
      <ul class="clearfix">
        <?php
          if(count($searchResult) > 0){
            foreach ($searchResult as $part) {
            //echo "<pre>";print_r($part);echo "</pre>";
            $part_slug = str_replace(' ','-',$part['title']);
            $part_slug = url_title($part_slug);
            //$details_url = "$model/part/$part_slug/" . $part['pnumber'];
        ?>
              <li class="bg_white text-center partproduct part_item"  id="part_<?=$part['id']?>">
                <a href="/part/<?= $part['title'] ?>/<?= $part['pnumber'] ?>">
                  <div class="home-offers--list--image" style="background-image:url(<?= site_url()?>inc/img/parts/l/<?= $part['img'] ?>);"></div>
                </a>  
                <div class="text-left padding-05">  
                  <h4 class="ptitle"><?= $part['title'] ?></h4>
                  <strong  class="pnumber"><?= $part['pnumber'] ?></strong>
                  <p></p>
                </div>
                <ul class="padding-05 clearfix">
                  <li>
                    <p>
                      <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                      <br>
                      <?= $part['count_sold']?> Sold</p>
                    </p>
                  </li>
                  <li>
                    <p>
                      <i class="fa fa-gbp" aria-hidden="true"></i>
                      <br>
                      <span class="pprice">
                        <?php
                          if(isset($part['offer'])){
                            echo " <span class='c-tertiary'>$part[offer]</span>"  ;
                            echo " <span class='line-through'>$part[price]</span>"  ;
                          }else{
                            echo " <span class='c-tertiary'>$part[price]</span>"  ;
                          }
                        ?>
                      </span>
                      
                    </p>
                  </li>
                  <li>
                    <p>
                      <?php
                        switch ($part['type']) {
                          case 'Recycled':
                            echo "<a href='/recycled'><i class='fa fa-envira' aria-hidden='true'></i><br> Recycled</a>";
                            break;
                          case 'OEM':
                            echo "<a href='/oem'><i class='fa fa-cogs' aria-hidden='true'></i><br>OEM</a>";
                            break;
                          case 'Factor':
                            echo "<a href='/factor'><i class='fa fa-industry' aria-hidden='true'></i><br> Factor</a>";
                            break;
                        }
                      ?>
                      <a href="#" data-toggle="tooltip" title="RECYCLED: Used parts refurbished, 
FACTOR: Parts directly from the aftermarket manufacturers,
OEM: Genuine original equipment manufacturer" 
                        data-placement="right">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                      </a>
                    </p>
                  </li>
                </ul>
                <?php
                  $detail_page = "/part/" . url_title($part['title']) ."/".url_title($part['pnumber']);
                ?>
                <div class="part_item--action" style="" class="clearfix" >
                  <span class="part_item--action--link" style="">
                    <a href="/part/<?= $part['title'] ?>/<?= $part['pnumber'] ?>"  style="color:white;">
                      <i class="fa fa-external-link" aria-hidden="true"></i>
                    </a>
                  </span>    
                  <form class="cart" role="form" style="margin:0;padding: 0;height: 100%">
                    <span  class="part_item--action--quantity" style="">
                      <input type="text" name="qty" value="1" class="quantity form-control" style="">
                    </span>    
                    <span class="part_item--action--button" style="">
                      <input type="submit" name="my-add-button" value="Add" id="addButton" style='' class=" btn-ghost-full" onclick="addedCart(this.id)">
                    </span>    
                  </form>
                </div>
                


                <!--
                <a href="#" class='btn-ghost-full'>
                  Buy
                </a>
                -->
              </li>
        <?php
            }
          }else{
        ?>
            <div style="margin-top: 10em;margin-bottom: 15em;text-align: center;">
              <h3>Sorry,<br> 
              Your search hasn’t found any matching products.<br>
              Please try a different keyword.</h3>
            </div>
        <?php
          }
        ?>
          
          
      </ul>
    </div>
  </section> 
</div>
<div class="clearfix"></div>
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
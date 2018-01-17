<?php
 // echo "<pre>"; print_r($manufacturers);echo "</pre>";
?>
<div class="jumbotron_mini" id="hero_img"  style="padding-top: 0px;margin-bottom: 0px;">
  <?php
    $this->load->view('template/navigation.php');
  ?>
  <div class="Jumbotron_container">
    <h1>Our Vehicles</h1> 
    <p></p> 
  </div>
</div>
<div class="row">
  <aside class="col-xs-12 col-sm-4 one_thirds">
    
    <div>
      <?php echo form_open("vehicle_filters"); ?>
        <div class="form-group">
          <label for="model">Choose Manufacturer</label>
          <select name='manufacturer' class="form-control" id="model" >
            <?php
              foreach ($manufacturers as $manufacturer) {
            ?>
                <option value="<?= $manufacturer['name']?>" ><?= ucfirst($manufacturer['name'])?></option>
            <?php
              }
            ?>
          </select>
        </div>
        <input type="submit" name="filter" value="Filter" class="btn-ghost cta">
      </form>
    </div>
  </aside>
  <section class="col-xs-12 col-sm-8 two_thirds">
    <h1>Browse Truck Parts By Vehicle</h1>
    <div class="wideimage part_item--container"  id="part_list" >
      <ul  class="clearfix">
        <?php
          foreach ($manufacturers as $manufacturer) {
        ?> 
            <li>
              <a href="trucks/<?=$manufacturer['name']?>">
                <h3><?=$manufacturer['name'] ?></h3>
              </a>
              <div class="">
                <ul class="clearfix">
        <?php
                  foreach($vehicles as $vehicle){
                    if($vehicle['name'] == $manufacturer['name']){
                      $detail_page = "/trucks/" . $vehicle['name'] ."/". $vehicle['vehicle_text'];
        ?>
                      <li class="bg_white text-center partproduct part_item-vehicle"  id="part_<?=$vehicle['id']?>">
                        <div class="">
                          <?php
                            $vehicle_images_bg = site_url('assets/img/vehicle') ."/". $vehicle['img'];
                          ?>
                          <a href="<?= $detail_page ?>">
                            <div class="home-offers--list--image" style="background-image:url('<?= $vehicle_images_bg ?>');"></div>
                          </a>
                          <div class="text-left padding-05">  
                            <h4 class="ptitle"><?= $vehicle['vehicle_text'] ?></h4>
                            <strong  class="pnumber"><?= $vehicle['model'] ?></strong>
                            <p><?= $vehicle['year_from'] ?> - <?= $vehicle['year_to'] ?></p>
                            <p><?= $vehicle['name'] ?></p>
                            <a href="<?= $detail_page ?>" class='btn-ghost clearfix'>
                              Details <br>
                            </a>  
                          </div>
                        </div>
                      </li>
        <?php          
                  }
                }  
                  

        ?>
                </ul>  
              </div>
        <?php
          }
        ?>
      </ul>
    </div>
  </section>  
</div>
<div class="clearfix"></div>





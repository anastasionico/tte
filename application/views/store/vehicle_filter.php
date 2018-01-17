<?php
//  echo "<pre>"; print_r($vehicles);echo "</pre>";

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
    <h1>
      <?=$manufacturer_item['name'] ?>' Vehicle
      <a href="trucks/<?=$manufacturer_item['name']?>">
        
      </a>
    </h1>

    <div class="wideimage part_item--container"  id="part_list" >
      <div>
      <?php
        foreach($vehicles as $vehicle){
       
      ?>
          <li class="bg_white text-center partproduct part_item-vehicle"  id="part_<?=$vehicle['id']?>">
            <div class="">
              <img src="/assets/img/Vehicle/<?= $vehicle['img'] ?> "/>
              <div class="text-left padding-05">  
                <h4 class="ptitle"><?= $vehicle['vehicle_text'] ?></h4>
                <strong  class="pnumber"><?= $vehicle['model'] ?></strong>
                <p><?= $vehicle['year_from'] ?> - <?= $vehicle['year_to'] ?></p>
                <p><?= $vehicle['name'] ?></p>
                <?php
                  $detail_page = "/trucks/" . $vehicle['name'] ."/". $vehicle['vehicle_text'];
                ?>
                <a href="<?= $detail_page ?>" class='btn-ghost clearfix'>
                  Details <br>
                </a>  
              </div>
            </div>
          </li>
      <?php          
          
        }  
      ?>
      </div>
    </div>
  </section>  
</div>
<div class="clearfix"></div>

<div style="background-color: red">




</div>




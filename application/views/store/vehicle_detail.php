<div class="jumbotron_mini" id="hero_img"  style="padding-top: 0px;margin-bottom: 0px;">
  <?php
    $this->load->view('template/navigation.php');
  ?>
  <div class="Jumbotron_container">
  <?php
    if(isset($model)){
  ?>
      <h1><?= ucfirst($model) ?></h1> 
      <h3><?= $manufacturer ?></h3>         
  <?php
    }else{
  ?>
      <h1><?= $manufacturer ?></h1>   
  <?php   
    }
  ?>
    <p>Truck part</p> 
  </div>
</div>
<div class="row">
  <aside class="col-xs-12 col-sm-4 one_thirds">
    
    <div>
      <?php echo form_open("part_filters/$manufacturer"); ?>
        <div class="form-group">
          <label for="model">Choose a Model</label>
          <select name='vehicle' class="form-control" id="model" >
            <option disabled selected>Please Select</option>
            <?php
              foreach ($vehicles_name as $vehicle) {
            ?>
                <option value="<?= $vehicle['vehicle_text']?>" ><?= ucfirst($vehicle['vehicle_text'])?></option>
            <?php
              }
            ?>
          </select>
        </div>
        <div class="form-group">
          <label for="category">Choose a Category</label>
          <select name="inputGroup" class="selectpicker form-control">
            <option disabled selected>Please Select</option>
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
    <?php
      if(!empty($parts)){
    ?>  
        <h1>
          <?php
            if(isset($model)){
          ?>
              <h1>All <?= ucfirst($model)?> parts</h1> 
          <?php
            }else{
          ?>
              All <?= $manufacturer ?> parts</h1>
          <?php   
            }
          ?>    
        <div class="wideimage part_item--container"  id="part_list" >
          <ul class="clearfix">
            <?php

              foreach ($parts as $part) {
                //echo "<pre>";print_r($part);echo "</pre>";
                $part_slug = str_replace(' ','-',$part['title']);
                $part_slug = url_title($part_slug);
                $details_url = "$model/part/$part_slug/" . $part['pnumber'];
                $detail_page =  site_url() . "part/" . url_title($part['title']) ."/".url_title($part['pnumber']);
            ?>
                  <li class="bg_white text-center partproduct part_item"  id="part_<?=$part['id']?>">
                    <a href="<?= $detail_page ?>">
                      <div class="home-offers--list--image" style="background-image:url(/inc/img/parts/l/<?= $part['img'] ?> );"></div>
                    </a>
                    <div class="text-left padding-05">  
                      <h4 class="ptitle"><?= $part['title'] ?></h4>
                      <strong  class="pnumber"><?= $part['pnumber'] ?></strong>
                      <p><?= $part['name'] ?></p>
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
                            <?php if(isset($part['offer'])): ?>
                                <span class='c-tertiary'><?= number_format($part['offer'],2) ?></span>
                                <span class='c-tertiary line-through'><?= number_format($part['price'],2) ?></span>
                            <?php else: ?>
                                <span class='c-tertiary'><?= number_format($part['price'],2) ?></span>
                            <?php endif ?>
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
                      $detail_page =  site_url() . "part/" . url_title($part['title']) ."/".url_title($part['pnumber']);
                    ?>
                    <div class="part_item--action" style="" class="clearfix" >
                      <span class="part_item--action--link" style="">
                        <a href="<?= $detail_page ?>"  style="color:white;">
                          <i class="fa fa-external-link" aria-hidden="true"></i>
                        </a>
                      </span>    
                      <form class="cart" role="form" style="margin:0;padding: 0;height: 100%">
                        <span  class="part_item--action--quantity" style="">
                          <input type="text" name="qty" value="1" class="quantity form-control" style="">
                        </span>    
                        <span class="part_item--action--button" style="">
                          <input type="submit" name="my-add-button" value="Add" id="addButton<?=$part['id']?>" style='' class=" btn-ghost-full" onclick="addedCart(this.id)">
                        </span>    
                      </form>
                    </div>
                  </li>
              <?php
                }
              ?>
          </ul>
        </div>
  <?
    }else{
      echo "<strong>We do not have these products available at the moment,</strong><br>";
      echo "<a href='http://trucktrailerequip.dev/enquiry'>Please enquiry us to obtain further information </a>";
    }
  ?>      
  </section>  
</div>
<div class="clearfix"></div>

<div style="background-color: red">
  <?php 
    /*  
    echo "<ul>";
    foreach ($parts as $part) {
      $part_slug = str_replace(' ','-',$part['title']);
      $part_slug = url_title($part_slug);
      $details_url = "$model/part/$part_slug/" . $part['pnumber'];
      

      echo "<li>";
        echo "<table>";
          echo "<tr>";    
              echo "<td  style='border:1px solid black;'>$part[pnumber]</td>";
              echo "<td  style='border:1px solid black;'>$part[title]</td>";
              echo "<td  style='border:1px solid black;'>$part[name]</td>";
              echo "<td  style='border:1px solid black;'>$part[price]</td>";
              echo "<td  style='border:1px solid black;'>$part[img]</td>";
              
              echo "<td  style='border:1px solid black;'>
                <a href='$details_url'>Details</a>
              </td>";
              echo "<td  style='border:1px solid black;'>
                <a href='#'>Buy</a>
              </td>";
          echo "</tr>";     
        echo "</table>";    
      echo "</li>";
    }
    echo "</ul>";
  */  
  ?>  
</div>




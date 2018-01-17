<?php
  //echo "<pre>"; print_r($parts);echo "</pre>"; 
?>

<div class="jumbotron_mini" id="hero_img"  style="padding-top: 0px;margin-bottom: 0px;">
  <?php
    $this->load->view('template/navigation.php');
  ?>
  <div class="Jumbotron_container">
    <h1>OEM</h1>   
    <p>Genuine Original Equipment Manufacturer</p> 
  </div>
</div>
<div class="row">
  <aside class="col-xs-12 col-sm-4 one_thirds">
    <div>
      <?php echo form_open("oem_page/filter"); ?>
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
    <h1>
      <?php
        /*
        if(isset($model)){
      ?>
          <h1>All <?= ucfirst($model)?> parts</h1> 
      <?php
        }else{
      ?>
          All <?= $manufacturer ?> parts</h1>
      <?php   
        }
        */
      ?>  
    </h1>    
    <div class="wideimage part_item--container"  id="part_list" >
      <ul class="clearfix">
        <?php
          foreach ($oem as $part) {
            //echo "<pre>";print_r($part);echo "</pre>";
            $part_slug = str_replace(' ','-',$part['title']);
            $part_slug = url_title($part_slug);
            //$details_url = "$model/part/$part_slug/" . $part['pnumber'];
            $detail_page = "/part/" . url_title($part['title']) ."/".url_title($part['pnumber']);
        ?>
              <li class="bg_white text-center partproduct part_item"  id="part_<?=$part['id']?>">
                <a href="part/<?= $part['title'] ?>/<?= $part['pnumber'] ?>"  style="color:white;">
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
                  $detail_page = "/part/" . url_title($part['title']) ."/".url_title($part['pnumber']);
                ?>
                <div class="part_item--action" style="" class="clearfix" >
                  <span class="part_item--action--link" style="">
                    <a href="part/<?= $part['title'] ?>/<?= $part['pnumber'] ?>"  style="color:white;">
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
                


                <!--
                <a href="#" class='btn-ghost-full'>
                  Buy
                </a>
                -->
              </li>
          <?php
            }
          ?>
      </ul>
    </div>
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
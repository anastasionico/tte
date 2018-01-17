<?php
 // echo "<pre>"; print_r($groups);echo "</pre>";
?>
<div class="jumbotron_mini" id="hero_img"  style="padding-top: 0px;margin-bottom: 0px;">
  <?php
    $this->load->view('template/navigation.php');
  ?>
  <div class="Jumbotron_container">
    <h1>Our Parts</h1> 
    <p></p> 
  </div>
</div>
<div class="row">
  <aside class="col-xs-12 col-sm-4 one_thirds">
   
    <div>
      <?php echo form_open("group_filters"); ?>
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
    <h1>Browse truck parts by categories</h1>
    <div class="wideimage part_item--container"  id="part_list" >
      <ul  class="clearfix">
        <?php
          foreach($groups as $group){
            $category_addr = $group['addr'];
            $category_name = $group['name'];
            if($group['parent_id'] == 0){
        ?> 
            <li>
              <a href="categories/<?= $category_addr?>">
                <h3><?= ucfirst($category_name)?></h3>
              </a>
              <div class=" ">
                <ul class="clearfix">
        <?php
                  $father_id = $group['id'];
                  foreach($groups as $group){
                    if($group['parent_id'] == $father_id){
        ?>
                  
                      <li class="bg_white text-center partproduct part_item-vehicle">
                        <div class="text-left padding-05">  
                          <h4 class="ptitle"><?= ucfirst($group['name'])?></h4>
                          <strong  class="pnumber"></strong>
                          <p><?= ucfirst($group['description'])?></p>
                          <p></p>
                        </div>
                        <a href="categories/<?= $category_addr ?>/<?= $group['addr']?>" class='btn-ghost'>
                          Details
                        </a>
                      </li>
        <?php          
                    }
                  }  
        ?>
                </ul>  
              </div>
            </li>
        <?php
            }
          }  
        ?>
      </ul>
    </div>
  </section>  
</div>
<div class="clearfix"></div>



<!--
  <div class="controls">
          <select name="inputGroup" class="selectpicker">
          <?php
            foreach($groups as $group){
              if($group['parent_id'] == 0){
          ?>
                <optgroup label="<?= ucfirst($group['name'])?>">
          <?php
                  $father_id = $group['id'];
                  foreach($groups as $group){
                    if($group['parent_id'] == $father_id){
          ?>
                      <option value="<?= $group['id']?>"><?= ucfirst($group['name'])?></option>
          <?php
                    }
                  }  
          ?>
                </optgroup>
          <?php        
                //echo $group['name']." ".$group['parent_id']. "<br>";
              }
            }
          ?>
          
          </select>
        </div>



-->

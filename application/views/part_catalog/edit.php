<style>
  #sortable { list-style-type: none;  }
  #sortable li {  float: left;}
</style>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  $( function(){
    $( "#sortable" ).sortable({
      update: function( event, ui ) {
        var postData = $(this).sortable('serialize');
        //console.log(postData);
        $.post(
          '<?=base_url()?>part_catalog/orderAdditionalImage', 
          {list:postData}, 
          function(o) {
            console.log(o);
          }, 
          'json');
      }
    //$( "#sortable" ).disableSelection();
    });
  });
</script>  
<ul class="breadcrumb">
  <li><a href="/part_catalog/">Part Catalog</a> <span class="divider">/</span></li>
  <li class="active">Edit Part</li>
</ul>
<div class="page-header">
  <h1>Edit: <?= ucfirst($part['pnumber'])?></h1> 
  <?php  
    if( $part['availability'] == 1 ){
      echo '<a href="/' . $this->uri->segment(1) . '/' . $part['id'] . '/available" class="btn btn-warning"> set as not Available &nbsp;<i class="fa fa-refresh" aria-hidden="true"></i></a>';
    }else{
      echo '<a href="/' . $this->uri->segment(1) . '/' . $part['id'] . '/available" class="btn btn-warning"> set as Available &nbsp;<i class="fa fa-refresh" aria-hidden="true"></i></a>';
    }
  ?>
  <br><br>
  <img src="<?= site_url('/inc/img/parts/l').'/'. $part['img'] ?>" alt="<?= site_url('/inc/img/parts/l').'/'. $part['img'] ?>">
</div>
<form action="/part_catalog/<?=$part['id']?>" class="form-horizontal" method="post" accept-charset="utf-8" enctype="multipart/form-data">
  <div class="row fluid">
    <div class="span4">
      <input name="picture" type="file"  class="btn btn-default"/>
    </div>
    <div class="span8">
      <div class="control-group">
        <label class="control-label" for="inputPnumber">Part Number *</label>
        <div class="controls">
          <input type="text" id="inputPnumber" name="inputPnumber" placeholder="Part Number" value="<?=$part['pnumber']?>"  required >
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="inputTitle">Title *</label>
        <div class="controls">
          <input type="text" id="inputTitle" name="inputTitle" placeholder="Title" value="<?=$part['title']?>"  required >
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="featured">Featured</label>
        <div class="controls">
          <label>
            <input type="checkbox" name="featured" <?php echo ($part['featured'] == 1) ? ' checked ' :''; ?> >
            
            <a href="#" data-toggle="tooltip" title="Set as Featured item">
              <i class="fa fa-star" aria-hidden="true"></i>
            </a>
          </label>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="inputGroup">Group *</label>
        <div class="controls">
          <select name="inputGroup" class="selectpicker"  required >
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
                        if($part['group'] == $group['id']) echo " selected";
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
      </div>
      <div class="control-group">
        <label class="control-label" for="price">Price *</label>
        <div class="controls"> 
            <input type="text" id="price" name="price" placeholder="100.00" value="<?=$part['price']?>"  required >
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="price">EBay</label>
        <div class="controls">
          <label>
            <input type="checkbox" name="ebay" <?php echo ($part['ebay'] == 1) ? ' checked ' :''; ?>  onclick="ebayCheckBox(this)" >
          </label>
        </div>
      </div>
      
      
      <div class="control-group" id="priceEbay">
        <label class="control-label" for="price">Price On Ebay</label>
        <div class="controls"> 
            <input type="text" name="priceEbay" placeholder="100.00" value="<?=$part['price_ebay']?>" >
        </div>
      </div>

      <div class="control-group" id="eBayGSP">
        <label class="control-label" for="eBayGSP">Included in eBay GSP</label>
        <div class="controls">
          <label>
            <input type="checkbox" name="eBayGSP" <?php echo ($part['ebay_gsp'] == 1) ? ' checked ' :''; ?> >
          </label>
        </div>
      </div>

      <div class="control-group ">
        <label class="control-label" for="offer">Offer</label>
        <div class="controls">
          <?php $offer = ($part['offer'] !== null) ?  $part['offer']: ''; ?>
          <input type="text" id="offer" name="offer" placeholder="Offer Price" value="<?= $offer ?>">
          <a href="#" data-toggle="tooltip" title="Set a price to put the item in the offer list">
            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
          </a>
          <span style="margin-left: 2em">
            <select name="homepage">
              <option value="null">no homepage</option>
  <?php 
                for ($i=1; $i <= 6 ; $i++): 
                  if($part['homepage'] == $i){
  ?>
                    <option value="<?= $part['homepage'] ?>" selected><?= $part['homepage'] ?></option>
  <?php           }else{ 
  ?>                  
                  <option value="<?= $i ?>"><?= $i ?></option>
  <?php            }
                endfor ?> 
            </select>
          </span>
          <a href="#" data-toggle="tooltip" title="Insert the position of the offer on the home page">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
          </a>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="type">Type *</label>
        <div class="controls">
            <select name="type"  required >
              <option value="<?= $part['type'] ?>" selected>Current: <?= $part['type'] ?></option>
              <option value="Recycled">Recycled</option>
              <option value="Factor">Factor</option>
              <option value="OEM">OEM</option>
            </select>
            <a href="#" data-toggle="tooltip" title="
              RECYCLED: Used parts refurbished, 
              FACTOR: Parts directly from the aftermarket manufacturers,
              OEM: Genuine original equipment manufacturer" 
              data-placement="right">
              <i class="fa fa-info-circle" aria-hidden="true"></i>
            </a>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="inputDescription">Description*</label>
        <div class="controls">
          <textarea rows="5" id="inputdescription" name="inputDescription" class="fullwidth"><?=$part['description']?></textarea  required >
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="count_sold">Count Solded</label>
        <div class="controls">
          <input type="text" id="price" name="count_sold" value="<?=$part['count_sold']?>" >
        </div>
      </div>
      <br><br><br><br>
      <div class="control-group">
        <div class="controls">
           <a href="#" onclick="event.preventDefault();$('.vehicleCheckbox').attr('checked', 'true')">Check All</a>
        </div>
      </div>
       <div class="row">
      <? 
      $last_vehicle = '';
      foreach($vehicles as $vehicle) {
        if($last_vehicle != $vehicle['vehicle_text']) {
          if($last_vehicle == '') { //first loop
            ?>
              <div class="control-group span4">
          <? } else { ?>
                <!-- <a href="#" onclick="event.preventDefault();$('.m<?=$last_vehicle_vin?>').attr('checked', 'true')">Check All</a> -->
              </div>
      </div>
      <div class="control-group span4">
            <? } ?>
        <label class="control-label" for="inputm<?=$vehicle['vehicle_vin']?>"><?=$vehicle['vehicle_text']?></label>
        <div class="controls">
          <?
          } // end last vehicle != current
          ?>
          <label class="checkbox inline">
            <input type="checkbox" class="m<?=$vehicle['vehicle_vin']?> vehicleCheckbox" name="m_<?=$vehicle['id']?>" value="1"<? if(in_array($vehicle['id'], $part['fits_vehicles'], true) == true) { ?> checked<? } ?>> <?=$vehicle['model']?>
          </label>
          <?
          $last_vehicle = $vehicle['vehicle_text'];
          $last_vehicle_vin = $vehicle['vehicle_vin'];
          } // foreach vehicle
       ?>
          
        </div>
      </div>
      </div><!--  end row -->

      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-success">Update  &nbsp;<i class="fa fa-refresh" aria-hidden="true"></i></button>
          <button type="reset" class="btn">Cancel  &nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></button>
          <?php 
            echo '<a href="/' . $this->uri->segment(1) . '/' . $part['id'] . '/delete" class="btn btn-danger">Delete  &nbsp;<i class="fa fa-times-circle" aria-hidden="true"></i></a>';
           ?>
        </div>
      </div>

    </div>
  </div>
</form>
<hr>

<div class="col-xs-12 col-md-9 ">
  <h5>Additional Images</h5>
  <p>Add an image from the button below and click the "Upload" button.</p>
  <p>Drag and drop the images to sort their order.</p>
  <br>
  <?php echo form_open_multipart("part_catalog/AddAdditionaImage/$part[id]");?>
    <input type="file" name="additionalImage"  class="btn btn-default"/>
    <button type="submit" class="btn btn-success">Upload  &nbsp;<i class="fa fa-upload" aria-hidden="true"></i></button>
  </form>
  <div class="row">
    <? 
      if(! empty($additionalImages['additional_images']) ) { 
        echo "<ul id='sortable'>";
        $i=0;
        //echo "<pre>"; print_r($vehicle['additional_images']);
        foreach($additionalImages['additional_images'] as $image) { 
    ?>
          <li class="ui-state-default" id="item-<?=$image['id']?>">
            <div class="" style="width:160px;height:160px;margin: 2em;text-align: center;background-image: url(<?= site_url('/inc/img/parts/additional').'/'. $image['image'] ?>);background-position:center; background-size: cover; ">
              <a href="/part_catalog/delete_picture/<?=$part['id']?>/<?=$image['id']?>        " 
                class="btn btn-xs btn-danger" style='width: 100%;padding: 0px'>
                Delete  &nbsp;<i class="fa fa-times-circle" aria-hidden="true"></i>
              </a>
            </div>
          </li>
          
    <?
        $i++;
        }
        echo "</ul>";
      } 
    ?>
  </div>
</div>  

<script type="text/javascript">
  function ebayCheckBox($this) {
    var priceEbay = document.getElementById('priceEbay');
    var eBayGSP = document.getElementById('eBayGSP');
    if($this.checked === true){
      priceEbay.style.display = 'block';      
      eBayGSP.style.display = 'block';      
    }else{
      priceEbay.style.display = 'none';      
      eBayGSP.style.display = 'none';      
    }
  }
</script>
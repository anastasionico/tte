<ul class="breadcrumb">
  <li><a href="/part_catalog/">Part Catalog</a> <span class="divider">/</span></li>
  <li class="active">Add Part</li>
</ul>
<div class="page-header">
  <h1>Add Part</h1>
</div>
<form action="/part_catalog/add" class="form-horizontal" method="post" accept-charset="utf-8" enctype="multipart/form-data">
  <div class="row fluid">
    <div class="span12">
      <div class="control-group">
        <label class="control-label" for="inputPnumber">Part Number *</label>
        <div class="controls">
        <input type="text" id="inputPnumber" name="inputPnumber" placeholder="Part Number" required value="<?
$pnumber = $this->session->flashdata('pnumber');
if($pnumber) echo $pnumber;
?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="inputTitle">Title *</label>
        <div class="controls">
          <input type="text" id="inputTitle" name="inputTitle" placeholder="Title" value=""  required >
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="price">Featured</label>
        <div class="controls">
          <label>
            <input type="checkbox" name="featured">
            &nbsp;&nbsp;yes
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
      </div>
      <div class="control-group">
        <label class="control-label" for="price">Price *</label>
        <div class="controls">
          <input type="text" id="price" name="price" placeholder="100.00"  required >
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="price">EBay</label>
        <div class="controls">
          <label>
            <input type="checkbox" name="ebay" onclick="ebayCheckBox(this)">
          </label>
        </div>
      </div>
      <div class="control-group" id="priceEbay" style="display: none;">
        <label class="control-label" for="price">Price On Ebay</label>
        <div class="controls">
          <input type="text" id="" name="priceEbay" placeholder="100.00">
          <a href="#" data-toggle="tooltip" title="This field is valid only if the Ebay checkbox is ticked">
              <i class="fa fa-info-circle" aria-hidden="true"></i>
            </a>
        </div>
      </div>
      <div class="control-group" id="eBayGSP" style="display: none;">
        <label class="control-label" for="eBayGSP">Include in eBay GSP</label>
        <div class="controls">
          <label>
            <input type="checkbox" name="eBayGSP">
          </label>
        </div>
      </div>
      <div class="control-group ">
        <label class="control-label" for="offer">Offer</label>
        <div class="controls">
          <input type="text" id="offer" name="offer" placeholder="Offer Price" value="">
          <a href="#" data-toggle="tooltip" title="Set a price to put the item in the offer list">
            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
          </a>
          <span style="margin-left: 2em">
            <select name="homepage">
              <option value="null">no homepage</option>
              <?php for ($i=1; $i <= 6 ; $i++): ?>
                <option value="<?= $i ?>"><?= $i ?></option>
              <?php endfor ?> 
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
        <label class="control-label" for="picture">Picture *</label>
        <div class="controls">
          <input type="file" name="picture" multiple="multiple" required>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="inputDescription">Description *</label>
        <div class="controls">
          <textarea rows="5" id="inputdescription" name="inputDescription" class="fullwidth"  required ></textarea>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="count_sold">Sold count</label>
        <div class="controls">
          <input type="text" id="price" name="count_sold" placeholder="100">
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
      <?      } else { 
      ?>
               <!--  <a href="#" onclick="event.preventDefault();$('.m<?=$last_vehicle_vin?>').attr('checked', 'true')">Check All <?= $last_vehicle ?></a> -->
                </div>
              </div>
              <div class="control-group  span4">
      <?      } 
      ?>
                <label class="control-label" for="inputm<?=$vehicle['vehicle_vin']?>"><?=$vehicle['vehicle_text']?></label>
                <div class="controls">
      <?
            } // end last vehicle != current
      ?>
            <label class="checkbox inline">
              <input type="checkbox" class="m<?=$vehicle['vehicle_vin']?> vehicleCheckbox" name="m_<?=$vehicle['id']?>" value="1"> <?=$vehicle['model']?>
            </label>
      <?
            $last_vehicle = $vehicle['vehicle_text'];
            $last_vehicle_vin = $vehicle['vehicle_vin'];
            
          } // foreach vehicle
      ?>
          
          </div>
        </div>
       </div> <!-- row -->
      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-success">Add &nbsp;<i class="fa fa-plus" aria-hidden="true"></i></button>
          <!-- <button type="submit" class="btn">Cancel  &nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></button> -->
        </div>
      </div>

    </div>
  </div>
</form>
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
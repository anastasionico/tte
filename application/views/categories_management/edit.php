<?php
  //echo "<pre>"; print_r($this->data['groups']);   echo "</pre>";
?>
<ul class="breadcrumb">
  <li><a href="<?=site_url('categories_management')?>">Part Categories</a> <span class="divider">/</span></li>
  <li class="active">Edit Subcategory</li>
</ul>
<div class="page-header">
    <h1><?php 
            echo ucfirst($groups['name']);
        ?>
    </h1>
</div>
<?php $action = site_url('categories_management/update')."/$groups[id]"; ?>
<?php echo validation_errors(); ?>
<?php echo form_open($action);?>
<!--<form action="<?= $action ?>" class="form-horizontal" method="post" accept-charset="utf-8" enctype="multipart/form-data">-->
  <div class="row fluid">
    <div class="span12">
      <div class="control-group">
        <label class="control-label" for="name">name</label>
        <div class="controls">
          <input type="text" id="name" name="name" value="<?=$groups['name']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="description">description</label>
        <div class="controls">
          <input type="text" id="description" name="description" value="<?=$groups['description']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="category">Category</label>
        <div class="controls">
          <select name="parent_id">
<?php       foreach ($getParentGroups as $group) { 
              if($groups['parent_id'] == $group['id'] ){
?>    
                <option value="<?= $group['id'] ?>" selected><?= $group['name'] ?> - currently</option>      
<?php         
              }else{
?>              
              <option value="<?= $group['id'] ?>" ><?= $group['name'] ?> </option>       
<?php        
              }
            }
?>
          </select>
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>
    </div>
  </div>
</form>


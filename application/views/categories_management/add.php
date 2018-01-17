<ul class="breadcrumb">
  <li><a href="<?=site_url('users')?>">User Management</a> <span class="divider">/</span></li>
  <li class="active">Add Category</li>
</ul>
<div class="page-header">
  <h1>Add Category</h1>
</div>
<?php echo validation_errors(); ?>
<?php echo form_open('categories_management/add'); ?>

  <div class="row fluid">
    <div class="span12">
      <div class="control-group">
        <label class="control-label" for="name">Name</label>
        <div class="controls">
          <input type="text" id="name" name="name">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="description">Description</label>
        <div class="controls">
          <input type="text" id="description" name="description">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="category">Category</label>
          <div class="controls">
            <select name="parent_id">
              <?php foreach ($getParentGroups as $group) : ?>
                <option value="<?= $group['id'] ?>"><?= $group['name'] ?> </option>
              <?php endforeach ?>
            </select>
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary">Add</button>
          <button type="submit" class="btn">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</form>


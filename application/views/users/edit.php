<ul class="breadcrumb">
  <li><a href="<?=site_url('users')?>">User Management</a> <span class="divider">/</span></li>
  <li class="active">Edit User</li>
</ul>
<div class="page-header">
    <h1><?=$user_account['fullname']?></h1>
</div>
<?php $action = site_url('users/update_user')."/$user_account[id]" ?>
<form action="<?= $action ?>" class="form-horizontal" method="post" accept-charset="utf-8" enctype="multipart/form-data">
  <div class="row fluid">
    <div class="span12">
      <div class="control-group">
        <label class="control-label" for="username">Username</label>
        <div class="controls">
          <input type="text" id="username" name="username" value="<?=$user_account['username']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="fullname">Full Name</label>
        <div class="controls">
          <input type="text" id="fullname" name="fullname" value="<?=$user_account['fullname']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="email">Email</label>
        <div class="controls">
          <input type="email" id="email" name="email" value="<?=$user_account['email']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="password">Password</label>
        <div class="controls">
          <input name="password" type="password" placeholder="Password" >
          <a href="#" data-toggle="tooltip" title="Type a password only if you want to change the old one" data-placement="right">
      <i class="fa fa-info-circle" aria-hidden="true"></i>
    </a>
        </div>
      </div>
      
      <!--
      <h4>MODULES AND PERMISSIONS</h4>
      <? foreach($modules as $module) { ?>
      <div class="control-group">
        <label class="control-label" for="permission_<?=$module['id']?>"><?=$module['title']?></label>
        <div class="controls">
          <input type="text" id="permission_<?=$module['id']?>" name="permission_<?=$module['id']?>" placeholder="0" value="<?
          foreach($user_account['permissions'] as $permission) {
            if($permission['module_id'] == $module['id']) {
              echo $permission['access'];
            }
          }
          ?>" class="input-mini">
        </div>
      </div>
      <? } ?>
      -->
      <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>
    </div>
  </div>
</form>

<ul class="breadcrumb">
  <li><a href="<?=site_url('customers')?>">Customer Management</a> <span class="divider">/</span></li>
  <li class="active">Edit Customer</li>
</ul>
<div class="page-header">
    <h1><?php 
            echo ucfirst($customer_account['lastname']) ." ".ucfirst($customer_account['firstname']);
        ?>
    </h1>
</div>
<?php $action = site_url('customers/update_customers')."/$customer_account[id]"; ?>
<?php echo validation_errors(); ?>
<?php echo form_open($action);?>
<!--<form action="<?= $action ?>" class="form-horizontal" method="post" accept-charset="utf-8" enctype="multipart/form-data">-->
  <div class="row fluid">
    <div class="span12">
      <div class="control-group">
        <label class="control-label" for="firstname">firstname</label>
        <div class="controls">
          <input type="text" id="firstname" name="firstname" value="<?=$customer_account['firstname']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="lastname">lastname</label>
        <div class="controls">
          <input type="text" id="lastname" name="lastname" value="<?=$customer_account['lastname']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="address1">address1</label>
        <div class="controls">
          <input type="text" id="address1" name="address1" value="<?=$customer_account['address1']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="address2">address2</label>
        <div class="controls">
          <input type="text" id="address2" name="address2" value="<?=$customer_account['address2']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="city">city</label>
        <div class="controls">
          <input type="text" id="city" name="city" value="<?=$customer_account['city']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="postcode">postcode</label>
        <div class="controls">
          <input type="text" id="postcode" name="postcode" value="<?=$customer_account['postcode']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="email">email</label>
        <div class="controls">
          <input type="text" id="email" name="email" value="<?=$customer_account['email']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="mobile">mobile</label>
        <div class="controls">
          <input type="text" id="mobile" name="mobile" value="<?=$customer_account['mobile']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="username">username</label>
        <div class="controls">
          <input type="text" id="username" name="username" value="<?=$customer_account['username']?>">
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
      <div class="control-group">
        <label class="control-label" for="creditcard">creditcard</label>
        <div class="controls">
          <input type="text" id="creditcard" name="creditcard" value="<?=$customer_account['creditcard']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="creditcard_type">creditcard_type</label>
        <div class="controls">
          <input type="text" id="creditcard_type" name="creditcard_type" value="<?=$customer_account['creditcard_type']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="creditcard_expmm">creditcard_expmm</label>
        <div class="controls">
          <input type="text" id="creditcard_expmm" name="creditcard_expmm" value="<?=$customer_account['creditcard_expmm']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="creditcard_expyy">creditcard_expyy</label>
        <div class="controls">
          <input type="text" id="creditcard_expyy" name="creditcard_expyy" value="<?=$customer_account['creditcard_expyy']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="billing_address">billing_address</label>
        <div class="controls">
          <input type="text" id="billing_address" name="billing_address" value="<?=$customer_account['billing_address']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="billing_city">billing_city</label>
        <div class="controls">
          <input type="text" id="billing_city" name="billing_city" value="<?=$customer_account['billing_city']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="billing_postcode">billing_postcode</label>
        <div class="controls">
          <input type="text" id="billing_postcode" name="billing_postcode" value="<?=$customer_account['billing_postcode']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="ship_city">ship_city</label>
        <div class="controls">
          <input type="text" id="ship_city" name="ship_city" value="<?=$customer_account['ship_city']?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="ship_postcode">ship_postcode</label>
        <div class="controls">
          <input type="text" id="ship_postcode" name="ship_postcode" value="<?=$customer_account['ship_postcode']?>">
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


<ul class="breadcrumb">
  <li><a href="<?=site_url('users')?>">User Management</a> <span class="divider">/</span></li>
  <li class="active">Add User</li>
</ul>
<div class="page-header">
  <h1>Add User</h1>
</div>
<form action="add" class="form-horizontal" method="post" accept-charset="utf-8" enctype="multipart/form-data">
  <div class="row fluid">
    <div class="span12">
      <div class="control-group">
        <label class="control-label" for="username">Username</label>
        <div class="controls">
          <input type="text" id="username" name="username" placeholder="Username" value="">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="fullname">Full Name</label>
        <div class="controls">
          <input type="text" id="fullname" name="fullname" placeholder="Full Name" value="">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="email">Email</label>
        <div class="controls">
          <input type="email" id="email" name="email" placeholder="Email Address" value="">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="password">Password</label>
        <div class="controls">
          <input name="password" type="password" placeholder="Password">
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


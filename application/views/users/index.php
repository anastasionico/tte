<?php 
  $this->data['user']['id'];
?>


<div class="page-header">
  <h1>Users list</h1>
  <a href="<?=site_url('users/add')?>" class="btn btn-info">Add User  &nbsp;<i class="fa fa-plus" aria-hidden="true"></i></a>  
</div>

<table id="users" class="table table-striped table-bordered">
  <thead>
    <tr>
      <th>Username</th>
      <th>Full Name</th>
      <th>Email</th>
      <th>Registered</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
  <? 
    $mark = "style='background-color:#252362;color:#8c7323;' ";
    foreach($user_accounts as $user) {
      if ($user['id'] == $this->data['user']['id']) {
        echo "<tr id='row_$user[id]' $mark>";
      }else{
        echo "<tr id='row_$user[id]'>";
      }

   ?>
    
      <td><?=$user['username']?></td>
      <td><?=$user['fullname']?></td>
      <td><?=$user['email']?></td>
      <td><?=$user['created_at']?></td>
      <td>
        <div class="btn-group btn-group-justified">
          <a href="users/edit/<?=$user['id']?>" class="btn btn-primary">Edit  &nbsp;<i class="fa fa-edit" aria-hidden="true"></i></a>
          <a href="users/delete/<?=$user['id']?>" class="btn btn-danger">Delete  &nbsp;<i class="fa fa-times-circle" aria-hidden="true"></i></a>
        </div>
      </td>
    </tr>
  <? } ?>
  </tbody>
</table>

<script src="/assets/js/jquery.dataTables.min.js"></script>
<script src="/assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript" charset="utf-8">

$.extend( $.fn.dataTableExt.oStdClasses, {
    "sWrapper": "dataTables_wrapper form-inline"
});
jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "date-uk-pre": function ( a ) {
        var ukDatea = a.split('/');
        return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
    },
    "date-uk-asc": function ( a, b ) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },
    "date-uk-desc": function ( a, b ) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
});


  $(document).ready(function() {

    /*
    // datatables
    $('#parts-unlisted').dataTable( {
        "aoColumns": [
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null
        ],
        "sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
        "aLengthMenu": [
            [25, 50, 100, 200, -1],
            [25, 50, 100, 200, "All"]
        ], 
        "iDisplayLength" : -1,
        "sPaginationType": "bootstrap"
    });
    */

  $(".table-clickrow tbody")
    .on("click", "tr", function() {
      var n=$(this).attr('id').split("_");
      window.location = '/<?=$this->uri->segment(1)?>/users/'+ n[1];
    })
    .on("mouseover", "tr", function() {
      $(this)
        .addClass("over")
        .css('cursor', 'pointer');
    })
    .on("mouseout", "tr", function() {
      $(this)
        .removeClass("over")
        .css('cursor', 'auto');
    });

  });
</script>

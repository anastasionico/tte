<div class="page-header">
  <h1>Customers list</h1>
  
</div>

<table id="customers" class="table table-striped table-hover table-clickrow table-bordered">
  <thead>
    <tr>
      <th>Username</th>
      <th>Name</th>
      <th>Surname</th>
      <th>City</th>
      <th>Phone</th>
      <th>mobile</th>
      <th>Email</th>
      <th>Registered</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
  <? foreach($customer_accounts as $customer) { ?>
    <tr id="row_<?=$customer['id']?>">
      <td><?=$customer['username']?></td>
      <td><?=$customer['firstname']?></td>
      <td><?=$customer['lastname']?></td>
      <td><?=$customer['city']?></td>
      <td><?=$customer['phone']?></td>
      <td><?=$customer['mobile']?></td>
      <td><?=$customer['email']?></td>
      <td><?=$customer['created_at']?></td>
      <td>
        <div class="btn-group btn-group-justified">
          <a href="customers/edit/<?=$customer['id']?>" class="btn btn-primary">Edit  &nbsp;<i class="fa fa-edit" aria-hidden="true"></i></a>
          <a href="customers/delete/<?=$customer['id']?>" class="btn btn-danger">Ban  &nbsp;<i class="fa fa-times-circle" aria-hidden="true"></i></a>
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
      window.location = '/<?=$this->uri->segment(1)?>/customers/'+ n[1];
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

  //echo "<pre>"; print_r($this->data['messages']);   echo "</pre>";
?>
<div class="page-header">
  <h1>Messages list</h1>
  
</div>

<table id="users" class="table table-striped table-hover table-bordered">
  <thead>
    <tr>
      <th>Date</th>
      <th>Name</th>
      <th>Email</th>
      <th>Message</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  <? foreach($messages as $message) { ?>
    <tr id="row_<?=$message['id']?>">
      <td style="min-width: 150px">
        <?= date("d-m-Y H:i",$message['date']);?>
      </td>
      <td><?=$message['name']?></td>
      <td>
        <a href="mailto:<?=$message['email']?>" target="_top">
          <?=$message['email']?>
        </a>
      </td>
      <td><?=$message['message']?></td>
      <td>
        <div class="btn-group btn-group-justified">
          <a href="contact_management/delete/<?=$message['id']?>" class="btn btn-danger">Delete  &nbsp;<i class="fa fa-times-circle" aria-hidden="true"></i></a>
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


<div>
  <h1>Vehicles list</h1>
  <a href="vehicle_management/create" class="btn btn-info">Add Vehicle  &nbsp;<i class="fa fa-plus" aria-hidden="true"></i></a>  
  <!--
  <form id="part-form" action="/part_catalog/search" method="post" class="form-search">
    <div class="input-append">
      <input type="text" id="query" name="query" class="input-large" placeholder="Part Number">
      <button type="submit" class="btn">Search</button>
    </div>
  </form> -->
</div>
<br><br>
<!--
<a href="/<?=$this->uri->segment(1)?>/part_catalog/awaiting_image" class="btn">Awaiting Image</a>
-->

<table id="parts-unlisted" class="table table-striped table-hover table-clickrow table-bordered">
  <thead>
    <tr>
      <th>Img</th>
      <th>Manufacturer</th>
      <th>Vehicle</th>
      <th>Year from</th>
      <th>Year to</th>
      <th>Model</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
  <? foreach($items as $item) { ?>
    <tr id="row_<?=$item['id']?>">

      <td><img style="width:100px;" src="<?= site_url('assets/img/vehicle') ."/". $item['img'] ?>"></td>
      <td><?=$item['name']?></td>
      <td><?=$item['vehicle_text']?></td>
      <td><?=$item['year_from']?></td>
      <td>
        <?= $item['year_to']!=0 ? $item['year_to'] : "in production";?>
      </td>
      <td><?=$item['model']?></td>
      <td>
        <div class="btn-group btn-group-justified">
          <a href="vehicle_management/edit/<?=$item['id']?>" class="btn btn-primary">Edit  &nbsp;<i class="fa fa-edit" aria-hidden="true"></i></a>
          <a href="vehicle_management/delete/<?=$item['id']?>" class="btn btn-danger">Delete  &nbsp;<i class="fa fa-times-circle" aria-hidden="true"></i></a>
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
      $('#query').val(n[1]);
      $('#part-form').submit();
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

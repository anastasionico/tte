<? echo count($awaiting_image); ?>

<div class="text-center">
  <h1>Awaiting Image</h1>
  <form id="part-form" action="/<?=$this->uri->segment(1)?>/part_catalog/search" method="post" class="form-search">
    <div class="input-append">
      <input type="text" id="query" name="query" class="input-large" placeholder="Part Number">
      <button type="submit" class="btn">Search</button>
    </div>
  </form>
</div>

<table id="parts-unlisted" class="table table-striped table-hover table-clickrow table-bordered">
  <thead>
    <tr>
      <th>Part Number</th>
      <th>Title</th>
      <th>Price</th>
    </tr>
  </thead>
  <tbody>
  <? foreach($awaiting_image as $part) { ?>
    <tr id="row_<?=$part['pnumber']?>">
      <td><?=$part['pnumber']?></td>
      <td><?=$part['description']?></td>
      <td><?=$part['price_kerridge']?></td>
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

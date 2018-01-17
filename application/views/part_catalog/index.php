<div class="text-center">
  <h1>Parts Catalog</h1>
  <form id="part-form" action="/part_catalog/search" method="post" class="form-search">
    <div class="input-append">
      <input type="text" id="query" name="query" class="input-large" placeholder="Part Number">
      <button type="submit" class="btn">Search &nbsp; <i class="fa fa-search" aria-hidden="true"></i></button>
    </div>
    <a href="#" data-toggle="tooltip" title="Type a missing part number to add it to the catalog" data-placement="right">
      <i class="fa fa-info-circle" aria-hidden="true"></i>
    </a>
  </form>
</div>
<!--
<a href="/<?=$this->uri->segment(1)?>/part_catalog/awaiting_image" class="btn">Awaiting Image</a>
-->
<br><br>

<table id="parts-unlisted" class="table table-striped table-hover table-clickrow table-bordered">
  <thead>
    <tr>
      <th></th>
      <th>Part Number</th>
      <th>Title</th>
      <th>Category</th>
      <th>Date</th>
      <th>Price</th>
      <th>Type</th>
      <th>Ebay</th>
      <th>Offer</th>
      <th>Featured</th>
      <th>Fitment</th>
      <th>Available</th>
      <th>Image</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
  <? foreach($all_items as $item) { 
    // echo "<pre>"; var_dump($all_items )?>
    <tr id="row_<?=$item['pnumber']?>">
      <td>
        <a href="/part_catalog/<?= $item['id'] ?>" class='btn btn-default'>
          Details
        </a>
      </td>  
      <td><?=$item['pnumber']?></td>
      <td>
        <a href="/part_catalog/<?= $item['id'] ?>">
          <?=$item['title']?>
        </a>
      </td>  

      <td><?=$item['category_name']?></td>
      <td style="min-width: 70px;">
      <?php
        $date = new DateTime($item['last_updated']);
        echo $date->format('d-m-y');
      ?>
      </td>
      <td>£<?=$item['price']?></td>
      <td><?=$item['type']?></td>
      <td>
        <?php if( $item['ebay'] == 1): ?>
          <span style='color:green;'>
            Listed 
            <?= ($item['ebay_gsp'] == 1 )? " (GSP) " : "" ; ?>
          </span>
        <?php else: ?>
          no
        <?php endif; ?>
      </td>
      <td>
        <?php if( !is_null($item['offer']) && !is_null($item['homepage'])) : ?>
          <span style='color:green;'>
            £<?= $item['offer']; ?>
            <a href="#" data-toggle="tooltip" title="This item appears in the homepage on <?= $item['homepage']; ?>&#730; position">
              <i class="fa fa-eye" aria-hidden="true"></i>
            </a>
            <?= $item['homepage']; ?>&#730;
          </span>
        <?php elseif( !is_null($item['offer'])): ?>
          <span style='color:green;'>
            £<?= $item['offer']; ?>
          </span>
        <?php else: ?>
          no
        <?php endif; ?>
      </td>
      <td>
        <?php
          echo ($item['featured'] == 1)? "<span style='color:green;'>Yes</span>": "no";    
        ?>
      </td>
      <td>
        <?php
          echo ($item['vehicles_fitted'] < '1')? "<span style='color:red;'>no</span>": "yes";    
        ?>
      </td>
      <td>
        <?= ($item['availability'] == 1)? "in stock": "<span style='color:red;'>not Available</span>";?> 
      </td>
      <td>
        <?= ($item['img'] !== "")? "present": "<span style='color:red;'>not Available</span>";?> 
      </td>
      <td>
        <?= (strlen($item['description']) > 30)? 'Yes ' . strlen($item['description']) : "<span style='color:red;'>Short </span>" . strlen($item['description']);?> 
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
    $('#parts-unlisted').DataTable();
    
  $(".table-clickrow tbody")
    .on("click", "tr", function() {
      var n=$(this).attr('id').split("_");
      console.log(n);
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

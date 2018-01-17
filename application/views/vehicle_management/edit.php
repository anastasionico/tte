<?php
  //echo "<pre>"; print_r($vehicle); echo "</pre>";
?>
<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <h1>Edit <?= ucfirst($vehicle['vehicle_text']) ?></h1>
    <a href="/vehicle_management" class="btn btn-primary">Back  &nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></a></a>
  </div>
</div>
<br><br>

<!--
<a href="/<?=$this->uri->segment(1)?>/part_catalog/awaiting_image" class="btn">Awaiting Image</a>
-->

<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <?php echo form_open_multipart("vehicle_management/edit/$vehicle[id]");?>
      <?php echo validation_errors(); ?>
      <div class="form-group" style="border: 1px solid #ddd;text-align: center">
        <img src="<?= site_url('assets/img/vehicle') ."/". $vehicle['img'] ?>">
        <br>
        <input type="file" name="img" class="btn btn-default"/>
      </div>  
      <br>
      <div class="form-group">
        <label for="manufacturer">Manufacturer:</label>
        <?php
          //echo "<pre>"; print_r($manufacturers);echo "</pre>";
          $options[$vehicle['manufacturer_id']] = $vehicle['name'];
          foreach ($manufacturers as $manufacturer) {
            $options[$manufacturer['id']] = $manufacturer['name'];
          }
          //echo "<pre>"; print_r($options);echo "</pre>";
          echo form_dropdown('manufacturer', $options, 0);

        ?>
      </div>
      <div class="form-group">
        <label for="pwd">Vehicle name</label>
        <?php
          echo form_input(array(
            'name' => 'vehicle_text',
            'value' => ucfirst($vehicle['vehicle_text']),
            'class' => 'form-control'
          ));
        ?>
      </div>
      <div class="form-group">
        <label for="pwd">Start Production</label>
        <?php
          echo form_input(array(
            'name' => 'year_from',
            'class' => 'form-control',
            'value' => $vehicle['year_from'],
            'type' => 'number',
            'min' => '1930',
            'max' => date('Y'),
          ));
        ?>
      </div>
      <div class="form-group">
        <label for="pwd">End Production</label>
        <?php
          echo form_input(array(
            'name' => 'year_to',
            'class' => 'form-control',
            'value' => $vehicle['year_to'],
            'type' => 'number',
            'min' => '1930',
            'max' => date('Y'),

          ));
        ?>
        <a href="#" data-toggle="tooltip" title="Leave the field empty to set still Production" data-placement="right">
          <i class="fa fa-info-circle" aria-hidden="true"></i>
        </a>
      </div>
      <div class="form-group">
        <label for="pwd">Model</label>
        <?php
          echo form_input(array(
            'name' => 'model',
            'value' => ucfirst($vehicle['model']),
            'class' => 'form-control'
          ));
        ?>
      </div>
      <button type="submit" class="btn btn-success">Edit  &nbsp;<i class="fa fa-refresh" aria-hidden="true"></i></button>
    </form>
  </div>
</div>








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

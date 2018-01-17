<?php
  //echo "<pre>"; print_r($orders); echo "</pre>";
?>
<div class="page-header">
  <h1>Orders list</h1>
  
</div>

<table id="users" class="table table-striped table-hover table-clickrow table-bordered">
  <thead>
    <tr>
      <th>Timestam</th>
      <th>Ship to</th>
      <th>Street</th>
      <th>City</th>
      <th>State</th>
      <th>Status</th>
      <th>Email</th>
      <th>Amount</th>
      <th>Paid</th>
      <th>Token</th>
      <th>Marketing</th>
      <th>Dispach</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
  <? foreach($orders as $order) { ?>
    <tr id="row_<?=$order['id']?>">
      <td><?=$order['timestamp']?></td>
      <td><?=$order['shiptoname']?></td>
      <td><?=$order['shiptostreet']?></td>
      <td><?=$order['shiptocity']?></td>
      <td><?=$order['shiptostate']?></td>
      <td><?=$order['addressstatus']?></td>
      <td><?=$order['email']?></td>
      <td><?=$order['amt']?></td>
      <td>
        <?php
          echo ($order['paid'] == 1)? "<span style='color:green;'><i class='fa fa-check' aria-hidden='true'></i> Yes</span>": "no"
        ?>
      </td>
      <td><?=$order['token']?></td>
      <td>
        <?php
          echo ($order['newsLetter'] == 1)? "<span style='color:green;'><i class='fa fa-check' aria-hidden='true'></i>Accepted</span>": "no"
        ?>
      </td>
      <td class="text-center">
        <?php
          if($order['dispatch'] == 0){
        ?>
            <a href="part_order/dispatch/<?=$order['id']?>" class=" confirmation_dispatch btn btn-primary">
              Dispatch  &nbsp;<i class="fa fa-times-circle" aria-hidden="true"></i>
            </a>    
        <?php 
          }else{
            echo "<span style='color:green;'><i class='fa fa-check' aria-hidden='true'></i>".$order['dispatcher']['fullname'].
             " </span>";
          }
        ?>  
      </td>
      <td>
        <div class="btn-group btn-group-justified">
          <!--<a href="part_order/edit/<?=$order['id']?>" class="btn btn-primary">Edit  &nbsp;<i class="fa fa-edit" aria-hidden="true"></i></a>-->
          <a href="part_order/delete/<?=$order['id']?>" class="btn btn-danger">
            Delete  &nbsp;<i class="fa fa-times-circle" aria-hidden="true"></i>
          </a>
          
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


    $('.confirmation_dispatch').click(function(event) {
     var r = confirm("Do you want to dispatch?");
      if(r == true) {
        window.location = $(this).attr('href');
      }
      else {

        event.preventDefault();
        event.stopImmediatePropagation();
      }
    });

  $(".table-clickrow tbody")
    .on("click", "tr", function() {
      var n=$(this).attr('id').split("_");
      window.location = '/<?=$this->uri->segment(1)?>/'+ n[1];
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

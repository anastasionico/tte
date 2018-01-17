<div class="jumbotron_mini" id="hero_img"  style="padding-top: 0px;margin-bottom: 0px;">
  <?php
    $this->load->view('template/navigation.php');
  ?>
  <div class="Jumbotron_container">
    <h1>Truck Trailer Equipment</h1> 
    <p>No. 1 for makes of truck and trailer parts</p> 
  </div>
</div>
<div class="row checkout_content">
  <h1>Your Cart</h1>  
  <h4>
    <i class="fa fa-truck" aria-hidden="true"></i>
    Free delivery 2-3 Days
  </h4>
  <div class="checkout_div">
    <form method="post" accept-charset="utf-8" action="/checkout/process" id="basketform" enctype="multipart/form-data" class="form-horizontal" role="form">
        <div class="page-header"></div>
        <div class="row">
          <div class="pull-right">
            <label for="newsLetter">Consent to receive details on latest offers</label>
            <input type="checkbox" name="newsLetter">
          </div>
        </div>
        <div class="row">  
          <div class="pull-right">
            <label for="fastDelivery">Fast Delivery – 1-2 Days ( +£7.90 ) </label>
            <input type="checkbox" name="fastDelivery" id='fastDeliveryCheckbox' onclick='fastDeliveryAdd()'>
          </div>
          <table class="table table-striped">
              <thead>
                  <tr>
                    <th>QTY</th>
                    <th>Item Description</th>
                    <th style="text-align:right">Item Price</th>
                    <th style="text-align:right">Sub-Total</th>
                  </tr>
              </thead>
              <tbody>
                  <?php $i = 1; ?>
                  <?php foreach ($this->cart->contents() as $items):?>
                  <tr>
                    <td>
                      <input type="hidden" name="<?php echo 'id_' . $i ?>" value="<?php echo $items['id'] ?>">
                      <input type="hidden" name="<?php echo 'row_' . $i ?>" value="<?php echo $items['rowid'] ?>">
                      <input type="text" name="<?php echo 'qty_' . $i ?>" value="<?php echo $items['qty']?>" maxlength="3" size="5" class="quantity form-control">
                        <?php
                          /*
                          echo form_hidden('id_' . $i, $items['id']);
                          echo form_hidden('row_' . $i, $items['rowid']);
                          echo form_input(array('name' => 'qty_' . $i, 'value' => $items['qty'], 'maxlength' => '3', 'size' => '5', 'class' => 'quantity form-control')); 
                          */
                        ?>
                    </td>
                    <td>
                        <?php echo $items['name']; ?>
                        <?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>
                        <? $options = $this->cart->product_options($items['rowid']); ?>
                        <? if(isset($options['pnumber'])) { ?>
                          <br><?=$options['pnumber']?>
                          <? } ?>
                          <? if(isset($options['vehicle_title'])) { ?>
                          <br><?=$options['vehicle_title']?>
                        <? } ?>
                        <?php endif; ?>
                    </td>
                    <td class="text-right"><?php echo $this->cart->format_number($items['price']); ?></td>
                    <td class="text-right">&#163;<?php echo $this->cart->format_number($items['subtotal']); ?></td>
                  </tr>
                  <?php $i++; ?>
                  <?php endforeach; ?>
              </tbody>
              <tfoot>
                  <tr>
                    <td colspan="2">
                      <input type="hidden" name="update" value="0">
                      <button id="update_cart" type="submit" class="btn btn-details btn-sm">Update Quantities</button>
                    </td>
                    <td class="text-right"><strong>VAT</strong></td>
                    <td class="text-right">
                      &#163;<?php
                      $vat = $this->cart->total() * $this->config->item('vat');
                      $total_inc = $this->cart->total() + $vat;
                      echo $this->cart->format_number($vat); ?>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2"></td>
                    <td class="text-right"><strong>Total</strong></td>
                    <td class="text-right"  id="total_inc">&#163;<?php echo $this->cart->format_number($total_inc); ?></td>
                  </tr>
              </tfoot>
          </table>
        </div>
        <div class="row">
          <span class="col-xs-12 col-sm-12 text-right">
            <input type="submit" value="Pay Now" class="btn btn-ghost-full btn-large">
          </span>
        </div>
        <div class="row">
          <a href="<?= site_url('contact#contact_form')?>" class="btn-ghost ">Send Enquiry</a>
          &nbsp;&nbsp;&nbsp;&nbsp;
          <?php
            $httpReferer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
          ?>
          <a href="<?= $httpReferer; ?>">Continue Shopping</a>
        </div>
        
    </form>
  </div>
</div>
<section class="row one_side mailing_list bg_tertiary" >
  <h1>Join our Mailing List</h1>
  <p>Join Our Mailing List
    Get all the latest prices and deals first! Simply enter your details in the boxes and press submit.
  </p>
  <form method="POST" action="<?php echo site_url('/') ?>">
    <div class="input-group">
      <input type="email" class="form-control" name="SignUpMessage" placeholder="your@email.co.uk">

      <span class="input-group-addon">
        <input type="submit" name="Subscribe" value="Subscribe">
      </span>
    </div>
  <?php
    if(isset($_POST["SignUpMessage"])) {
      $message = "The user with email " . $_POST["SignUpMessage"] . " just sign up to the TTE work";  
      mail("sales@trucktrailerequip.co.uk", "Form to email message", $message, "From: noreplay@sbcommercials.co.uk");
    }
  ?>
</section> 

<div class="row one_side enquiryDiv" >
  <h1>Enquiries</h1>
  <div class="enquiryDiv--div">
    <span class="enquiryDiv--div--span">
      <p>
        If you need parts anywhere in the UK, you can rely on Truck & Trailer Equipment. Call us to discuss your needs.
      </p>
    </span>
    <a href="/enquiry">
      Send us an enquiry
      <br>
      <i class="fa fa-question-circle-o" aria-hidden="true"></i>
    </a>
  </div>
</div> 
        

<script type="text/html" id="basketpart">
  <% var linetotal = Number(price) * Number(qty); %>
  <tr>
    <td></td>
    <td>
      <div class="ptitle"><h4><%=title%></h4></div>
      <div class="pnumber"><%=part_no%></div>
      <div></div>
    </td>
    <td style="width:75px;">
      <input type="text" name="<%=id%>" value="<%=qty%>" style="width:70px;text-align: right;" class="quantity form-control">
    </td>
    <td><a href="#" class="checkout-delete"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></a></td>
    <td class="text-right">
      £<%=price.toFixed(2)%>
    </td>
    <td class="text-right">
      £<span class="pprice"><%=linetotal.toFixed(2)%></span>
    </td>
  </tr>
</script>
<script src="/assets/js/jquery.js"></script>
<script src="/assets/js/jquery.mixitup.min.js"></script>
<script src="/assets/js/parts.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    loadSessionBasket();
  });
  function fastDeliveryAdd() {
    if(document.getElementById('fastDeliveryCheckbox').checked) {
      var table = document.getElementsByTagName("table")[0];
    
      var row = table.insertRow(1);
      var cell0 = row.insertCell(0);
      var cell1 = row.insertCell(1);
      var cell2 = row.insertCell(2);
      var cell3 = row.insertCell(3);
      cell3.className = 'text-right';
      cell1.innerHTML = "Fast Delivery";
      cell3.innerHTML = "£7.90";
      <?php 
        $total_inc = $this->cart->format_number($total_inc);
        $total_inc = $total_inc + 7.90 ; 
      ?>
      document.getElementById('total_inc').innerHTML = <?= $total_inc ?> ;
      //alert()
    } else {
      var table = document.getElementsByTagName("table")[0];
      var row = table.deleteRow(1);
      <?php 
        $total_inc = $total_inc - 7.90 ; 
      ?>
      document.getElementById('total_inc').innerHTML = <?= $total_inc ?> ;
    }
  }
</script>



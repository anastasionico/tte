<style type="text/css">
  table td, table th{
    border: 1px solid black;
    padding: 1em
  }

</style>
This is the index of the checkout page
<br>





<form method="post" accept-charset="utf-8" action="/trucks/process" id="basketform" enctype="multipart/form-data" class="form-horizontal" role="form">
  	<div class="page-header">
    	<h1>Checkout</h1>
  	</div>
	<div class="row">
        <div class="col-xs-12">
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
                  	<?php foreach ($this->cart->contents() as $items):
                     
                    ?>

                    <tr>
                    	<td>
                      		<?php echo form_hidden('id_' . $i, $items['id']); ?>
                          <?php echo form_hidden('row_' . $i, $items['rowid']); ?>
                      		<?php echo form_input(array('name' => 'qty_' . $i, 'value' => $items['qty'], 'maxlength' => '3', 'size' => '5', 'class' => 'quantity form-control')); ?>
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
	                      <button id="update_cart" type="button" class="btn btn-details btn-sm">Update Quantities</button>
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
	                    <td class="text-right">&#163;<?php echo $this->cart->format_number($total_inc); ?></td>
	                  </tr>
            	</tfoot>
          	</table>
		</div>
  	</div>
	<div class="row">
        <div class="col-xs-6 text-right">
	        <input type="submit" value="Submit" class="btn btn-details">
        </div>
    </div>
</form>


<h1><a href="<?= site_url('contact#contact_form')?>">Send us an enquiry</a></h1>
<script src="/assets/js/jquery.js"></script>
<script src="/assets/js/jquery.mixitup.min.js"></script>
<script src="/assets/js/parts.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    loadSessionBasket();
  });
</script>

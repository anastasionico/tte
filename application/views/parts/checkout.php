<div class="container">
  <div class="box-padded box-white">
    <? if($this->session->flashdata('error')) { ?>
        <div class="alert alert-danger">
            <?=$this->session->flashdata('error')?>
            <? //print_r($this->session->flashdata('error_fields')); ?>
        </div>
    <? } ?>
    <div class="row">
      <div class="col-xs-12">
        <form method="post" accept-charset="utf-8" action="/<?=$this->uri->segment(1)?>/process" id="basketform" enctype="multipart/form-data" class="form-horizontal" role="form">
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
                  <?php foreach ($this->cart->contents() as $items): ?>
                  <tr>
                    <td>
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
            <div class="col-sm-6">
              <div class="form-group">
                <label for="reg" class="col-md-4 control-label">Vehicle Registration</label>
                <div class="col-md-8">
                  <input type="text" name="reg" id="reg" class="form-control" maxlength="10" value="">
                </div>
              </div>
              <div class="form-group required">
                <label for="CustomerEmail" class="col-md-4 control-label">Email</label>
                <div class="col-md-8">
                  <input type="text" name="CustomerEmail" id="CustomerEmail" class="form-control" maxlength="255" value="">
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6">
              <h2>Your Billing Details</h2>
              <div class="form-group required">
                <label for="BillingFirstnames" class="col-md-4 control-label">First Name(s)</label>
                <div class="col-md-8">
                  <input type="text" name="BillingFirstnames" id="BillingFirstnames" class="form-control" maxlength="20" value="">
                </div>
              </div>
              <div class="form-group required">
                <label for="BillingSurname" class="col-md-4 control-label">Surname</label>
                <div class="col-md-8">
                  <input type="text" name="BillingSurname" id="BillingSurname" class="form-control" maxlength="20" value="">
                </div>
              </div>
              <div class="form-group required">
                <label for="BillingAddress1" class="col-md-4 control-label">Address Line 1</label>
                <div class="col-md-8">
                  <input type="text" name="BillingAddress1" id="BillingAddress1" class="form-control" maxlength="100" value="">
                </div>
              </div>
              <div class="form-group">
                <label for="BillingAddress2" class="col-md-4 control-label">Address Line 2</label>
                <div class="col-md-8">
                  <input type="text" name="BillingAddress2" id="BillingAddress2" class="form-control" maxlength="100" value="">
                </div>
              </div>
              <div class="form-group required">
                <label for="BillingCity" class="col-md-4 control-label">City</label>
                <div class="col-md-8">
                  <input type="text" name="BillingCity" id="BillingCity" class="form-control" maxlength="40" value="">
                </div>
              </div>
              <div class="form-group required">
                <label for="BillingPostCode" class="col-md-4 control-label">Postcode</label>
                <div class="col-md-8">
                  <input type="text" name="BillingPostCode" id="BillingPostCode" class="form-control" maxlength="10" value="">
                </div>
              </div>
              <div class="form-group">
                <label for="BillingCountry" class="col-md-4 control-label">Country</label>
                <div class="col-md-8">
                  <select name="BillingCountry" id="BillingCountry" class="form-control">
                    <option value="GB" selected="selected">United Kingdom</option>
                  </select>
                </div>
              </div>
              <div class="form-group required">
                <label for="BillingPhone" class="col-md-4 control-label">Phone</label>
                <div class="col-md-8">
                  <input type="text" name="BillingPhone" id="BillingPhone" class="form-control" maxlength="20" value="">
                </div>
              </div>

            </div>
            <div class="col-sm-6">


              <h2>Delivery Details</h2>


              <div class="checkbox checkbox-padded">
                <label>
                  <input name="IsDeliverySame" type="checkbox">
                  Same as Billing Details
                </label>
              </div>

              <div class="form-group required">
                <label for="DeliveryFirstnames" class="col-md-4 control-label">First Name(s)</label>
                <div class="col-md-8">
                  <input type="text" name="DeliveryFirstnames" id="DeliveryFirstnames" class="form-control" maxlength="20" value="">
                </div>
              </div>
              <div class="form-group required">
                <label for="DeliverySurname" class="col-md-4 control-label">Surname</label>
                <div class="col-md-8">
                  <input type="text" name="DeliverySurname" id="DeliverySurname" class="form-control" maxlength="20" value="">
                </div>
              </div>
              <div class="form-group required">
                <label for="DeliveryAddress1" class="col-md-4 control-label">Address Line 1</label>
                <div class="col-md-8">
                  <input type="text" name="DeliveryAddress1" id="DeliveryAddress1" class="form-control" maxlength="100" value="">
                </div>
              </div>
              <div class="form-group">
                <label for="DeliveryAddress2" class="col-md-4 control-label">Address Line 2</label>
                <div class="col-md-8">
                  <input type="text" name="DeliveryAddress2" id="DeliveryAddress2" class="form-control" maxlength="100" value="">
                </div>
              </div>
              <div class="form-group required">
                <label for="DeliveryCity" class="col-md-4 control-label">City</label>
                <div class="col-md-8">
                  <input type="text" name="DeliveryCity" id="DeliveryCity" class="form-control" maxlength="40" value="">
                </div>
              </div>
              <div class="form-group required">
                <label for="DeliveryPostCode" class="col-md-4 control-label">Postcode</label>
                <div class="col-md-8">
                  <input type="text" name="DeliveryPostCode" id="DeliveryPostCode" class="form-control" maxlength="10" value="">
                </div>
              </div>
              <div class="form-group">
                <label for="DeliveryCountry" class="col-md-4 control-label">Country</label>
                <div class="col-md-8">
                  <select name="DeliveryCountry" id="DeliveryCountry" class="form-control">
                    <option value="GB" selected="selected">United Kingdom</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="DeliveryPhone" class="col-md-4 control-label">Phone</label>
                <div class="col-md-8">
                  <input type="text" name="DeliveryPhone" id="DeliveryPhone" class="form-control" maxlength="20" value="">
                </div>
              </div>

            </div>
          </div>

          <div class="row">
            <div class="col-xs-6">
              <i>All prices exclude VAT</i>
            </div>
            <div class="col-xs-6 text-right">
              <input type="submit" value="Submit" class="btn btn-details">
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
<script src="/assets/js/parts.js"></script>

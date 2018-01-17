<div class="container">
  <div class="box-padded box-white">
    <div id="part_list" class="row">
      <div class="col-xs-12">

        <div id="part_<?=$part['id']?>" class="partproduct">
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6">
              <?
              // needs removing
              $filename = $this->config->item('dir_local') . "/inc/img/parts/l/" . $part['pnumber'] . "_L.jpg";
              if(file_exists($filename)) {
                  echo "<img class='img-responsive nocopy' src='/inc/img/parts/l/" . $part['pnumber'] . "_L.jpg' />";
              }
              else {
                  echo "<img src='/inc/img/parts/_none.jpg' class='img-responsive' />";
              }
              ?>
            </div>
            <div class="col-xs-12 col-sm-6">
              <h1 class="ptitle"><?=$part['title']?></h1>
              <p><span class="pdescription"><? if(! empty($part['description'])) { ?><?=$part['description']?><br><? } ?></span></p>
              <b>Fits Vehicles</b>
              <!-- fits vehicle -->
              <? 
              $last_vehicle = '';
              foreach($part['vehicles'] as $vehicle) {
                if($last_vehicle != $vehicle['vehicle_text']) {
                  if($last_vehicle == '') { //first loop
                    ?>
              <div class="vehicle-group">
                    <? } else { ?>
                </ul>
              </div>
              <div class="vehicle-group">
                    <? } ?>
                <div class="vehicle-label" for="inputm<?=$vehicle['vehicle_vin']?>"><?=$vehicle['vehicle_text']?></div>
                <ul class="vehicle-models">
                  <?
                  } // end last vehicle != current
                  ?>
                  <li>
                    <?=$vehicle['model']?>
                  </li>
                  <?
                  $last_vehicle = $vehicle['vehicle_text'];
                  $last_vehicle_vin = $vehicle['vehicle_vin'];
                  } // foreach vehicle
               ?>
                </ul>
              </div>
              <!-- /fits vehicle -->
              <table class="table">
                <tr>
                  <td>Part Number</td>
                  <td>
                    <span class="pnumber"><?=$part['pnumber']?></span><br>
                  </td>
                </tr>
                <? if(! empty($part['group']['name'])) { ?>
                <tr>
                  <td>Category</td>
                  <td>
                    <span class="pnumber"><?=$part['group']['name']?></span><br>
                  </td>
                </tr>
                <? } ?>
                <tr>
                  <td>Price (excluding VAT)</td>
                  <td>
                    £<span class="pprice"><?=$part['price']?></span>
                  </td>
                </tr>
                <tr>
                  <td>Price (including VAT)</td>
                  <td>
                    £<span class="pprice"><?=$part['price_vat']?></span>
                  </td>
                </tr>
                <tr>
                  <td>Postage</td>
                  <td>
                    FREE
                  </td>
                </tr>
              </table>
              <div class="well">
                <form class="form-inline cart" role="form">
                  <label for="qty">QTY:</label>
                  <input type="text" name="qty" value="1" class="quantity form-control">
                  <input type="submit" name="my-add-button" value="Add ›" class="btn btn-details">
                </form>
              </div>
            </div><!--/.col-->
          </div><!--/.row-->
        </div><!--.partproduct-->
        <? /*

        [id]
        [pnumber]
        [title]
        [description]
        [price]
        [oldprice]
        [group]
        [last_updated]
        [last_updated_by]

        */ ?>
      </div>
    </div>
  </div>
</div>

<div id="scroll-basket" class="container">
  <div class="box-padded box-white">
    <div class="row">
      <div class="col-xs-12">
        <form method="post" accept-charset="utf-8" action="/<?=$this->uri->segment(1)?>/checkout" id="basketform" onSubmit="return validateForm(this)">
          <table id="part_basket" class="table table-striped">
            <thead>
              <tr>
                <th>QTY</th>
                <th>Item Description</th>
                <th>Item Price</th>
                <th class="text-right">Sub-Total</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td colspan="4"><i>There are currently no items in the basket.</i></td>
              </tr>
            </tbody>
            <tfoot>
<?/*
              <tr>
                <td colspan="2">&nbsp;</td>
                <td class="text-right">NET</td>
                <td class="text-right"><div id="total-net"></div></td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
                <td class="text-right">DELIVERY</td>
                <td class="text-right"><div id="total-delivery"></div></td>
              </tr>
*/?>
              <tr>
                <td colspan="2">&nbsp;</td>
                <td class="text-right">TOTAL</td>
                <td class="text-right"><div id="total-total"></div></td>
              </tr>
            </tfoot>
          </table>
          <div class="text-right">
            <input type="submit" value="Order" class="btn btn-details" id="finalorderbutton">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/html" id="basketpart">
  <% var linetotal = Number(price) * Number(qty); %>
  <tr>
    <td><input type="text" name="<%=id%>" value="<%=qty%>" class="quantity form-control"></td>
    <td>
      <div class="ptitle"><%=title%></div>
      <div class="pnumber"><%=part_no%></div>
      <div><a href="#" class="btn btn-danger btn-xs checkout-delete">Delete</a></div>
    </td>
    <td><%=price.toFixed(2)%></td>
    <td class="text-right">
      £<span class="pprice"><%=linetotal.toFixed(2)%></span>
    </td>
  </tr>
</script>
<script src="/assets/js/jquery.mixitup.min.js"></script>
<script src="/assets/js/parts.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    loadSessionBasket();
  });
</script>

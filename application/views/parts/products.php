<div id="scroll-basket" class="container">
  <div class="box-padded box-white">
    <div class="row">
      <div class="col-xs-12">
        <div class="page-header">
          <h2>Basket - UK Wide Free Delivery</h2>
        </div>
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
<div class="container">
  <div class="box-padded box-white">
    <div class="row">
      <div class="col-xs-12">
        <div class="page-header">
          <h2>Mercedes-Benz Parts</h2>
        </div>
        <div class="well">
          <ul id="select-groups">
            <li class="filter active" data-filter="all">All</li>
            <? foreach($groups as $group) { ?>
            <li class="filter" data-filter="group-<?=$group['addr']?>" data-order="desc"><?=$group['name']?></li>
            <? } ?>
          </ul>
        </div>
      </div>
    </div>
    <div id="part_list" class="row">
      <? $i = 0; foreach($parts as $part) { $i++;?>
      <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 mix group-<?=$part['group_addr']?> mix_all">
        <div id="part_<?=$part['id']?>" class="partproduct">

          <? if($this->uri->segment(2) == 'accessories') { ?>
          <a href="/<?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/<?=$part['id']?>-<?=url_title($part['title'], '_', TRUE)?>">
          <? } else { ?>
          <a href="/<?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/<?=$this->uri->segment(3)?>/<?=$part['id']?>-<?=url_title($part['title'], '_', TRUE)?>">
          <? } ?>
            <?
            // needs removing
            $filename = $this->config->item('dir_local') . "/inc/img/parts/m/" . $part['pnumber'] . "_M.jpg";
            if(file_exists($filename)) {
                echo "<img class='img-responsive nocopy' src='/inc/img/parts/m/" . $part['pnumber'] . "_M.jpg' />";
            }
            else {
                echo "<img src='/inc/img/parts/_none.jpg' class='img-responsive' />";
            }
            ?>
          </a>

          <div class="pull-left">
            <span class="ptitle"><?=$part['title']?></span><br>
            <span class="pnumber"><?=$part['pnumber']?></span><br>
          </div>
          <div class="pull-right text-right">
            £<span class="pprice"><?=$part['price']?></span>
          </div>
          <div class="clearfix"></div>
          <div class="text-right">
            <form class="form-inline cart" role="form">
              <label for="qty">QTY:</label>
              <input type="text" name="qty" value="1" class="quantity form-control">
              <input type="submit" name="my-add-button" value="Add ›" class="btn btn-details">
            </form>
          </div>
        </div>
      </div>
      <? if($i % 4 == 0) { ?><div class="clearfix visible-lg"></div><? } ?>
      <? if($i % 3 == 0) { ?><div class="clearfix visible-md"></div><? } ?>
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
      <? } ?>
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

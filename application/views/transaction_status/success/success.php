<? if(isset($order)) { ?>

<script>
dataLayer.push({
  'ecommerce' : {
    'purchase' : {
      'actionField' : {
        'id' : '<?=$order['id']?>',
        'revenue' : '<?=$order['Amount']?>'
      },
      'products' : [<? foreach($order['items'] as $key => $item) { if($key != 0) { echo ','; } ?>{
        'id' : '<?=$item['part_id']?>',
        'name' : '<?=$item['title']?>',
        'price' : '<?=$item['price']?>',
        'quantity' : <?=$item['quantity']?>
      }<? } ?>]
    }
  },
  'event' : 'transactionComplete' 
});  
</script>

<? } ?>
<link rel="stylesheet" href="/inc/css/service.css" type="text/css">
<div id="main">
  <div class="section">
    <h1>Payment Success</h1>
    <p>Your payment was a success. This page is confirmation we have recieved your order and will process it as soon as possible.</p>
    <?php if (isset($VendorTxCode)): ?>
    <p>Your order reference number is <?php echo $VendorTxCode; ?>. An email containing your order details should arrive shortly.</p>
    <?php endif; ?>
  </div>
</div>

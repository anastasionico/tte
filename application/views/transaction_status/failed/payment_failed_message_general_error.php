<link rel="stylesheet" href="/inc/css/service.css" type="text/css">
<div id="main">
  <div class="section">
    <h1>Payment Failed</h1>
    <p><strong>There seems to be a problem with your payment. Your card has not been charged.</strong></p>
    <p>Please try making another payment, or contact us.</p>
    <?php if (isset($VendorTxCode)): ?>
    <p>Please quote the reference number: <?php echo $VendorTxCode; ?></p>
    <?php endif; ?>
  </div>
</div>

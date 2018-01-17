<?php
	//echo "<pre>";print_r($order);echo "</pre>";
?>
<div class="page-header">
  <h1>Items</h1>
</div>
<a href="/part_order" class=" btn btn-primary">
  Back
</a>
<br><br><br>
<table class="table table-striped table-bordered">
    <tr>
      	<th>Ship to</th>
     	<td><?=$order['shiptoname']?></td>
    <tr>
    	<th>Street</th>
    	<td><?=$order['shiptostreet']?></td>
    </tr>  
    <tr>
    	<th>City</th>
    	<td><?=$order['shiptocity']?></td>
    </tr>    
    <tr>
    	<th>State</th>
    	<td><?=$order['shiptostate']?></td>
    </tr>    
    <tr>
    	<th>Country</th>
    	<td><?=$order['shiptocontryname']?> | <?=$order['shiptocountrycode']?></td>
    </tr>    
    <tr>
    	<th>Currency</th>
    	<td><?=$order['currencycode']?></td>
    </tr>    
    <tr>
    	<th>Email</th>
    	<td><?=$order['email']?></td>
    </tr>    
    <tr>
    	<th>Amount</th>
    	<td><?=$order['amt']?></td>
    </tr>    
    <tr>
    	<th>Paid</th>
    	<td>
    		<?php
	          echo ($order['paid'] == 1)? "<span style='color:green;'><i class='fa fa-check' aria-hidden='true'></i> Yes</span>": "no"
	        ?>
    	</td>
    </tr>    
</table>
<table class="table table-striped table-bordered">
	<tr>
		<td>Id</td>
		<td>Order Id</td>
		<td>Name</td>
		<td>Price</td>
		<td>Quantity</td>
		<td>Item Id</td>
		<td>Subtotal</td>
	</tr>
	<?php
		foreach ($order['items'] as $items) {
			echo "<tr>";	
			foreach ($items as $items) {
                if($items === 'Fast Delivery'){
                    echo "<td style='background-color:#238c54;'><i class='fa fa-truck' aria-hidden='true'></i> " . $items . "</td>";    
                    continue;
                }
                echo "<td>" . $items . "</td>";
			}
			echo "</tr>";
		}
	?>
</table>	

 


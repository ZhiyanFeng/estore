<h2>Cart</h2>
	
<?php 
	echo "<p>";
	echo form_open('store/catalogue');
	
	// the table
	echo "<p> Your order: </p>\n";
	echo "<table>";
	echo "<tr><th>Name</th><th>Price</th><th>Quantity</th><th>Subtotal</th></tr>\n";
	$total = 0;
	foreach($order_items as $key=>$value){
			if ($value > 0){
				$product = new Product();
				$product = $this->product_model->get($key);
				echo "<tr><td>" . $product->name . "</td>";
				echo "<td name='price'>" . $product->price . "</td>";
				echo "<td>";
				echo "$value";
				echo "</td>";
				echo "<td id='subtotal'>".$value*floatval($product->price)."</td>";
				echo "</tr>\n";
				$total += $value*floatval($product->price);
			}	
	}
	
	echo "<tr><th colspan='3'>Total</th><td id='total'>".$total."</td></tr>\n";
	echo "</table><br>\n";
	echo form_hidden('total',$total);
	echo form_submit('submit', 'Save and Continue Shopping')."\n";
	echo form_submit('submit', 'Checkout')."\n";
	echo form_close()."<br>";
	
?>
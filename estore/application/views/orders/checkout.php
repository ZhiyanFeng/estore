<h2>Checkout</h2>
<?php

echo form_open('store/checkout')."\n";

echo "<p>" . anchor ( "store/catalogue", 'Cancel Order', "onClick='return confirm(\"Do you really want to cancel this order?\");'" ) . "</p>\n";

echo "<table>";
echo "<tr><th>Name</th><th>Price</th><th>Quantity</th><th>Subtotal</th></tr>\n";
$total = 0;
foreach ( $order_items as $key=>$value) {
		if ($value > 0){
			$product = new Product();
			$product = $this->product_model->get($key);
			echo "<tr><td>" . $product->name ."</td>";
			echo "<td>" . $product->price ."</td>";
			echo "<td>" . $value . "</td>";
			echo "<td>" . $value * floatval($product->price) . "</td>";
			echo "</tr>\n";
			$total += $value*floatval($product->price);
		}
}
		
		echo "<tr><th colspan='3'>Total</th><td>".$total."</td></tr>\n";
		echo "</table><br>\n";
		echo "<p>Bill to {$customers['first']}</p>";
		echo form_hidden('total',$total);
		
		// By default the billing email is the one the customer registered with,
		// but he can choose to provide a different one via this form (if valid).
		echo form_label('Email')."\n";
		echo form_input('email',$customers['email'])."\n<br><br>";
	   	
	   	// Credit card info
		echo form_label('Credit Card Number')."\n";
		echo form_input('creditcard_number')."\n";
	    
	    // Don't show the error if this is the first checkout attempt
		if (!isset($submit) || $submit!="Checkout"){
			echo form_error('creditcard_number')."\n";
		}
		echo "<br><br>";
		echo form_label('Expiry Month (MM)')."\n";
		echo form_input('creditcard_month')."\n";
		if (!isset($submit) || $submit!="Checkout"){
			echo form_error('creditcard_month')."\n";
		}
		echo "<br><br>";
		echo form_label('Expiry Year (YY)')."\n";
		echo form_input('creditcard_year')."\n";
		if (!isset($submit) || $submit!="Checkout"){
			echo form_error('creditcard_year')."\n";
		}	
		echo "<br><br>";
		echo form_submit('submit', 'Finish and Pay')."\n";
		echo form_close()."<br>";
?>	
<h2> Estore </h2>

<?php 
	
	echo form_open('store/catalog') . "\n";
	echo "<p>Welcome!</p>\n";
	echo "<p>Catalog of our available products";
	echo "<table>";
	echo "<tr><th>Prouct Name</th><th>Description</th><th>Price</th><th>Photo</th><th>Quantity</th><th>Subtotal</th></tr>\n";

	foreach($products as $product){
		echo "<tr>";
		echo "<td>".$product->name."</td>\n";
		echo "<td>".$product->description."</td>\n";
		echo "<td name='price'>". $product->price."</td>\n";
		echo "<td><img src='".base_url()."images/product/".$product->photo_url.
			"' width='100px'/></td>\n";
		echo "<td><input type='number' size='5' name='{$product->id}'/>"."</td>";
		echo "<td id='subtotal'>"."</td>"; // need to calculate subtotal
		echo "</tr>\n";
	}
	
	echo "<tr><th colspan='5'>Total</th><td id='total' ></td></tr>\n";
	
	echo "</table><br>\n";
	echo form_hidden('total','');
	echo form_error('total')."\n";
	echo form_submit('submit', 'Add to Cart')."\n";
	echo form_submit('submit', 'View/Edit Cart')."\n";
	echo form_close()."<br>";
?>
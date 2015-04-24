<h2>Product Table</h2>
<?php 
		echo "<p>" . anchor('store/newProductForm','Add New') . "</p>";
		echo "<p>" . anchor("store/deleteAllProduct",'Delete all',"onClick='return confirm(\"Do you really want to delete all records?\");'") . "</p>";
		
		echo "<table>";
		echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Photo</th></tr>";
		
		foreach ($products as $product) {
			echo "<tr>";
			echo "<td>" . $product->name . "</td>";
			echo "<td>" . $product->description . "</td>";
			echo "<td>" . $product->price . "</td>";
			echo "<td><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px' /></td>";
				
			echo "<td>" . anchor("store/deleteProduct/$product->id",'Delete',"onClick='return confirm(\"Do you really want to delete this record?\");'") . "</td>";
				
			echo "<td>" . anchor("store/editForm/$product->id",'Edit') . "</td>";
			echo "<td>" . anchor("store/read/$product->id",'View') . "</td>";
				
			echo "</tr>\n";
		}
		echo "<table><br>";
?>	

<h2>Orders Table</h2>
<?php
echo "<p>" . anchor ( "store/deleteAllOrders", 'Delete All', "onClick='return confirm(\"Do you really want to delete all customer?\");'" ) . "</p>\n";
echo "<table>";
echo "<tr><th>Customer</th><th>Date</th><th>Time</th><th>Total</th></tr>";
foreach ( $orders as $order ) {
		echo "<tr>";
		
		foreach ($customers as $customer){
			if ($customer->id == $order->customer_id){
				echo "<td>" . $customer->first . " " . $customer->last . "</td>";
			}
		}
		
		echo "<td>" . $order->order_date . "</td>";
		echo "<td>" . $order->order_time . "</td>";
		echo "<td>" . $order->total . "</td>";
		
		echo "<td>" . anchor ( "store/deleteOrder/$order->id", 'Delete', "onClick='return confirm(\"Do you really want to delete this customer?\");'" ) . "</td>\n";
		
		echo "</tr>\n";
}
echo "<table><br>";

?>	
<?php include($_SERVER['DOCUMENT_ROOT'].'/estore/application/views/pages/bottom.php');?>
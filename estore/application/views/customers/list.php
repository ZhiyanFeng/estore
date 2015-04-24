<h2>Customer Table</h2>
<?php
echo "<p>" . anchor ( "store/deleteAllCustomers", 'Delete All', "onClick='return confirm(\"Do you really want to delete all customer?\");'" ) . "</p>\n";
echo "<table>";
echo "<tr><th>First Name</th><th>Last Name</th><th>Login</th><th>Email</th></tr>";
foreach ( $customers as $customer ) {
	if ($customer->login != 'admin') {
		echo "<tr>";
		echo "<td>" . $customer->first . "</td>";
		echo "<td>" . $customer->last . "</td>";
		echo "<td>" . $customer->login . "</td>";
		echo "<td>" . $customer->email . "</td>";
		
		echo "<td>" . anchor ( "store/deleteCustomer/$customer->id", 'Delete', "onClick='return confirm(\"Do you really want to delete this customer?\");'" ) . "</td>\n";
		
		echo "</tr>\n";
	}
}
echo "<table><br>";
?>	
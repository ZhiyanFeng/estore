<?php include($_SERVER['DOCUMENT_ROOT'].'/estore/application/views/pages/top.php');?>


<h2> Receipt </h2>
<?php 
	
	$config = Array (
		'protocol' => 'smtp',
		'smtp_host' => 'ssl://smtp.gmail.com',
		'smtp_port' => 465,
		'smtp_user' => 'csc309A3vish@gmail.com',
		'smtp_pass' => 'csc309A3',
		'mailtype' => 'html',
		'charset' => 'utf-8',
		'smtp_timeout' => '4',
		'wordwrap' => TRUE
	);

	$this->load->library('email');
	$this->email->initialize($config);
	$this->email->set_newline("\r\n");
	
	$customer = $this->session->userdata("loggedinCustomer");
	
	// Order summary
	$receipt = "<p>Order data and time: " . date('Y-m-d H:i:s') . "</p>";
	$receipt = $receipt . "<p>Billed to: " . $customer['first'] . "</p>";
	$receipt = $receipt . "<p>Billing Email: " . $customer['email'] . "</p>";
	$receipt = $receipt . "<p>Credit card: *********-" .substr($orders['creditcard_number'], -4) . "</p>";
	$receipt = $receipt. "<table>";
	$receipt = $receipt . "<tr><th>Name</th><th>Price</th><th>Quantity</th><th>Subtotal</th></tr>";
	$total = 0;
	foreach ($order_items as $key=>$value){
		if ($value > 0){
			$product = new Product();
			$product = $this->product_model->get($key);
			$receipt = $receipt . "<tr><td>" . $product->name . "</td>";
			$receipt = $receipt . "<td>" . $product->price . "</td>";
			$receipt = $receipt . "<td>" . $value . "</td>";
			$receipt = $receipt . "<td>" . $value * floatval($product->price). "</td>";
			$receipt = $receipt . "</tr>\n";
			$total += $value*floatval($product->price);
		}
	} 
	
	$receipt = $receipt ."<tr><th colspan='3'>Total</th><td>".$total."</td></tr>\n";
	$receipt = $receipt . "</table><br>\n";
	
	echo $receipt;
	echo "<p><a href=# onclick='window.print();return false;'>Print Receipt</a></p>";
	echo anchor('store/catalogue', 'Back to Store');
	
	$this->email->from('csc309A3vish@gmail.com', 'admin');
	$this->email->to($this->input->post('email'));
	$this->email->subject('Receipt: estore');
	$this->email->message($receipt);
	$this->email->send();
?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/estore/application/views/pages/bottom.php');?>
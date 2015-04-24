
<div id="container">
	<h1>Estore signup</h1>
	
<?php 
	
	
	//using functions provided in form_helper.php
	
	
	echo"<p>";
	echo form_open('store/signup_validation');
	echo"</p>";
	
	echo validation_errors();
	
	echo"<p>";
	echo form_label('First Name');
	echo form_input("first", set_value("first"), "required");
	echo"<p>";
	
	echo"<p>";
	echo form_label('Last Name');
	echo form_input("last", set_value("last"), "required");
	echo"<p>";
	
	echo"<p>";
	echo form_label('Username');
	echo form_input("login", set_value("login"), "required");
	echo"<p>";

	echo"<p>";
	echo form_label('Password');
	echo form_password('password', set_value("password"), "required");
	echo"<p>";
	
	echo"<p>";
	echo form_label('Confirm password');
	echo form_password('cpassword', set_value("cpassword"), "required");
	echo"<p>";
	
	echo"<p>";
	echo form_label('Email');
	echo form_input('email', set_value("email"), "required");
	echo"<p>";
	
	echo form_submit('submit', 'Sign Up');
	echo"</p>";
	
	echo form_close();
	?>
	

	</div>
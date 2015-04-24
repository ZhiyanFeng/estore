
<div id="container">
	<h1>Estore Login</h1>
	
<?php 
$this->load->helper ( 'form' );

// using functions provided in form_helper.php
echo validation_errors ();

echo "<p >";
echo form_open ( 'store/login_validation');
echo "</p>";

echo "<p>";
echo form_label ( 'User Name' );
echo form_error ( 'login' );
echo form_input ( 'login', set_value ( 'login' ), "required" );
echo "<p>";

echo "<p>";
echo form_label ( 'Password' );
echo form_error ( 'password' );

echo form_password( 'password', set_value ( 'password' ), "required" );
echo "<p>";
echo form_submit ( 'submit', 'Login' );
echo "</p>";

echo form_close ();
?>
	<a href='<?php echo base_url()."store/signup_validation";?>'>Sign up!</a>

</div>


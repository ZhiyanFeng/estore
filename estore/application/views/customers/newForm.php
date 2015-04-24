<h2>New Customer</h2>

<style>
	input { display: block;}
	
</style>

<?php 
	echo "<p>" . anchor('store/index','Back') . "</p>";
	
	echo form_open_multipart('store/create');
		
	echo form_label('First Name'); 
	echo form_error('first');
	echo form_input('first',set_value('first'),"required");

	echo form_label('Last Name');
	echo form_error('last');
	echo form_input('last',set_value('last'),"required");
	
	echo form_label('Login');
	echo form_error('login');
	echo form_input('login',set_value('login'),"required");
	
	echo form_label('E-Mail');
	echo form_error('email');
	echo form_input('email', set_value('input'), "required");
	
	if(isset($fileerror))
		echo $fileerror;	
?>	
	<input type="file" name="customerfile" size="20" />
	
<?php 	
	
	echo form_submit('submit', 'Create');
	echo form_close();
?>	

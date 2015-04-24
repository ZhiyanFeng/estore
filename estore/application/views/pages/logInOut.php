<?php
if ($this->session->userdata('loggedinCustomer')['islogin']) {
	echo "<p>" . anchor('store/logout','Logout') . "</p> ";
}else{
	echo "<p>" . anchor('store/login','Login') . "</p>";
}
?>
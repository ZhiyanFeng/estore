<!DOCTYPE html>
<html>
<body>

	<h1>members</h1>

	<div>
<?php
echo "<pre>";
print_r($this->session->all_userdata ());
echo "</pre>";

?>
</div>

</body>
</html>

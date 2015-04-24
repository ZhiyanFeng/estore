<?php
$this->load->helper ( 'html' );
$this->load->helper ( 'url' );
$img = img ( 'images/logo.png' );
echo anchor ( base_url () . 'store/index', $img );
?>
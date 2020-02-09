<?php
	include 'class_mysql.php';

	$new = new Mysql();

	$tmp = explode("=", $_SERVER['QUERY_STRING'])[1];

	echo $new->get_page( $tmp );
?>
<?php
	include 'class_mysql.php';

	$new = new Mysql();

	echo $new->get_counts();
?>
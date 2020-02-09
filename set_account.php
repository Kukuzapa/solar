<?php
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);

	include 'class_mysql.php';

	$new = new Mysql();

	$params = explode("&", $_SERVER['QUERY_STRING']);

	$fin = [];

	foreach ( $params as $value ) {

		$tmp = explode('=', $value);

		if ( strlen( $tmp[1] ) == 0 ){
			$fin = [];
			$fin['error'] = $tmp[0];
			break;
		}

		$fin[$tmp[0]] = $tmp[1];
	}

	if ( array_key_exists('error', $fin) ){
		echo json_encode( $fin, JSON_UNESCAPED_UNICODE );
	} else {
		$new->set_account( $fin );
		$fin = [];
		$fin['success'] = 'success';
		echo json_encode( $fin, JSON_UNESCAPED_UNICODE );
	}
?>
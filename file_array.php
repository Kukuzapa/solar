<?php
	$arr = array();

	#Создать нумерованный массив из 100 случайных элементов (числа от 0 до 5685).
	for ( $i = 1; $i <= 100; $i++ ) {
		array_push( $arr, rand( 0, 5685 ) );
	}

	#Полученныймассив записать в файл в json формате (array-1.json).
	$handle = fopen( 'array-1.json', 'w' );
	fputs( $handle, json_encode($arr) );
	fclose( $handle );

	foreach ($arr as $key => $value) {
		if ( $value >= 2450 && $value < 4031 ){
			#и умножить на 2 элементы массива значение которых >=2450 и < 4031.
			$arr[$key] = $value * 2;
		} elseif ( $value % 4 == 0 || $value % 2 != 0 ){
			#Из каждого значения созданного массива, ключи которого не четные или делятся на 4 без остатка, вычесть 23
			$arr[$key] = $value - 23;
		}
	}

	#Записать в файл array-2.json.
	$handle = fopen( 'array-2.json', 'w' );
	fputs( $handle, json_encode($arr) );
	fclose( $handle );
?>
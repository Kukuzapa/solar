<?php
class Mysql {
	private $link;

	function __construct() {
		$this->link = mysqli_connect("127.0.0.1", "root", "", "swansoft");
		mysqli_set_charset($this->link, "utf8");
	}

	#заполняем таблицу
	public function fill_the_table(){
		
		$handle   = fopen( 'array-1.json', "r" );
		$json1    = fread( $handle, filesize( 'array-1.json' ) );

		$handle   = fopen( 'array-2.json', "r" );
		$json2    = fread( $handle, filesize( 'array-2.json' ) );
		fclose( $handle );

		$arr1 = json_decode( $json1 );
		$arr2 = json_decode( $json2 );

		print_r( $arr1 );
		print_r( $arr2 );

		for ( $i = 0; $i < 100; $i++ ){
			$name    = 'Василий' . $i;
			$surname = 'Пупкин' . ( $i + 6 );
			$fname   = 'Александрович' . $arr1[$i];

			$time    = strtotime( "-21 year -" . $i . " days", time() );
			$bdate   = date( "Y-m-d", $time );

			$amount  = $arr1[$i] + $arr2[4];

			$sql = 'INSERT INTO solar (name,surname,fname,bdate,amount) VALUES ("%s","%s","%s","%s","%s")';
			$sql = sprintf( $sql, mysqli_real_escape_string( $this->link, $name ), mysqli_real_escape_string( $this->link, $surname ), mysqli_real_escape_string( $this->link, $fname ), 
				mysqli_real_escape_string( $this->link, $bdate ), mysqli_real_escape_string( $this->link, $amount ) );

			mysqli_query( $this->link, $sql );
		}
	}

	#Добавляем договор
	public function set_account( $tbl ){

		$sql = 'INSERT INTO solar (name,surname,fname,bdate,amount) VALUES ("%s","%s","%s","%s","%s")';
		$sql = sprintf( $sql, mysqli_real_escape_string( $this->link, $tbl['name'] ), mysqli_real_escape_string( $this->link, $tbl['surname'] ), mysqli_real_escape_string( $this->link, $tbl['fname'] ), 
			mysqli_real_escape_string( $this->link, $tbl['bdate'] ), mysqli_real_escape_string( $this->link, $tbl['amount'] ) );

		mysqli_query( $this->link, $sql );
	}

	#Кол-во записей
	public function get_counts(){
		$result = [];

		$count = mysqli_num_rows( mysqli_query( $this->link, 'SELECT * FROM solar' ) );

		$count = ceil( $count/8 );

		$result['count'] = $count;

		return json_encode( $result, JSON_UNESCAPED_UNICODE );
	}

	#Получаем страницу
	public function get_page( $page ){

		$result = [];

		$offset = ( $page - 1 ) * 8;

		$sql = 'SELECT * FROM `solar` ORDER BY account LIMIT 8 OFFSET %s';
		$sql = sprintf( $sql, mysqli_real_escape_string( $this->link, $offset ) );

		$response = mysqli_query( $this->link, $sql );

		while ( $row = mysqli_fetch_row( $response ) ) {
			array_push($result, $row);
		}

		return json_encode( $result, JSON_UNESCAPED_UNICODE );
	}
}
?>
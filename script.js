$(function(){

	var current_page = 1;

	//Получение строк на странице
	function get_page( page ){
		$.ajax({
			data: 'page=' + page,
				url: 'get_page.php',
				success: function( data ){
				var response = JSON.parse( data );
				$('#test').html('');
				var rows = '';
				for ( var key in response ) {
					if ( key != 'count' ){
						rows = rows + '<tr>';

						for ( var row in response[key] ){
							rows = rows + '<td>' + response[key][row] + '</td>';
						}

						rows = rows + '</tr>';
					}
				}
				$('#test').html(rows);
				}
		})
	}

	//Получение пагинации
	function get_pagination(){
		$.ajax({
				url: 'get_count.php',
				success: function( data ){
				var response = JSON.parse( data );
				$('.pagination').html('');
				var pags = ''
				for ( var i=1; i<=response.count; i++ ){
					pags = pags + '<li class="page-item"><a class="page-link" href="#">' + i + '</a></li>'
				}
				$('.pagination').html(pags);

				//Обработка только что нарисованной пагинации
				$('a').click(function(){
					current_page = $(this).text();
					get_page( $(this).text() );
				})
				}
		})
	}

	//Внесение изменений
	$('#add').click(function(){

		$('#good').hide();
		$('#bad').hide();

		var str = 'name='+$('#name').val()+'&surname='+$('#surname').val()+'&fname='+$('#fname').val()+'&bdate='+$('#bdate').val()+'&amount='+$('#amount').val();

		$.ajax({
			data: str,
				url: 'set_account.php',
				success: function( data ){
				var response = JSON.parse( data );
				if ( response.error ){
					$('#bad').show();
				} else {
					$('#good').show();
					get_pagination();
					get_page( current_page );	    					
				}
				}
		})
	})

	get_pagination();
	get_page( 1 );
});
<?php

session_start();

include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');

// если пользователь не авторизован

if (!isset($_SESSION['user_id']))
{
	// то проверяем его куки
	// вдруг там есть логин и пароль к нашему скрипту

	if (isset($_COOKIE['login']) && isset($_COOKIE['password']))
	{
		// если же такие имеются
		// то пробуем авторизовать пользователя по этим логину и паролю
		$login = sanitize($_COOKIE['login']);
		$password = sanitize($_COOKIE['password']);

		// и по аналогии с авторизацией через форму:

		// делаем запрос к БД
		// и ищем юзера с таким логином и паролем

		$query = "SELECT `id`
					FROM `admin`
					WHERE `login`='{$login}' AND `password`='{$password}'
					LIMIT 1";
		$sql = mysql_query($query) or die(mysql_error());

		// если такой пользователь нашелся
		if (mysql_num_rows($sql) == 1)
		{
			// то мы ставим об этом метку в сессии (допустим мы будем ставить ID пользователя)

			$row = mysql_fetch_assoc($sql);
			$_SESSION['user_id'] = $row['id'];

			// не забываем, что для работы с сессионными данными, у нас в каждом скрипте должно присутствовать session_start();
		}
	}
}

if (isset($_SESSION['user_id']))
{
	$query = "SELECT `login`
				FROM `admin`
				WHERE `id` = '{$_SESSION['user_id']}'
				LIMIT 1";
	$sql = mysql_query($query) or die(mysql_error());
	
	// если нету такой записи с пользователем
	// ну вдруг удалили его пока он лазил по сайту.. =)
	// то надо ему убить ID, установленный в сессии, чтобы он был гостем
	if (mysql_num_rows($sql) != 1)
	{
		header('Location: login.php?logout');
		exit;
	}
	
	$row = mysql_fetch_assoc($sql);
	
	$welcome = $row['login'];
}
else
{
	$welcome = 'гость';
}

if (!isset($_SESSION['user_id']))
{
	header('Location: login.php');
}
else
{
	
	if (!empty($_GET))
	{
		$include = dirname(__FILE__) . "/inc/" . sanitize(array_shift(array_keys($_GET))) . ".php";
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Panel</title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<link href="css/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="css/jquery.ui.theme.css" rel="stylesheet" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<script src="css/jquery.ui.touch-punch.min.js"></script>
<script src="css/jquery.validate.js"></script>
<script>
jQuery(document).ready(function($){
	
	$( "#street_search" ).autocomplete({
		source: "address_search.php",
		minLength: 2,
		delay: 500,
		close: function( event, ui ) {
				$.getJSON("address_search.php?street=" + $("#street_search").val(),
				function(data){
					$.each(data, function(i,item){
						$("#house").val(item[0].value);
						$("#building").val(item[1].value);
					});
				});
		}
	});
	
	$( "#user_search" ).autocomplete({
		source: "user_search.php",
		minLength: 2,
		delay: 500,
		response: function( event, ui ) {
				$("#name, #mail, #birthday").removeAttr('readonly disabled').val('');
				$("img.ui-datepicker-trigger").show(0);
				$("#add_user").attr({
					name: 'add_user',
					value: 'Добавить клиента'
				});
				$("#tabs").hide();
		},
		close: function( event, ui ) {
				$.getJSON("user_search.php?phone=" + $("#user_search").val(),
				function(data){
						if (data[0].user_id != '') {
							$("#name, #mail, #birthday").prop('readonly', true);
							$("img.ui-datepicker-trigger").hide(0);
							$("#add_user").attr({
								name: 'get_address',
								value: 'Получить адрес'
							});
						}
						$("#user_id").val(data[0].user_id);
						$("#name").val(data[0].name);
						$("#mail").val(data[0].mail);
						$("#birthday").val(data[0].birthday);
				});
		},
	});

	$(document).on("keydown.autocomplete",".product_search",function(e){
		$(this).autocomplete({
			source: "product_search.php",
			minLength: 0,
			delay: 0,
			close: function( event, ui ) {
					var selector = $(this);
					$.getJSON("product_search.php?name=" + ($( selector ).closest("tr").find(".product_search").val()),
					function(data){
						$( selector ).closest("tr").find(".product_id").val(data[0].product_id);
						$( selector ).closest("tr").find(".price, .price_total").val(data[0].value + ".00");
						$( selector ).closest("tr").find(".amount").spinner( 'value', 1 );
						bill = 0;
						$( selector ).closest("table").find( ".price_total" ).each(function() {
							bill += parseFloat($(this).val());
						});
						if (bill > 1500) {
							$( ".delivery" ).text("Бесплатно");
						} else if (bill == 0) {
							$( ".delivery" ).text("0.00");
						} else {
							$( ".delivery" ).text("250.00");
							bill += 250;
						}
						$( ".bill" ).text(bill + ".00");
						$( "input[name=bill]" ).val(bill + ".00");
					});
			}
		}).each(function() {
			$(this).data("autocomplete")._renderItem = function(ul, item) {
				return $('<li></li>')
					.data("item.autocomplete", item)
					.append("<a>" + item.value + "</a>")
					.appendTo(ul);
			};
		});
	});
		
	$( "#birthday" ).datepicker({
		yearRange: "-80:+0",
		showOn: "button",
		buttonImage: "css/images/calendar.png",
		buttonImageOnly: true,
		buttonText: "Календарь",
		dateFormat: "dd.mm.yy",
		changeMonth: true,
		changeYear: true
	});
	
	$( ".delivery_date" ).datepicker({
		yearRange: "-0:+1",
		altField: "input[name=delivery_date]",
		defaultDate: +1,
		dateFormat: "dd.mm.yy",
		changeMonth: true,
		changeYear: true
	});

	$("input[name='office']").change(function() {
		if(this.checked) {
			$("#office_yes").show();
			$("#office_no").hide();
		} else {
			$("#office_yes").hide();
			$("#office_no").show();
		}
	});
	
	$( ".time_range" ).slider({
		range: true,
		min: 10,
		max: 22,
		values: [ 10, 12 ],
		slide: function( event, ui ) {
			if (ui.values[1] - ui.values[0] < 2) {
				return false;
			} else {
				$( ".delivery_time" ).val( ui.values[ 0 ] + ":00 - " + ui.values[ 1 ] + ":00" );
			}
		}
	});
	
	$( ".delivery_time" ).val( $( ".time_range" ).slider( "values", 0 ) + ":00 - " + $( ".time_range" ).slider( "values", 1 ) + ":00" );

	$( "#tabs" ).tabs();
	
	$( "#dialog" ).dialog({ modal: true });
	
	$( ".orders" ).accordion({
		collapsible: true,
		heightStyle: "content"
	});
	
	$( '.amount' ).spinner({
		min: 1,
		change: function( event, ui ) {
			$( this ).closest("tr").find( ".price_total" ).val($( this ).spinner('value') * $( this ).closest("tr").find( ".price" ).val() + ".00");
			bill = 0;
			$( this ).closest("table").find( ".price_total" ).each(function() {
				bill += parseFloat($(this).val());
			});
			if (bill > 1500) {
				$( ".delivery" ).text("Бесплатно");
			} else if (bill == 0) {
				$( ".delivery" ).text("0.00");
			} else {
				$( ".delivery" ).text("250.00");
				bill += 250;
			}
			$( ".bill" ).text(bill + ".00");
			$( "input[name=bill]" ).val(bill + ".00");
		}
	});
	
	$( ".button" ).button();
	
	$( ".addrow" ).click(function(e) {
		$('.new_order > tbody:first > tr:last-child').before("\
						<tr>\
							<th></th>\
							<th>\
								<input type='hidden' class='product_id' name='product_id[]'>\
								<input type='text' class='product_search' name='name'>\
							</th>\
							<th><input type='text' class='amount' name='amount[]'></th>\
							<th><input type='text' class='price' value='0.00' disabled='disabled' name='price'></th></th>\
							<th><input type='text' class='price_total' value='0.00' disabled='disabled' name='price_total'></th>\
							<th><span class='deleterow'></span></th>\
							<th></th>\
						</tr>");
		$( ".new_order tbody:first > tr:not(:last-child) > th:first-child" ).each(function(index, element) {
            $( this ).text( index + 1 );
        });
		$( ".deleterow" ).show();
		$( '.amount' ).spinner({
			min: 1,
			change: function( event, ui ) {
				$( this ).closest("tr").find( ".price_total" ).val($( this ).spinner('value') * $( this ).closest("tr").find( ".price" ).val() + ".00");
				bill = 0;
				$( this ).closest("table").find( ".price_total" ).each(function() {
					bill += parseFloat($(this).val());
				});
				if (bill > 1500) {
					$( ".delivery" ).text("Бесплатно");
				} else if (bill == 0) {
					$( ".delivery" ).text("0.00");
				} else {
					$( ".delivery" ).text("250.00");
					bill += 250;
				}
				$( ".bill" ).text(bill + ".00");
				$( "input[name=bill]" ).val(bill + ".00");
			}
		});
	});
	
	$('.orders').on('spin.spinner', '.amount', function(event, ui) {
		$( this ).closest("tr").find( ".price_total" ).val(ui.value * $( this ).closest("tr").find( ".price" ).val() + ".00");
		bill = 0;
		$( this ).closest("table").find( ".price_total" ).each(function() {
			bill += parseFloat($(this).val());
		});
		if (bill > 1500) {
			$( ".delivery" ).text("Бесплатно");
		} else if (bill == 0) {
			$( ".delivery" ).text("0.00");
		} else {
			$( ".delivery" ).text("250.00");
			bill += 250;
		}
		$( ".bill" ).text(bill + ".00");
		$( "input[name=bill]" ).val(bill + ".00");
	});
	
	$('.orders').on('click', '.deleterow', function() {
		$( this ).closest("tr").remove();
		$( ".new_order tbody:first > tr:not(:last-child) > th:first-child" ).each(function(index, element) {
            $( this ).text( index + 1 );
        });
		if ($( ".new_order tbody:first > tr" ).length == 2) {
			$( ".deleterow" ).hide();
		}
		bill = 0;
		$( ".new_order" ).find( ".price_total" ).each(function() {
			bill += parseFloat($(this).val());
		});
		if (bill > 1500) {
			$( ".delivery" ).text("Бесплатно");
		} else if (bill == 0) {
			$( ".delivery" ).text("0.00");
		} else {
			$( ".delivery" ).text("250.00");
			bill += 250;
		}
		$( ".bill" ).text(bill + ".00");
		$( "input[name=bill]" ).val(bill + ".00");
	});
	
});
</script>
</head>

<body>
<div id="wrapper">
<div id="nav">
<ul>
	<li><a href="?add_user">Добавить клиента</a></li>
    <li><a href="?add_order">Добавить заказ</a></li>
    <li><a href="?register">Зарегистрировать нового админа</a></li>
    <li><a href="login.php?logout">Выход</a></li>
</ul>
</div>
<div id="content">
<?php

if ($include == "")
{
	print "Привет, $welcome!";
}
else
{
	include ($include);
}

?>

</div>
</div>
</body>
</html>

<?php

}

?>
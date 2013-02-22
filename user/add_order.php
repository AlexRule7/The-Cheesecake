<?php

// Use session_start() in all pages that are working with sessions
session_start();

include($_SERVER['DOCUMENT_ROOT'].'/Connections/exarium.php');

header('Content-type: application/json');

$user_name = (isset($_POST['user-name'])) ? sanitize($_POST['user-name']) : '';
$user_email = (isset($_POST['user-email'])) ? sanitize($_POST['user-email']) : '';
$user_phone = (isset($_POST['user-phone'])) ? sanitize($_POST['user-phone']) : '';
$address_id = (isset($_POST['user-address'])) ? sanitize($_POST['user-address']) : '';
$user_office = (isset($_POST['user-office'])) ? sanitize($_POST['user-office']) : '';
$user_metro = (isset($_POST['user-metro'])) ? sanitize($_POST['user-metro']) : '';
$user_street = (isset($_POST['user-street'])) ? sanitize($_POST['user-street']) : '';
$user_house = (isset($_POST['user-house'])) ? sanitize($_POST['user-house']) : '';
$user_building = (isset($_POST['user-building'])) ? sanitize($_POST['user-building']) : '';
$user_flat = (isset($_POST['user-flat'])) ? sanitize($_POST['user-flat']) : '';
$user_enter = (isset($_POST['user-enter'])) ? sanitize($_POST['user-enter']) : '';
$user_floor = (isset($_POST['user-floor'])) ? sanitize($_POST['user-floor']) : '';
$user_domofon = (isset($_POST['user-domofon'])) ? sanitize($_POST['user-domofon']) : '';
$user_company = (isset($_POST['user-company'])) ? sanitize($_POST['user-company']) : '';

$order_comment = (isset($_POST['order-comment'])) ? sanitize($_POST['order-comment']) : '';
$order_time = (isset($_POST['order-time'])) ? sanitize($_POST['order-time']) : '';
$order_date = (isset($_POST['order-date'])) ? sanitize($_POST['order-date']) : '';
$order_bill = (isset($_POST['order-bill'])) ? sanitize($_POST['order-bill']) : '';

$order_date = date('d.m.Y', strtotime($order_date));

if (!isset($_SESSION['user_id'])) {
	$query = "SELECT `user_id`
				FROM `users`
				WHERE `email` = '{$user_email}'";

	$sql = mysql_query($query) or die(mysql_error());
	if (!mysql_num_rows($sql)) {
		$query = "INSERT
					INTO `users`
					SET
						`name`='{$user_name}',
						`email`='{$user_email}'";
						
		$sql = mysql_query($query) or die(mysql_error());
		$_SESSION['user_id'] = mysql_insert_id();
		
		$query = "INSERT
					INTO `phones`
					SET
						`user_id`='{$_SESSION['user_id']}',
						`phone`='{$user_phone}'";
						
		$sql = mysql_query($query) or die(mysql_error());
		$phone_id = mysql_insert_id();
		
		if (empty($user_office)) {
			$query = "INSERT
						INTO `addresses`
						SET
							`user_id`='{$_SESSION['user_id']}',
							`metro`='{$user_metro}',
							`street`='{$user_street}',
							`house`='{$user_house}',
							`building`='{$user_building}',
							`office`='0',
							`flat`='{$user_flat}',
							`enter`='{$user_enter}',
							`floor`='{$user_floor}',
							`domofon`='{$user_domofon}'";
		} else {
			$query = "INSERT
						INTO `addresses`
						SET
							`user_id`='{$_SESSION['user_id']}',
							`metro`='{$user_metro}',
							`street`='{$user_street}',
							`house`='{$user_house}',
							`building`='{$user_building}',
							`office`='1',
							`company`='{$user_company}'";
		}
						
		$sql = mysql_query($query) or die(mysql_error());
		$address_id = mysql_insert_id();
	} else {
		$error = array (
			'id' => '1',
			'text' => 'Пользователя с таким e-mail уже зарегистрирован. Если это вы - <a class="si-popup-trigger" href="#">войдите</a>.'
		);
		echo json_encode($error);
		exit;
	}
} else {
	$query = "SELECT `phone_id`
				FROM `phones`
				WHERE `phone` = '{$user_phone}'";
				
	$sql = mysql_query($query) or die(mysql_error());
	if (!mysql_num_rows($sql)) {
		$query = "INSERT
					INTO `phones`
					SET
						`user_id`='{$_SESSION['user_id']}',
						`phone`='{$user_phone}'";
						
		$sql = mysql_query($query) or die(mysql_error());
		$phone_id = mysql_insert_id();
	} else {
		$row = mysql_fetch_assoc($sql);
		$phone_id = $row['phone_id'];
	}
	
	if ($address_id == 0) {
		if (empty($user_office)) {
			$query = "INSERT
						INTO `addresses`
						SET
							`user_id`='{$_SESSION['user_id']}',
							`metro`='{$user_metro}',
							`street`='{$user_street}',
							`house`='{$user_house}',
							`building`='{$user_building}',
							`office`='0',
							`flat`='{$user_flat}',
							`enter`='{$user_enter}',
							`floor`='{$user_floor}',
							`domofon`='{$user_domofon}'";
		} else {
			$query = "INSERT
						INTO `addresses`
						SET
							`user_id`='{$_SESSION['user_id']}',
							`metro`='{$user_metro}',
							`street`='{$user_street}',
							`house`='{$user_house}',
							`building`='{$user_building}',
							`office`='1',
							`company`='{$user_company}'";
		}
						
		$sql = mysql_query($query) or die(mysql_error());
		$address_id = mysql_insert_id();
	}
}

$query = "INSERT
			INTO `orders`
			SET
				`user_id`='{$_SESSION['user_id']}',
				`phone_id`='{$phone_id}',
				`address_id`='{$address_id}',
				`delivery_date`='{$order_date}',
				`delivery_time`='{$order_time}',
				`bill`='{$order_bill}',
				`comment`='{$order_comment}'";
				
$sql = mysql_query($query) or die(mysql_error());
$order_id = mysql_insert_id();

foreach ($_SESSION['item_list'] as $key => $val) {
	$query = "INSERT
				INTO `purchases`
				SET
					`order_id`='{$order_id}',
					`product_id`='{$val['id']}',
					`amount`='{$val['qty']}'";
					
	$sql = mysql_query($query) or die(mysql_error());
}

unset ($_SESSION['item_total']);
unset ($_SESSION['item_list']);

$error = array (
	'id' => '0',
	'text' => 'Success'
);
echo json_encode($error);

?>
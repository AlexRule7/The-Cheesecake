<?php

// Use session_start() in all pages that are working with sessions
session_start();

include($_SERVER['DOCUMENT_ROOT'].'/Connections/exarium.php');

header('Content-type: application/json');

$user_name = (isset($_POST['user-name'])) ? sanitize($_POST['user-name']) : '';
$user_email = (isset($_POST['user-email'])) ? sanitize($_POST['user-email']) : '';
$user_phone = (isset($_POST['user-phone'])) ? sanitize($_POST['user-phone']) : '';
$address_id = (isset($_POST['user-address'])) ? sanitize($_POST['user-address']) : '';
$user_metro = (isset($_POST['user-metro'])) ? sanitize($_POST['user-metro']) : '';
$user_street = (isset($_POST['user-street'])) ? sanitize($_POST['user-street']) : '';
$user_house = (isset($_POST['user-house'])) ? sanitize($_POST['user-house']) : '';
$user_building = (isset($_POST['user-building'])) ? sanitize($_POST['user-building']) : '';
$user_flat = (isset($_POST['user-flat'])) ? sanitize($_POST['user-flat']) : '';
$user_enter = (isset($_POST['user-enter'])) ? sanitize($_POST['user-enter']) : '';
$user_floor = (isset($_POST['user-floor'])) ? sanitize($_POST['user-floor']) : '';
$user_domofon = (isset($_POST['user-domofon'])) ? sanitize($_POST['user-domofon']) : '';
$user_company = (isset($_POST['user-company'])) ? sanitize($_POST['user-company']) : '';
if (isset($_POST['user-office'])) {
	$user_office = 1;
} else {
	$user_office = 0;
}

$order_comment = (isset($_POST['order-comment'])) ? sanitize($_POST['order-comment']) : '';
$order_time = (isset($_POST['order-time'])) ? sanitize($_POST['order-time']) : '';
$order_date = (isset($_POST['order-date'])) ? sanitize($_POST['order-date']) : '';
$order_discount = (isset($_POST['order-discount'])) ? sanitize($_POST['order-discount']) : '';
$order_raw_bill = (isset($_POST['order-raw-bill'])) ? sanitize($_POST['order-raw-bill']) : '';
$order_bill = (isset($_POST['order-bill'])) ? sanitize($_POST['order-bill']) : '';
$order_delivery = (isset($_POST['order-delivery'])) ? sanitize($_POST['order-delivery']) : '';

$order_date = date('d.m.Y', strtotime($order_date));

if (!isset($_SESSION['user_id'])) {
	$query = "SELECT `user_id`
				FROM `users`
				WHERE `email` = '{$user_email}'";

	$sql = mysql_query($query) or die(mysql_error());
	if (!mysql_num_rows($sql)) {
		preg_match('/\d-\d+-\d+$/', $user_phone, $match);
		$pass = str_replace('-', '', $match[0]);
		$salt = GenerateSalt();
		$user_pass = md5(md5($pass) . $salt);
		
		$query = "INSERT
					INTO `users`
					SET
						`name`='{$user_name}',
						`email`='{$user_email}',
						`password`='{$user_pass}',
						`salt`='{$salt}'";
						
		$sql = mysql_query($query) or die(mysql_error());
		$_SESSION['user_id'] = mysql_insert_id();
		$_SESSION['new_user'] = true;
		
		$query = "INSERT
					INTO `discounts`
					SET
						`user_id`='{$_SESSION['user_id']}',
						`discount`='5',
						`value`='1'";
						
		$sql = mysql_query($query) or die(mysql_error());
		
		$query = "INSERT
					INTO `phones`
					SET
						`user_id`='{$_SESSION['user_id']}',
						`phone`='{$user_phone}'";
						
		$sql = mysql_query($query) or die(mysql_error());
		$phone_id = mysql_insert_id();
		
		$query = "INSERT
					INTO `addresses`
					SET
						`user_id`='{$_SESSION['user_id']}',
						`metro`='{$user_metro}',
						`street`='{$user_street}',
						`house`='{$user_house}',
						`building`='{$user_building}',
						`office`='{$user_office}',
						`company`='{$user_company}',
						`flat`='{$user_flat}',
						`enter`='{$user_enter}',
						`floor`='{$user_floor}',
						`domofon`='{$user_domofon}'";
						
		$sql = mysql_query($query) or die(mysql_error());
		$address_id = mysql_insert_id();
		
		// MAIL
		
		$mail_data = array (
			'file' => 'register',
			'user_name' => $user_name
		);
		
		$subject = 'Добро пожаловать, '.$user_name;
		$message = send_mail($mail_data);
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf8' . "\r\n";
		$headers .= 'To: '.$user_name.' <'.$user_email.'>' . "\r\n";
		$headers .= 'From: Moscow Cheesecake <info@thecheesecake.ru>' . "\r\n";
		mail($user_email, $subject, $message, $headers);
		
		// END OF MAIL
	} else {
		$error = array (
			'id' => '1',
			'text' => 'Пользователь с таким e-mail уже зарегистрирован. Если это вы - <a class="si-popup-trigger" href="#">войдите</a>.'
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
		$query = "INSERT
					INTO `addresses`
					SET
						`user_id`='{$_SESSION['user_id']}',
						`metro`='{$user_metro}',
						`street`='{$user_street}',
						`house`='{$user_house}',
						`building`='{$user_building}',
						`office`='0',
						`office`='{$user_office}',
						`company`='{$user_company}',
						`flat`='{$user_flat}',
						`enter`='{$user_enter}',
						`floor`='{$user_floor}',
						`domofon`='{$user_domofon}'";
						
		$sql = mysql_query($query) or die(mysql_error());
		$address_id = mysql_insert_id();
	}
}

$query = "SELECT 1
			FROM `orders`
			WHERE `user_id` = '{$_SESSION['user_id']}'";
			
$sql = mysql_query($query) or die(mysql_error());

if (!mysql_num_rows($sql)) {
	$query = "INSERT
				INTO `discounts`
				SET
					`user_id`='{$_SESSION['user_id']}',
					`discount`='5',
					`value`='1'";
					
	$sql = mysql_query($query) or die(mysql_error());
	$_SESSION['new_user_discount'] = 5;
}

$query = "INSERT
			INTO `orders`
			SET
				`user_id`='{$_SESSION['user_id']}',
				`phone_id`='{$phone_id}',
				`address_id`='{$address_id}',
				`delivery_date`='{$order_date}',
				`delivery_time`='{$order_time}',
				`discount`='{$order_discount}',
				`raw_bill`='{$order_raw_bill}',
				`bill`='{$order_bill}',
				`delivery`='{$order_delivery}',
				`comment`='{$order_comment}'";
				
$sql = mysql_query($query) or die(mysql_error());
$order_id = mysql_insert_id();
$_SESSION['order_id'] = $order_id;

if (!empty($order_discount)) {
	$query = "SELECT *
				FROM `discounts`
				WHERE `user_id` = '{$_SESSION['user_id']}' AND `discount` = '{$order_discount}'";
				
	$sql = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_assoc($sql);
	
	if ($row['value'] == 1) {
		$query = "DELETE
					FROM `discounts`
					WHERE `discount_id` = '{$row['discount_id']}'";
		$sql = mysql_query($query) or die(mysql_error());
	} else {
		$query = "UPDATE `discounts`
					SET `value`=value-1
					WHERE `discount_id` = '{$row['discount_id']}'";
		$sql = mysql_query($query) or die(mysql_error());
	}
}

foreach ($_SESSION['item_list'] as $key => $val) {
	if ($val['qty'] != 0) {
		$query = "INSERT
					INTO `purchases`
					SET
						`order_id`='{$order_id}',
						`product_id`='{$val['id']}',
						`amount`='{$val['qty']}'";
						
		$sql = mysql_query($query) or die(mysql_error());
	}
}

if ($_SESSION['item_total'] >= 3) {
	$new_discount = 5;
	if ($_SESSION['item_total'] >= 5) {
		$new_discount = 10;
	}
	$query = "SELECT `discount_id`, `discount`
				FROM `discounts`
				WHERE `user_id` = '{$_SESSION['user_id']}'";
				
	$sql = mysql_query($query) or die(mysql_error());
	
	if (mysql_num_rows($sql)) {
		while ($row = mysql_fetch_assoc($sql)) {
			if ($row['discount'] == $new_discount) {
				$query = "UPDATE `discounts`
							SET `value`=value+1
							WHERE `discount_id` = '{$row['discount_id']}'";
				$sql = mysql_query($query) or die(mysql_error());
				$created = 1;
			}
		}
	}
	if ($created != 1) {
		$query = "INSERT
					INTO `discounts`
					SET
						`user_id`='{$_SESSION['user_id']}',
						`discount`='{$new_discount}',
						`value`='1'";
						
		$sql = mysql_query($query) or die(mysql_error());
	}
	
	$_SESSION['new_discount'] = $new_discount;
}

// MAIL

$mail_data = array (
	'file' => 'order',
	'user_name' => $user_name,
	'order_id' => $order_id,
	'item_list' => $item_list,
	'delivery' => $order_delivery,
	'bill' => $order_bill,
	'raw_bill' => $order_raw_bill,
	'discount' => $order_discount,
	'comment' => $order_comment,
	'address' => array (
		'metro' => $user_metro,
		'street' => $user_street,
		'house' =>  $user_house,
		'building' => $user_building,
		'office' => $user_office,
		'flat' => $user_flat,
		'enter' => $user_enter,
		'floor' => $user_floor,
		'domofon' => $user_domofon,
		'company' => $user_company,
		'phone' => $user_phone
	)
);

$to = $user_email.', info@thecheesecake.ru';
$subject = 'Информация о заказе № '.$order_id;
$message = send_mail($mail_data);
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf8' . "\r\n";
$headers .= 'To: '.$user_name.' <'.$user_email.'>' . "\r\n";
$headers .= 'From: Moscow Cheesecake <info@thecheesecake.ru>' . "\r\n";
mail($to, $subject, $message, $headers);

// END OF MAIL

$error = array (
	'id' => '0',
	'text' => 'Success'
);
echo json_encode($error);

?>
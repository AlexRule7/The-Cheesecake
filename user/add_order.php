<?php

// Use session_start() in all pages that are working with sessions
session_start();

include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');

header('Content-type: application/json');

$user_name = (isset($_POST['user-name'])) ? Database::sanitize($_POST['user-name']) : '';
$user_email = (isset($_POST['user-email'])) ? Database::sanitize($_POST['user-email']) : '';
$user_phone = (isset($_POST['user-phone'])) ? Database::sanitize($_POST['user-phone']) : '';
$address_id = (isset($_POST['user-address'])) ? Database::sanitize($_POST['user-address']) : '';
$user_metro = (isset($_POST['user-metro'])) ? Database::sanitize($_POST['user-metro']) : '';
$user_street = (isset($_POST['user-street'])) ? Database::sanitize($_POST['user-street']) : '';
$user_house = (isset($_POST['user-house'])) ? Database::sanitize($_POST['user-house']) : '';
$user_building = (isset($_POST['user-building'])) ? Database::sanitize($_POST['user-building']) : '';
$user_flat = (isset($_POST['user-flat'])) ? Database::sanitize($_POST['user-flat']) : '';
$user_enter = (isset($_POST['user-enter'])) ? Database::sanitize($_POST['user-enter']) : '';
$user_floor = (isset($_POST['user-floor'])) ? Database::sanitize($_POST['user-floor']) : '';
$user_domofon = (isset($_POST['user-domofon'])) ? Database::sanitize($_POST['user-domofon']) : '';
$user_company = (isset($_POST['user-company'])) ? Database::sanitize($_POST['user-company']) : '';
if (isset($_POST['user-office'])) {
	$user_office = 1;
} else {
	$user_office = 0;
}

$order_comment = (isset($_POST['order-comment'])) ? Database::sanitize($_POST['order-comment']) : '';
$order_time = (isset($_POST['order-time'])) ? Database::sanitize($_POST['order-time']) : '';
$order_date = (isset($_POST['order-date'])) ? Database::sanitize($_POST['order-date']) : '';
$order_discount = (isset($_POST['order-discount'])) ? Database::sanitize($_POST['order-discount']) : '';
$order_raw_bill = (isset($_POST['order-raw-bill'])) ? Database::sanitize($_POST['order-raw-bill']) : '';
$order_bill = (isset($_POST['order-bill'])) ? Database::sanitize($_POST['order-bill']) : '';
$order_delivery = (isset($_POST['order-delivery'])) ? Database::sanitize($_POST['order-delivery']) : '';

$order_date = date('d.m.Y', strtotime($order_date));

if (!isset($_SESSION['user_id'])) {
	$query = "SELECT `user_id`
				FROM `users`
				WHERE `email` = '{$user_email}'";

	$result = $mysqli->query($query) or die($mysqli->error);
	if (!$result->num_rows) {
		preg_match('/\d-\d+-\d+$/', $user_phone, $match);
		$pass = str_replace('-', '', $match[0]);
		$salt = GenerateSalt();
		$password = md5(md5($pass) . $salt);
		
		$query = "SELECT *
					FROM `phones`
					WHERE `phone` = '{$user_phone}'";
	
		$result = $mysqli->query($query) or die($mysqli->error);
		
		if (!$result->num_rows) {
			$query = "INSERT
						INTO `users`
						SET
							`name`='{$user_name}',
							`email`='{$user_email}',
							`password`='{$password}',
							`bonus_received`='1',
							`salt`='{$salt}'";
							
			$result = $mysqli->query($query) or die($mysqli->error);
			$_SESSION['user_id'] = $mysqli->insert_id;
			$_SESSION['new_user'] = true;
			
			$query = "INSERT
						INTO `phones`
						SET
							`user_id`='{$_SESSION['user_id']}',
							`phone`='{$user_phone}'";
							
			$result = $mysqli->query($query) or die($mysqli->error);
			$phone_id = $mysqli->insert_id;
		} else {
			$row = $result->fetch_assoc();
			$phone_id = $row['phone_id'];
			$user_id = $row['user_id'];
			
			$query = "SELECT *
						FROM `users`
						WHERE `user_id` = '{$user_id}'";
		
			$result = $mysqli->query($query) or die($mysqli->error);
			$row = $result->fetch_assoc();
			
			if (empty($row['email'])) {
				$query = "UPDATE `users`
							SET
								`name`='{$user_name}',
								`email`='{$user_email}',
								`password`='{$password}',
								`bonus_received`='1',
								`salt`='{$salt}'
							WHERE `user_id`='{$user_id}'";
				
				$result = $mysqli->query($query) or die($mysqli->error);
				$_SESSION['user_id'] = $user_id;
				$_SESSION['new_user'] = true;
			} else {
				$error = array (
					'id' => '2',
					'text' => 'Пользователь с таким телефоном уже зарегистрирован'
				);
				echo json_encode($error);
				exit;
			}
		}
		
		add_discount($_SESSION['user_id'], 5);
		$_SESSION['new_user_discount'] = 5;
		
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
						
		$result = $mysqli->query($query) or die($mysqli->error);
		$address_id = $mysqli->insert_id;
		
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
				
	$result = $mysqli->query($query) or die($mysqli->error);
	if (!$result->num_rows) {
		$query = "INSERT
					INTO `phones`
					SET
						`user_id`='{$_SESSION['user_id']}',
						`phone`='{$user_phone}'";
						
		$result = $mysqli->query($query) or die($mysqli->error);
		$phone_id = $mysqli->insert_id;
	} else {
		$row = $result->fetch_assoc();
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
						`office`='{$user_office}',
						`company`='{$user_company}',
						`flat`='{$user_flat}',
						`enter`='{$user_enter}',
						`floor`='{$user_floor}',
						`domofon`='{$user_domofon}'";
						
		$result = $mysqli->query($query) or die($mysqli->error);
		$mysqli->insert_id;
	}
}

$query = "SELECT `bonus_received`
			FROM `users`
			WHERE `user_id` = '{$_SESSION['user_id']}'";
			
$result = $mysqli->query($query) or die($mysqli->error);
$row = $result->fetch_assoc();

if ($row['bonus_received'] == 0 && !isset($_SESSION['new_user'])) {
	add_discount($_SESSION['user_id'], 5);
	$_SESSION['new_user_discount'] = 5;
	
	$query = "UPDATE `users`
				SET `bonus_received`='1'
				WHERE `user_id`='{$_SESSION['user_id']}'";
	
	$result = $mysqli->query($query) or die($mysqli->error);
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
				
$result = $mysqli->query($query) or die($mysqli->error);
$order_id = $mysqli->insert_id;
$_SESSION['order_id'] = $order_id;

if (!empty($order_discount)) {
	remove_discount($_SESSION['user_id'], $order_discount);
}

foreach ($_SESSION['item_list'] as $key => $val) {
	if ($val['qty'] != 0) {
		$query = "INSERT
					INTO `purchases`
					SET
						`order_id`='{$order_id}',
						`product_id`='{$val['id']}',
						`amount`='{$val['qty']}'";
						
		$result = $mysqli->query($query) or die($mysqli->error);
	}
}

if ($_SESSION['item_total'] >= 3) {
	$new_discount = 5;
	if ($_SESSION['item_total'] >= 5) {
		$new_discount = 10;
	}
	add_discount($_SESSION['user_id'], $new_discount);
	$_SESSION['new_discount'] = $new_discount;
}

if (isset($_SESSION['new_user_discount']) || isset($_SESSION['new_discount'])) {
	if (isset($_SESSION['new_user_discount']) && !isset($_SESSION['new_discount'])) {
		$discounts_given = $_SESSION['new_user_discount'];
	} else if (!isset($_SESSION['new_user_discount']) && isset($_SESSION['new_discount'])) {
		$discounts_given = $_SESSION['new_discount'];
	} else if (isset($_SESSION['new_user_discount']) && isset($_SESSION['new_discount'])) {
		$discounts_given = $_SESSION['new_discount'].','.$_SESSION['new_discount'];
	}
	
	$query = "UPDATE `orders`
				SET `discounts_given`='{$discounts_given}'
				WHERE `order_id` = '{$order_id}'";
	$result = $mysqli->query($query) or die($mysqli->error);
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
	'date' => $order_date,
	'time' => $order_time,
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

echo json_encode('success');

?>
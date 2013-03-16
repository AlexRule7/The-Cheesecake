<?php

session_start();

include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');

header('Content-type: application/json');

if (!empty($_POST['user-id'])) {
	$user_id = (isset($_POST['user-id'])) ? Database::sanitize($_POST['user-id']) : '';
	$phone_id = (isset($_POST['user-phone-id'])) ? Database::sanitize($_POST['user-phone-id']) : '';
	$address_id = (isset($_POST['user-address'])) ? Database::sanitize($_POST['user-address']) : '';
	$product_id = $_POST['product-id'];
	$product_amount = $_POST['product-amount'];
	$order_date = (isset($_POST['order-date'])) ? Database::sanitize($_POST['order-date']) : '';
	$order_time = (isset($_POST['order-time'])) ? Database::sanitize($_POST['order-time']) : '';
	$order_comment = (isset($_POST['order-comment'])) ? Database::sanitize($_POST['order-comment']) : '';
	
	$order_discount = (isset($_POST['order-discount'])) ? Database::sanitize($_POST['order-discount']) : '';
	$order_raw_bill = (isset($_POST['order-raw-bill'])) ? Database::sanitize($_POST['order-raw-bill']) : '';
	$order_delivery = (isset($_POST['order-delivery'])) ? Database::sanitize($_POST['order-delivery']) : '';
	$order_bill = (isset($_POST['order-bill'])) ? Database::sanitize($_POST['order-bill']) : '';
	
	$order_date = date('d.m.Y', strtotime($order_date));
	$item_total = 0;
	
	$query = "INSERT
				INTO `orders`
				SET
					`user_id`='{$user_id}',
					`phone_id`='{$phone_id}',
					`address_id`='{$address_id}',
					`admin_id`='{$_SESSION['admin_id']}',
					`delivery_date`='{$order_date}',
					`delivery_time`='{$order_time}',
					`discount`='{$order_discount}',
					`raw_bill`='{$order_raw_bill}',
					`bill`='{$order_bill}',
					`delivery`='{$order_delivery}',
					`comment`='{$order_comment}'";
					
	$result = $mysqli->query($query) or die($mysqli->error);
	$order_id = $mysqli->insert_id;
	
	if (!empty($order_discount)) {
		remove_discount($user_id, $order_discount);
	}
	
	foreach ($product_id as $key => $val) {
		if (!empty($product_amount[$key])) {
			$query = "INSERT
						INTO `purchases`
						SET
							`order_id`='{$order_id}',
							`product_id`='{$val}',
							`amount`='{$product_amount[$key]}'";
			
			$result = $mysqli->query($query) or die($mysqli->error);
			
			$item_total += $product_amount[$key];
		}
	}
	
	if ($item_total >= 3) {
		$new_discount = 5;
		if ($item_total >= 5) {
			$new_discount = 10;
		}
		add_discount($user_id, $new_discount);
		$query = "UPDATE `orders`
					SET `discounts_given`='{$new_discount}'
					WHERE `order_id` = '{$order_id}'";
		$result = $mysqli->query($query) or die($mysqli->error);
	}
	
	echo json_encode('success');
}

?>
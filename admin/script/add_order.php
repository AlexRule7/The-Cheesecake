<?php

include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');

header('Content-type: application/json');

if (!empty($_POST)) {
	$user_id = (isset($_POST['user-id'])) ? sanitize($_POST['user-id']) : '';
	$phone_id = (isset($_POST['user-phone-id'])) ? sanitize($_POST['user-phone-id']) : '';
	$address_id = (isset($_POST['user-address'])) ? sanitize($_POST['user-address']) : '';
	$product_id = $_POST['product-id'];
	$product_amount = $_POST['product-amount'];
	$order_date = (isset($_POST['order-date'])) ? sanitize($_POST['order-date']) : '';
	$order_time = (isset($_POST['order-time'])) ? sanitize($_POST['order-time']) : '';
	$order_comment = (isset($_POST['order-comment'])) ? sanitize($_POST['order-comment']) : '';
	
	$order_discount = (isset($_POST['order-discount'])) ? sanitize($_POST['order-discount']) : '';
	$order_raw_bill = (isset($_POST['order-raw-bill'])) ? sanitize($_POST['order-raw-bill']) : '';
	$order_delivery = (isset($_POST['order-delivery'])) ? sanitize($_POST['order-delivery']) : '';
	$order_bill = (isset($_POST['order-bill'])) ? sanitize($_POST['order-bill']) : '';
	
	$order_date = date('d.m.Y', strtotime($order_date));
	$item_total = 0;
	
	$query = "INSERT
				INTO `orders`
				SET
					`user_id`='{$user_id}',
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
	
	if (!empty($order_discount)) {
		$query = "SELECT *
					FROM `discounts`
					WHERE `user_id` = '{$user_id}' AND `discount` = '{$order_discount}'";
					
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
	
	foreach ($product_id as $key => $val) {
		$query = "INSERT
					INTO `purchases`
					SET
						`order_id`='{$order_id}',
						`product_id`='{$val}',
						`amount`='{$product_amount[$key]}'";
		
		$sql = mysql_query($query) or die(mysql_error());
		
		$item_total += $product_amount[$key];
	}
	
	if ($item_total >= 3) {
		$new_discount = 5;
		if ($item_total >= 5) {
			$new_discount = 10;
		}
		$query = "SELECT *
					FROM `discounts`
					WHERE `user_id` = '{$user_id}'";
					
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
							`user_id`='{$user_id}',
							`discount`='{$new_discount}',
							`value`='1'";
							
			$sql = mysql_query($query) or die(mysql_error());
		}
	}
	
	echo json_encode('success');
}

?>
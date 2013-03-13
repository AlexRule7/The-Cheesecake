<?php

session_start();

include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');
include($_SERVER['DOCUMENT_ROOT'].'/admin/script/functions.php');

header('Content-type: application/json');

if (!empty($_POST['cancel-id'])) {
	$cancel_id = sanitize($_POST['cancel-id']);
	
	$query = "UPDATE `orders`
				SET `canceled`='1'
				WHERE `order_id` = '{$cancel_id}'";
	$sql = mysql_query($query) or die(mysql_error());
	
	$query = "SELECT `user_id`, `discounts_given`
				FROM `orders`
				WHERE `order_id` = '{$cancel_id}'";

	$sql = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_assoc($sql);
	
	$discounts = explode(',', $row['discounts_given']);
	
	foreach ($discounts as $key => $val) {
		remove_discount($row['user_id'], $val);
	}
	
	echo json_encode('success');
} else if (!empty($_POST['approve-id'])) {
	$approve_id = sanitize($_POST['approve-id']);
	
	$query = "UPDATE `orders`
				SET `canceled`='0'
				WHERE `order_id` = '{$approve_id}'";
	$sql = mysql_query($query) or die(mysql_error());
	
	$query = "SELECT `user_id`, `discounts_given`
				FROM `orders`
				WHERE `order_id` = '{$approve_id}'";

	$sql = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_assoc($sql);
	
	$discounts = explode(',', $row['discounts_given']);
	
	foreach ($discounts as $key => $val) {
		add_discount($row['user_id'], $val);
	}
	
	echo json_encode('success');
} else if (!empty($_POST['order-id']) && !empty($_POST['user-id'])) {
	$user_id = (isset($_POST['user-id'])) ? sanitize($_POST['user-id']) : '';
	$phone_id = (isset($_POST['user-phone-id'])) ? sanitize($_POST['user-phone-id']) : '';
	$address_id = (isset($_POST['user-address'])) ? sanitize($_POST['user-address']) : '';
	$order_id = (isset($_POST['order-id'])) ? sanitize($_POST['order-id']) : '';
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
	
	$query = "SELECT *
				FROM `orders`
				WHERE `order_id` = '{$order_id}'";

	$sql = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_assoc($sql);
	
	if ($order_discount != $row['discount']) {
		if (!empty($row['discount'])) {
			add_discount ($user_id, $row['discount']);
		}
		if (!empty($order_discount)) {
			remove_discount($user_id, $order_discount);
		}
	}
	
	$query = "DELETE
				FROM `purchases`
				WHERE `order_id` = '{$order_id}'";

	$sql = mysql_query($query) or die(mysql_error());
	
	foreach ($product_id as $key => $val) {
		if (!empty($product_amount[$key])) {
			$query = "INSERT
						INTO `purchases`
						SET
							`order_id`='{$order_id}',
							`product_id`='{$val}',
							`amount`='{$product_amount[$key]}'";
			
			$sql = mysql_query($query) or die(mysql_error());
			
			$item_total += $product_amount[$key];
		}
	}
	
	if (!empty($row['discounts_given'])) {
		$discounts_given_old = explode(',', $row['discounts_given']);
		foreach ($discounts_given_old as $key => $val) {
			if ($val == 5) {
				$query = "SELECT *
							FROM `orders`
							WHERE `user_id` = '{$user_id}' AND `admin_id` = '0'";
			
				$sql = mysql_query($query) or die(mysql_error());
				$aaa = mysql_num_rows($sql);
				if (mysql_num_rows($sql) == 1) {
					$new_user_discount = 5;
				} else {
					remove_discount($user_id, $val);
				}
			} else {
				remove_discount($user_id, $val);
			}
		}
	}
	
	if ($item_total >= 3) {
		$new_discount = 5;
		if ($item_total >= 5) {
			$new_discount = 10;
		}
		add_discount($user_id, $new_discount);
	}
	
	if (isset($new_user_discount) || isset($new_discount)) {
		if (isset($new_user_discount) && !isset($new_discount)) {
			$discounts_given = $new_user_discount;
		} else if (!isset($new_user_discount) && isset($new_discount)) {
			$discounts_given = $new_discount;
		} else if (isset($new_user_discount) && isset($new_discount)) {
			$discounts_given = $new_user_discount.','.$new_discount;
		}
	}
	
	$query = "UPDATE `orders`
				SET
					`address_id`='{$address_id}',
					`delivery_date`='{$order_date}',
					`delivery_time`='{$order_time}',
					`discount`='{$order_discount}',
					`raw_bill`='{$order_raw_bill}',
					`bill`='{$order_bill}',
					`delivery`='{$order_delivery}',
					`comment`='{$order_comment}',
					`discounts_given`='{$discounts_given}'
				WHERE `order_id`='{$order_id}'";
					
	$sql = mysql_query($query) or die(mysql_error());
	
	echo json_encode('success');
	
}

?>
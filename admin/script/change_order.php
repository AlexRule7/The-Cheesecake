<?php

session_start();

include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');

header('Content-type: application/json');

if (!empty($_POST['cancel-id'])) {
	$cancel_id = Database::sanitize($_POST['cancel-id']);
	
	$query = "UPDATE `orders`
				SET
					`admin_id_change`='{$_SESSION['admin_id']}',
					`canceled`='1'
				WHERE `order_id` = '{$cancel_id}'";
	$result = $mysqli->query($query) or die($mysqli->error);
	
	$query = "SELECT `user_id`, `discounts_given`
				FROM `orders`
				WHERE `order_id` = '{$cancel_id}'";

	$result = $mysqli->query($query) or die($mysqli->error);
	$row = $result->fetch_assoc();
	
	$discounts = explode(',', $row['discounts_given']);
	
	foreach ($discounts as $key => $val) {
		remove_discount($row['user_id'], $val);
	}
	
	echo json_encode('success');
} else if (!empty($_POST['approve-id'])) {
	$approve_id = Database::sanitize($_POST['approve-id']);
	
	$query = "UPDATE `orders`
				SET
					`admin_id_change`='{$_SESSION['admin_id']}',
					`canceled`='0'
				WHERE `order_id` = '{$approve_id}'";
	$result = $mysqli->query($query) or die($mysqli->error);
	
	$query = "SELECT `user_id`, `discounts_given`
				FROM `orders`
				WHERE `order_id` = '{$approve_id}'";

	$result = $mysqli->query($query) or die($mysqli->error);
	$row = $result->fetch_assoc();
	
	$discounts = explode(',', $row['discounts_given']);
	
	foreach ($discounts as $key => $val) {
		add_discount($row['user_id'], $val);
	}
	
	echo json_encode('success');
} else if (!empty($_POST['order-id']) && !empty($_POST['user-id'])) {
	$user_id = (isset($_POST['user-id'])) ? Database::sanitize($_POST['user-id']) : '';
	$phone_id = (isset($_POST['user-phone-id'])) ? Database::sanitize($_POST['user-phone-id']) : '';
	$address_id = (isset($_POST['user-address'])) ? Database::sanitize($_POST['user-address']) : '';
	$order_id = (isset($_POST['order-id'])) ? Database::sanitize($_POST['order-id']) : '';
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
	
	$query = "SELECT *
				FROM `orders`
				WHERE `order_id` = '{$order_id}'";

	$result = $mysqli->query($query) or die($mysqli->error);
	$row = $result->fetch_assoc();
	
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

	$result = $mysqli->query($query) or die($mysqli->error);
	
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
	
	if (!empty($row['discounts_given'])) {
		$discounts_given_old = explode(',', $row['discounts_given']);
		foreach ($discounts_given_old as $key => $val) {
			if ($val == 5) {
				$query = "SELECT *
							FROM `orders`
							WHERE `user_id` = '{$user_id}' AND `admin_id` = '0'";
			
				$result = $mysqli->query($query) or die($mysqli->error);
				if ($result->num_rows == 1) {
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
					`admin_id_change`='{$_SESSION['admin_id']}',
					`delivery_date`='{$order_date}',
					`delivery_time`='{$order_time}',
					`discount`='{$order_discount}',
					`raw_bill`='{$order_raw_bill}',
					`bill`='{$order_bill}',
					`delivery`='{$order_delivery}',
					`comment`='{$order_comment}',
					`discounts_given`='{$discounts_given}'
				WHERE `order_id`='{$order_id}'";
					
	$result = $mysqli->query($query) or die($mysqli->error);
	
	echo json_encode('success');
	
}

?>
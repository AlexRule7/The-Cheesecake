<?php

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
}

?>
<?php
include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');

if ( isset($_REQUEST['term'])) {
	$query = "SELECT `user_id`, `phone`
				FROM `phones`
				WHERE `phone` like '".sanitize($_REQUEST['term'])."%'
				ORDER BY phone ASC LIMIT 0,10";
	$sql = mysql_query($query) or die(mysql_error());
	 
	$data = array();
	if ( $sql && mysql_num_rows($sql)) {
		while( $row = mysql_fetch_assoc($sql) ) {
			$query2 = "SELECT `name`
						FROM `users`
						WHERE `user_id`='{$row['user_id']}'";
			$sql2 = mysql_query($query2) or die(mysql_error());
			$row2 = mysql_fetch_assoc($sql2);
			$data[] = array(
				'label' => $row['phone'] .', '. $row2['name'],
				'value' => $row['phone']
			);
		}
	}

	echo json_encode($data);
	flush();
} else if (isset($_REQUEST['phone'])) {
	$query = "SELECT `phone_id`, `user_id`
				FROM `phones`
				WHERE `phone` like '%".sanitize($_REQUEST['phone'])."'";
	$sql = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_assoc($sql);
	$user_id = $row['user_id'];
	$phone_id = $row['phone_id'];
	
	$query = "SELECT *
				FROM `users`
				WHERE `user_id`='{$user_id}'";
	$sql = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_assoc($sql);
	
	$data = array (
		'user_id' => $user_id,
		'phone_id' => $phone_id,
		'user_name' => $row['name'],
		'user_email' => $row['email'],
		'addresses' => array(),
		'discounts' => array(),
		'phones' => array()
	);
	
	$query = "SELECT *
				FROM `addresses`
				WHERE `user_id` = '{$user_id}'";
	
	$sql = mysql_query($query) or die(mysql_error());
	$i = 0;
	if ( $sql && mysql_num_rows($sql) ) {
		while( $row = mysql_fetch_assoc($sql)) {
			$address = "м. {$row['metro']}, {$row['street']} {$row['house']}".
				(!empty($row['building']) ? 'к'.$row['building'].'' : '').
				(!empty($row['flat']) ? ', кв. '.$row['flat'].'' : '').
				(!empty($row['enter']) ? ', подъезд '.$row['enter'].'' : '').
				(!empty($row['floor']) ? ', этаж '.$row['floor'].'' : '').
				(!empty($row['domofon']) ? ', домофон '.$row['domofon'].'' : '');
			$data['addresses'][$i]['title'] = $address;
			foreach ($row as $key => $val) {
				$data['addresses'][$i][$key] = $val;
			}
		}
	}
	
	$query = "SELECT *
				FROM `discounts`
				WHERE `user_id` = '{$user_id}'";
	
	$sql = mysql_query($query) or die(mysql_error());
	if ( $sql && mysql_num_rows($sql) ) {
		while( $row = mysql_fetch_assoc($sql)) {
			$data['discounts'][$row['discount']] = $row['value'];
		}
	}
	
	$query = "SELECT *
				FROM `phones`
				WHERE `user_id` = '{$user_id}'";
	
	$sql = mysql_query($query) or die(mysql_error());
	if ( $sql && mysql_num_rows($sql) ) {
		while( $row = mysql_fetch_assoc($sql)) {
			$data['phones'][$row['phone_id']] = $row['phone'];
		}
	}

	echo json_encode($data);
	flush();
}

?>
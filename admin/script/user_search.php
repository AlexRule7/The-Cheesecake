<?php
include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');

if ( isset($_REQUEST['term'])) {
	$query = "SELECT `user_id`, `phone`
				FROM `phones`
				WHERE `phone` like '".Database::sanitize($_REQUEST['term'])."%'
				ORDER BY phone ASC LIMIT 0,10";
	$result = $mysqli->query($query) or die($mysqli->error);
	 
	$data = array();
	if ($result->num_rows) {
		while($row = $result->fetch_assoc()) {
			$query2 = "SELECT `name`
						FROM `users`
						WHERE `user_id`='{$row['user_id']}'";
			$result2 = $mysqli->query($query2) or die($mysqli->error);
			$row2 = $result2->fetch_assoc();
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
				WHERE `phone` like '%".Database::sanitize($_REQUEST['phone'])."'";
	$result = $mysqli->query($query) or die($mysqli->error);
	$row = $result->fetch_assoc();
	$user_id = $row['user_id'];
	$phone_id = $row['phone_id'];
	
	$query = "SELECT *
				FROM `users`
				WHERE `user_id`='{$user_id}'";
	$result = $mysqli->query($query) or die($mysqli->error);
	$row = $result->fetch_assoc();
	
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
	
	$result = $mysqli->query($query) or die($mysqli->error);
	$i = 0;
	if ($result->num_rows) {
		while($row = $result->fetch_assoc()) {
			$data['addresses'][$i]['title'] = address_title($row);
			foreach ($row as $key => $val) {
				$data['addresses'][$i][$key] = $val;
			}
			$i++;
		}
	}
	
	$query = "SELECT *
				FROM `discounts`
				WHERE `user_id` = '{$user_id}'";
	
	$result = $mysqli->query($query) or die($mysqli->error);
	if ($result->num_rows) {
		while($row = $result->fetch_assoc()) {
			$data['discounts'][$row['discount']] = $row['value'];
		}
	}
	
	$query = "SELECT *
				FROM `phones`
				WHERE `user_id` = '{$user_id}'";
	
	$result = $mysqli->query($query) or die($mysqli->error);
	if ($result->num_rows) {
		while($row = $result->fetch_assoc()) {
			$data['phones'][$row['phone_id']] = $row['phone'];
		}
	}

	echo json_encode($data);
	flush();
}

?>
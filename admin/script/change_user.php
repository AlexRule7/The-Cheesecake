<?php

include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');

header('Content-type: application/json');

if (!empty($_POST)) {
	$user_id = (!empty($_POST['user-id'])) ? sanitize($_POST['user-id']) : '';
	$user_name = (!empty($_POST['user-name'])) ? sanitize($_POST['user-name']) : '';
	$user_email = (!empty($_POST['user-email'])) ? sanitize($_POST['user-email']) : '';
	$phone_id = $_POST['user-phone-id'];
	$phone = $_POST['user-phone'];
	
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

	// Phone update
	foreach ($phone_id as $key => $val) {
		if ($key != 0) {
			if ($val != 0) {
				$query = "SELECT `phone`
							FROM `phones`
							WHERE `phone_id` = '{$val}'";
				$sql = mysql_query($query) or die(mysql_error());
				$row = mysql_fetch_assoc($sql);
				if ($phone[$key] == '') {
					$query = "DELETE
								FROM `phones`
								WHERE `phone_id` = '{$val}'";
					$sql = mysql_query($query) or die(mysql_error());
				} else if ($row['phone'] != $phone[$key]) {
					$query = "UPDATE `phones`
								SET `phone`='{$phone[$key]}'
								WHERE `phone_id` = '{$val}'";
					$sql = mysql_query($query) or die(mysql_error());
				}
			} else {
				if ($phone[$key] != '') {
					$query = "SELECT *
								FROM `phones`
								WHERE `user_id`='{$user_id}'";
					$sql = mysql_query($query) or die(mysql_error());
					while ($row = mysql_fetch_assoc($sql)) {
						if ($row['phone'] == $phone[$key]) {
							$error = array (
								'id' => 1,
								'phone_id' => $row['phone_id'],
								'text' => 'У вас уже добавлен такой номер'
							);
							echo json_encode($error);
							exit;
						}
					}
					$query = "INSERT
								INTO `phones`
								SET
									`user_id`='{$user_id}',
									`phone`='{$phone[$key]}'";
									
					$sql = mysql_query($query) or die(mysql_error());
				}
			}
		}
	}
	
	// Personal update
	$query = "SELECT `name`, `email`
				FROM `users`
				WHERE `user_id` = '{$user_id}'";
	$sql = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_assoc($sql);
	
	if ($row['name'] != $user_name || $row['email'] != $user_email) {
		$query = "UPDATE `users`
					SET
						`name`='{$user_name}',
						`email`='{$user_email}'
					WHERE `user_id` = '{$user_id}'";
		$sql = mysql_query($query) or die(mysql_error());
	}
	
	// Address update
	if ($address_id != 0) {
		$query = "UPDATE `addresses`
					SET
						`metro`='{$user_metro}',
						`street`='{$user_street}',
						`house`='{$user_house}',
						`building`='{$user_building}',
						`office`='{$user_office}',
						`company`='{$user_company}',
						`flat`='{$user_flat}',
						`enter`='{$user_enter}',
						`floor`='{$user_floor}',
						`domofon`='{$user_domofon}'
					WHERE `address_id`='{$address_id}'";
	} else {
		$query = "INSERT
					INTO `addresses`
					SET
						`user_id`='{$user_id}',
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
	}
	$sql = mysql_query($query) or die(mysql_error());
	
	echo json_encode('success');
	
}

?>
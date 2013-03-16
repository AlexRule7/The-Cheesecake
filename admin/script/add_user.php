<?php

session_start();

include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');

header('Content-type: application/json');

if (!empty($_POST['user-name'])) {
	$user_name = (isset($_POST['user-name'])) ? Database::sanitize($_POST['user-name']) : '';
	$user_phone = (isset($_POST['user-phone'])) ? Database::sanitize($_POST['user-phone']) : '';
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
		
	$query = "SELECT *
				FROM `phones`
				WHERE `phone` = '{$user_phone}'";

	$result = $mysqli->query($query) or die($mysqli->error);
	
	if (!$result->num_rows) {
		$query = "INSERT
					INTO `users`
					SET
						`name`='{$user_name}',
						`admin_id`='{$_SESSION['admin_id']}',
						`bonus_received`='0'";
						
		$result = $mysqli->query($query) or die($mysqli->error);
		$user_id = $mysqli->insert_id;
		
		$query = "INSERT
					INTO `phones`
					SET
						`user_id`='{$user_id}',
						`phone`='{$user_phone}'";
						
		$result = $mysqli->query($query) or die($mysqli->error);
		
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
						
		$result = $mysqli->query($query) or die($mysqli->error);
		echo json_encode('success');
	} else {
		$error = array (
			'id' => '1',
			'text' => 'Пользователь с таким телефоном уже зарегистрирован'
		);
		echo json_encode($error);
	}
}

?>
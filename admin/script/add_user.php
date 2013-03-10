<?php

include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');

header('Content-type: application/json');

if (!empty($_POST)) {
	$user_name = (isset($_POST['user-name'])) ? sanitize($_POST['user-name']) : '';
	$user_phone = (isset($_POST['user-phone'])) ? sanitize($_POST['user-phone']) : '';
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
		
	$query = "SELECT *
				FROM `phones`
				WHERE `phone` = '{$user_phone}'";

	$sql = mysql_query($query) or die(mysql_error());
	
	if (!mysql_num_rows($sql)) {
		$query = "INSERT
					INTO `users`
					SET
						`name`='{$user_name}',
						`bonus_received`='0'";
						
		$sql = mysql_query($query) or die(mysql_error());
		$user_id = mysql_insert_id();
		
		$query = "INSERT
					INTO `phones`
					SET
						`user_id`='{$user_id}',
						`phone`='{$user_phone}'";
						
		$sql = mysql_query($query) or die(mysql_error());
		
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
						
		$sql = mysql_query($query) or die(mysql_error());
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
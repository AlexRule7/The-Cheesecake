<?php

// Use session_start() in all pages that are working with sessions
session_start();

include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');

header('Content-type: application/json');

if (isset($_POST['id'])) {
	$query = "DELETE
			  FROM `addresses`
			  WHERE `address_id` = '{$_POST['id']}'";
	$sql = mysql_query($query) or die(mysql_error());
	
	echo json_encode('success');
	exit;
} else {
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
						`user_id`='{$_SESSION['user_id']}',
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
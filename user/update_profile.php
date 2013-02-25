<?php

// Use session_start() in all pages that are working with sessions
session_start();

include($_SERVER['DOCUMENT_ROOT'].'/Connections/exarium.php');

header('Content-type: application/json');

if (!empty($_POST)) {
	$user_name = (isset($_POST['user-name'])) ? sanitize($_POST['user-name']) : '';
	$user_email = (isset($_POST['user-email'])) ? sanitize($_POST['user-email']) : '';
	foreach ($_POST as $key => $val) {
		if ($key == 'user-phone-id') {
			$phone_id = $val;
		} else if ($key == 'user-phone') {
			$phone = $val;
		}
	}
	$i = 0;
	foreach ($phone_id as $key => $val) {
		if ($val != 0) {
			$query = "SELECT `phone`
						FROM `phones`
						WHERE `phone_id` = '{$val}'";
			$sql = mysql_query($query) or die(mysql_error());
			$row = mysql_fetch_assoc($sql);
			if ($phone[$i] == '') {
				$query = "DELETE
							FROM `phones`
							WHERE `phone_id` = '{$val}'";
				$sql = mysql_query($query) or die(mysql_error());
			} else if ($row['phone'] != $phone[$i]) {
				$query = "UPDATE `phones`
							SET `phone`='{$phone[$i]}'
							WHERE `phone_id` = '{$val}'";
				$sql = mysql_query($query) or die(mysql_error());
			}
		} else {
			if ($phone[$i] != '') {
				$query = "SELECT `phone`
							FROM `phones`
							WHERE `user_id`='{$_SESSION['user_id']}'";
				$sql = mysql_query($query) or die(mysql_error());
				while ($row = mysql_fetch_assoc($sql)) {
					if ($row['phone'] == $phone[$i]) {
						$exists = 1;
					}
				}
				if ($exists != 1) {
					$query = "INSERT
								INTO `phones`
								SET
									`user_id`='{$_SESSION['user_id']}',
									`phone`='{$phone[$i]}'";
									
					$sql = mysql_query($query) or die(mysql_error());
				} else {
					$error = array (
						'id' => 1,
						'text' => 'У вас уже добавлен такой номер'
					);
					echo json_encode($error);
					exit;
				}
			}
		}
		$i++;	
	}
	
	$query = "SELECT `name`
				FROM `users`
				WHERE `user_id` = '{$_SESSION['user_id']}'";
	$sql = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_assoc($sql);
	
	if ($row['name'] != $user_name) {
		$query = "UPDATE `users`
					SET `name`='{$user_name}'
					WHERE `user_id` = '{$_SESSION['user_id']}'";
		$sql = mysql_query($query) or die(mysql_error());
	}
	
	echo json_encode('success');
}

?>
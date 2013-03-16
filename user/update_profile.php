<?php

// Use session_start() in all pages that are working with sessions
session_start();

include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');

header('Content-type: application/json');

if (!empty($_POST)) {
	$user_name = (!empty($_POST['user-name'])) ? Database::sanitize($_POST['user-name']) : '';
	$user_email = (!empty($_POST['user-email'])) ? Database::sanitize($_POST['user-email']) : '';
	$user_pass_old = (!empty($_POST['user-pass-old'])) ? Database::sanitize($_POST['user-pass-old']) : '';
	$user_pass = (!empty($_POST['user-pass'])) ? Database::sanitize($_POST['user-pass']) : '';
	$user_pass_conf = (!empty($_POST['user-pass-conf'])) ? Database::sanitize($_POST['user-pass-conf']) : '';
	
	foreach ($_POST as $key => $val) {
		if ($key == 'user-phone-id') {
			$phone_id = $val;
		} else if ($key == 'user-phone') {
			$phone = $val;
		}
	}
	foreach ($phone_id as $key => $val) {
		if ($val != 0) {
			$query = "SELECT `phone`
						FROM `phones`
						WHERE `phone_id` = '{$val}'";
			$result = $mysqli->query($query) or die($mysqli->error);
			$row = $result->fetch_assoc();
			if ($phone[$key] == '') {
				$query = "DELETE
							FROM `phones`
							WHERE `phone_id` = '{$val}'";
				$result = $mysqli->query($query) or die($mysqli->error);
			} else if ($row['phone'] != $phone[$key]) {
				$query = "UPDATE `phones`
							SET `phone`='{$phone[$key]}'
							WHERE `phone_id` = '{$val}'";
				$result = $mysqli->query($query) or die($mysqli->error);
			}
		} else {
			if ($phone[$key] != '') {
				$query = "SELECT `phone`
							FROM `phones`
							WHERE `user_id`='{$_SESSION['user_id']}'";
				$result = $mysqli->query($query) or die($mysqli->error);
				while ($row = $result->fetch_assoc()) {
					if ($row['phone'] == $phone[$key]) {
						$exists = 1;
					}
				}
				if ($exists != 1) {
					$query = "INSERT
								INTO `phones`
								SET
									`user_id`='{$_SESSION['user_id']}',
									`phone`='{$phone[$key]}'";
									
					$result = $mysqli->query($query) or die($mysqli->error);
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
	}
	
	$query = "SELECT *
				FROM `users`
				WHERE `user_id` = '{$_SESSION['user_id']}'";
	$result = $mysqli->query($query) or die($mysqli->error);
	$row = $result->fetch_assoc();
	
	if ($row['name'] != $user_name) {
		$query = "UPDATE `users`
					SET `name`='{$user_name}'
					WHERE `user_id` = '{$_SESSION['user_id']}'";
		$result = $mysqli->query($query) or die($mysqli->error);
	}
	
	if (!empty($user_pass_old) && !empty($user_pass) && !empty($user_pass_conf)) {
		$salt = $row['salt'];
		$user_pass_old = md5(md5($user_pass_old) . $salt);
		if ($row['password'] == $user_pass_old) {
			$salt = GenerateSalt();
			$user_pass = md5(md5($user_pass) . $salt);
			$query = "UPDATE `users`
						SET
							`password`='{$user_pass}',
							`salt`='{$salt}'
						WHERE `user_id` = '{$_SESSION['user_id']}'";
			$result = $mysqli->query($query) or die($mysqli->error);
			
			echo json_encode('success');
		} else {
			$error = array (
				'id' => 2,
				'text' => 'Вы неверно ввели старый пароль'
			);
			echo json_encode($error);
			exit;
		}
	} else {
		echo json_encode('success');
	}
	
}

?>
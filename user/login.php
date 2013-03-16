<?php

// Use session_start() in all pages that are working with sessions
session_start();

include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');

header('Content-type: application/json');

if (!empty($_POST)) {
	$email = (isset($_POST['user-email'])) ? Database::sanitize($_POST['user-email']) : '';
	$pass = (isset($_POST['user-pass'])) ? Database::sanitize($_POST['user-pass']) : '';
	
	$query = "SELECT `salt`
				FROM `users`
				WHERE `email`='{$email}'";
	$result = $mysqli->query($query) or die($mysqli->error);
	
	if ($result->num_rows) {
		$row = $result->fetch_assoc();	
		$salt = $row['salt'];
		$password = md5(md5($pass) . $salt);

		$query = "SELECT *
					FROM `users`
					WHERE `email`='{$email}' AND `password`='{$password}'";
		$result = $mysqli->query($query) or die($mysqli->error);

		if ($result->num_rows == 1) {
			$row = $result->fetch_assoc();
			$salt = $row['salt'];
			$hashed_id = md5(md5($row['user_id']) . $salt);
			$_SESSION['user_id'] = $row['user_id'];
			$_SESSION['user_hashed_id'] = $hashed_id;
			
			// If "remember me" is checked, then assign him a cookie with login and hashed password
			$time = 60*60*24*30; // set cookie for a month
			if (isset($_POST['user-remember'])) {
				setcookie('email', $email, time()+$time, "/");
				setcookie('password', $password, time()+$time, "/");
			}
			echo json_encode('success');
		} else {
			$error = array (
				'id' => '2',
				'text' => 'Пароль неверный'
			);
			echo json_encode($error);
		}
	} else {
		$error = array (
			'id' => '1',
			'text' => 'Пользователя с таким e-mail не существует'
		);
		echo json_encode($error);
	}
}

?>
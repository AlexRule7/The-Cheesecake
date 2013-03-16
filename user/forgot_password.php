<?php

// Use session_start() in all pages that are working with sessions
session_start();

include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');

header('Content-type: application/json');

if (!empty($_POST['user-email'])) {
	$user_email = Database::sanitize($_POST['user-email']);
	
	$query = "SELECT `user_id`, `name`
				FROM `users`
				WHERE `email` = '{$user_email}'";
	$result = $mysqli->query($query) or die($mysqli->error);
	
	if ($result->num_rows) {
		$row = $result->fetch_assoc();
		$user_name = $row['name'];
		$hash = uniqid();
		
		$query = "SELECT `change_id`
					FROM `password_change`
					WHERE `user_id`='{$row['user_id']}'";
		$result = $mysqli->query($query) or die($mysqli->error);
		
		if ($result->num_rows) {
			$query = "DELETE
						FROM `password_change`
						WHERE `user_id`='{$row['user_id']}'";
			$result = $mysqli->query($query) or die($mysqli->error);
		}
		
		$query = "INSERT
					INTO `password_change`
					SET
						`user_id`='{$row['user_id']}',
						`hash`='{$hash}'";
						
		$result = $mysqli->query($query) or die($mysqli->error);
		
		// MAIL
		
		$mail_data = array (
			'file' => 'forgot',
			'user_name' => $user_name,
			'url_hash' => $hash
		);
		
		$subject = 'Смена пароля';
		$message = send_mail($mail_data);
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf8' . "\r\n";
		$headers .= 'To: '.$user_name.' <'.$user_email.'>' . "\r\n";
		$headers .= 'From: Moscow Cheesecake <info@thecheesecake.ru>' . "\r\n";
		mail($user_email, $subject, $message, $headers);
		
		// END OF MAIL
		
		echo json_encode('success');
	} else {
		$error = array (
			'id' => 1,
			'text' => 'Пользователь с такими e-mail адресом не зарегистрирован'
		);
		echo json_encode($error);
		exit;
	}
} else if (!empty($_POST['user-pass']) && !empty($_POST['user-pass-conf'])) {
	$user_id = Database::sanitize($_POST['user-id']);
	$user_pass = Database::sanitize($_POST['user-pass']);
	$salt = GenerateSalt();
	$user_pass = md5(md5($user_pass) . $salt);
	
	$query = "UPDATE `users`
				SET
					`password`='{$user_pass}',
					`salt`='{$salt}'
				WHERE `user_id` = '{$user_id}'";
	$result = $mysqli->query($query) or die($mysqli->error);
	
	$query = "DELETE
				FROM `password_change`
				WHERE `user_id`='{$user_id}'";
	$result = $mysqli->query($query) or die($mysqli->error);
	
	echo json_encode('success');
}

?>
<?php

// Use session_start() in all pages that are working with sessions
session_start();

include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');

header('Content-type: application/json');

if (!empty($_POST))
{
	$user_name = (isset($_POST['user-name'])) ? sanitize($_POST['user-name']) : '';
	$user_email = (isset($_POST['user-email'])) ? sanitize($_POST['user-email']) : '';
	$user_phone = (isset($_POST['user-phone'])) ? sanitize($_POST['user-phone']) : '';
	$pass = (isset($_POST['user-pass'])) ? sanitize($_POST['user-pass']) : '';
		
	$salt = GenerateSalt();
	$password = md5(md5($pass) . $salt);
		
	$query = "SELECT *
				FROM `users`
				WHERE `email` = '{$user_email}'";

	$sql = mysql_query($query) or die(mysql_error());
	
	if (!mysql_num_rows($sql)) {
		$query = "SELECT *
					FROM `phones`
					WHERE `phone` = '{$user_phone}'";
	
		$sql = mysql_query($query) or die(mysql_error());
		
		if (!mysql_num_rows($sql)) {
			$query = "INSERT
						INTO `users`
						SET
							`name`='{$user_name}',
							`email`='{$user_email}',
							`password`='{$password}',
							`bonus_received`='0',
							`salt`='{$salt}'";
							
			$sql = mysql_query($query) or die(mysql_error());
			$_SESSION['user_id'] = mysql_insert_id();
			
			$query = "INSERT
						INTO `phones`
						SET
							`user_id`='{$_SESSION['user_id']}',
							`phone`='{$user_phone}'";
							
			$sql = mysql_query($query) or die(mysql_error());
		} else {
			$row = mysql_fetch_assoc($sql);
			$user_id = $row['user_id'];
			
			$query = "SELECT *
						FROM `users`
						WHERE `user_id` = '{$user_id}'";
		
			$sql = mysql_query($query) or die(mysql_error());
			$row = mysql_fetch_assoc($sql);
			
			if (empty($row['email'])) {
				$query = "UPDATE `users`
							SET
								`name`='{$user_name}',
								`email`='{$user_email}',
								`password`='{$password}',
								`bonus_received`='0',
								`salt`='{$salt}'
							WHERE `user_id`='{$user_id}'";
				
				$sql = mysql_query($query) or die(mysql_error());
				$_SESSION['user_id'] = $user_id;
			} else {
				$error = array (
					'id' => '2',
					'text' => 'Пользователь с таким телефоном уже зарегистрирован'
				);
				echo json_encode($error);
				exit;
			}
		}
		// MAIL
		
		$mail_data = array (
			'file' => 'register',
			'user_name' => $user_name
		);
		
		$subject = 'Добро пожаловать, '.$user_name;
		$message = send_mail($mail_data);
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf8' . "\r\n";
		$headers .= 'To: '.$user_name.' <'.$user_email.'>' . "\r\n";
		$headers .= 'From: Moscow Cheesecake <info@thecheesecake.ru>' . "\r\n";
		mail($user_email, $subject, $message, $headers);
		
		// END OF MAIL
				
		echo json_encode ('success');
	} else {
		$error = array (
			'id' => '1',
			'text' => 'Пользователь с таким e-mail уже зарегистрирован'
		);
		echo json_encode($error);
	}
}

?>
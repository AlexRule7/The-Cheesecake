<?php

// Use session_start() in all pages that are working with sessions
session_start();

include($_SERVER['DOCUMENT_ROOT'].'/Connections/exarium.php');

header('Content-type: application/json');

if (!empty($_POST['user-email'])) {
	$user_email = (!empty($_POST['user-email'])) ? sanitize($_POST['user-email']) : '';
	
	$query = "SELECT `user_id`
				FROM `users`
				WHERE `email` = '{$user_email}'";
	$sql = mysql_query($query) or die(mysql_error());
	
	if (mysql_num_rows($sql)) {
		$row = mysql_fetch_assoc($sql);
		$hash = uniqid();
		
		$query2 = "SELECT `change_id`
					FROM `password_change`
					WHERE `user_id`='{$row['user_id']}'";
		$sql2 = mysql_query($query2) or die(mysql_error());
		
		if (mysql_num_rows($sql2)) {
			$query3 = "DELETE
						FROM `password_change`
						WHERE `user_id`='{$row['user_id']}'";
			$sql3 = mysql_query($query3) or die(mysql_error());
		}
		
		$query = "INSERT
					INTO `password_change`
					SET
						`user_id`='{$row['user_id']}',
						`hash`='{$hash}'";
						
		$sql = mysql_query($query) or die(mysql_error());
				
		$to = $user_email;
		$subject = 'Смена пароля';
		$message = 'http://'.$_SERVER['HTTP_HOST'].'/profile/forgot/?hash='.$hash;
		$from = 'info@thecheesecake.ru';
		$headers = 'From:' . $from;
		mail($to,$subject,$message,$headers);
		
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
	$user_id = sanitize($_POST['user-id']);
	$user_pass = sanitize($_POST['user-pass']);
	$salt = GenerateSalt();
	$user_pass = md5(md5($user_pass) . $salt);
	
	$query = "UPDATE `users`
				SET
					`password`='{$user_pass}',
					`salt`='{$salt}'
				WHERE `user_id` = '{$user_id}'";
	$sql = mysql_query($query) or die(mysql_error());
	
	$query = "DELETE
				FROM `password_change`
				WHERE `user_id`='{$user_id}'";
	$sql = mysql_query($query) or die(mysql_error());
	
	echo json_encode('success');
}

?>
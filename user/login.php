<?php

// Use session_start() in all pages that are working with sessions
session_start();

require(dirname(__FILE__).'/../Connections/exarium.php');

header('Content-type: application/json');

if (!empty($_POST))
{
	$mail = (isset($_POST['user-email'])) ? sanitize($_POST['user-email']) : '';
	$pass = (isset($_POST['user-pass'])) ? sanitize($_POST['user-pass']) : '';
	
	$query = "SELECT `salt`
				FROM `users`
				WHERE `mail`='{$mail}'
				LIMIT 1";
	$sql = mysql_query($query) or die(mysql_error());
	
	if (mysql_num_rows($sql) == 1)
	{
		$row = mysql_fetch_assoc($sql);		
		$salt = $row['salt'];
		$password = md5(md5($pass) . $salt);

		$query = "SELECT `user_id`, `name`
					FROM `users`
					WHERE `mail`='{$mail}' AND `password`='{$password}'
					LIMIT 1";
		$sql = mysql_query($query) or die(mysql_error());

		// If user exists
		if (mysql_num_rows($sql) == 1)
		{
			// We create session based on user's id
			$row = mysql_fetch_assoc($sql);
			$_SESSION['user_id'] = $row['user_id'];
			
			// If "remember me" is checked, then assign him a cookie with login and hashed password
			$time = 60*60*24*30; // set cookie for a month
			if (isset($_POST['user-remember']))
			{
				setcookie('mail', $mail, time()+$time, "/");
				setcookie('password', $password, time()+$time, "/");
			}
			echo json_encode('success');
		}
		else
		{
			$error = array (
				'id' => '2',
				'text' => 'Пароль неверный'
			);
			echo json_encode($error);
		}
	}
	else
	{
		$error = array (
			'id' => '1',
			'text' => 'Пользователя с таким e-mail не существует'
		);
		echo json_encode($error);
	}
}

?>
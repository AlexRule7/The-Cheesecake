<?php

	session_start();
	
	include($_SERVER['DOCUMENT_ROOT'].'/Connections/exarium.php');
	
	if (!isset($_SESSION['user_id']))
	{
		if (isset($_COOKIE['email']) && isset($_COOKIE['password']))
		{
			$email = sanitize($_COOKIE['email']);
			$password = sanitize($_COOKIE['password']);
	
			$query = "SELECT `user_id`, `password`
						FROM `users`
						WHERE `email`='{$email}' AND `password`='{$password}'
						LIMIT 1";
			$sql = mysql_query($query) or die(mysql_error());
	
			if (mysql_num_rows($sql) == 1)
			{
				$row = mysql_fetch_assoc($sql);
				$_SESSION['user_id'] = $row['user_id'];
			}
		}
	}
	
	if (isset($_SESSION['user_id']))
	{
		$query = "SELECT `name`, `email`
					FROM `users`
					WHERE `user_id` = '{$_SESSION['user_id']}'
					LIMIT 1";
		$sql = mysql_query($query) or die(mysql_error());
		
		if (mysql_num_rows($sql) != 1)
		{
			if (isset($_SESSION['user_id'])) {
				unset($_SESSION['user_id']);
				unset($name);
			}
			
			setcookie('login', '', 0, "/");
			setcookie('password', '', 0, "/");
			
			header('Location: index.php');
		}
		
		$row = mysql_fetch_assoc($sql);
		
		$name = $row['name'];
	}
	
	if (!isset($_SESSION['item_total'])) {
		$_SESSION['item_total'] = 0;
	}
	
	if (!isset($_SESSION['item_list'])) {
		$_SESSION['item_list'] = array();
	}
	
	switch ($_SERVER['PHP_SELF']) {
		case '/index.php':
			$nav_1 = 'class="selected"';
			break;
		case '/about/index.php':
			$nav_2 = 'class="selected"';
			break;
		case '/payments-and-delivery/index.php':
			$nav_3 = 'class="selected"';
			break;
		case '/company/index.php':
			$nav_4 = 'class="selected"';
			break;
	}

?>

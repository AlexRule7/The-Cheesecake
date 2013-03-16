<?php

	session_start();
	
	include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');
	
	if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_hashed_id'])) {
		if (isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
			$email = Database::sanitize($_COOKIE['email']);
			$password = Database::sanitize($_COOKIE['password']);
	
			$query = "SELECT `user_id`, `password`
						FROM `users`
						WHERE `email`='{$email}' AND `password`='{$password}'
						LIMIT 1";
			$result = $mysqli->query($query) or die($mysqli->error);
	
			if ($result->num_rows == 1) {
				$row = $result->fetch_assoc();
				$_SESSION['user_id'] = $row['user_id'];
				$hashed_id = md5(md5($row['user_id']) . $row['salt']);
				$_SESSION['user_hashed_id'] = $hashed_id;
			}
		}
	}
	
	if (isset($_SESSION['user_id']) && isset($_SESSION['user_hashed_id'])) {
		$query = "SELECT *
					FROM `users`
					WHERE `user_id` = '{$_SESSION['user_id']}'
					LIMIT 1";
		$result = $mysqli->query($query) or die($mysqli->error);
		
		if ($result->num_rows != 1) {
			header('Location: http://'.$_SERVER['SERVER_NAME'].'/user/logout.php');
			exit;
		} else {
			$row = $result->fetch_assoc();
			$hashed_id = md5(md5($row['user_id']) . $row['salt']);
			if ($_SESSION['user_hashed_id'] != $hashed_id) {
				header('Location: http://'.$_SERVER['SERVER_NAME'].'/user/logout.php');
				exit;
			}
		}
		
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

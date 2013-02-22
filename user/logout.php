<?php

	session_start();
	
	if (isset($_SESSION['user_id'])) {
		unset($_SESSION['user_id']);
		unset($name);
	}
	
	setcookie('email', '', 0, "/");
	setcookie('password', '', 0, "/");
	
?>
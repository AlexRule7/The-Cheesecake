<?php

	session_start();
	
	if (isset($_SESSION['user_id'])) {
		unset($_SESSION['user_id']);
	}
	
	if (isset($_SESSION['user_hashed_id'])) {
		unset($_SESSION['user_hashed_id']);
	}
	
	setcookie('email', '', 0, "/");
	setcookie('password', '', 0, "/");
	
?>
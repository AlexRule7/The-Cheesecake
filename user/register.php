<?php

// Use session_start() in all pages that are working with sessions
session_start();

require(dirname(__FILE__).'/../Connections/exarium.php');

if (!empty($_POST))
{
	$name = (isset($_POST['user-name'])) ? sanitize($_POST['user-name']) : '';
	$mail = (isset($_POST['user-email'])) ? sanitize($_POST['user-email']) : '';
	$pass = (isset($_POST['user-pass'])) ? sanitize($_POST['user-pass']) : '';
	
	$salt = GenerateSalt();
	$password = md5(md5($pass) . $salt);
		
	$query = "SELECT 1
				FROM `users`
				WHERE `mail` = '{$mail}'";

	$sql = mysql_query($query) or die(mysql_error());
	
	if (!mysql_num_rows($sql)) {
		$query = "INSERT
					INTO `users`
					SET
						`name`='{$name}',
						`mail`='{$mail}',
						`password`='{$password}',
						`salt`='{$salt}'";
						
		$sql = mysql_query($query) or die(mysql_error());
		
		$_SESSION['user_id'] = mysql_insert_id();
				
		echo 0;
	} else {
		echo 1;
	}
}

?>
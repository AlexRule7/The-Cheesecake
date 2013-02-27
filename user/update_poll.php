<?php

// Use session_start() in all pages that are working with sessions
session_start();

include($_SERVER['DOCUMENT_ROOT'].'/Connections/exarium.php');

header('Content-type: application/json');

foreach ($_POST as $key => $val) {
	$query = "SELECT `poll_result_id`
				FROM `poll_results`
				WHERE `user_id` = '{$_SESSION['user_id']}' AND `poll_id` = '{$key}'";

	$sql = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($sql)) {
		$query = "UPDATE `poll_results`
					SET `poll_choice_id`='{$val}'
					WHERE `user_id` = '{$_SESSION['user_id']}' AND `poll_id` = '{$key}'";
		$sql = mysql_query($query) or die(mysql_error());
	} else {
		$query = "INSERT
					INTO `poll_results`
					SET
						`user_id`='{$_SESSION['user_id']}',
						`poll_id`='{$key}',
						`poll_choice_id`='{$val}'";
						
		$sql = mysql_query($query) or die(mysql_error());
	}
	
}

echo json_encode('success');

?>
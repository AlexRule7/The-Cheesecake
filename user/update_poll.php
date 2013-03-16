<?php

// Use session_start() in all pages that are working with sessions
session_start();

include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');

header('Content-type: application/json');

foreach ($_POST as $key => $val) {
	$query = "SELECT `poll_result_id`
				FROM `poll_results`
				WHERE `user_id` = '{$_SESSION['user_id']}' AND `poll_id` = '{$key}'";

	$result = $mysqli->query($query) or die($mysqli->error);
	if ($result->num_rows) {
		$query = "UPDATE `poll_results`
					SET `poll_choice_id`='{$val}'
					WHERE `user_id` = '{$_SESSION['user_id']}' AND `poll_id` = '{$key}'";
		$result = $mysqli->query($query) or die($mysqli->error);
	} else {
		$query = "INSERT
					INTO `poll_results`
					SET
						`user_id`='{$_SESSION['user_id']}',
						`poll_id`='{$key}',
						`poll_choice_id`='{$val}'";
						
		$result = $mysqli->query($query) or die($mysqli->error);
	}
	
}

echo json_encode('success');

?>
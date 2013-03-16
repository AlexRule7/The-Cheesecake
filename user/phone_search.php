<?php

// Use session_start() in all pages that are working with sessions
session_start();

include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');

if (isset($_REQUEST['term']))
{
	$query = "SELECT `phone`
				FROM `phones`
				WHERE `user_id`='{$_SESSION['user_id']}' AND `phone` like '".Database::sanitize($_REQUEST['term'])."%'
				LIMIT 0,10";
	$result = $mysqli->query($query) or die($mysqli->error);
	 
	$data = array();
	if ($result->num_rows) {
		while($row = $result->fetch_assoc()) {
			$data[] = array(
				'label' => $row['phone'],
				'value' => $row['phone']
			);
		}
	}
	
	// jQuery wants JSON data
	echo json_encode($data);
	flush();
} else {
	exit();
}

?>
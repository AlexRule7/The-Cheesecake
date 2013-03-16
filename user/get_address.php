<?php

// Use session_start() in all pages that are working with sessions
session_start();

include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');

header('Content-type: application/json');

if (isset($_POST)) {
	$query = "SELECT *
				FROM `addresses`
				WHERE `address_id` = '{$_POST['id']}'";

	$result = $mysqli->query($query) or die($mysqli->error);
	$row = $result->fetch_assoc();

	echo json_encode($row);
}

?>
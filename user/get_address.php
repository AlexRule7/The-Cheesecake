<?php

// Use session_start() in all pages that are working with sessions
session_start();

include($_SERVER['DOCUMENT_ROOT'].'/Connections/exarium.php');

header('Content-type: application/json');

if (isset($_POST)) {
	$query = "SELECT `metro`, `street`, `house`, `building`, `office`, `company`, `flat`, `enter`, `floor`, `domofon`
				FROM `addresses`
				WHERE `address_id` = '{$_POST['id']}'";

	$sql = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_assoc($sql);

	echo json_encode($row);
}

?>
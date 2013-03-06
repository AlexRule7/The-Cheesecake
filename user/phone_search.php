<?php

// Use session_start() in all pages that are working with sessions
session_start();

include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');

if (isset($_REQUEST['term']))
{
	$query = "SELECT `phone`
				FROM `phones`
				WHERE `user_id`='{$_SESSION['user_id']}' AND `phone` like '".sanitize($_REQUEST['term'])."%'
				LIMIT 0,10";
	$sql = mysql_query($query) or die(mysql_error());
	 
	$data = array();
	if ( $sql && mysql_num_rows($sql) )
	{
		while( $row = mysql_fetch_array($sql, MYSQL_ASSOC) )
		{
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
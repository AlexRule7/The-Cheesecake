<?php
include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');

 
// if the 'term' variable is not sent with the request, exit
if ( isset($_REQUEST['term']) )
{
	// query the database table for zip codes that match 'term'
	$query = "SELECT `name`, `phone`
				FROM `users`
				WHERE `phone` like '".sanitize($_REQUEST['term'])."%'
				ORDER BY phone ASC LIMIT 0,10";
	$sql = mysql_query($query) or die(mysql_error());
	 
	// loop through each result returned and format the response for jQuery
	$data = array();
	if ( $sql && mysql_num_rows($sql) )
	{
		while( $row = mysql_fetch_array($sql, MYSQL_ASSOC) )
		{
			$data[] = array(
				'label' => $row['phone'] .', '. $row['name'],
				'value' => $row['phone']
			);
		}
	}
	
	// jQuery wants JSON data
	echo json_encode($data);
	flush();
}
else if (isset($_REQUEST['phone']) )
{
	// query the database table for phonesthat match 'phone'
	$query = "SELECT `user_id`, `name`, `mail`, DATE_FORMAT(`birthday`, '%d.%m.%Y')
				FROM `users`
				WHERE `phone` = '".sanitize($_REQUEST['phone'])."'
				LIMIT 1";
	$sql = mysql_query($query) or die(mysql_error());
	 
	// loop through each result returned and format the response for jQuery
	$data = array();
	
	if ( $sql && mysql_num_rows($sql) )
	{
		$row = mysql_fetch_array($sql, MYSQL_ASSOC);
		$data[] = array(
			'user_id' => $row['user_id'],
			'name' => $row['name'],
			'mail' => $row['mail'],
			'birthday' => $row['DATE_FORMAT(`birthday`, \'%d.%m.%Y\')']
		);
	}
	
	// jQuery wants JSON data
	echo json_encode($data);
	flush();
}
else
{
	exit();
}

?>
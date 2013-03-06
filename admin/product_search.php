<?php
include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');

 
// if the 'term' variable is not sent with the request, exit
if ( isset($_REQUEST['term']) )
{
	// query the database table for zip codes that match 'term'
	$query = "SELECT `name`
				FROM `products`
				WHERE `name` like '%".sanitize($_REQUEST['term'])."%'
				ORDER BY name ASC LIMIT 0,10";
	$sql = mysql_query($query) or die(mysql_error());
	 
	// loop through each result returned and format the response for jQuery
	$data = array();
	if ( $sql && mysql_num_rows($sql) )
	{
		while( $row = mysql_fetch_array($sql, MYSQL_ASSOC) )
		{
			$data[] = array('value' => $row['name']);
		}
	}
	
	// jQuery wants JSON data
	echo json_encode($data);
	flush();
}
else if (isset($_REQUEST['name']) )
{
	// query the database table for phonesthat match 'phone'
	$query = "SELECT `product_id`, `price`
				FROM `products`
				WHERE `name` = '".sanitize($_REQUEST['name'])."'
				LIMIT 1";
	$sql = mysql_query($query) or die(mysql_error());
	 
	// loop through each result returned and format the response for jQuery
	$data = array();
	
	if ( $sql && mysql_num_rows($sql) )
	{
		$row = mysql_fetch_array($sql, MYSQL_ASSOC);
		$data[] = array(
			'product_id' => $row['product_id'],
			'value' => $row['price']
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
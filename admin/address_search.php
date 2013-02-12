<?php
require(dirname(__FILE__).'/../Connections/exarium.php');

 
// if the 'term' variable is not sent with the request, exit
if ( isset($_REQUEST['term']) )
{
	// query the database table for zip codes that match 'term'
	$query = "SELECT `street`, `house`, `building`
				FROM `addresses`
				WHERE `street` like '".sanitize($_REQUEST['term'])."%'
				ORDER BY street ASC LIMIT 0,10";
	$sql = mysql_query($query) or die(mysql_error());
	 
	// loop through each result returned and format the response for jQuery
	$data = array();
	if ( $sql && mysql_num_rows($sql) )
	{
		while( $row = mysql_fetch_array($sql, MYSQL_ASSOC) )
		{
			$data[] = array(
				'label' => $row['street'] .', '. $row['house'] .'к'. $row['building'],
				'value' => $row['street']
			);
		}
	}
	
	// jQuery wants JSON data
	echo json_encode($data);
	flush();
}
else if (isset($_REQUEST['street']) )
{
	// query the database table for zip codes that match 'term'
	$query = "SELECT `street`, `house`, `building`
				FROM `addresses`
				WHERE `street` = '".sanitize($_REQUEST['street'])."'
				LIMIT 1";
	$sql = mysql_query($query) or die(mysql_error());
	 
	// loop through each result returned and format the response for jQuery
	$data = array();
	if ( $sql && mysql_num_rows($sql) )
	{
		while( $row = mysql_fetch_array($sql, MYSQL_ASSOC) )
		{
			$data[] = array(
				array ('field' => 'house', 'value' => $row['house']),
				array ('field' => 'building', 'value' => $row['building'])
			);
		}
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
<?php
include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');

if ( isset($_REQUEST['term'])) {
	$query = "SELECT `name`
				FROM `products`
				WHERE `name` like '%".sanitize($_REQUEST['term'])."%'
				ORDER BY name ASC LIMIT 0,10";
	$sql = mysql_query($query) or die(mysql_error());
	 
	$data = array();
	if ( $sql && mysql_num_rows($sql) )
	{
		while( $row = mysql_fetch_assoc($sql) )
		{
			$data[] = array('value' => $row['name']);
		}
	}
	
	echo json_encode($data);
	flush();
} else if (isset($_REQUEST['name']) ) {
	$query = "SELECT `product_id`, `price`
				FROM `products`
				WHERE `name` = '".sanitize($_REQUEST['name'])."'
				LIMIT 1";
	$sql = mysql_query($query) or die(mysql_error());
	 
	$data = array();
	if ( $sql && mysql_num_rows($sql) )
	{
		$row = mysql_fetch_assoc($sql);
		$data = array(
			'product_id' => $row['product_id'],
			'price' => $row['price']
		);
	}
	
	echo json_encode($data);
	flush();
}

?>
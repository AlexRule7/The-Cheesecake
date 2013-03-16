<?php
include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');

if ( isset($_REQUEST['term'])) {
	$query = "SELECT `name`
				FROM `products`
				WHERE `name` like '%".Database::sanitize($_REQUEST['term'])."%'
				ORDER BY name ASC LIMIT 0,10";
	$result = $mysqli->query($query) or die($mysqli->error);
	 
	$data = array();
	if ($result->num_rows) {
		while($row = $result->fetch_assoc()) {
			$data[] = array('value' => $row['name']);
		}
	}
	
	echo json_encode($data);
	flush();
} else if (isset($_REQUEST['name']) ) {
	$query = "SELECT `product_id`, `price`
				FROM `products`
				WHERE `name` = '".Database::sanitize($_REQUEST['name'])."'
				LIMIT 1";
	$result = $mysqli->query($query) or die($mysqli->error);
	 
	$data = array();
	if ($result->num_rows) {
		$row = $result->fetch_assoc();
		$data = array(
			'product_id' => $row['product_id'],
			'price' => $row['price']
		);
	}
	
	echo json_encode($data);
	flush();
}

?>
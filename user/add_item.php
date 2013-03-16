<?php

// Use session_start() in all pages that are working with sessions
session_start();

include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');

header('Content-type: application/json');

if (isset($_POST['id'])) {
	$counter = 0;
	
	if (count($_SESSION['item_list']) > 0) {
		foreach($_SESSION['item_list'] as $key => $val) {
			if($val['id'] == $_POST['id']) {
				$_SESSION['item_list'][$key]['qty'] += $_POST['qty'];
			} else {
				$counter++;
			}
		}
	} else {
		add_item($_POST['id'], $_POST['qty']);
	}
	
	if ($counter == count($_SESSION['item_list'])) {
		add_item($_POST['id'], $_POST['qty']);
	}
} else {
	$update_list = array();
	
	for ($i = 0; $i < (count($_POST)/2); $i++) {
		array_push($update_list, array(
			'id' => $_POST['id'.$i],
			'qty' => $_POST['qty'.$i]
		));
	}
	
	if (count($_SESSION['item_list']) > 0) {
		foreach($update_list as $item) {
			$counter = 0;
			foreach($_SESSION['item_list'] as $key => $val) {
				if($val['id'] == $item['id']) {
					if ($item['qty'] == 0) {
						unset ($_SESSION['item_list'][$key]);
					} else {
						$_SESSION['item_list'][$key]['qty'] = $item['qty'];
					}
				} else {
					$counter++;
				}
			}
			if($counter == count($_SESSION['item_list'])) {
				add_item($item['id'], $item['qty']);
			}
		}
	} else {
		foreach($update_list as $item) {
			add_item($item['id'], $item['qty']);
		}
	}
}

$_SESSION['item_total'] = 0;
foreach ($_SESSION['item_list'] as $key) {
	$_SESSION['item_total'] += $key['qty'];
}
	
echo json_encode($_SESSION['item_total']);

?>
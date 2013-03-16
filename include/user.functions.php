<?php

	function GenerateSalt($n=3) {
		$key = '';
		$pattern = '1234567890abcdefghijklmnopqrstuvwxyz.,*_-=+';
		$counter = strlen($pattern)-1;
		for($i=0; $i<$n; $i++) {
			$key .= $pattern{rand(0,$counter)};
		}
		return $key;
	}
	
	function send_mail(array $vars) {
		extract($vars);
		
		ob_start();
		include($_SERVER['DOCUMENT_ROOT'].'/mail/mail_'.$file.'.php');
		return ob_get_clean();
	}
	
	function add_discount ($user_id, $discount) {
		$mysqli = Database::getConnection();
		$query = "SELECT *
					FROM `discounts`
					WHERE `user_id` = '{$user_id}' AND `discount` = '{$discount}'";
					
		$result = $mysqli->query($query) or die($mysqli->error);
		
		if ($result->num_rows) {
			$row = $result->fetch_assoc();
			$query = "UPDATE `discounts`
						SET `value`=value+1
						WHERE `discount_id` = '{$row['discount_id']}'";
			$mysqli->query($query) or die($mysqli->error);
		} else {
			$query = "INSERT
						INTO `discounts`
						SET
							`user_id`='{$user_id}',
							`discount`='{$discount}',
							`value`='1'";
							
			$mysqli->query($query) or die($mysqli->error);
		}
	}
	
	function remove_discount ($user_id, $discount) {
		$mysqli = Database::getConnection();
		$query = "SELECT *
					FROM `discounts`
					WHERE `user_id` = '{$user_id}' AND `discount` = '{$discount}'";
					
		$result = $mysqli->query($query) or die($mysqli->error);
		$row = $result->fetch_assoc();
		
		if ($row['value'] == 1) {
			$query = "DELETE
						FROM `discounts`
						WHERE `discount_id` = '{$row['discount_id']}'";
			$mysqli->query($query) or die($mysqli->error);
		} else {
			$query = "UPDATE `discounts`
						SET `value`=value-1
						WHERE `discount_id` = '{$row['discount_id']}'";
			$mysqli->query($query) or die($mysqli->error);
		}
	}
	
	function address_title (array $address) {
		$address_title = "м. {$address['metro']}, {$address['street']} {$address['house']}".
						(!empty($address['building']) ? 'к'.$address['building'].'' : '').
						(!empty($address['flat']) ? ', кв. '.$address['flat'].'' : '').
						(!empty($address['enter']) ? ', подъезд '.$address['enter'].'' : '').
						(!empty($address['floor']) ? ', этаж '.$address['floor'].'' : '').
						(!empty($address['domofon']) ? ', домофон '.$address['domofon'].'' : '');
						
		return $address_title;
	}
	
	function add_item($id, $qty) {
		array_push($_SESSION['item_list'], array(
			'id' => $id,
			'qty' => $qty
		));
	}

?>
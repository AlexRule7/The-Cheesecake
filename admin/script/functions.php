<?php

	function add_discount ($user_id, $discount) {
		$query = "SELECT *
					FROM `discounts`
					WHERE `user_id` = '{$user_id}' AND `discount` = '{$discount}'";
					
		$sql = mysql_query($query) or die(mysql_error());
		
		if (mysql_num_rows($sql)) {
			$row = mysql_fetch_assoc($sql);
			$query = "UPDATE `discounts`
						SET `value`=value+1
						WHERE `discount_id` = '{$row['discount_id']}'";
			$sql = mysql_query($query) or die(mysql_error());
		} else {
			$query = "INSERT
						INTO `discounts`
						SET
							`user_id`='{$user_id}',
							`discount`='{$discount}',
							`value`='1'";
							
			$sql = mysql_query($query) or die(mysql_error());
		}
	}
	
	function remove_discount ($user_id, $discount) {
		$query = "SELECT *
					FROM `discounts`
					WHERE `user_id` = '{$user_id}' AND `discount` = '{$discount}'";
					
		$sql = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_assoc($sql);
		
		if ($row['value'] == 1) {
			$query = "DELETE
						FROM `discounts`
						WHERE `discount_id` = '{$row['discount_id']}'";
			$sql = mysql_query($query) or die(mysql_error());
		} else {
			$query = "UPDATE `discounts`
						SET `value`=value-1
						WHERE `discount_id` = '{$row['discount_id']}'";
			$sql = mysql_query($query) or die(mysql_error());
		}
	}

?>
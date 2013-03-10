<?php

include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');

header('Content-type: text/html; charset=utf-8');

if (isset($_POST)) {
	$order_date = date('d.m.Y', strtotime($_POST['order_date']));
	$query = "SELECT *
				FROM `orders`
				WHERE `delivery_date` = '{$order_date}'
				ORDER BY `delivery_time` ASC";

	$sql = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($sql)) {
		echo"<div class='order-history-holder'>";
		while ($row = mysql_fetch_assoc($sql)) {
			echo"
				<div class='order-history-item group'>
					<div class='order-history-number'>Заказ № {$row['order_id']}</div>
					<div class='order-history-date'>{$row['delivery_time']}</div>
					<div class='order-history-sum'>Сумма: {$row['bill']} ₷</div>
					<div class='order-history-details group'>";
					
			$query2 = "SELECT `product_id`, `amount`
						FROM `purchases`
						WHERE `order_id` = '{$row['order_id']}'
						ORDER BY `id` ASC";
							
			$sql2 = mysql_query($query2) or die(mysql_error());
			
			if (mysql_num_rows($sql2)) {
				for ($p = 1; $p <= mysql_num_rows($sql2); $p++)
				{
					$row2 = mysql_fetch_assoc($sql2);
					
					$query3 = "SELECT `name`, `price`
								FROM `products`
								WHERE `product_id` = '{$row2['product_id']}'";
									
					$sql3 = mysql_query($query3) or die(mysql_error());
					
					$row3 = mysql_fetch_assoc($sql3);
					
					echo "
						<div class='order-history-details-row group'>
							<div class='order-history-details-number'>$p.</div>
							<div class='order-history-details-name'>{$row3['name']}</div>   
							<div class='order-history-details-price'>{$row3['price']} ₷</div>
							<div class='order-history-details-qt'>× {$row2['amount']} шт.</div>
							<div class='order-history-details-total-price'>".($row2['amount'] * $row3['price'])." ₷</div>
						</div>";
				}
			}
			echo "
						<div class='order-history-details-row group'>
							<div class='order-history-details-number'>&nbsp;</div>
							<div class='order-history-details-name'>Доставка</div>   
							<div class='order-history-details-price'>&nbsp;</div>
							<div class='order-history-details-qt'>&nbsp;</div>
							<div class='order-history-details-total-price'>".((empty($row['delivery'])) ? 'Бесплатно' : $row['delivery'].' ₷')."</div>
						</div>
					</div>
				</div>";
		}
		echo "</div>";
	}
}

?>
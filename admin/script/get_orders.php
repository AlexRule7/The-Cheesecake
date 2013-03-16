<?php

include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');

header('Content-type: text/html; charset=utf-8');

if (isset($_POST['order-date']) || isset($_POST['user-id'])) {
	if (isset($_POST['order-date'])) {
		$order_date = date('d.m.Y', strtotime($_POST['order-date']));
		$query = "SELECT *
					FROM `orders`
					WHERE `delivery_date` = '{$order_date}'
					ORDER BY `delivery_time` ASC";
	} else if (isset($_POST['user-id'])) {
		$user_id = Database::sanitize($_POST['user-id']);
		$query = "SELECT *
					FROM `orders`
					WHERE `user_id` = '{$user_id}'
					ORDER BY `delivery_time` ASC";
	}

	$result = $mysqli->query($query) or die($mysqli->error);
	if ($result->num_rows) {
		echo"<div class='order-history-holder'>";
		while ($row = $result->fetch_assoc()) {
			if ($row['canceled'] == 0) {
				$order_status_change_class = 'order-history-cancel';
				$order_status_change_title = 'Отменить';
				$order_status_button = 'red-btn';
				$order_status_canceled = '';
			} else {
				$order_status_change_class = 'order-history-approve';
				$order_status_change_title = 'Подтвердить';
				$order_status_button = 'green-btn';
				$order_status_canceled = 'order-status-canceled';
			}
			echo"
				<div class='order-history-item group {$order_status_canceled}'>
					<div class='order-history-number'>Заказ № {$row['order_id']}</div>
					<div class='order-history-date'>{$row['delivery_date']} ({$row['delivery_time']})</div>
					<div class='order-history-sum'>Сумма: {$row['bill']} ₷</div>
				</div>
				<div class='order-history-details group'>";
					
			$query2 = "SELECT `product_id`, `amount`
						FROM `purchases`
						WHERE `order_id` = '{$row['order_id']}'
						ORDER BY `id` ASC";
							
			$result2 = $mysqli->query($query2) or die($mysqli->error);
			
			if ($result2->num_rows) {
				for ($p = 1; $p <= $result2->num_rows; $p++)
				{
					$row2 = $result2->fetch_assoc();
					
					$query3 = "SELECT `name`, `price`
								FROM `products`
								WHERE `product_id` = '{$row2['product_id']}'";
									
					$result3 = $mysqli->query($query3) or die($mysqli->error);
					
					$row3 = $result3->fetch_assoc();
					
					echo "
						<div class='order-history-details-row order-history-product group'>
							<input type='hidden' name='product-id[]' value='{$row2['product_id']}'>
							<div class='order-history-details-number'>$p.</div>
							<div class='order-history-details-product-name'>{$row3['name']}</div>   
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
				</div>";
				
			$query2 = "SELECT *
						FROM `users`
						WHERE `user_id` = '{$row['user_id']}'";
							
			$result2 = $mysqli->query($query2) or die($mysqli->error);
			$row2 = $result2->fetch_assoc();
			
			$query3 = "SELECT *
						FROM `phones`
						WHERE `phone_id` = '{$row['phone_id']}'";
							
			$result3 = $mysqli->query($query3) or die($mysqli->error);
			$row3 = $result3->fetch_assoc();
			
			$query4 = "SELECT *
						FROM `addresses`
						WHERE `address_id` = '{$row['address_id']}'";
							
			$result4 = $mysqli->query($query4) or die($mysqli->error);
			$row4 = $result4->fetch_assoc();
			
			$address = address_title($row4);
						
			echo "
				<div class='hor-splitter'></div>
				<div class='order-history-details-row group'>
					<div class='order-history-details-number'>&nbsp;</div>
					<div class='order-history-details-address'>$address</div>   
					<div class='order-history-details-user-name'>{$row2['name']}</div>
					<div class='order-history-details-phone'>{$row3['phone']}</div>
				</div>";
			
			if (!empty($row['comment'])) {
				echo "
					<div class='order-history-details-row group'>
						<div class='order-history-details-number'>[+]</div>
						<div class='order-history-details-comment'>{$row['comment']}</div>   
					</div>";
			}
				
			echo "
				<div class='order-history-details-row group'>
					<div class='order-history-details-number'>&nbsp;</div>
					<div class='order-history-details-address'>
						<a href='{$row['order_id']}' class='small-btn blue-btn order-history-change'>Редактировать</a>
					</div>   
					<div class='order-history-details-user-name'>&nbsp;</div>
					<div class='order-history-details-total-price'>
						<a href='{$row['order_id']}' class='small-btn {$order_status_button} {$order_status_change_class}'>{$order_status_change_title}</a>
					</div>
				</div>
			</div>";
		}
		echo "</div>";
	}
} else if (isset($_POST['order-id'])) {
	$order_id = Database::sanitize($_POST['order-id']);
	
	$query = "SELECT *
				FROM `orders`
				WHERE `order_id` = '{$order_id}'";

	$result = $mysqli->query($query) or die($mysqli->error);
	$row = $result->fetch_assoc();
	
	$order_date = date('Y-m-d', strtotime($row['delivery_date']));
	
	if (!empty($row['discount'])) {
		if ($row['discount'] == 5) {
			$discount_5 = '<i class="icn-discount-5 discount-btn selected"></i>';
		} else {
			$discount_10 = '<i class="icn-discount-10 discount-btn selected"></i>';
		}
	}
	
	echo "
		<input type='hidden' name='order-id' value='{$order_id}'/>
		<table>
			<thead>
				<tr>
					<td widtd='5%'>&nbsp;</td>
					<td widtd='50%'>Наименование</td>
					<td widtd='10%'>Кол.</td>
					<td widtd='15%'>Цена</td>
					<td widtd='15%'>Всего</td>
					<td widtd='5%'>&nbsp;</td>
				</tr>
			</thead>
			<tbody>";
			
	$query2 = "SELECT `product_id`, `amount`
				FROM `purchases`
				WHERE `order_id` = '{$order_id}'
				ORDER BY `id` ASC";
					
	$result2 = $mysqli->query($query2) or die($mysqli->error);
	if ($result2->num_rows) {
		for ($p = 1; $p <= $result2->num_rows; $p++) {
			$row2 = $result2->fetch_assoc();
			
			$query3 = "SELECT `name`, `price`
						FROM `products`
						WHERE `product_id` = '{$row2['product_id']}'";
							
			$result3 = $mysqli->query($query3) or die($mysqli->error);
			$row3 = $result3->fetch_assoc();
			
			echo "
				<tr class='admin-change-order-product'>
					<td>$p</td>
					<td>
						<div class='field'>
							<input type='text' class='text-input product_search' name='product-name' value='{$row3['name']}'>
							<input type='hidden' name='product-id[]' value='{$row2['product_id']}'/>
						</div>
					</td>
					<td><div class='field'><input type='number' class='text-input' name='product-amount[]' value='{$row2['amount']}'></div></td>
					<td><div class='field'><input type='text' class='text-input disabled' name='product-price' value='{$row3['price']}.00'></div></td>
					<td><div class='field'><input type='text' class='text-input disabled' name='product-price-total' value='".($row2['amount']*$row3['price']).".00'></div></td>
					<td><span class='deleterow'></span></td>
				</tr>";
		}
	}

	echo "
				<tr>
					<td>&nbsp;</td>
					<td align='left' colspan='2'><span class='addrow'>Добавить строку</span></td>
					<td>Сумма:</td>
					<td class='raw-bill'>{$row['raw_bill']}.00</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan='3'>&nbsp;</td>
					<td>Доставка:</td>
					<td class='delivery'>".(empty($row['delivery']) ? 'Бесплатно' : '250.00')."</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan='3'>&nbsp;</td>
					<td>Скидка:</td>
					<td class='discount'>".($row['raw_bill']+$row['delivery']-$row['bill']).".00</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan='3'>&nbsp;</td>
					<td>Всего к оплате:</td>
					<td class='bill'>{$row['bill']}.00</td>
					<td>&nbsp;</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td>&nbsp;</td>
					<td colspan='4'>
						<div class='field group'>
							<div class='half-field'>
								<label for='order-date'>Дата доставки:</label>
								<input class='text-input' type='date' name='order-date' value='".$order_date."'>
							</div>
							<div class='half-field'>
								<label for='order-time'>Время доставки:</label>
								<select class='text-input' name='order-time'>
									<option value='10:00-14:00' ".(($row['delivery_time'] == '10:00-14:00') ? 'selected' : '').">10:00-14:00</option>
									<option value='14:00-18:00' ".(($row['delivery_time'] == '14:00-18:00') ? 'selected' : '').">14:00-18:00</option>
									<option value='18:00-22:00' ".(($row['delivery_time'] == '18:00-22:00') ? 'selected' : '').">18:00-22:00</option>
								</select>
							</div>
						</div>
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<div class='field'>
							<label for='order-comment'>Комментарий к заказу:</label>
							<textarea class='text-input' rows='5' name='order-comment'>{$row['comment']}</textarea>
						</div>
					</td>
					<td class='discount-5'>$discount_5</td>
					<td class='discount-10'>$discount_10</td>
					<td colspan='2'>
						<input type='hidden' name='order-discount' value='0' />
						<div class='field'><a href='#' class='big-btn red-btn admin-change-order'>Сохранить изменения</a></div>
					</td>
				</tr>
			</tfoot>
		</table>
	";
}

?>
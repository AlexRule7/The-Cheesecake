<center>

<?php

function user_form($title, $button, $c_error, $c_success, $disabled) 
{
	print "
		<div align='left' class='ui-widget' style='width: 500px;'>
		
		<form id='user' name='get_address' method='post' action='?add_order'>
		
			<fieldset class='ui-corner-all'><legend class='ui-corner-all'>$title</legend>";
			
	if(!$c_error == '') {
		print "<div id='error_notification' class='ui-corner-all'>$c_error</div>";
	} else if (!$c_success == '') {
		print "<div id='success_notification' class='ui-corner-all'>$c_success</div>";
	}
				
	print "
		<label><b>Телефон *</b></label><input id='user_search' type='text' name='phone' value='".$_POST['phone']."'><br />
		<label>Имя *</label><input id='name' type='text' name='name' value='".$_POST['name']."' $disabled><br />
		<label>E-mail</label><input id='mail' type='text' name='mail' value='".$_POST['mail']."' $disabled><br />
		<label>День Рождения</label><input id='birthday' type='text' name='birthday' value='".$_POST['birthday']."' $disabled><br />
		<input id='user_id' type='hidden' name='user_id' value='".$_POST['user_id']."'>
		<input id='get_address' class='button' type='submit' name='get_address' value='$button'><br />
		</fieldset>
		
		</form>
		
		</div>
	"; 
} 

if (isset($_POST['get_address']))
{	
	$user_id = (isset($_POST['user_id'])) ? sanitize($_POST['user_id']) : '';

	$query = "SELECT `address_id`, `metro`, `street`, `house`, `building`, `office`,
				`company`, `flat`, `enter`, `floor`, `domofon`
				FROM `addresses`
				WHERE `user_id` = '{$user_id}'";
					
	$sql = mysql_query($query) or die(mysql_error());
	
	if (!mysql_num_rows($sql)) {
		$c_error = "У этого пользователя пока нет добавленных адресов.";
		$disabled = "disabled";
		user_form ("Выбор клиента", "Получить адрес", $c_error, $c_success, $disabled);
		exit;
	} else {
		$c_success = "У этого пользователя есть адрес доставки.";
	}
	
	print "
	<div id='tabs' style='width: auto; margin-top:20px'>
	
	<ul>";
		for ($i = 1; $i <= mysql_num_rows($sql); $i++)
		{
			print "<li><a href='#address-$i'>$i</a></li>";
		}
	print "
	</ul>";

	for ($i = 1; $i <= mysql_num_rows($sql); $i++)
	{
		$row = mysql_fetch_array($sql, MYSQL_ASSOC);
		(!$row["office"]) ? $o_yes = "style='display: none;'" : $o_no = "style='display: none;'";
		
		print "
		<div id='address-$i' align='left' style='padding:0px'>
		<form class='address' name='get_orders' method='post' action='index.php?add_order'>";
		
		if(!$a_error == '') {
			print '<div id="error_notification" class="ui-corner-all">'.$a_error.'</div>';
		} else if (!$a_success == '') {
			print '<div id="success_notification" class="ui-corner-all">'.$a_success.'</div>';
		}
		
		print "
			<fieldset class='ui-corner-all' style='border:none; width: 500px; margin: 20px auto;'><legend class='ui-corner-all'>Адрес #$i</legend>
			<label>Метро *</label><input type='text' name='metro' value=".$row["metro"]."><br />
			<label>Улица *</label><input type='text' name='street' value=".$row["street"]."><br />
			<label>Дом *</label><input type='text' name='house' value=".$row["house"]."><br />
			<label>Корпус/строение</label><input type='text' name='building' value=".$row["building"]."><br />
			<label>Офис</label><input type='checkbox' name='office'><br />
			<span id='office_yes' $o_yes>
			<label>Компания</label><input id='company' type='text' name='company' value=".$row["company"]."><br />
			</span>
			<span id='office_no' $o_no>
			<label>Квартира</label><input id='flat' type='text' name='flat' value=".$row["flat"]."><br />
			<label>Подъезд</label><input id='enter' type='text' name='enter' value=".$row["enter"]."><br />
			<label>Этаж</label><input id='floor' type='text' name='floor' value=".$row["floor"]."><br />
			<label>Домофон</label><input id='domofon' type='text' name='domofon' value=".$row["domofon"]."><br />
			</span>
			</fieldset>
			</form>
			<hr />
			<form class='order' name='add_order' method='post' action='index.php?add_order'>
			<fieldset class='ui-corner-all' style='border:none'><legend class='ui-corner-all'>Заказы</legend>
			<input id='address_id' type='hidden' name='address_id' value='".$row["address_id"]."'>
			<input id='user_id' type='hidden' name='user_id' value='".$user_id."'>
			<input type='hidden' name='delivery_date'>
			<input type='hidden' name='bill'>
			<div class='orders'>
			<h3>Добавить заказ</h3>
			<div>
				<table class='new_order'>
					<thead>
						<tr>
							<th>&nbsp;</th>
							<th>Наименование</th>
							<th>Кол.</th>
							<th>Цена</th>
							<th>Всего</th>
							<th width='20px'>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>1</th>
							<th>
								<input type='hidden' class='product_id' name='product_id[]'>
								<input type='text' class='product_search' name='name'>
							</th>
							<th><input type='text' class='amount' name='amount[]'></th>
							<th><input type='text' class='price' value='0.00' disabled='disabled' name='price'></th>
							<th><input type='text' class='price_total' value='0.00' disabled='disabled' name='price_total'></th>
							<th><span class='deleterow' style='display: none;'></span></th>
						</tr>
						<tr align='right'>
							<th>&nbsp;</th>
							<th align='left'><span type='button' class='addrow'>Добавить строку</span></th>
							<th colspan='2'>Доставка:</th>
							<th class='delivery'>0.00</th>
							<th>&nbsp;</th>
						</tr>
					</tbody>
					<tfoot>
						<tr align='right'>
							<th colspan='4'>Всего к оплате:</th>
							<th class='bill'>0.00</th>
							<th>&nbsp;</th>
						</tr>
						<tr>
							<th>&nbsp;</th>
							<th><div class='delivery_date'></div></th>
							<th colspan='3'>
								<label for='delivery_time'>Время доставки:</label>
								<input type='text' class='delivery_time' name='delivery_time' style='border: 0; color: #f6931f; font-weight: bold;' /><br />
								<div class='time_range' style='margin-top:10px'></div>
								<textarea cols='60' rows='8' name='comment' class='ui-corner-all comment' placeholder='Комментарий...'></textarea>
							</th>
							<th>&nbsp;</th>
						</tr>
						<tr>
							<th>&nbsp;</th>
							<th>&nbsp;</th>
							<th>&nbsp;</th>
							<th>&nbsp;</th>
							<th><input class='button add_order' type='submit' name='add_order' value='Добавить'></th>
							<th>&nbsp;</th>
						</tr>
					</tfoot>
				</table>
			</div>";
			
		$query2 = "SELECT `order_id`, `order_date`, DATE_FORMAT(`delivery_date`, '%d.%m.%Y'), `delivery_time`, `bill`, `comment`
					FROM `orders`
					WHERE `user_id` = '{$user_id}' AND `address_id` = '".$row["address_id"]."'
					ORDER BY `order_date` DESC";
						
		$sql2 = mysql_query($query2) or die(mysql_error());
		
		if (mysql_num_rows($sql2)) {
			for ($o = mysql_num_rows($sql2); $o > 0; $o--)
			{
				$row2 = mysql_fetch_array($sql2, MYSQL_ASSOC);
				
				print "
					<h3>Заказ #$o (".$row2["order_date"].") :: Доставка: ".$row2["DATE_FORMAT(`delivery_date`, '%d.%m.%Y')"]." :: Сумма: ".$row2["bill"].".00 руб.</h3>
					<div>
					<table border='1px'>
						<thead>
							<tr>
								<th>&nbsp;</th>
								<th>Наименование</th>
								<th>Кол.</th>
								<th>Цена</th>
								<th>Всего</th>
							</tr>
						</thead>
						<tbody>";
						
				$query3 = "SELECT `product_id`, `amount`
							FROM `purchases`
							WHERE `order_id` = '".$row2["order_id"]."'
							ORDER BY `id` ASC";
								
				$sql3 = mysql_query($query3) or die(mysql_error());
				
				if (mysql_num_rows($sql3)) {
					for ($p = 1; $p <= mysql_num_rows($sql3); $p++)
					{
						$row3 = mysql_fetch_array($sql3, MYSQL_ASSOC);
						
						$query4 = "SELECT `name`, `price`
									FROM `products`
									WHERE `product_id` = '".$row3["product_id"]."'";
										
						$sql4 = mysql_query($query4) or die(mysql_error());
						
						$row4 = mysql_fetch_array($sql4, MYSQL_ASSOC);
						
						print "			
								<tr>
									<th>$p</th>
									<th>".$row4["name"]."</th>
									<th>".$row3["amount"]."</th>
									<th>".$row4["price"]."</th>
									<th>".($row3["amount"] * $row4["price"])."</th>
								</tr>";
					}
				}
				print "
							<tr align='right'>
								<th>&nbsp;</th>
								<th colspan='3'>Доставка:</th>
								<th>".(($row2["bill"] > 1500) ? "Бесплатно" : "250.00")."</th>
							</tr>
						</tbody>
						<tfoot>
							<tr align='right'>
								<th colspan='4'>Всего к оплате:</th>
								<th>".$row2["bill"]."</th>
							</tr>
						</tfoot>
					</table>

					</div>";
			}
		}
		
		print "
			</div>
			</fieldset>
		
		</form>
		</div>";
		
	}
	
} else if (isset($_POST['add_order'])) {
	$user_id = (isset($_POST['user_id'])) ? sanitize($_POST['user_id']) : '';
	$address_id = (isset($_POST['address_id'])) ? sanitize($_POST['address_id']) : '';
	$delivery_date = (isset($_POST['delivery_date'])) ? sanitize($_POST['delivery_date']) : '';
	$delivery_time = (isset($_POST['delivery_time'])) ? sanitize($_POST['delivery_time']) : '';
	$bill = (isset($_POST['bill'])) ? sanitize($_POST['bill']) : '';
	$comment = (isset($_POST['comment'])) ? sanitize($_POST['comment']) : '';
	
	$product_id = $_POST['product_id'];
	$amount = $_POST['amount'];
	
	$d_date = substr($delivery_date, -4) . "-" . substr($delivery_date, 3, -5) . "-" . substr($delivery_date, 0, 2);
		
	$query = "INSERT
				INTO `orders`
				SET
					`user_id`='{$user_id}',
					`address_id`='{$address_id}',
					`delivery_date`='{$d_date}',
					`delivery_time`='{$delivery_time}',
					`bill`='{$bill}',
					`comment`='{$comment}'";
	
	$sql = mysql_query($query) or die(mysql_error());
	
	$i = 0;
	$last_id = mysql_insert_id();
	foreach ($product_id as $id) {
		$query = "INSERT
					INTO `purchases`
					SET
						`order_id`='{$last_id}',
						`product_id`='{$id}',
						`amount`='{$amount[$i]}'";
						
		$sql = mysql_query($query) or die(mysql_error());
		
		$i++;
	}
} else {
	$disabled = "disabled";
	user_form ("Выбор клиента", "Получить адрес", $c_error, $c_success, $disabled);
}

?>

</center>

</body>
</html>
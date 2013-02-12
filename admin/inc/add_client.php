<?php

// показываем защищенные от гостей данные.
$sql = 0;

$b_submit = "add_user";
$b_value = "Добавить клиента";
$disabled = "disabled";

if (isset($_POST['add_user']))
{
	$name = (isset($_POST['name'])) ? sanitize($_POST['name']) : '';
	$phone = (isset($_POST['phone'])) ? sanitize($_POST['phone']) : '';
	$mail = (isset($_POST['mail'])) ? sanitize($_POST['mail']) : '';
	$birthday = (isset($_POST['birthday'])) ? sanitize($_POST['birthday']) : '';
	
	$b_day = substr($birthday, -4) . "-" . substr($birthday, 3, -5) . "-" . substr($birthday, 0, 2);
	
	$query = "SELECT 1
				FROM `users`
				WHERE `mail` = '{$mail}'";

	$sql = mysql_query($query) or die(mysql_error());
	
	if (!mysql_num_rows($sql)) {
		$query = "INSERT
					INTO `users`
					SET
						`name`='{$name}',
						`phone`='{$phone}',
						`mail`='{$mail}',
						`birthday`='{$b_day}'";
						
		$sql = mysql_query($query) or die(mysql_error());
		
		$c_success = "Пользователь <em>$name</em> добавлен.";
	} else {
		$c_error = "Пользователь с таким E-mail уже существует.";
	}
}

if (isset($_POST['edit_user']))
{
	$b_submit = "edit_user";
	$b_value = "Редактировать";
	$disabled = "";
	
	$name = (isset($_POST['name'])) ? sanitize($_POST['name']) : '';
	$mail = (isset($_POST['mail'])) ? sanitize($_POST['mail']) : '';
	$birthday = (isset($_POST['birthday'])) ? sanitize($_POST['birthday']) : '';
	$user_id = (isset($_POST['user_id'])) ? sanitize($_POST['user_id']) : '';
	
	$b_day = substr($birthday, -4) . "-" . substr($birthday, 3, -5) . "-" . substr($birthday, 0, 2);
	
	$query = "SELECT 1
				FROM `users`
				WHERE `mail` = '{$mail}'
				AND `phone` != '{$phone}'";

	$sql = mysql_query($query) or die(mysql_error());
		
	if (!mysql_num_rows($sql)) {
		$query = "UPDATE `users`
					SET
						`name`='{$name}',
						`mail`='{$mail}',
						`birthday`='{$b_day}'
					WHERE `user_id` = '{$user_id}'";
						
		$sql = mysql_query($query) or die(mysql_error());
		
		$c_success = "Данные пользователя <em>$name</em> изменены.";
	} else {
		$c_error = "Пользователь с таким E-mail уже существует.";
	}
}

if (isset($_POST['get_address']))
{
	$b_submit = "edit_user";
	$b_value = "Редактировать";
	$disabled = "";
	
	$user_id = (isset($_POST['user_id'])) ? sanitize($_POST['user_id']) : '';
	
	$query = "SELECT `address_id`, `metro`, `street`, `house`, `building`, `office`,
				`company`, `flat`, `enter`, `floor`, `domofon`
				FROM `addresses`
				WHERE `user_id` = '{$user_id}'";
					
	$sql = mysql_query($query) or die(mysql_error());
	
	if (!mysql_num_rows($sql)) {
		$a_error = "У этого пользователя пока нет добавленных адресов.";
	} else {
		$a_success = "У этого пользователя есть адрес доставки.";
	}
}

if (isset($_POST['add_address']))
{
	$metro = (isset($_POST['metro'])) ? sanitize($_POST['metro']) : '';
	$street = (isset($_POST['street'])) ? sanitize($_POST['street']) : '';
	$house = (isset($_POST['house'])) ? sanitize($_POST['house']) : '';
	$building = (isset($_POST['building'])) ? sanitize($_POST['building']) : '';
	$office = (isset($_POST['office'])) ? sanitize($_POST['office']) : '';
	$company = (isset($_POST['company'])) ? sanitize($_POST['company']) : '';
	$flat = (isset($_POST['flat'])) ? sanitize($_POST['flat']) : '';
	$enter = (isset($_POST['enter'])) ? sanitize($_POST['enter']) : '';
	$floor = (isset($_POST['floor'])) ? sanitize($_POST['floor']) : '';
	$domofon = (isset($_POST['domofon'])) ? sanitize($_POST['domofon']) : '';
	$user_id = (isset($_POST['user_id'])) ? sanitize($_POST['user_id']) : '';
	
	$query = "INSERT
				INTO `addresses`
				SET
					`user_id`='{$user_id}',
					`metro`='{$metro}',
					`street`='{$street}',
					`house`='{$house}',
					`building`='{$building}',
					`office`='{$office}',
					`company`='{$company}',
					`flat`='{$flat}',
					`enter`='{$enter}',
					`floor`='{$floor}',
					`domofon`='{$domofon}'";
					
	$sql = mysql_query($query) or die(mysql_error());

	$success = "Адрес добавлен.";
}

if (isset($_POST['edit_address']))
{
	$metro = (isset($_POST['metro'])) ? sanitize($_POST['metro']) : '';
	$street = (isset($_POST['street'])) ? sanitize($_POST['street']) : '';
	$house = (isset($_POST['house'])) ? sanitize($_POST['house']) : '';
	$building = (isset($_POST['building'])) ? sanitize($_POST['building']) : '';
	$office = (isset($_POST['office'])) ? sanitize($_POST['office']) : '';
	$company = (isset($_POST['company'])) ? sanitize($_POST['company']) : '';
	$flat = (isset($_POST['flat'])) ? sanitize($_POST['flat']) : '';
	$enter = (isset($_POST['enter'])) ? sanitize($_POST['enter']) : '';
	$floor = (isset($_POST['floor'])) ? sanitize($_POST['floor']) : '';
	$domofon = (isset($_POST['domofon'])) ? sanitize($_POST['domofon']) : '';
	$address_id = (isset($_POST['address_id'])) ? sanitize($_POST['address_id']) : '';
	
	$query = "UPDATE `addresses`
				SET
					`metro`='{$metro}',
					`street`='{$street}',
					`house`='{$house}',
					`building`='{$building}',
					`office`='{$office}',
					`company`='{$company}',
					`flat`='{$flat}',
					`enter`='{$enter}',
					`floor`='{$floor}',
					`domofon`='{$domofon}'
					WHERE `address_id` = '{$address_id}'";
					
	$sql = mysql_query($query) or die(mysql_error());

	$success = "Адрес изменен.";
}

if (isset($_POST['delete_address']))
{
	$address_id = (isset($_POST['address_id'])) ? sanitize($_POST['address_id']) : '';
	
	$query = "DELETE FROM `addresses`
				WHERE `address_id` = '{$address_id}'";
					
	$sql = mysql_query($query) or die(mysql_error());

	$success = "Адрес удален.";
}

if ($success) {
	print "
	<div id='dialog' title='Вот так вот'>
	  <p>$success</p>
	</div>";
}

?>

<center>

<div align="left" class="ui-widget" style="width: 500px;">

<form id="user" name="add_user" method="post" action="?add_user">

	<fieldset class="ui-corner-all"><legend class="ui-corner-all">Добавление клиента</legend>
    <?php
		if(!$c_error == '') {
			print '<div id="error_notification" class="ui-corner-all">'.$c_error.'</div>';
		} else if (!$c_success == '') {
			print '<div id="success_notification" class="ui-corner-all">'.$c_success.'</div>';
		}
		
		print "<label><b>Телефон *</b></label><input id='user_search' type='text' name='phone' value='".$_POST['phone']."'><br />
				<label>Имя *</label><input id='name' type='text' name='name' value='".$_POST['name']."' ".$disabled."><br />
				<label>E-mail</label><input id='mail' type='text' name='mail' value='".$_POST['mail']."' ".$disabled."><br />
				<label>День Рождения</label><input id='birthday' type='text' name='birthday' value='".$_POST['birthday']."' ".$disabled."><br />
				<input id='user_id' type='hidden' name='user_id' value='".$_POST['user_id']."'>
				<input id='add_user' class='button' type='submit' name='$b_submit' value='$b_value'><br />"
	?>
	</fieldset>


</form>

</div>

<?php
if (isset($_POST['get_address']))
{
	print "
	<div id='tabs' style='width: 500px; margin-top:20px'>
	
	<ul>";
		for ($i = 1; $i <= mysql_num_rows($sql); $i++)
		{
			print "<li><a href='#address-$i'>$i</a></li>";
		}
	print "
		<li><a href='#address-new'>*</a></li>
	</ul>";

	for ($i = 1; $i <= mysql_num_rows($sql); $i++)
	{
		$row = mysql_fetch_array($sql, MYSQL_ASSOC);
		(!$row["office"]) ? $o_yes = "style='display: none;'" : $o_no = "style='display: none;'";
		
		print "
		<div id='address-$i' align='left' style='padding:0px'>
		<form class='address' name='edit_address' method='post' action='index.php?add_user'>";
			
		if(!$a_error == '') {
			print '<div id="error_notification" class="ui-corner-all">'.$a_error.'</div>';
		} else if (!$a_success == '') {
			print '<div id="success_notification" class="ui-corner-all">'.$a_success.'</div>';
		}
		
		print "
			<fieldset class='ui-corner-all' style='border:none'><legend class='ui-corner-all'>Адрес #$i</legend>
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
			<input id='address_id' type='hidden' name='address_id' value='".$row["address_id"]."'>
			<input class='button' type='submit' name='delete_address' value='Удалить адрес' style='float: left; margin-right: 0px; margin-left: 20px;'>
			<input class='button' type='submit' name='edit_address' value='Редактировать адрес' style='float: right;'><br />
			</fieldset>
		
		</form>
		</div>";
	}

	print "
	<div id='address-new' align='left' style='padding:0px'>
	<form class='address' name='add_address' method='post' action='index.php?add_user'>";
				
	if(!$a_error == '') {
		print '<div id="error_notification" class="ui-corner-all">'.$a_error.'</div>';
	} else if (!$a_success == '') {
		print '<div id="success_notification" class="ui-corner-all">'.$a_success.'</div>';
	}
	
	print "	
		<fieldset class='ui-corner-all' style='border:none'><legend class='ui-corner-all'>Новый адрес</legend>
		<label>Метро *</label><input type='text' name='metro'><br />
		<label>Улица *</label><input type='text' name='street'><br />
		<label>Дом *</label><input type='text' name='house'><br />
		<label>Корпус/строение</label><input type='text' name='building'><br />
		<label>Офис</label><input type='checkbox' name='office'><br />
		<span id='office_yes' style='display: none;'>
		<label>Компания</label><input type='text' name='company'><br />
		</span>
		<span id='office_no'>
		<label>Квартира</label><input type='text' name='flat'><br />
		<label>Подъезд</label><input type='text' name='enter'><br />
		<label>Этаж</label><input type='text' name='floor'><br />
		<label>Домофон</label><input type='text' name='domofon'><br />
		</span>
		<input id='user_id' type='hidden' name='user_id' value='".$_POST['user_id']."'>
		<input class='button' type='submit' name='add_address' value='Добавить адрес'><br />
		</fieldset>
	
	</form>
	</div>
	
	</div>
	
	</div>";
}
?>

</center>
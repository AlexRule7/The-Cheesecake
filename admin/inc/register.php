<?php

if (!empty($_POST))
{
	// обрабатывае пришедшие данные функцией mysql_real_escape_string перед вставкой в таблицу БД
	
	$login = (isset($_POST['login'])) ? sanitize($_POST['login']) : '';
	$password = (isset($_POST['password'])) ? sanitize($_POST['password']) : '';
	
	
	// проверяем на наличие ошибок (например, длина логина и пароля)
	
	$error = false;
	$errort = '';
	
	if (strlen($login) < 3)
	{
		$error = true;
		$errort .= 'Длина логина должна быть не менее 3х символов.<br />';
	}
	if (strlen($password) < 4)
	{
		$error = true;
		$errort .= 'Длина пароля должна быть не менее 4 символов.<br />';
	}
	
	// проверяем, если юзер в таблице с таким же логином
	$query = "SELECT `id`
				FROM `admin`
				WHERE `login`='{$login}'
				LIMIT 1";
	$sql = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($sql)==1)
	{
		$error = true;
		$errort .= 'Пользователь с таким логином уже существует в базе данных, введите другой.<br />';
	}
	
	
	// если ошибок нет, то добавляем юзера в таблицу
	
	if (!$error)
	{
		// генерируем соль и пароль
		
		$salt = GenerateSalt();
		$hashed_password = md5(md5($password) . $salt);
		
		$query = "INSERT
					INTO `admin`
					SET
						`login`='{$login}',
						`password`='{$hashed_password}',
						`salt`='{$salt}'";
		$sql = mysql_query($query) or die(mysql_error());
		
		
		$errort = 'Поздравляем, <b>'.$login.'</b> успешно зарегистрирован!';
	}
}

	?>

<center>
<div align="left" style="width: 330px;">

<form name="login" method="post" action="../index.php?register">

	<fieldset><legend>Регистрация</legend>
    <?php
	
	if($error)
	{
		print '<div id="error_notification">'.$errort.'</div>';
	}
	else
	{
		if(!empty($_POST))
		{
			print '<div id="success_notification">'.$errort.'</div>';
		}
	}
	
	?>
    <label>Логин</label><input id="name" type="text" name="login"><br />
	<label>Пароль</label><input type="password" name="password"><br />
	<label>&nbsp;</label><input id="submit" type="submit" name="submit" value="Зарегистрировать"><br />
	</fieldset>

</form>

</div>
</center>	

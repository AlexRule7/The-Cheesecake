<?php

session_start();

include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');

if (isset($_GET['logout']))
{
	if (isset($_SESSION['user_id']))
		unset($_SESSION['user_id']);
	
	setcookie('login', '', 0, "/");
	setcookie('password', '', 0, "/");
	// и переносим его на главную
	header('Location: index.php');
	exit;
}

if (isset($_SESSION['user_id']))
{
	// юзер уже залогинен, перекидываем его отсюда на закрытую страницу
	
	header('Location: index.php');
	exit;

}



if (!empty($_POST))
{
	$login = (isset($_POST['login'])) ? sanitize($_POST['login']) : '';
	
	$query = "SELECT `salt`
				FROM `admin`
				WHERE `login`='{$login}'
				LIMIT 1";
	$sql = mysql_query($query) or die(mysql_error());
	
	if (mysql_num_rows($sql) == 1)
	{
		$error = '';
		
		$row = mysql_fetch_assoc($sql);
		
		// итак, вот она соль, соответствующая этому логину:
		$salt = $row['salt'];
		
		// теперь хешируем введенный пароль как надо и повторям шаги, которые были описаны выше:
		$password = md5(md5($_POST['password']) . $salt);
		
		// и пошло поехало...

		// делаем запрос к БД
		// и ищем юзера с таким логином и паролем

		$query = "SELECT `id`
					FROM `admin`
					WHERE `login`='{$login}' AND `password`='{$password}'
					LIMIT 1";
		$sql = mysql_query($query) or die(mysql_error());

		// если такой пользователь нашелся
		if (mysql_num_rows($sql) == 1)
		{
			// то мы ставим об этом метку в сессии (допустим мы будем ставить ID пользователя)

			$row = mysql_fetch_assoc($sql);
			$_SESSION['user_id'] = $row['id'];
			
			
			// если пользователь решил "запомнить себя"
			// то ставим ему в куку логин с хешем пароля
			
			$time = 60*60*24*30; // ставим куку на месяц
			
			if (isset($_POST['remember']))
			{
				setcookie('login', $login, time()+$time, "/");
				setcookie('password', $password, time()+$time, "/");
			}
			
			// и перекидываем его на закрытую страницу
			header('Location: index.php');
			exit;

			// не забываем, что для работы с сессионными данными, у нас в каждом скрипте должно присутствовать session_start();
		}
		else
		{
			$error = 'Такой логин с паролем не найдены в базе данных.</br>';
		}
	}
	else
	{
		$error = 'Пользователь с таким логином не найден.</br>';
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Login</title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<link href="css/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="css/jquery.ui.theme.css" rel="stylesheet" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<script>
jQuery(document).ready(function($){
	$( ".button" ).button();
});
</script>
</head>
<body>

<center>
<div class="ui-widget" align="left" style="width: 500px;">

<form name="login" method="post" action="login.php">

	<fieldset class="ui-corner-all"><legend class="ui-corner-all">Авторизация</legend>
    <?php
	
	if(!$error == '')
	{
		print '<div id="error_notification">'.$error.'</div>';
	}
	
	?>
    <label>Логин</label><input id="name" type="text" name="login"><br />
	<label>Пароль</label><input type="password" name="password"><br />
	<label>Запомнить</label><input type="checkbox" name="remember" value="1"><br />
	<input id="submit" class="button" type="submit" name="submit" value="Войти"><br />
	</fieldset>

</form>

</div>
</center>

</body>
</html>
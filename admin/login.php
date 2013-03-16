<?php

session_start();

include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');

if (isset($_GET['logout']))
{
	if (isset($_SESSION['admin_hashed_id']))
		unset($_SESSION['admin_hashed_id']);
		
	if (isset($_SESSION['admin_id']))
		unset($_SESSION['admin_id']);
	
	setcookie('login', '', 0, "/");
	setcookie('password', '', 0, "/");
	// и переносим его на главную
	header('Location: index.php');
	exit;
}

if (isset($_SESSION['admin_hashed_id']))
{
	// юзер уже залогинен, перекидываем его отсюда на закрытую страницу
	
	header('Location: index.php');
	exit;

}



if (!empty($_POST))
{
	$login = (isset($_POST['login'])) ? Database::sanitize($_POST['login']) : '';
	
	$query = "SELECT `salt`
				FROM `admin`
				WHERE `login`='{$login}'
				LIMIT 1";
	$result = $mysqli->query($query) or die($mysqli->error);
	
	if ($result->num_rows == 1) {
		$error = '';
		
		$row = $result->fetch_assoc();
		
		// итак, вот она соль, соответствующая этому логину:
		$salt = $row['salt'];
		
		// теперь хешируем введенный пароль как надо и повторям шаги, которые были описаны выше:
		$password = md5(md5($_POST['password']) . $salt);
		
		// и пошло поехало...

		// делаем запрос к БД
		// и ищем юзера с таким логином и паролем

		$query = "SELECT `admin_id`
					FROM `admin`
					WHERE `login`='{$login}' AND `password`='{$password}'
					LIMIT 1";
		$result = $mysqli->query($query) or die($mysqli->error);

		// если такой пользователь нашелся
		if ($result->num_rows == 1) {
			// то мы ставим об этом метку в сессии (допустим мы будем ставить ID пользователя)

			$row = $result->fetch_assoc();
			$hashed_id = md5(md5($row['admin_id']) . $salt);
			$_SESSION['admin_hashed_id'] = $hashed_id;
			$_SESSION['admin_id'] = $row['admin_id'];
			
			
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
    <link href="/stylesheets/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
    <link href="/admin/stylesheets/admin_screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
</head>
<body>

    <!-- Sign in popup -->
        <div class="popup-holder">
            <div class="popup-body">
                <div class="big-col centered">
                	<form class="login" name="login" method="post" action="/admin/login.php">
                        <h2>Вход</h2>
                        <div class="hor-splitter"></div>
                        <div class="field">
                            <label for="login">Login:</label>
                            <input class="text-input" type="text" tabindex="1" name="login">
                        </div>
                        <div class="field">
                            <label for="password">Пароль:</label>
                            <input class="text-input" type="password" tabindex="2" name="password">
                        </div>
                        <div class="field checkbox-field">
                            <input class="checkbox-input" type="checkbox" name="remember" value="1">
                            <label for="remember">Запомнить меня</label>
                        </div>
                        <div class="field">
                            <input type="submit" name="submit" class="small-btn blue-btn user-login" value="Войти">
                        </div>
                    </form>
                </div>
            </div>
        </div>

</body>
</html>
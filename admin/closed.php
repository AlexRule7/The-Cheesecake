<?php

session_start();

if (isset($_SESSION['user_id']))
{
	// показываем защищенные от гостей данные.
	
	print '<h1>Здрасте!</h1>
	<p>Это закрытая страница.</p>
	<p><a href="index.php">Перейти на главную</a></p>';
}
else
{
	header('Location: index.php');
}


?>
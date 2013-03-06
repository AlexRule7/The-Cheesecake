<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_thecheesecake = "localhost";
$database_thecheesecake = "denjer_ck";
$username_thecheesecake = "denjer_ck";
$password_thecheesecake = "thecheesecake13";
$thecheesecake = mysql_pconnect($hostname_thecheesecake, $username_thecheesecake, $password_thecheesecake) or trigger_error(mysql_error(),E_USER_ERROR); 

$db_selected = mysql_select_db($database_thecheesecake);

mysql_query("SET NAMES `utf8`");

function sanitize($data)
{
	// remove whitespaces (not a must though)
	$data = trim($data); 
	
	// apply stripslashes if magic_quotes_gpc is enabled
	if(get_magic_quotes_gpc()) 
	{
		$data = stripslashes($data); 
	}
	
	// a mySQL connection is required before using this function
	$data = mysql_real_escape_string($data);
	
	return $data;
}

/*
** Функция для генерации соли, используемоей в хешировании пароля
** возращает 3 случайных символа
*/

function GenerateSalt($n=3)
{
	$key = '';
	$pattern = '1234567890abcdefghijklmnopqrstuvwxyz.,*_-=+';
	$counter = strlen($pattern)-1;
	for($i=0; $i<$n; $i++)
	{
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
?>
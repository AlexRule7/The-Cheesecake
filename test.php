<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<?php

include($_SERVER['DOCUMENT_ROOT'].'/Connections/exarium.php');

$user_phone = '+7(111)111-11-11';
preg_match('/\d-\d+-\d+$/', $user_phone, $match);
$pass = str_replace('-', '', $match[0]);
$salt = GenerateSalt();
$user_pass = md5(md5($pass) . $salt);

echo "salt = $salt<br>pass = $pass<br>hash = $user_pass";

?>

<body>
</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<?php

include($_SERVER['DOCUMENT_ROOT'].'/Connections/exarium.php');


$order_id = 10;
$user_name = 'Денис';
$item_list = array (
	'id' => '3',
	'qty' => '2'
);
$order_bill = 1240;
$user_email = 'denjer@mail.ru';
//$to = 'alexrule7@gmail.com';
$mail_data = array (
	'user_name' => $user_name,
	'order_id' => $order_id,
	'item_list' => $item_list,
	'order_bill' => $order_bill
);


$to = $user_email;
$subject = 'Информация о заказе № '.$order_id;
$message = mail_order($mail_data);
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf8' . "\r\n";
$headers .= 'To: '.$user_name.' <'.$user_email.'>' . "\r\n";
$headers .= 'From: Moscow Cheesecake <info@thecheesecake.ru>' . "\r\n";
echo mail($to,$subject,$message,$headers);


?>

</html>
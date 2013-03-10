<?php

session_start();

include($_SERVER['DOCUMENT_ROOT'].'/Connections/thecheesecake.php');
include($_SERVER['DOCUMENT_ROOT'].'/admin/script/functions.php');

if (!isset($_SESSION['admin_id'])) {
	if (isset($_COOKIE['login']) && isset($_COOKIE['password'])) {
		$login = sanitize($_COOKIE['login']);
		$password = sanitize($_COOKIE['password']);

		$query = "SELECT `id`
					FROM `admin`
					WHERE `login`='{$login}' AND `password`='{$password}'
					LIMIT 1";
		$sql = mysql_query($query) or die(mysql_error());

		if (mysql_num_rows($sql) == 1) {
			$row = mysql_fetch_assoc($sql);
			$_SESSION['admin_id'] = $row['id'];
		}
	}
}

if (isset($_SESSION['admin_id'])) {
	$query = "SELECT `login`
				FROM `admin`
				WHERE `id` = '{$_SESSION['admin_id']}'
				LIMIT 1";
	$sql = mysql_query($query) or die(mysql_error());
	
	if (mysql_num_rows($sql) != 1) {
		header('Location: login.php?logout');
		exit;
	}
}

if (!isset($_SESSION['admin_id'])) {
	header('Location: login.php');
} else {
	
	if (!empty($_GET)) {
		$include = $_SERVER['DOCUMENT_ROOT'].'/admin/include/'.sanitize(array_shift(array_keys($_GET))).'.php';
	} else {
		$include = $_SERVER['DOCUMENT_ROOT'].'/admin/include/orders.php';
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Admin Panel</title>
    <link href="/stylesheets/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
    <link href="/admin/stylesheets/admin_screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
    <link href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
    <script src="/admin/js/jquery.ui.touch-punch.min.js"></script>
    <script src="/admin/js/jquery.ui.styling.js"></script>
    <script src="/js/jquery.maskedinput.min.js"></script>
    <script src="/js/validation.js"></script>
</head>

<body>
    <div class="wrapper">
        <header class="site-main-header">
            <div class="inner">
                <nav>
                    <ul class="main-navigation">
                        <li><a href="/admin/?orders">Заказы</a></li>
                        <li><a href="/admin/?users">Клиенты</a></li>
                        <li><a class="logo" href="/admin/"><i class="icn-logo"></i></a></li>
                        <li><a href="/admin/?order_info">Статистика</a></li>
                        <li><a href="/admin/login.php?logout">Выход</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <section class="content">
            <div class="inner">
                <section class="profile-holder group">
                <div id="profile-tabs">
                    <div class="ver-shadow-splitter"></div>
					<?php include ($include); ?>
                </div><!-- profile tabs -->
                </section>
            </div><!-- inner -->
        </section><!-- content -->
        <div class="footer-push"></div>
    </div><!-- wrapper -->

    <footer>© 2011–2013 Moscow Cheesecake</footer>
</body>
</html>
<?php

}

?>
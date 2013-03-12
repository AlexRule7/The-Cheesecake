<?php

if (!empty($_POST)) {
	$admin_login = (isset($_POST['admin-login'])) ? sanitize($_POST['admin-login']) : '';
	$admin_pass = (isset($_POST['admin-pass'])) ? sanitize($_POST['admin-pass']) : '';
	
	if (!empty($admin_login) && !empty($admin_pass)) {
		$salt = GenerateSalt();
		$admin_pass = md5(md5($admin_pass) . $salt);
		$query = "INSERT
					INTO `admin`
					SET
						`login`='{$admin_login}',
						`password`='{$admin_pass}',
						`salt`='{$salt}'";
						
		$sql = mysql_query($query) or die(mysql_error());
	}
}

?>

<div class="small-col centered">
    <form id="admin-register" name="admin-register" method="post" action="/admin/index.php?register">
        <h2>Регистрация админа</h2>
        <div class="hor-splitter"></div>
        <div class="field">
            <label for="admin-login">Login:</label>
            <input class="text-input" type="text" name="admin-login">
        </div>
        <div class="field">
            <label for="admin-pass">Пароль:</label>
            <input class="text-input" type="password" name="admin-pass">
        </div>
        <div class="field">
            <input type="submit" class="small-btn blue-btn admin-register" value="Зарегистрировать">
        </div>
    </form>
</div>

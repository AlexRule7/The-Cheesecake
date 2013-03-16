<?php include($_SERVER['DOCUMENT_ROOT'].'/user/session.php');

	if (isset($_SESSION['user_id'])) {
		header('Location: ../../profile/');
	}

?>

<!doctype html><head>
    <meta charset="UTF-8">
    <title>Восстановление пароля | The Moscow Cheesecake</title>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/include/header.php'); ?>
	
	<section class="content">
        <div class="inner">
				<?php include($_SERVER['DOCUMENT_ROOT'].'/user/user_panel.php'); ?>
                <!-- Cart result -->
                <section class="result-holder">
                <?php
				
					if (isset($_GET['hash'])) {
						$hash = Database::sanitize($_GET['hash']);
						$query = "SELECT `user_id`
									FROM `password_change`
									WHERE `hash`='{$hash}'";
						$result = $mysqli->query($query) or die($mysqli->error);
						
						if ($result->num_rows) {
							$row = $result->fetch_assoc();
				?>
                    <h2>Смена пароля</h2>
                    <div class="hor-splitter"></div>
                    <form id="forgot">
                    	<input type="hidden" name="user-id" value="<?php echo $row['user_id']; ?>">
                        <div class="field">
                            <label for="user-pass">Новый пароль:</label>
                            <input class="text-input" type="password" name="user-pass">
                        </div>
                        <div class="field">
                            <label for="user-pass-conf">Новый пароль еще раз:</label>
                            <input class="text-input" type="password" name="user-pass-conf">
                        </div>
                        <div class="field">
                            <a href="#" class="small-btn blue-btn">Сохранить</a>
                            <span id="spinner_si"><img src="/images/spinner.gif" class="spinner" title="Loading..."></span>
                        </div>
                        <p class="forgot-success hidden">Поздравляем, Вы только что сменили пароль! Теперь можете <a class="si-popup-trigger" href="#">войти</a>, используя его.</p>
                    </form>
				<?php
						} else {
							echo '<script> window.location.replace("/profile/forgot/") </script>';
							exit;
						}
					} else {
				?>
                    <h2>Забыли пароль?</h2>
                    <div class="hor-splitter"></div>
                    <p>Не страшно! Введите свой <span class="bold">e-mail адрес</span> и проверьте почту.</p>
                    <form id="forgot">
                        <div class="field">
                            <label for="user-email">Email:</label>
                            <input class="text-input" type="email" name="user-email">
                        </div>
                        <div class="field">
                            <a href="#" class="small-btn blue-btn">Отправить</a>
                            <span id="spinner_si"><img src="/images/spinner.gif" class="spinner" title="Loading..."></span>
                        </div>
                        <p class="forgot-success hidden">Код для восстановления пароля отпрален вам на почту. Он будет действителен в течение <span class="bold">24 часов</span>.</p>
                    </form>
                <?php
					}
				?>
                </section><!-- result-holder-->

            </div><!-- inner -->
        </section><!-- content -->

	<?php include($_SERVER['DOCUMENT_ROOT'].'/include/footer.php'); ?>
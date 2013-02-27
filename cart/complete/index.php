<?php include($_SERVER['DOCUMENT_ROOT'].'/user/session.php');

	if (!isset($_SESSION['user_id'])) {
		header('Location: ../');
	}

?>

<!doctype html><head>
    <meta charset="UTF-8">
    <title>Ваш заказ успешно оформлен | The Moscow Cheesecake</title>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/include/header.php'); ?>
	
	<section class="content">
        <div class="inner">
				<?php include($_SERVER['DOCUMENT_ROOT'].'/user/user_panel.php'); ?>
                <!-- Cart result -->
                <section class="result-holder">
                    <h2>Заказ успешно оформлен!</h2>
                    <div class="hor-splitter"></div>
                    <p class="bold">Мы получили ваш заказ и присвоили ему номер: <?php echo $_SESSION['order_id']; ?>.</p>
                    <p>В ближайшее время наш оператор свяжется с вами. <br />Спасибо, что выбрали наши чизкейки.</p>
                    <p>Для того, чтобы вам не пришлось вводить адрес доставки в следующий раз, мы сохранили его в вашем личном кабинете. Пароль от него — <span class="bold">5 последних цифр вашего телефонного номера</span>. Вы всегда можете его <a href="#">изменить в личном кабинете.</a></p>
                </section><!-- result-holder-->

            </div><!-- inner -->
        </section><!-- content -->

	<?php include($_SERVER['DOCUMENT_ROOT'].'/include/footer.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/user/session.php');

	if (!isset($_SESSION['order_id'])) {
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
                    <?php if (isset($_SESSION['new_user_discount']) || isset($_SESSION['new_user'])) { ?>
                    <p>Вы только что оформили свой <span class="bold">первый заказ</span>, и за это <span class="bold">мы дарим вам скидку 5%</span> на следующий!</p>
                    <?php } ?>
                    <?php if (isset($_SESSION['new_discount'])) { ?>
                    <p>Вы только что оформили <span class="bold">заказ на <?php echo $_SESSION['item_total']; ?> чизкейк<?php echo ($_SESSION['item_total'] >= 5 ? 'ов' : 'а'); ?></span>, и за это <span class="bold">мы дарим вам скидку <?php echo $_SESSION['new_discount']; ?>%</span> на следующий!</p>
                    <?php } ?>
                    <?php if (isset($_SESSION['new_user'])) { ?>
                    <p>Для того, чтобы вам не пришлось вводить адрес доставки в следующий раз, мы сохранили его в вашем личном кабинете. Пароль от него — <span class="bold">5 последних цифр вашего телефонного номера</span>. Вы всегда можете его <a href="/profile/">изменить в личном кабинете.</a></p>
                    <?php } ?>
                </section><!-- result-holder-->

            </div><!-- inner -->
        </section><!-- content -->

	<?php
		
		unset ($_SESSION['item_total']);
		unset ($_SESSION['item_list']);
		unset ($_SESSION['order_id']);
		unset ($_SESSION['new_user_discount']);
		unset ($_SESSION['new_discount']);
		unset ($_SESSION['new_user']);
    
		include($_SERVER['DOCUMENT_ROOT'].'/include/footer.php');
	
	?>
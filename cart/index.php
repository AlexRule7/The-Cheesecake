<?php include($_SERVER['DOCUMENT_ROOT'].'/user/session.php');

	if ($_SESSION['item_total'] == 0) {
		header('Location: ../');
	}
  
	$query1 = "SELECT `address_id`, `metro`, `street`, `house`, `building`, `office`, `company`, `flat`, `enter`, `floor`, `domofon`
				FROM `addresses`
				WHERE `user_id` = '{$_SESSION['user_id']}'";
	
	$sql1 = mysql_query($query1) or die(mysql_error());
	
	$query3 = "SELECT `phone`
				FROM `phones`
				WHERE `user_id` = '{$_SESSION['user_id']}'
				ORDER BY `phone_id` ASC LIMIT 1";
	
	$sql3 = mysql_query($query3) or die(mysql_error());
	$row3 = mysql_fetch_assoc($sql3);
  
?>

<!doctype html><head>
    <meta charset="UTF-8">
    <title>Оформление заказа | The Moscow Cheesecake</title>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/include/header.php'); ?>
    
	<section class="content">
        <div class="inner">
				<?php include($_SERVER['DOCUMENT_ROOT'].'/user/user_panel.php'); ?>
                <!-- Full item card -->
                <section class="main-cart-holder">
                    <div class="main-cart group">
                        <div class="text-content-inner group">
                            <h2>Корзина</h2>
                            <div class="hor-splitter"></div>
                            <?php
								foreach ($_SESSION['item_list'] as $key => $item) {
									if ($item['qty'] != 0) {
										$query2 = "SELECT `product_id`, `url`, `name`, `image_thumb`, `price`
													FROM `products`
													WHERE `product_id`='".$item['id']."'
													LIMIT 1";
										$sql2 = mysql_query($query2) or die(mysql_error());
										$row2 = mysql_fetch_assoc($sql2);
										
										$total_price = $row2['price'] * $item['qty'];
										
										echo "
											<div class='main-cart-item group'>
												<div class='main-cart-photo-holder main-cart-cell'>
													<a href='{$row2['url']}'><img class='main-cart-photo' src='{$row2['image_thumb']}' alt='{$row2['name']}'></a>
												</div>
												<div class='main-cart-info main-cart-cell'>
													<a href='{$row2['url']}' class='main-cart-item-link'>{$row2['name']}</a>
													<span class='main-cart-item-sub-info'>{$row2['price']} ₷</span>
												</div>
												<div class='main-cart-qt main-cart-cell'>
													<input class='mini-cart-item-id' type='hidden' value='{$row2['product_id']}'>
													<input class='mini-cart-item-qt' type='number' value='{$item['qty']}'>
													<input class='mini-cart-item-price' type='hidden' value='{$row2['price']}'>
													<span class='mini-cart-item-qt-label'>× шт.</span>
												</div>
												<div class='main-cart-item-price main-cart-cell'>$total_price ₷</div>
												<div class='main-cart-item-del main-cart-cell'>
													<a class='del-item-btn' title='Убрать из корзины' href='#'><i class='icn-del-item'></i></a>
												</div>
											</div>";
											
										$bill += $total_price;
									}
								}
							?>
                            <div class="main-cart-sub-total">
                                <span class="sub-dark-color">Товаров в корзине на:</span><span class="final-sum sub-dark-color">
								<?php echo $bill; ?> ₷</span><br />
                                <span class="sub-dark-color">Доставка по Москве:</span><span class="final-sum sub-dark-color">
								<?php echo ($bill > 1500 ? 'Бесплатно' : '250 ₷'); ?></span>
                                <div class="hor-splitter"></div>
                                <div class="total-price">Итого к оплате: <span class="final-sum">
								<?php echo ($bill > 1500 ? $bill.' ₷' : ($bill+250).' ₷'); ?></span></div>
                            </div>
                        </div><!-- text-content-inner  -->
                    </div><!-- main-cart -->
                    <form id="order">
                        <div class="grid half-col multi-form">
                            <div class="big-col">
                                <h2>Личные данные</h2>
                                <div class="hor-splitter"></div>
                                <div class="field">
                                    <label for="user-name">Ваше имя:</label>
                                    <input class="text-input" type="text" tabindex="1" name="user-name" value="<?php echo $row['name']; ?>">
                                </div>
                                <div class="field">
                                    <label for="user-email">Email:</label>
                                    <input class="text-input" type="email" tabindex="2" name="user-email" value="<?php echo $row['email']; ?>">
                                </div>
                                <div class="field">
                                    <label for="user-phone">Телефон:</label>
                                    <input class="text-input" type="tel" tabindex="3" name="user-phone" value="<?php echo $row3['phone']; ?>">
                                </div>
                                <div class="field">
                                    <label for="order-comment">Комментарий к заказу:</label>
                                    <textarea class="text-input" rows="5" tabindex="4" name="order-comment"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="grid half-col multi-form">
                            <div class="big-col">
                                <h2>Адрес и время доставки</h2>
                                <div class="hor-splitter"></div>
                                <?php
									if (mysql_num_rows($sql1) != 0) {
										echo "
											<div class='field'>
												<label for='user-address'>На эти адреса Вы уже делали заказ:</label>
												<select class='text-input' name='user-address'>";
										while ($row1 = mysql_fetch_assoc($sql1)) {
											echo "
													<option value='{$row1['address_id']}'>м. {$row1['metro']}, {$row1['street']}, {$row1['house']}</option>";
										}
										echo "
													<option value='0'>-- Добавить новый адрес --</option>
												</select>
											</div>";
										mysql_data_seek($sql1, 0);
										$row1 = mysql_fetch_assoc($sql1);
									}
								?>
                                <div id="address">
                                    <div class="field checkbox-field">
                                        <input class="checkbox-input" type="checkbox" id="to-office" name="user-office" <?php echo ($row1['office'] == 1) ? 'checked' : ''; ?>>
                                        <label for="user-office">Доставка в офис</label>
                                    </div>
                                    <div class="field">
                                        <label for="user-metro">Ближайшая станция метро:</label>
                                        <input class="text-input" type="text" tabindex="5" name="user-metro" value="<?php echo $row1['metro']; ?>">
                                    </div>
                                    <div class="field">
                                        <label for="user-street">Улица:</label>
                                        <input class="text-input" type="text" tabindex="6" name="user-street" value="<?php echo $row1['street']; ?>">
                                    </div>
                                    <div class="field group">
                                        <div class="mini-field">
                                            <label for="user-house">Дом:</label>
                                            <input class="text-input" type="text" tabindex="7" name="user-house" value="<?php echo $row1['house']; ?>">
                                        </div>
                                        <div class="mini-field">
                                            <label for="user-building">Корпус:</label>
                                            <input class="text-input" type="text" tabindex="8" name="user-building" value="<?php echo $row1['building']; ?>">
                                        </div>
                                        <div class="mini-field">
                                            <label for="user-flat">Квартира:</label>
                                            <input class="text-input" type="text" tabindex="9" name="user-flat" value="<?php echo $row1['flat']; ?>">
                                        </div>
                                    </div>
                                    <div class="field group">
                                        <div class="mini-field">
                                            <label for="user-enter">Подъезд:</label>
                                            <input class="text-input" type="text" tabindex="10" name="user-enter" value="<?php echo $row1['enter']; ?>">
                                        </div>
                                        <div class="mini-field">
                                            <label for="user-floor">Этаж:</label>
                                            <input class="text-input" type="text" tabindex="11" name="user-floor" value="<?php echo $row1['floor']; ?>">
                                        </div>
                                        <div class="mini-field">
                                            <label for="user-domofon">Домофон:</label>
                                            <input class="text-input" type="text" tabindex="12" name="user-domofon" <?php echo $row1['domofon']; ?>>
                                        </div>
                                    </div>
                                    <div class="field company">
                                        <label for="user-company">Название компании:</label>
                                        <input class="text-input" type="text" tabindex="13" name="user-company" value="<?php echo $row1['company']; ?>">
                                    </div>
                                </div>
                                <div class="field group">
                                	<div class="half-field">
                                        <label for="order-time">Время доставки*:</label>
                                        <select class="text-input" name="order-time">
                                        	<option value="10:00-14:00" selected>10:00-14:00</option>
                                            <option value="14:00-18:00">14:00-18:00</option>
                                            <option value="18:00-22:00">18:00-22:00</option>
                                        </select>
                                    </div>
                                    <?php
										$tomorrow = mktime(0, 0, 0, date("m"), date("d")+1, date("y"));
										$date = date("Y-m-d", $tomorrow); 
									?>
                                    <div class="half-field">
                                        <label for="order-date">Дата доставки*:</label>
                                        <input class="text-input" type="date" name="order-date" value="<?php echo $date; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid full-size-col centered-text">
                            <div class="field"><a href="/cart/complete/" class="big-btn red-btn">Оформить заказ</a></div>
                        </div>
                        </form>
                        <div class="grid half-col multi-form">
                            <div class="big-col">
                            	<form class="login">
                                <h2>Вход</h2>
                                <div class="hor-splitter"></div>
                                <div class="field">
                                    <label for="user-email">Email:</label>
                                    <input class="text-input" type="email" name="user-email">
                                </div>
                                <div class="field">
                                    <label for="user-pass">Пароль:</label>
                                    <a href="#" class="label-link">Забыли?</a>
                                    <input class="text-input" type="password" name="user-pass">
                                    <span class="caption">Ошибка: пароль введен неверно.</span>
                                </div>
                                <div class="field checkbox-field">
                                    <input class="checkbox-input" type="checkbox" name="user-remember">
                                    <label for="user-remember">Запомнить меня</label>
                                </div>
                                <div class="field">
                                    <a href="#" class="small-btn blue-btn user-login">Войти</a>
                                    <span id="spinner_si"><img src="/images/spinner.gif" class="spinner" title="Loading..."></span>
                                </div>
                                </form>
                            </div>
                        </div>
                        <div class="grid half-col multi-form">
                            <div class="big-col">
                                <h2>Заказ без регистрации</h2>
                                <div class="hor-splitter"></div>
                                <div class="field">
                                    <p>Завершить оформление заказа без регистрации в нашем магазине.</p>
                                    <p>В конце мы предложим вам зарегистрироваться, чтобы не вводить адрес при следующей покупке.</p>
                                </div>
                                <div class="field">
                                    <a href="#" class="small-btn blue-btn">Продолжить</a>
                                </div>
                            </div>
                        </div>
                </section><!-- main-cart-holder -->

            </div><!-- inner -->
        </section><!-- content -->
        
	<?php include($_SERVER['DOCUMENT_ROOT'].'/include/footer.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/user/session.php');

	if (!isset($_SESSION['user_id'])) {
		header('Location: ../');
	}
?>

<!doctype html><head>
    <meta charset="UTF-8">
    <title>Личный кабинет | The Moscow Cheesecake</title>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/include/header.php'); ?>
	
	<section class="content">
        <div class="inner">
				<?php include($_SERVER['DOCUMENT_ROOT'].'/user/user_panel.php'); ?>
                <!-- profile-holder -->
                <section class="profile-holder group">
                <div id="profile-tabs">
                    <div class="ver-shadow-splitter"></div>
                    <div class="grid small-col">
                        <aside class="progile-nav">
                        <ul>
                            <li><a href="#tabs-1" class="profile-nav-link selected">Личные данные <i class="icn-selected-nav"></i></a></li>
                            <li><a href="#tabs-2" class="profile-nav-link">Адрес доставки <i class="icn-selected-nav"></i></a></li>
                            <li><a href="#tabs-3" class="profile-nav-link">История заказов <i class="icn-selected-nav"></i></a></li>
                            <li><a href="#tabs-4" class="profile-nav-link">Скидки и купоны <i class="icn-selected-nav"></i></a></li>
                        </ul>
                        </aside>
                    </div>
                    <div class="grid big-col group">
                        <div class="almost-full-size-col centered tab" id="tabs-1">
                        	<div class="big-col centered">
                                <form id="profile-personal">
                                    <h2>Личные данные</h2>
                                    <div class="hor-splitter"></div>
                                    <div class="field">
                                        <label for="user-name">Ваше имя:</label>
                                        <input class="text-input" type="text" name="user-name" value="<?php echo $row['name']; ?>">
                                    </div>
                                    <div class="field">
                                        <label for="user-email">Email:</label>
                                        <input class="text-input" disabled type="email" name="user-email" value="<?php echo $row['email']; ?>">
                                    </div>
                                    <div class="field">
                                        <label for="user-phone">Телефоны:</label>
                                        <br>
                                        <?php
                                            $query = "SELECT *
                                                        FROM `phones`
                                                        WHERE `user_id` = '{$_SESSION['user_id']}'
                                                        ORDER BY `phone_id` ASC";
                                            $result = $mysqli->query($query) or die($mysqli->error);
                                            while($row = $result->fetch_assoc()) {
                                                echo "
                                                    <span class='profile-phone-holder'>
                                                        <input type='hidden' name='user-phone-id[]' value='{$row['phone_id']}'>
                                                        <input class='text-input profile-phone' type='tel' name='user-phone[]' value='{$row['phone']}'>
                                                        <span class='deleterow'></span>
                                                    </span>";
                                            }
                                        ?>
                                        <input type="hidden" name="user-phone-id[]" value="0">
                                        <input class="text-input" type="tel" name="user-phone[]" placeholder="Добавить новый телефон">
                                    </div>
                                    <div class="hor-splitter"></div>
                                    <div class="field">
                                        <label for="user-pass-old">Старый пароль:</label>
                                        <input class="text-input" type="password" name="user-pass-old">
                                    </div>
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
                                    <div class="whiteboard grid full-size-col hidden centered-text change-success"></div>
                                </form>
                            </div>
                        </div><!-- tab-1 -->
                        <div class="almost-full-size-col centered tab" id="tabs-2">
                        	<div class="big-col centered">
                                <form id="profile-address">
                                    <h2>Ваши адреса</h2>
                                    <div class="hor-splitter"></div>
                                    <?php
                                        $query = "SELECT *
                                                    FROM `addresses`
                                                    WHERE `user_id` = '{$_SESSION['user_id']}'";
                                        
                                        $result = $mysqli->query($query) or die($mysqli->error);
                                        if ($result->num_rows != 0) {
                                            echo "
                                                <div class='field'>
                                                    <label for='user-address'>На эти адреса Вы уже делали заказ:</label>
                                                    <select class='text-input' name='user-address'>";
                                            while ($row = $result->fetch_assoc()) {
												$address_title = address_title($row);
                                                echo "
                                                        <option value='{$row['address_id']}'>{$address_title}</option>";
                                            }
                                            echo "
                                                        <option value='0'>-- Добавить новый адрес --</option>
                                                    </select>
                                                </div>";
                                            $result->data_seek(0);
                                            $row = $result->fetch_assoc();
                                        }
                                    ?>
                                    <div id="address">
                                        <div class="field checkbox-field">
                                            <input class="checkbox-input" type="checkbox" id="to-office" name="user-office" <?php echo ($row['office'] == 1) ? 'checked' : ''; ?>>
                                            <label for="user-office">Доставка в офис</label>
                                        </div>
                                        <div class="field">
                                            <label for="user-metro">Ближайшая станция метро:</label>
                                            <input class="text-input" type="text" tabindex="5" name="user-metro" value="<?php echo $row['metro']; ?>">
                                        </div>
                                        <div class="field">
                                            <label for="user-street">Улица:</label>
                                            <input class="text-input" type="text" tabindex="6" name="user-street" value="<?php echo $row['street']; ?>">
                                        </div>
                                        <div class="field group">
                                            <div class="mini-field">
                                                <label for="user-house">Дом:</label>
                                                <input class="text-input" type="text" tabindex="7" name="user-house" value="<?php echo $row['house']; ?>">
                                            </div>
                                            <div class="mini-field">
                                                <label for="user-building">Корпус:</label>
                                                <input class="text-input" type="text" tabindex="8" name="user-building" value="<?php echo $row['building']; ?>">
                                            </div>
                                            <div class="mini-field">
                                                <label for="user-flat">Квартира:</label>
                                                <input class="text-input" type="text" tabindex="9" name="user-flat" value="<?php echo $row['flat']; ?>">
                                            </div>
                                        </div>
                                        <div class="field group">
                                            <div class="mini-field">
                                                <label for="user-enter">Подъезд:</label>
                                                <input class="text-input" type="text" tabindex="10" name="user-enter" value="<?php echo $row['enter']; ?>">
                                            </div>
                                            <div class="mini-field">
                                                <label for="user-floor">Этаж:</label>
                                                <input class="text-input" type="text" tabindex="11" name="user-floor" value="<?php echo $row['floor']; ?>">
                                            </div>
                                            <div class="mini-field">
                                                <label for="user-domofon">Домофон:</label>
                                                <input class="text-input" type="text" tabindex="12" name="user-domofon" value="<?php echo $row['domofon']; ?>">
                                            </div>
                                        </div>
                                        <div class="field company">
                                            <label for="user-company">Название компании:</label>
                                            <input class="text-input" type="text" tabindex="13" name="user-company" value="<?php echo $row['company']; ?>">
                                        </div>
                                        <div class="field">
                                            <div class="half-field">
                                                <a href="#tabs-2" class="small-btn blue-btn save-address">Сохранить</a>
                                                <span id="spinner_si"><img src="/images/spinner.gif" class="spinner" title="Loading..."></span>
                                            </div>
                                            <div class="half-field">
                                                <a href="#tabs-2" class="small-btn red-btn delete-address">Удалить адрес</a>
                                            </div>
                                        </div>
                                        <div class="whiteboard grid full-size-col hidden centered-text change-success"></div>
                                    </div>
                                </form>
                        	</div>
                        </div><!-- tab-2 -->
                        <div class="almost-full-size-col centered tab" id="tabs-3">
                            <div class="big-col centered">
                                <h2>История ваших заказов</h2>
                                <div class="hor-splitter"></div>
                                <div class="order-history-holder">
                                <?php
                                    $query = "SELECT *
                                                FROM `orders`
                                                WHERE `user_id` = '{$_SESSION['user_id']}'
                                                ORDER BY `order_date` DESC";
                                                    
                                    $result = $mysqli->query($query) or die($mysqli->error);
                                    
                                    if ($result->num_rows) {
                                        for ($i = $result->num_rows; $i > 0; $i--)
                                        {
                                            $row = $result->fetch_assoc();
											
											if ($row['canceled'] == 0) {
												$order_status_canceled = '';
												$order_title_canceled = '';
											} else {
												$order_status_canceled = 'order-status-canceled';
												$order_title_canceled = '(Отменен)';
											}
                                            
                                            echo "
                                                <div class='order-history-item group $order_status_canceled'>
                                                    <div class='order-history-number'>Заказ № {$row['order_id']} $order_title_canceled</div>
                                                    <div class='order-history-date'>{$row['delivery_date']}</div>
                                                    <div class='order-history-sum'>Сумма: {$row['bill']} ₷</div>
                                                    <div class='order-history-details group'>";
                                                    
                                            $query2 = "SELECT `product_id`, `amount`
                                                        FROM `purchases`
                                                        WHERE `order_id` = '{$row['order_id']}'
                                                        ORDER BY `id` ASC";
                                                            
                                            $result2 = $mysqli->query($query2) or die($mysqli->error);
                                            
                                            if ($result2->num_rows) {
                                                for ($p = 1; $p <= $result2->num_rows; $p++)
                                                {
                                                    $row2 = $result2->fetch_assoc();
                                                    
                                                    $query3 = "SELECT `name`, `price`
                                                                FROM `products`
                                                                WHERE `product_id` = '{$row2['product_id']}'";
                                                                    
                                                    $result3 = $mysqli->query($query3) or die($mysqli->error);
                                                    
                                                    $row3 = $result3->fetch_assoc();
                                                    
                                                    echo "
                                                        <div class='order-history-details-row group'>
                                                            <div class='order-history-details-number'>$p.</div>
                                                            <div class='order-history-details-name'>{$row3['name']}</div>   
                                                            <div class='order-history-details-price'>{$row3['price']} ₷</div>
                                                            <div class='order-history-details-qt'>× {$row2['amount']} шт.</div>
                                                            <div class='order-history-details-total-price'>".($row2['amount'] * $row3['price'])." ₷</div>
                                                        </div>";
                                                }
                                            }
                                            echo "
                                                        <div class='order-history-details-row group'>
                                                            <div class='order-history-details-number'>&nbsp;</div>
                                                            <div class='order-history-details-name'>Доставка</div>   
                                                            <div class='order-history-details-price'>&nbsp;</div>
                                                            <div class='order-history-details-qt'>&nbsp;</div>
                                                            <div class='order-history-details-total-price'>".((empty($row['delivery'])) ? 'Бесплатно' : $row['delivery'].' ₷')."</div>
                                                        </div>
                                                    </div>
                                                </div>";
                                        }
                                    } else {
                                        echo '<p>Вы еще ничего не заказывали</p>';
                                    }
                                ?>
                                </div>
                            </div>
                        </div><!-- tab-3 -->
                        <div class="almost-full-size-col centered tab" id="tabs-4">
                        	<div class="big-col centered">
                                <h2>Ваши скидки и купоны</h2>
                                <div class="hor-splitter"></div>
                                <div class="grid half-col">
                                    <?php
                                    
                                        $discount_5 = '';
                                        $discount_5_value = 0;
                                        $discount_10 = '';
                                        $discount_10_value = 0;
                                    
                                        $query = "SELECT *
                                                    FROM `discounts`
                                                    WHERE `user_id` = '{$_SESSION['user_id']}'";
                                                        
                                        $result = $mysqli->query($query) or die($mysqli->error);
                                        
                                        if ($result->num_rows) {
                                            while ($row = $result->fetch_assoc()) {
                                                if ($row['discount'] == 5) {
                                                    $discount_5 = 'selected';
                                                    $discount_5_value = $row['value'];
                                                } else if ($row['discount'] == 10) {
                                                    $discount_10 = 'selected';
                                                    $discount_10_value = $row['value'];
                                                }
                                            }
                                        }
                                    ?>
                                    <p>
                                        <i class='icn-discount-5 discount-btn discount-profile <?php echo $discount_5; ?>'>
                                        <span class="discount-qt"><?php echo $discount_5_value; ?></span></i>
                                    </p>
                                    <p>Скидка 5% дается каждому зарегистрированному пользователю:</p>
                                    <p>1. После оформления первого заказа;</p>
                                    <p>2. При заказе от 3 чизкейков на следующий заказ.</p>
                                </div>
                                <div class="grid half-col">
                                    <p>
                                        <i class='icn-discount-10 discount-btn discount-profile <?php echo $discount_10; ?>'>
                                        <span class="discount-qt"><?php echo $discount_10_value; ?></span></i>
                                    </p>
                                    <p>Скидка 10% дается каждому зарегистрированному пользователю при заказе от 5 чизкейков на следующий заказ.</p>
                                </div>
                            </div>
                        </div><!-- tab-4 -->
                    </div>
                </div>
                </section><!-- profile-holder -->

            </div><!-- inner -->
        </section><!-- content -->
        
	<?php include($_SERVER['DOCUMENT_ROOT'].'/include/footer.php'); ?>
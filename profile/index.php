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
                        <div class="half-col centered tab" id="tabs-1">
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
                                        $query = "SELECT `phone`, `phone_id`
                                                    FROM `phones`
                                                    WHERE `user_id` = '{$_SESSION['user_id']}'
													ORDER BY `phone_id` ASC";
                                        $sql = mysql_query($query) or die(mysql_error());
                                        while( $row = mysql_fetch_assoc($sql) ) {
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
                                <div class="field">
                                    <a href="#" class="small-btn blue-btn">Сохранить</a>
                                    <span id="spinner_si"><img src="/images/spinner.gif" class="spinner" title="Loading..."></span>
                                </div>
                            </form>
                        </div><!-- half-col -->
                        <div class="half-col centered tab" id="tabs-2">
                        	<form id="profile-address">
                                <h2>Ваши адреса</h2>
                                <div class="hor-splitter"></div>
                                <?php
                                    $query1 = "SELECT `address_id`, `metro`, `street`, `house`, `building`, `office`, `company`, `flat`, `enter`, `floor`, `domofon`
                                                FROM `addresses`
                                                WHERE `user_id` = '{$_SESSION['user_id']}'";
                                    
                                    $sql1 = mysql_query($query1) or die(mysql_error());
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
                                    <div class="field">
                                        <div class="half-field">
                                            <a href="#tabs-2" class="small-btn blue-btn save-address">Сохранить</a>
                                            <span id="spinner_si"><img src="/images/spinner.gif" class="spinner" title="Loading..."></span>
                                        </div>
                                        <div class="half-field">
                                            <a href="#tabs-2" class="small-btn red-btn delete-address">Удалить адрес</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div><!-- half-col -->
                        <div class="full-size-col centered tab" id="tabs-3">
                        	<h2>История ваших заказов</h2>
                            <div class="hor-splitter"></div>
                        	<div id="profile-orders">
                        	<?php
                                $query = "SELECT `order_id`, `order_date`, `delivery_date`, `delivery_time`, `bill`, `comment`
                                            FROM `orders`
                                            WHERE `user_id` = '{$_SESSION['user_id']}'
                                            ORDER BY `order_date` DESC";
                                                
                                $sql = mysql_query($query) or die(mysql_error());
                                
                                if (mysql_num_rows($sql)) {
                                    for ($i = mysql_num_rows($sql); $i > 0; $i--)
                                    {
                                        $row = mysql_fetch_assoc($sql);
                                        
                                        print "
                                            <h3>Заказ #$i :: Доставка: ".$row["delivery_date"]." :: Сумма: ".$row["bill"].".00 руб.</h3>
                                            <div>
                                            <table border='1px'>
                                                <thead>
                                                    <tr>
                                                        <th>&nbsp;</th>
                                                        <th>Наименование</th>
                                                        <th>Кол.</th>
                                                        <th>Цена</th>
                                                        <th>Всего</th>
                                                    </tr>
                                                </thead>
                                                <tbody>";
                                                
                                        $query2 = "SELECT `product_id`, `amount`
                                                    FROM `purchases`
                                                    WHERE `order_id` = '".$row["order_id"]."'
                                                    ORDER BY `id` ASC";
                                                        
                                        $sql2 = mysql_query($query2) or die(mysql_error());
                                        
                                        if (mysql_num_rows($sql2)) {
                                            for ($p = 1; $p <= mysql_num_rows($sql2); $p++)
                                            {
                                                $row2 = mysql_fetch_assoc($sql2);
                                                
                                                $query3 = "SELECT `name`, `price`
                                                            FROM `products`
                                                            WHERE `product_id` = '".$row2["product_id"]."'";
                                                                
                                                $sql3 = mysql_query($query3) or die(mysql_error());
                                                
                                                $row3 = mysql_fetch_assoc($sql3);
                                                
                                                print "			
                                                        <tr>
                                                            <th>$p</th>
                                                            <th>".$row3["name"]."</th>
                                                            <th>".$row2["amount"]."</th>
                                                            <th>".$row3["price"]."</th>
                                                            <th>".($row2["amount"] * $row3["price"])."</th>
                                                        </tr>";
                                            }
                                        }
                                        print "
                                                    <tr align='right'>
                                                        <th>&nbsp;</th>
                                                        <th colspan='3'>Доставка:</th>
                                                        <th>".(($row["bill"] > 1500) ? "Бесплатно" : "250.00")."</th>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr align='right'>
                                                        <th colspan='4'>Всего к оплате:</th>
                                                        <th>".(($row["bill"] > 1500) ? $row["bill"] : $row["bill"]+250)."</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                        
                                            </div>";
                                    }
                                } else {
									echo '<p>Вы еще ничего не заказывали</p>';
								}
							?>
                            </div>
                        </div><!-- half-col -->
                        <div class="half-col centered tab" id="tabs-4">
                            <h2>Ваши скидки и купоны</h2>
                            <div class="hor-splitter"></div>
                        </div><!-- half-col -->
                    </div>
                </div>
                </section><!-- profile-holder -->

            </div><!-- inner -->
        </section><!-- content -->
        
	<?php include($_SERVER['DOCUMENT_ROOT'].'/include/footer.php'); ?>
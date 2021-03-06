<body style="background: #442712">
    <table align="center" width="100%" height="100%" cellspacing="1px" cellpadding="0" style="font-family: sans-serif;font-size:14px;  background: #442712; margin:0; padding:0;">
        <tr>
            <td>&nbsp;</td>
            <td width="450">
                <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:15px; margin-bottom: 15px;">
                    <tr>
                        <td align="center"><a href="#"><img width="110px" height="100px" src="http://thecheesecake.ru/images/logo.png" alt=""></a></td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="15px" style="background: white; margin-top:20px; padding-top: 15px; -webkit-border-radius:10px; -moz-border-radius:10px; border-radius:10px;">
                                <tr>
                                    <td><h1 style="margin-bottom: 0px">Заказ принят</h1></td>
                                </tr>    
                                <tr>
                                    <td>
                                        <p>Привет, <?php echo $user_name; ?>!</p>
                                        <p>Мы успешно получили ваш <b>заказ № <?php echo $order_id; ?></b> на <b><?php echo $date; ?></b> с доставкой в интервале <b><?php echo $time; ?></b>. В ближайшее время с вами свяжется наш оператор.</p>
                                        <p>Спасибо, что выбрали наши чизкейки.</p>
										<?php if (isset($_SESSION['new_user_discount']) || isset($_SESSION['new_user'])) { ?>
                                        <p>Вы только что оформили свой <span class="bold">первый заказ</span>, и за это <span class="bold">мы дарим вам скидку 5%</span> на следующий!</p>
                                        <?php } ?>
                                        <?php if (isset($_SESSION['new_discount'])) { ?>
                                        <p>Вы только что оформили <span class="bold">заказ на <?php echo $_SESSION['item_total']; ?> чизкейк<?php echo ($_SESSION['item_total'] >= 5 ? 'ов' : 'а'); ?></span>, и за это <span class="bold">мы дарим вам скидку <?php echo $_SESSION['new_discount']; ?>%</span> на следующий!</p>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="100%" cellspacing="0" cellpadding="5px" style="border-top: solid 5px #f5f0f3">
                                            <tr>
                                                <td colspan="3"><h3 style="margin-bottom: 3px; margin-top: 10px">Детали заказа № <?php echo $order_id; ?></h3></td>
                                            </tr>
                                            <?php
											
												$mysqli = Database::getConnection();
											
												foreach ($item_list as $key => $val) {
													if ($val['qty'] != 0) {
														$query = "SELECT `name`, `price`
																	FROM `products`
																	WHERE `product_id`='{$val['id']}'";
														$result = $mysqli->query($query) or die($mysqli->error);
														$row = $result->fetch_assoc();
														
														echo "
															<tr>
																<td width='45%' style='border-bottom: solid 1px #e9e4e7'>{$row['name']}</td>
																<td width='25%' style='border-bottom: solid 1px #e9e4e7' valign='top'>× {$val['qty']} шт.</td>
																<td width='20%' style='border-bottom: solid 1px #e9e4e7' valign='top' align='right'>".($row['price']*$val['qty'])." р.</td>
															</tr>";
													}
												}
											
											?>
                                            <tr>
                                                <td width="45%" style="border-bottom: solid 1px #e9e4e7">Доставка</td>
                                                <td width="25%" style="border-bottom: solid 1px #e9e4e7" valign="top">&nbsp;</td>
                                                <td width="20%" style="border-bottom: solid 1px #e9e4e7" valign="top" align="right"><?php echo (empty($delivery)) ? 'Бесплатно' : $delivery.' р.'; ?></td>
                                            </tr>
                                            <?php if (!empty($discount)) { ?>
                                            <tr>
                                                <td width="45%" style="border-bottom: solid 1px #e9e4e7">Скидка <?php echo $discount; ?>%</td>
                                                <td width="25%" style="border-bottom: solid 1px #e9e4e7" valign="top">&nbsp;</td>
                                                <td width="20%" style="border-bottom: solid 1px #e9e4e7" valign="top" align="right">
													<?php echo ($raw_bill + $delivery - $bill).' р.'; ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                            <tr>
                                                <td colspan="3" valign="top" align="right"><b>Итого: <?php echo $bill; ?> р.</b></td>
                                            </tr>
                                            <?php if (!empty($comment)) { ?>
                                            <tr>
                                                <td colspan="3"><h3 style="margin-bottom: 3px; margin-top: 10px">Комментарий</h3></td>
                                            </tr>
                                            <tr>
                                            	<td colspan="3"><?php echo $comment; ?></td>
                                            </tr>
                                            <?php } ?>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="15px" style="background: white; margin-top:20px; padding-top: 15px; -webkit-border-radius:10px; -moz-border-radius:10px; border-radius:10px;">
                            	<tr>
                                	<td width="30%" style="border-bottom: solid 1px #e9e4e7"><h3 style="margin-bottom: 3px; margin-top: 10px">Адрес:</h3></td>
                                	<td width="70%" style="border-bottom: solid 1px #e9e4e7"><?php echo address_title($address); ?></td>
                                </tr>
                                <?php
									if ($address['office'] == 1 && !empty($address['company'])) {
										echo "
											<tr>
												<td width='30%' style='border-bottom: solid 1px #e9e4e7'><h3 style='margin-bottom: 3px; margin-top: 10px'>Компания:</h3></td>
												<td width='70%' style='border-bottom: solid 1px #e9e4e7'>{$address['company']}</td>
											</tr>";
									}
								?>
                                <tr>
                                	<td width="30%"><h3 style="margin-bottom: 3px; margin-top: 10px">Телефон:</h3></td>
                                    <td width="70%"><?php echo $address['phone']; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td>&nbsp;</td>
        </tr>
    </table>
</body>
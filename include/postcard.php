                <!-- Postcart -->
                <section class="postcard-content group">
                    <div class="postcard-corener pc-l-t"></div>
                    <div class="postcard-corener pc-r-t"></div>
                    <div class="postcard-corener pc-l-b"></div>
                    <div class="postcard-corener pc-r-b"></div>
                    <article class="text-content-inner group">
                        <div class="information-part group">
                            <div class="grid small-col right-dark-border">
                                <h2><i class="icn-heart"></i>Чизкейки</h2>
                                <p>Основной принцип нашей компании — это высокое качество продукта. Все наши Чизкейки готовятся только по оригинальным американским рецептам.</p>
                                <p>Ассортимент и конечная рецептура разрабатывались при участии американского кондитера с опытом работы более 20 лет.</p>
                                <p>Присоединяйтесь к нам:</p>
                                <p><a href="http://vk.com/moscowcheesecake" target="_blank"><i class="icn-vk"></i></a>
                                    <a href="https://www.facebook.com/MoscowCheesecake" target="_blank"><i class="icn-fb"></i></a></p>
                            </div>
                            <div class="grid small-col right-dark-border left-light-border">
                                <h2><i class="icn-delivery"></i>Доставка</h2>
                                <p>Пока мы доставляем чизкейки только по Москве.</p>
                                <p>Доставка осуществляется каждый день (даже в праздники) с 10:00 до 22:00.</p>
                                <p>Стоимость доставки 250 ₷.</p>
                                <p><span class="italic">При заказе от 2-х чизкейков, мы доставим их бесплатно.</span></p>
                            </div>
                            <div class="grid medium-col left-light-border">
                                <h2><i class="icn-profile-card"></i>Бонусы и скидки</h2>
                                <p>Регистрация позволит вам экономить время при заказе и даст возможность получать скидки.</p>
                                <p><a class="su-popup-trigger" href="#">Зарегистрируйтесь сейчас</a> или во время оформления первого заказа.</p>
                                <div class="hor-splitter"></div>
                                <h2><i class="icn-case"></i>Для ресторанов</h2>
                                <p>Мы любим сотрудничать. Если вы тоже, то, пожалуйста, посмотрите на <a href="/Moscow-Cheesecake.pdf">наше коммерческое предложение</a> <small>(pdf, 780 kb)</small>.</p>
                            </div>
                        </div>
                        <?php if ($_SERVER['PHP_SELF'] == '/index.php') { ?>
                        <div class="hor-splitter"></div>
                        <div class="full-size-col group">
                            <h2><i class="icn-chat"></i>Нам интересно</h2>
                            <div class="questions-part group">
                            	<form id="poll">
                            	<?php
								
									$query = "SELECT *
												FROM `polls`
												ORDER BY `poll_id` ASC
												LIMIT 3";
									$result = $mysqli->query($query) or die($mysqli->error);
									
									while ($row = $result->fetch_assoc()) {
										echo "
											<div class='grid small-col'>
												<h3>{$row['title']}</h3>
												<div class='variants'>";
										
										$query2 = "SELECT `poll_choice_id`, `value`
													FROM `poll_choices`
													WHERE `poll_id`='{$row['poll_id']}'
													ORDER BY `poll_choice_id` ASC";
									
										$result2 = $mysqli->query($query2) or die($mysqli->error);
										while ($row2 = $result2->fetch_assoc()) {
											$query3 = "SELECT `poll_choice_id`
														FROM `poll_results`
														WHERE `poll_id`='{$row['poll_id']}' AND `user_id` = '{$_SESSION['user_id']}'";
										
											$result3 = $mysqli->query($query3) or die($mysqli->error);
											if ($result3->num_rows) {
												$row3 = $result3->fetch_assoc();
												if ($row3['poll_choice_id'] == $row2['poll_choice_id']) {
													$is_checked = 'checked';
												} else {
													$is_checked = '';
												}
											}
											echo "
												<p>
													<input type='radio' name='{$row['poll_id']}' value='{$row2['poll_choice_id']}' $is_checked>
													<label for='{$row['poll_id']}'>{$row2['value']}</label>
												</p>";
										}
										echo "
												</div>
											</div>";
										
									}
								
								?>
                                </form>
                            </div>
                            <div class="answers">Пожалуйста, поучаствуйте в нашем опросе (только для зарегистрированных пользователей).</div>
                        </div>
                        <?php } ?>
                    </article>
                </section>

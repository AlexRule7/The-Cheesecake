                <!-- User panel -->
                <section class="user-panel-holder group">
                    <div class="phone-holder">
                        <i class="icn-phone"></i>
                        <h1 class="phone-number" itemprop="telephone"><a href="tel:+74955185456">+7 (495) 518-54-56</a></h1>
                    </div>
                    <div class="panel-fix-position">
                        <ul class="user-panel">
						<?php
                        
							if (isset($name) && isset($_SESSION['user_id'])) {
								print '
									<li class="splitter-next"><a href="#">Здравствуйте, '.$name.'!</a></li>
									<li class="splitter-next"><a href="#" id="logout">Выйти</a></li>';
							} else {
								print '
									<li class="splitter-next"><a class="si-popup-trigger" href="#">Вход</a></li>
									<li class="splitter-next"><a class="su-popup-trigger" href="#">Регистрация</a></li>';
							}
                        
                        ?>
                        <li class="mini-cart"><a href="#"><i class="icn-cart"></i>Корзина: <?php echo $_SESSION['item_total']; ?></a></li>
                        </ul>
                        <section class="mini-cart-container empty-cart">
                            <div class="mini-cart-arrow"></div>
                            <div class="mini-height-scroll-container">
                            	<span id="spinner_cart"><img src="images/spinner.gif" class="spinner" title="Loading..."></span>
                            </div>
                        </section>
                    </div>
                </section>
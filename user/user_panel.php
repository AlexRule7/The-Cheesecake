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
                        <li class="mini-cart"><a href="#"><i class="icn-cart"></i>Корзина: 4</a></li>
                        </ul>
                        <section class="mini-cart-container">
                            <div class="mini-cart-arrow"></div>
                            <div class="mini-height-scroll-container">
                                <div class="mini-cart-item group">
                                    <div class="mini-cart-photo-holder">
                                        <a href="#"><img class="mini-cart-photo" src="/images/menu/mint.jpg" alt="Чизкейк Мятный"></a>
                                    </div>
                                    <div class="mini-cart-info">
                                        <span class="mini-cart-item-name">Мятный чизкейк</span>
                                        <input class="mini-cart-item-qt" type="number" value="1">
                                        <span class="mini-cart-item-qt-label">× шт.</span>
                                    </div>
                                </div>
                                <div class="mini-cart-item group">
                                    <div class="mini-cart-photo-holder">
                                        <a href="#"><img class="mini-cart-photo" src="/images/menu/strawberry.jpg" alt="Чизкейк Клубничный"></a>
                                    </div>
                                    <div class="mini-cart-info">
                                        <span class="mini-cart-item-name">Клубничный чизкейк</span>
                                        <input class="mini-cart-item-qt" type="number" value="1">
                                        <span class="mini-cart-item-qt-label">× шт.</span>
                                    </div>
                                </div>
                                <div class="mini-cart-item group">
                                    <div class="mini-cart-photo-holder">
                                        <a href="#"><img class="mini-cart-photo" src="/images/menu/caramel-apple.jpg" alt="Чизкейк Карамельно-яблочный"></a>
                                    </div>
                                    <div class="mini-cart-info">
                                        <span class="mini-cart-item-name">Карамельно-яблочный чизкейк</span>
                                        <input class="mini-cart-item-qt" type="number" value="1">
                                        <span class="mini-cart-item-qt-label">× шт.</span>
                                    </div>
                                </div>
                                <div class="mini-cart-item group">
                                    <div class="mini-cart-photo-holder">
                                        <a href="#"><img class="mini-cart-photo" src="/images/menu/lime.jpg" alt="Чизкейк Лаймовый"></a>
                                    </div>
                                    <div class="mini-cart-info">
                                        <span class="mini-cart-item-name">Лаймовый чизкейк</span>
                                        <input class="mini-cart-item-qt" type="number" value="1">
                                        <span class="mini-cart-item-qt-label">× шт.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mini-cart-btn">
                                <a href="#" class="big-btn red-btn"><span class="in-btn-price">3960 ₷</span><span class="in-btn-text">Оформить</span></a>
                            </div>
                        </section>
                    </div>
                </section>
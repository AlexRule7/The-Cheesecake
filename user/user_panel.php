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
									<li class="splitter-next"><a href="#">Здравствуйте, '.$name.'!</a></li>';
								if ($_SERVER['PHP_SELF'] != '/cart/index.php') {
									print '
										<li class="splitter-next"><a href="#" id="logout">Выйти</a></li>';
										include($_SERVER['DOCUMENT_ROOT'].'/user/mini-cart.php');
								} else {
									print '
										<li><a href="#" id="logout">Выйти</a></li>';
								}
							} else {
								print '
									<li class="splitter-next"><a class="si-popup-trigger" href="#">Вход</a></li>';
								if ($_SERVER['PHP_SELF'] != '/cart/index.php') {
									print '
										<li class="splitter-next"><a class="su-popup-trigger" href="#">Регистрация</a></li>';
										include($_SERVER['DOCUMENT_ROOT'].'/user/mini-cart.php');
								} else {
									print '
										<li><a class="su-popup-trigger" href="#">Регистрация</a></li>';
								}
							}
                        
                        ?>
                    </div>
                </section>
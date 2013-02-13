<?php

session_start();

require(dirname(__FILE__).'/Connections/exarium.php');

function user_panel($name) {
	if (isset($name) && isset($_SESSION['user_id'])) {
		print '
                    <div class="panel-fix-position">
                        <ul class="user-panel">
                            <li class="splitter-next"><a href="#">Здравствуйте, '.$name.'!</a></li>
                            <li class="splitter-next"><a href="#" id="logout">Выйти</a></li>
                            <li class="mini-cart"><a href="#"><i class="icn-cart"></i>Корзина: 1</a></li>
                        </ul>
                    </div>';
	} else {
		print '
                    <div class="panel-fix-position">
                        <ul class="user-panel">
                            <li class="splitter-next"><a class="si-popup-trigger" href="#">Вход</a></li>
                            <li class="splitter-next"><a class="su-popup-trigger" href="#">Регистрация</a></li>
                            <li class="mini-cart"><a href="#"><i class="icn-cart"></i>Корзина: 1</a></li>
                        </ul>
                    </div>';
	}
}

if (!isset($_SESSION['user_id']))
{
	if (isset($_COOKIE['mail']) && isset($_COOKIE['password']))
	{
		$mail = sanitize($_COOKIE['mail']);
		$password = sanitize($_COOKIE['password']);

		$query = "SELECT `user_id`, `password`
					FROM `users`
					WHERE `mail`='{$mail}' AND `password`='{$password}'
					LIMIT 1";
		$sql = mysql_query($query) or die(mysql_error());

		if (mysql_num_rows($sql) == 1)
		{
			$row = mysql_fetch_assoc($sql);
			$_SESSION['user_id'] = $row['user_id'];
		}
	}
}

if (isset($_SESSION['user_id']))
{
	$query = "SELECT `name`, `mail`
				FROM `users`
				WHERE `user_id` = '{$_SESSION['user_id']}'
				LIMIT 1";
	$sql = mysql_query($query) or die(mysql_error());
	
	if (mysql_num_rows($sql) != 1)
	{
		if (isset($_SESSION['user_id'])) {
			unset($_SESSION['user_id']);
			unset($name);
		}
		
		setcookie('login', '', 0, "/");
		setcookie('password', '', 0, "/");
		
		header('Location: index.php');
	}
	
	$row = mysql_fetch_assoc($sql);
	
	$name = $row['name'];
}



?>


<!doctype html>
<head>
    <meta charset="UTF-8">
    <title>Чизкейки в Москве | The Moscow Cheesecake</title>
    <link href="/stylesheets/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
    <link href="stylesheets/validation.css" rel="stylesheet" type="text/css">
    <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!--<script src="/js/jquery-1.9.1.min.js"></script> NOT FOR PROD -->
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script src="/js/jquery.iosslider.min.js"></script>
    <script src="/js/jquery.ui.styling.js"></script>
    <script src="js/validation.js"></script>
    <script>
        $(function() {
            $('.main-slider-container').iosSlider({
                snapToChildren: true,
                snapSlideCenter: true,
                keyboardControls: true,
                responsiveSlides: false,
                navPrevSelector: $(".prev-slide"),
                navNextSelector: $(".next-slide"),
                autoSlide: true,
                autoSlideTimer: 3000,
                autoSlideTransTimer: 600,
                infiniteSlider: true
            });
        });
    </script>
</head>
<body>

    <!-- Sign in popup -->
    <section class="popup-container si-popup">
        <div class="popup-holder">
            <div class="popup-body">
                <a class="close-btn" href="#"><i class="icn-close-popup"></i></a>
                <div class="big-col centered">
                	<form id="login">
                        <h2>Вход</h2>
                        <div class="hor-splitter"></div>
                        <div class="field">
                            <label for="user-email">Email:</label>
                            <input class="text-input" type="email" tabindex="1" name="user-email">
                        </div>
                        <div class="field">
                            <label for="user-pass">Пароль:</label>
                            <a href="#" class="label-link">Забыли?</a>
                            <input class="text-input" type="password" tabindex="2" name="user-pass">
                        </div>
                        <div class="field checkbox-field">
                            <input class="checkbox-input" type="checkbox" name="user-remember">
                            <label for="user-remember">Запомнить меня</label>
                        </div>
                        <div class="field">
                            <a href="#" class="small-btn blue-btn" id="user-login">Войти</a>
                            <div id="spinner_si"><img src="images/spinner2.gif" class="spinner" title="Loading..."></div>
                        </div>
                        <div class="hor-splitter"></div>
                        <p class="sub-dark-color">У вас еще нет аккаунта? <br /><a class="su-popup-trigger" href="#">Зарегистрируйтесь</a> и полуйчате бонусы.</p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Sign up popup -->
    <section class="popup-container su-popup">
        <div class="popup-holder">
            <div class="popup-body">
                <a class="close-btn" href="#"><i class="icn-close-popup"></i></a>
                <div class="big-col centered">
                    <h2>Регистрация</h2>
                    <div class="hor-splitter"></div>
                    <div class="field">
                        <label for="user-name">Ваше имя:</label>
                        <input class="text-input" type="text" name="user-name">
                    </div>
                    <div class="field">
                        <label for="user-email">Email:</label>
                        <input class="text-input" type="email" name="user-email">
                    </div>
                    <div class="field">
                        <label for="user-pass">Пароль:</label>
                        <input class="text-input" type="password" name="user-pass">
                    </div>
                    <div class="field">
                        <label for="user-pass-conf">Пароль еще раз:</label>
                        <input class="text-input" type="password" name="user-pass-conf">
                    </div>
                    <div class="field">
                        <a href="#" class="small-btn blue-btn">Зарегистрироваться</a>
                    </div>
                    <div class="hor-splitter"></div>
                    <p class="sub-dark-color">У вас уже есть аккаунт? Тогдай <a class="si-popup-trigger" href="#">войдите</a>.</p>
                </div>
            </div>
        </div>
    </section>
    <div class="popup-bg"></div>

    <div class="wrapper">
        <header class="site-main-header">
            <div class="inner">
                <nav>
                    <ul class="main-navigation">
                        <li><a class="selected" href="/">Меню</a></li>
                        <li><a href="/about">О наших чизкейках</a></li>
                        <li><a class="logo" href="/"><i class="icn-logo"></i></a></li>
                        <li><a href="/payments-and-deliveries">Доставка и оплата</a></li>
                        <li><a href="/company">Компания</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <section class="content">
            <div class="inner">

                <!-- User panel -->
                <section class="user-panel-holder group">
                    <div class="phone-holder">
                        <i class="icn-phone"></i>
                        <h1 class="phone-number" itemprop="telephone"><a href="tel:+74955185456">+7 (495) 518-54-56</a></h1>
                    </div>
                    <?php
						user_panel($name);
					?>
                </section>

                <!-- Main slider -->
                <section class="main-slider-container">
                    <div class="main-slider">
                        <div class="slide"><a class="photo-slide" href="#" style="background-image: url(/images/deals/1.jpg)"></a></div>
                        <div class="slide"><a class="photo-slide" href="#" style="background-image: url(/images/deals/1.jpg)"></a></div>
                        <div class="slide"><a class="photo-slide" href="#" style="background-image: url(/images/deals/1.jpg)"></a></div>
                        <div class="slide"><a class="photo-slide" href="#" style="background-image: url(/images/deals/1.jpg)"></a></div>
                    </div>
                    <div class="slider-arrow prev-slide"><i class="icn-prev-slide"></i></div>
                    <div class="slider-arrow next-slide"><i class="icn-next-slide"></i></div>
                    <div class="slider-border left-slider-border"></div>
                    <div class="slider-border right-slider-border"></div>
                </section>

                <!-- Menu -->
                <section class="menu-container">
                    <ul class="menu-list group">
                        <li class="menu-item info-block">
                            <div class="menu-photo-holder">
                                <img class="menu-photo" src="/images/menu/menu-all-price.jpg" alt="Все чизкейки по 990 рублей">
                            </div>
                        </li>
                        <li class="menu-item">
                            <div class="menu-photo-holder">
                                <a href="#"><img class="menu-photo" src="/images/menu/new-york.jpg" alt="Чизкейк New-York"></a>
                            </div>
                            <a href="#" class="menu-name">New-York</a>
                            <a href="#" class="small-btn red-btn">В корзину</a>
                        </li>
                        <li class="menu-item">
                            <div class="menu-photo-holder">
                                <a href="#"><img class="menu-photo" src="/images/menu/chocolate.jpg" alt="Чизкейк Шоколадный"></a>
                            </div>
                            <a href="#" class="menu-name">Шоколадный</a>
                            <a href="#" class="small-btn red-btn">В корзину</a>
                        </li>
                        <li class="menu-item">
                            <div class="menu-photo-holder">
                                <a href="#"><img class="menu-photo" src="/images/menu/strawberry.jpg" alt="Чизкейк Клубничный"></a>
                            </div>
                            <a href="#" class="menu-name">Клубничный</a>
                            <a href="#" class="small-btn red-btn">В корзину</a>
                        </li>
                        <li class="menu-item">
                            <div class="menu-photo-holder">
                                <a href="#"><img class="menu-photo" src="/images/menu/mint.jpg" alt="Чизкейк Мятный"></a>
                            </div>
                            <a href="#" class="menu-name">Мятный</a>
                            <a href="#" class="small-btn red-btn">В корзину</a>
                        </li>
                        <li class="menu-item">
                            <div class="menu-photo-holder">
                                <a href="#"><img class="menu-photo" src="/images/menu/caramel-apple.jpg" alt="Чизкейк Карамельно-яблочный"></a>
                            </div>
                            <a href="#" class="menu-name">Карамельно-яблочный</a>
                            <a href="#" class="small-btn red-btn">В корзину</a>
                        </li>
                        <li class="menu-item">
                            <div class="menu-photo-holder">
                                <a href="#"><img class="menu-photo" src="/images/menu/berries.jpg" alt="Чизкейк Ягодный"></a>
                            </div>
                            <a href="#" class="menu-name">Ягодный</a>
                            <a href="#" class="small-btn red-btn">В корзину</a>
                        </li>
                        <li class="menu-item">
                            <div class="menu-photo-holder">
                                <a href="#"><img class="menu-photo" src="/images/menu/lime.jpg" alt="Чизкейк Лаймовый"></a>
                            </div>
                            <a href="#" class="menu-name">Лаймовый</a>
                            <a href="#" class="small-btn red-btn">В корзину</a>
                        </li>
                        <li class="menu-item">
                            <div class="menu-photo-holder">
                                <a href="#"><img class="menu-photo" src="/images/menu/peanuts.jpg" alt="Чизкейк Арахисовый"></a>
                            </div>
                            <a href="#" class="menu-name">Арахисовый</a>
                            <a href="#" class="small-btn red-btn">В корзину</a>
                        </li>
                        <li class="menu-item">
                            <div class="menu-photo-holder">
                                <a href="#"><img class="menu-photo" src="/images/menu/raspberry.jpg" alt="Чизкейк Малиновый"></a>
                            </div>
                            <a href="#" class="menu-name">Малиновый</a>
                            <a href="#" class="small-btn red-btn">В корзину</a>
                        </li>
                    </ul>
                </section>

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
                            </div>
                            <div class="grid small-col right-dark-border left-light-border">
                                <h2><i class="icn-delivery"></i>Доставка</h2>
                                <p>Пока мы доставляем чизкейки только по Москве.</p>
                                <p>Доставка осуществляется каждый день (даже в праздники) с 10:00 до 22:00.</p>
                                <p>Стоимость доставки 250 руб.</p>
                                <p><span class="italic">При заказе от 3-х чизкейков, мы доставим их бесплатно.</span></p>
                            </div>
                            <div class="grid medium-col left-light-border">
                                <h2><i class="icn-profile-card"></i>Бонусы и скидки</h2>
                                <p>Регистрация позволит вам экономить время при заказе и даст возможность получать скидки.</p>
                                <p><a class="su-popup-trigger" href="#">Зарегистрируйтесь сейчас</a> или во время оформления первого заказа.</p>
                                <div class="hor-splitter"></div>
                                <h2><i class="icn-case"></i>Для ресторанов</h2>
                                <p>Мы любим сотрудничать. Если вы тоже, то, пожалуйста, посмотрите на <a href="#">наше коммерческое предложение</a> <small>(pdf, 3 mb)</small>.</p>
                            </div>
                        </div>
                        <div class="hor-splitter"></div>
                        <div class="full-size-col group">
                            <h2><i class="icn-chat"></i>Нам интересно</h2>
                            <div class="questions-part group">
                                <div class="grid small-col">
                                    <h3>Как вы узнали о наших чизкейках?</h3>
                                    <div class="variants">
                                        <p><input type="radio" name="q1" id='q1-1'><label for="q1-1">Реклама в интернете</label></p>
                                        <p><input type="radio" name="q1" id='q1-2' checked><label for="q1-2">Упоминание в СМИ</label></p>
                                        <p><input type="radio" name="q1" id='q1-3'><label for="q1-3">Рекомендация знакомых</label></p>
                                    </div>
                                </div>
                                <div class="grid small-col">
                                    <h3>Каким способом вам удобнее оформлять заказ у нас?</h3>
                                    <div class="variants">
                                        <p><input type="radio" name="q2" id='q2-1'><label for="q2-1">Телефон</label></p>
                                        <p><input type="radio" name="q2" id='q2-2'><label for="q2-2">Сайт</label></p>
                                    </div>
                                </div>
                                <div class="grid medium-col">
                                    <h3>Как часто вы заказываете себе еду домой?</h3>
                                    <div class="variants">
                                        <p><input type="radio" name="q3" id='q3-1'><label for="q3-1">Почти каждый день</label></p>
                                        <p><input type="radio" name="q3" id='q3-2'><label for="q3-2">Несколько раз в неделю</label></p>
                                        <p><input type="radio" name="q3" id='q3-3'><label for="q3-3">Несколько раз в месяц</label></p>
                                    </div>
                                </div>
                            </div>
                            <div class="answers">Спасибо за ответ. Пожалуйста, ответьте на оставшиеся 2 вопроса.</div>
                        </div>
                    </article>
                </section>

                <!-- Press -->
                <section class="press-container group">
                    <article class="text-content-inner group">
                        <div class="grid big-col">
                            <div class="press-image">
                                <a href="#" class="press-link afisha-link"></a>
                                <a href="#" class="press-link hopes-link"></a>
                            </div>
                        </div>
                        <div class="grid medium-col">
                            <p>Если вы написали или нашли в прессе рецензию на наши чизкейки, пожалуйста, расскажите нам об этом.</p> 
                            <p>Для пожеланий, советов и коммерческих предложений используйте это адрес:</p>
                            <p><h2><a class="mail-link" href="mailto:info@thecheesecake.ru"><i class="icn-mail"></i> info@thecheesecake.ru</a></h2></p>
                        </div>
                    </article>
                </section>

            </div><!-- inner -->
        </section><!-- content -->
        <div class="footer-push"></div>
    </div><!-- wrapper -->

    <footer>© 2011–2013 Moscow Cheesecake</footer>
</body>
</html>
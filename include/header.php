    <link href="/stylesheets/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
    <link href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">
    <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!--<script src="/js/jquery-1.9.1.min.js"></script> NOT FOR PROD -->
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
    <script src="/js/jquery.iosslider.min.js"></script>
    <script src="/js/jquery.ui.styling.js"></script>
    <script src="/js/jquery.maskedinput.min.js"></script>
    <script src="/js/cart.js"></script>
    <script src="/js/validation.js"></script>
    <script src="/js/profile.js"></script>
    <script>
        $(function() {
            $('.main-slider-container').iosSlider({
                snapToChildren: true,
                snapSlideCenter: true,
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
                	<form class="login">
                        <h2>Вход</h2>
                        <div class="hor-splitter"></div>
                        <div class="field">
                            <label for="user-email">Email:</label>
                            <input class="text-input" type="email" tabindex="1" name="user-email">
                        </div>
                        <div class="field">
                            <label for="user-pass">Пароль:</label>
                            <a href="/profile/forgot/" class="label-link">Забыли?</a>
                            <input class="text-input" type="password" tabindex="2" name="user-pass">
                        </div>
                        <div class="field checkbox-field">
                            <input class="checkbox-input" type="checkbox" name="user-remember">
                            <label for="user-remember">Запомнить меня</label>
                        </div>
                        <div class="field">
                            <a href="#" class="small-btn blue-btn user-login">Войти</a>
                        	<span id="spinner_si"><img src="/images/spinner.gif" class="spinner" title="Loading..."></span>
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
                    <form id="register">
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
                            <a href="#" class="small-btn blue-btn" id="user-register">Зарегистрироваться</a>
                            <span id="spinner_su"><img src="/images/spinner.gif" class="spinner" title="Loading..."></span>
                        </div>
                        <div class="hor-splitter"></div>
                        <p class="sub-dark-color">У вас уже есть аккаунт? Тогда <a class="si-popup-trigger" href="#">войдите</a>.</p>
                    </form>
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
                        <li><a <?php echo $nav_1; ?> href="/">Меню</a></li>
                        <li><a <?php echo $nav_2; ?> href="/about">О наших чизкейках</a></li>
                        <li><a class="logo" href="/"><i class="icn-logo"></i></a></li>
                        <li><a <?php echo $nav_3; ?> href="/payments-and-delivery">Доставка и оплата</a></li>
                        <li><a <?php echo $nav_4; ?> href="/company">Компания</a></li>
                    </ul>
                </nav>
            </div>
        </header>

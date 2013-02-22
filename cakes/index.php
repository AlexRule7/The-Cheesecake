<?php
	include($_SERVER['DOCUMENT_ROOT'].'/user/session.php');
	
	if (isset($_GET)) {
		switch (key($_GET)) {
			case 'newyork':
				$product_id = 1;
				break;
			case 'chocolate':
				$product_id = 2;
				break;
			case 'strawberry':
				$product_id = 3;
				break;
			case 'mint':
				$product_id = 4;
				break;
			case 'caramelapple':
				$product_id = 5;
				break;
			case 'berries':
				$product_id = 6;
				break;
			case 'lime':
				$product_id = 7;
				break;
			case 'peanutbutter':
				$product_id = 8;
				break;
			case 'raspberry':
				$product_id = 9;
				break;
			default:
				header('Location: ../');
		}
		
		$query = "SELECT `name`, `image`, `price`, `annotation`,
					`protein`, `fat`, `carbohydrate`, `calories`
					FROM `products`
					WHERE `product_id`='{$product_id}'
					LIMIT 1";
		$sql = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_assoc($sql);
	} else {
		header('Location: ../');
	}
?>

<!doctype html><head>
    <meta charset="UTF-8">
    <title>Ягодный чизкейк | The Moscow Cheesecake</title>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/include/header.php'); ?>
    
<section class="content">
        <div class="inner">
			<?php include($_SERVER['DOCUMENT_ROOT'].'/user/user_panel.php'); ?>
            
                <!-- Full item card -->
                <section class="full-item-card">
                    <img class="item-big-photo" src="/images/menu/berries-big.jpg" alt="Ягодный чизкейк">
                    <article class="text-content-inner group">
                        <div class="grid half-col">&nbsp;</div>
                        <div class="grid half-col full-item-description">
                            <h1 class="agora-font"><?php echo $row['name']; ?></h1>
                            <p><?php echo $row['annotation']; ?></p>
                            <p>Чизкейк весит 1500 грамм и разделен на 12 порций.</p>
                            <div class="nutrition-table">
                                <div class="hor-splitter"></div>
                                <div class="centered-text italic"><small>В 100 граммах содержится:</small></div>
                                <div class="cell-row group">
                                    <div class="cell-block"><span class="cell-data gramm-after"><?php echo $row['protein']; ?></span><span class="cell-label">Белок</span></div>
                                    <div class="cell-block"><span class="cell-data gramm-after"><?php echo $row['fat']; ?></span><span class="cell-label">Жир</span></div>
                                    <div class="cell-block"><span class="cell-data gramm-after"><?php echo $row['carbohydrate']; ?></span><span class="cell-label">Углеводы</span></div>
                                    <div class="cell-block"><span class="cell-data"><?php echo $row['calories']; ?></span><span class="cell-label">Калорий</span></div>
                                </div>
                                <div class="hor-splitter"></div>
                            </div>
                            <div class="grid big-col">
                                <a href="<?php echo $product_id; ?>" class="big-btn red-btn"><span class="in-btn-price"><?php echo $row['price']; ?> ₷</span><span class="in-btn-text">В корзину</span></a>
                            </div>
                            <div class="grid medium-col">
                                <small class="bold"><a href="/">Закажите еще 2 чизкейка</a>, и мы доставим их бесплатно!</small>
                            </div>
                        </div>
                    </article>
                </section>

                <!-- Menu -->
                <section class="menu-container">
                    <ul class="menu-list group">
                        <li class="menu-item">
                            <div class="menu-photo-holder">
                                <a href="#"><img class="menu-photo" src="/images/menu/new-york.jpg" alt="Чизкейк New-York"></a>
                            </div>
                            <a href="#" class="menu-name">New-York</a>
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
                                <p>Стоимость доставки 250 ₷.</p>
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
                    </article>
                </section>

            </div><!-- inner -->
        </section><!-- content -->
        
	<?php include($_SERVER['DOCUMENT_ROOT'].'/include/footer.php'); ?>
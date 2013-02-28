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
    <title><?php echo $row['name']; ?> | The Moscow Cheesecake</title>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/include/header.php'); ?>
    
<section class="content">
        <div class="inner">
			<?php include($_SERVER['DOCUMENT_ROOT'].'/user/user_panel.php'); ?>
            
                <!-- Full item card -->
                <section class="full-item-card">
                    <img class="item-big-photo" src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
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
                                <a href="<?php echo $product_id; ?>" class="big-btn red-btn add-to-cart"><span class="in-btn-price"><?php echo $row['price']; ?> ₷</span><span class="in-btn-text">В корзину</span></a>
                            </div>
                            <div class="grid medium-col">
                                <small class="bold teaser">Закажите 2 чизкейка, и мы доставим их бесплатно!</small>
                            </div>
                        </div>
                    </article>
                </section>

                <!-- Menu -->
                <section class="menu-container">
                    <ul class="menu-list group">
                        <li class="menu-item info-block">
                            <div class="menu-photo-holder">
                                <img class="menu-photo" src="/images/menu/best-seller.jpg" alt="При заказе 2 чизкейков доставка бесплатна">
                            </div>
                        </li>
                        <?php
						
							$query = "SELECT `product_id`, `url`, `name`, `image_thumb`
										FROM `products`
										WHERE `product_id`='1'
											OR `product_id`='2'
											OR `product_id`='5'
											OR `product_id`='6'";
							$sql = mysql_query($query) or die(mysql_error());
							while ($row = mysql_fetch_assoc($sql)) {
								echo "
									<li class='menu-item'>
										<div class='menu-photo-holder'>
											<a href='{$row['url']}'><img class='menu-photo' src='{$row['image_thumb']}' alt='{$row['name']}'></a>
										</div>
										<a href='{$row['url']}' class='menu-name'>{$row['name']}</a>
										<a href='{$row['product_id']}' class='small-btn red-btn add-to-cart'>В корзину</a>
									</li>";
							}
						
						?>
                    </ul>
                </section>
                
				<?php include($_SERVER['DOCUMENT_ROOT'].'/include/postcard.php'); ?>

            </div><!-- inner -->
        </section><!-- content -->
        
	<?php include($_SERVER['DOCUMENT_ROOT'].'/include/footer.php'); ?>
<?php

// Use session_start() in all pages that are working with sessions
session_start();

include($_SERVER['DOCUMENT_ROOT'].'/Connections/exarium.php');

header('Content-type: text/html; charset=utf-8');

echo "
		<div class='mini-cart-arrow'></div>
		<div class='mini-height-scroll-container'>";


if ($_SESSION['item_total'] != 0) {
	foreach($_SESSION['item_list'] as $key => $item) {
		if ($item['qty'] != 0) {
			$query = "SELECT `product_id`, `url`, `name`, `image_thumb`, `price`
						FROM `products`
						WHERE `product_id`='".$item['id']."'
						LIMIT 1";
			$sql = mysql_query($query) or die(mysql_error());
			$row = mysql_fetch_assoc($sql);
			
			echo "
				<div class='mini-cart-item group'>
					<div class='mini-cart-photo-holder'>
						<a href='{$row['url']}'><img class='mini-cart-photo' src='{$row['image_thumb']}' alt='{$row['name']}'></a>
					</div>
					<div class='mini-cart-info'>
						<span class='mini-cart-item-name'>{$row['name']}</span>
						<input class='mini-cart-item-id' type='hidden' value='{$row['product_id']}'>
						<input class='mini-cart-item-qt' type='number' value='{$item['qty']}'>
						<span class='mini-cart-item-qt-label'>× шт.</span>
						<input class='mini-cart-item-price' type='hidden' value='{$row['price']}'>
					</div>
				</div>";
				
			$bill += $row['price'] * $item['qty'];
		}
	}
	
echo "
		</div>
		<div class='mini-cart-btn'>
			<a href='/cart/' class='big-btn red-btn'><span class='in-btn-price'>$bill ₷</span><span class='in-btn-text'>Оформить</span></a>
		</div>";

} else {
	echo "<div class='empty-cart-message mini-cart-item'>Пока ваша корзина пуста :(</div></div>";
}


?>
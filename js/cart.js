jQuery(document).ready(function($){
    // Show/hide mini cart function
    function openMiniCart() {
        $('.mini-cart-container').toggleClass('opened');
    };
	
    function addItem(id, qty) {
		var data = '';
		if ($.isArray(id)) {
			$.each(id, function(index) {
				data += 'id'+ index+ '='+ id[index]+ '&qty'+ index+ '='+ qty[index]+'&';
			});
		} else {
			data = 'id='+ id+ '&qty='+ qty;
		}
		
		$.ajax({
			type: 'POST',
			url: '/user/add_item.php',
			data: data,
			cache: false,
			dataType: 'json',
			async: false,
			success: function(data) {
				$('.mini-cart a').html('<i class="icn-cart"></i>Корзина: '+ data);
			}
		});
    };

	$('.mini-cart').click(function(e) {
		openMiniCart();

		if ($('.mini-cart-container').hasClass('opened')) {
			$.ajax({
				type: 'POST',
				url: '/user/get_cart.php',
				cache: false,
				dataType: 'html',
				async: false,
				success: function(data) {
					$('.mini-cart-container').html(data);
					if ($('.empty-cart-message').length) {
						$('.mini-cart-container').addClass('empty-cart');
					} else {
						$('.mini-cart-container').removeClass('empty-cart');
					}
				}
			});
		} else {
			var id = new Array();
			$('.mini-cart-item-id').each(function(index, element) {
				id[index] = element.value;
			});
			
			var qty = new Array();
			$('.mini-cart-item-qt').each(function(index, element) {
				qty[index] = element.value;
			});
			
			addItem(id, qty);
			
			$('.mini-height-scroll-container').html('<span id="spinner_cart"><img src="images/spinner.gif" class="spinner" title="Loading..."></span>');
			$('.mini-cart-btn').remove();
		}
		
        e.preventDefault();
    });
	
	$('li.menu-item a.red-btn').click(function(e) {
		
		if ($('.mini-cart-container').hasClass('opened')) {
			openMiniCart();
		}
		
		id = $(this).attr("href");
		addItem(id, 1);
		$('.mini-cart').trigger('click');
		
		$('.mini-cart-item-id').each(function(index, element) {
            if (element.value == id) {
				$(this).next().focus();
			}
        });
		
		
		e.preventDefault();
    });
	
	$('body').on('change', '.mini-cart-item-qt', function() {
		if (this.value < 0 || !$.isNumeric(this.value)) {
			this.value = 0;
		}
		
		var price = new Array();
		$('.mini-cart-item-price').each(function(index, element) {
            price[index] = element.value;
        });
		var qty = new Array();
		$('.mini-cart-item-qt').each(function(index, element) {
            qty[index] = element.value;
        });
		
		var bill = 0;
		$.each(price, function(index) {
			bill += price[index] * qty[index];
		});
		
		var item_total = 0;
		$.each(qty, function(index) {
			item_total += Number(qty[index]);
		});
		
		$('.mini-cart a').html('<i class="icn-cart"></i>Корзина: '+ item_total);
		
		console.log(item_total);

		$('.in-btn-price').text(bill+ ' ₷');
	});
	
	$('body').on('click', '.mini-cart-btn a', function(e) {
		
		e.preventDefault();
    });
});
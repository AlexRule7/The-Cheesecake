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

jQuery(document).ready(function($){
    // Show/hide mini cart function
    function openMiniCart() {
        $('.mini-cart-container').toggleClass('opened');
    };
	// Click mini-cart button action
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
			$('.mini-height-scroll-container').html('<span id="spinner_cart"><img src="images/spinner.gif" class="spinner" title="Loading..."></span>');
			$('.mini-cart-btn').remove();
		}
		
        e.preventDefault();
    });
	// Click on button "Add to cart"
	$('.menu-item a.red-btn, .grid a.red-btn').click(function(e) {
		
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
	// Change item qty in mini-cart
	$('body').on('change', '.mini-cart-item-qt', function() {
		if (this.value < 0 || !$.isNumeric(this.value)) {
			this.value = 0;
		}
		
		var id = new Array();
		$('.mini-cart-item-id').each(function(index, element) {
			id[index] = element.value;
		});
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
		
		if ($('.main-cart-holder').length) {
			var q = $(this).val();
			var p = $(this).closest('.main-cart-item').find('.mini-cart-item-price').val();
			$(this).closest('.main-cart-item').find('.main-cart-item-price').text((p*q)+ ' ₷');
			$('.final-sum').text(bill+ ' ₷');
		} else {
			$('.mini-cart a').html('<i class="icn-cart"></i>Корзина: '+ item_total);
			$('.mini-cart-btn .in-btn-price').text(bill+ ' ₷');
		}
		
		addItem(id, qty);
	});
	// Click on delete item in main-cart
	$('.del-item-btn').click(function(e) {
		var item = $(this).closest('.main-cart-item');
		item.find('.mini-cart-item-qt').val(0);
		$('.mini-cart-item-qt').trigger('change');
		
		item.hide('slow');
		var id = new Array();
		$('.mini-cart-item-id').each(function(index, element) {
			id[index] = element.value;
		});

		var qty = new Array();
		$('.mini-cart-item-qt').each(function(index, element) {
            qty[index] = element.value;
        });
		addItem(id, qty);
		
		if ($('.main-cart-item:visible').length == 1) {
			$('.text-content-inner h2').after('<span id="empty-message">Ваша корзина пуста :(</span>');
			$('.grid.full-size-col a').remove();
		}
        e.preventDefault();
    });
	// Show sign-in prompt
	if ($('.half-col:first input[name=user-email]').val() != '') {
		$('.grid:gt(2)').hide();
	} else {
		$('.grid:lt(3)').hide();
	}
	$('.grid:last a').click(function(e) {
		$('.grid:gt(2)').hide();
		$('.grid:lt(3)').show();
		
		e.preventDefault();
    });
	// Office checkbox behaviour
	$('#to-office').change(function() {
		if(this.checked) {
			$('.field.group:eq(1), .field.group:first .mini-field:last').hide('normal');
			$('.field.company').show('normal');
		} else {
			$('.field.group:eq(1), .field.group:first .mini-field:last').show('normal');
			$('.field.company').hide('normal');
		}
	});
	if ($('#to-office').checked) {
		$('#to-office').trigger('change')
	} else {
		$('#to-office').trigger('change')
	}
	// Datepicker initialization
	if ($('.main-cart-holder').length) {
		if ($('input[name=order-date]')[0].type!=='date') {
			 $('input[name=order-date]').datepicker({
				yearRange: "-0:+1",
				defaultDate: +1,
				dateFormat: "dd.mm.yy",
				changeMonth: true,
				changeYear: true
			});
		}
	}
	// Metro autocomplete
	$.get('../js/metro.txt', function(file) {
		var data = file.split(', ');
		$('input[name=user-metro]').autocomplete({
			source: function(req, response) { 
				var re = $.ui.autocomplete.escapeRegex(req.term); 
				var matcher = new RegExp( "^" + re, "i" ); 
				response($.grep( data, function(item){ 
					return matcher.test(item);
				}));
			},
	 		minLength: 0
		})
	});
	// Phone autocomplete
	$('input[name=user-phone]').autocomplete({
		source: '/user/phone_search.php',
		minLength: 0
	})
	// Autocomplete 5 results limit
	$.ui.autocomplete.prototype._renderMenu = function( ul, items ) {
		var self = this;
		$.each( items, function( index, item ) {
			if (index < 5) {
				self._renderItemData( ul, item );
			}
		});
	};
	// Disable e-mail field if user is logged in
	if ($('.half-col:first input[name=user-email]').val() != '') {
		$('.half-col:first input[name=user-name]').prop('disabled', true);
		$('.half-col:first input[name=user-email]').prop('disabled', true);
    }
	// Address select
	if ($('select[name=user-address]').length) {
		$('#address :input').prop('disabled', true);
		$('select[name=user-address]').change(function(e) {
			if ($(this).val() == '0') {
				$('#address :input').val('').prop('disabled', false);
				$('#to-office').prop('checked', false).trigger('change');
			} else {
				$.ajax({
					type: 'POST',
					url: '/user/get_address.php',
					data: 'id='+ $(this).val(),
					cache: false,
					dataType: 'json',
					success: function(data) {
						$('#address :input').prop('disabled', true);
						if (data.office == 1) {
							$('#to-office').prop('checked', true).trigger('change');
						} else {
							$('#to-office').prop('checked', false).trigger('change');
						}
						var patt = /[a-z]+$/;
						$('#address :input').each(function(index, element) {
							var matches = patt.exec($(element).prop('name'));
							$(element).val(data[matches[0]]);
						});
					}
				});
			}
		});
	}
	
	
});
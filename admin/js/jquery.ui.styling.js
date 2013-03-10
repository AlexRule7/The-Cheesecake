jQuery(document).ready(function($){
	
	// ========== MAIN ========== //
	
	// Tabs behaviour
	$('#profile-tabs .tab:not([id=tabs-1])').hide();
	$('#profile-tabs ul li a').click(function(e) {
		var tab = $(this).prop('href').match(/[^#.]*$/i);
		$('#profile-tabs ul li a').removeClass('selected');
        $(this).addClass('selected');
		$('#profile-tabs .tab').hide();
		$('#profile-tabs .tab[id=' + tab + ']').show();
		
		e.preventDefault();
    });
	
	// Hide AJAX spinner
	$('.spinner').hide();
	
	// Show spinner when AJAX is in progress
	$(document)
		.ajaxStart(function(){
			$('.spinner').fadeIn('fast');
		})
		.ajaxStop(function(){
			$('.spinner').fadeOut('fast');
		})
	;
	
	// User search init
	$('#user_search').autocomplete({
		source: '/admin/script/user_search.php',
		minLength: 2,
		delay: 500,
		close: function( event, ui ) {
			var form = $(this).closest('form');
			$.getJSON('/admin/script/user_search.php?phone=' + $('#user_search').val(),
			function(data){
				form.find('input[name=user-id]').val(data.user_id);
				form.find('input[name=user-phone-id]').val(data.phone_id);
				form.find('input[name=user-name]').val(data.user_name);
				form.find('input[name=user-email]').val(data.user_email);
				form.find('select[name=user-address]').html('');
				if (!$.isEmptyObject(data.addresses)) {
					$.each(data.addresses, function(element) {
						form.find('select[name=user-address]').append('<option value="'+data['addresses'][element]['address_id']+'">'+data['addresses'][element]['title']+'</option>');
					});
					if (data['addresses'][0]['office'] == 1) {
						form.find('#to-office').prop('checked', true).trigger('change');
					}
					var patt = /[a-z]+$/;
					form.find('.address-group input').each(function(index, element) {
						var matches = patt.exec($(element).prop('name'));
						$(element).val(data['addresses'][0][matches[0]]);
					});
				} else {
					form.find('select[name=user-address]').html('<option value="0">У пользователя нет адреса</option>');
					form.find('.address-group input').val('');
				}
				if (!$.isEmptyObject(data.discounts)) {
					$.each(data.discounts, function(element) {
						form.find('.discount-'+element).html('<i class="icn-discount-'+element+' discount-btn"></i>');
					});
				} else {
					form.find('.discount-btn').remove();
				}
			});
		}
	});
	
	// Metro autocomplete
	$.get('/js/metro.txt', function(file) {
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
	
	// Change and get address
	$('select[name=user-address]').change(function(e) {
        $.ajax({
			type: 'POST',
			url: '/user/get_address.php',
			data: 'id='+ $(this).val(),
			cache: false,
			dataType: 'json',
			success: function(data) {
				if (data.office == 1) {
					$(this).closest('form').find('#to-office').prop('checked', true).trigger('change');
				} else {
					$(this).closest('form').find('#to-office').prop('checked', false).trigger('change');
				}
				var patt = /[a-z]+$/;
				$(this).closest('form').find('input').each(function(index, element) {
					var matches = patt.exec($(element).prop('name'));
					$(element).val(data[matches[0]]);
				});
			}
		});
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
	
	// Datepicker init
	if ($('input[name=order-date]').length) {
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
	
	// ========== Orders ========== //
	
	// Add new order counter function
	var add_order_counter = function () {
		$('.order-products tbody tr:not(:nth-last-child(-n+4)) td:first-child').each(function(index, element) {
            $(this).text( index + 1 );
        });
		if ($('.order-products tbody tr').length == 5) {
			$('.deleterow').hide();
		}
		var discount = 0;
		var raw_bill = 0;
		var delivery = 0;
		var difference = 0;
		$('.order-products .discount-btn').each(function(index, element) {
            if ($(element).hasClass('selected')) {
				discount = $(this).prop('class').match(/\d+/);
			}
        });
		$('.order-products').find('input[name=product-price-total]').each(function() {
			var product_price = parseInt($(this).closest('tr').find('input[name=product-price]').val(), 10);
			var product_amount = parseInt($(this).closest('tr').find('input[name="product-amount[]"]').val(), 10);
			if ($(this).val() != '') {
				$(this).val(product_price * product_amount + '.00');
				raw_bill += parseInt($(this).val(), 10);
			}
		});
		
		if (raw_bill < 1500 && raw_bill != 0) {
			delivery = 250;
		} else {
			delivery = 0;
		}

		if (discount != 0) {
			var bill = Math.floor((raw_bill + delivery) * ('0.'+(100-discount)));
			difference = (raw_bill + delivery) - bill;
		} else {
			var bill = raw_bill + delivery;
		}
		if (delivery == 0 && raw_bill != 0) {
			$('.order-products .delivery').text('Бесплатно');
		} else {
			$('.order-products .delivery').text(delivery+'.00');
		}
		$('.order-products .raw-bill').text(raw_bill+'.00');
		$('.order-products .discount').text(difference+'.00');
		$('.order-products .bill').text(bill+'.00');
	};
	
	// Show orders
	$('.order-datepicker input[name=order-date]').change(function(e) {
		var data = 'order_date='+$(this).val();
        $.ajax({
			type: 'POST',
			url: '/admin/script/get_orders.php',
			data: data,
			cache: false,
			dataType: 'html',
			success: function(data) {
				$('.order-history').html(data);
			}
		});
    });
	
	// Expand/Collapse order info
	$('body').on('click', '.order-history-item', (function() {
		$(this).find('.order-history-details').slideToggle();
	}));
	
	// Product search init
	$(document).on('keydown.autocomplete','.product_search',function(e){
		$(this).autocomplete({
			source: '/admin/script/product_search.php',
			minLength: 0,
			delay: 0,
			close: function( event, ui ) {
					var that = $(this);
					$.getJSON('/admin/script/product_search.php?name=' + ($(that).closest('tr').find('.product_search').val()),
					function(data){
						$(that).closest('tr').find('input[name="product-id[]"]').val(data.product_id);
						$(that).closest('tr').find('input[name=product-price], input[name=product-price-total]').val(data.price + ".00");
						$(that).closest('tr').find('input[name="product-amount[]"]').val('1');
						if ($('.order-products .discount-btn'))
						add_order_counter();
					});
			}
		}).each(function() {
			$(this).data('ui-autocomplete')._renderItem = function(ul, item) {
				return $('<li></li>')
					.data('ui-autocomplete-item', item)
					.append('<a>' + item.value + '</a>')
					.appendTo(ul);
			};
		});
	});
	
	// Add new product to order
	$('.order-products .addrow').click(function(e) {
		$('.order-products tbody tr:nth-last-child(4)').before('\
						<tr>\
							<td>&nbsp;</td>\
                            <td>\
								<div class="field">\
									<input type="text" class="text-input product_search" name="product-name">\
									<input type="hidden" name="product-id[]" />\
								</div>\
							</td>\
                            <td><div class="field"><input type="number" class="text-input" name="product-amount[]"></div></td>\
                            <td><div class="field"><input type="text" class="text-input disabled" name="product-price"></div></td>\
                            <td><div class="field"><input type="text" class="text-input disabled" name="product-price-total"></div></td>\
                            <td><span class="deleterow"></span></td>\
						</tr>');
		add_order_counter();
		$('.order-products .deleterow').show();
	});
	
	// Change product quantity
	$('.order-products').on('change', 'input[name="product-amount[]"]', function() {
		if (this.value < 0 || !$.isNumeric(this.value)) {
			this.value = 0;
		}
		add_order_counter();
	});
	
	// Hide delete row button
	$('.order-products .deleterow').hide();
	
	// Deleterow click
	$('.order-products').on('click', '.deleterow', function() {
		$( this ).closest('tr').remove();
		add_order_counter();
	});
	
    // Select discount badge
    $('.order-products').on('click', '.discount-btn', function(){
		if ($(this).hasClass('selected')) {
			$('.order-products .discount-btn').removeClass('selected');
			$('.order-products input[name=order-discount]').val('0');
			add_order_counter();
		} else {
			$('.order-products .discount-btn').removeClass('selected');
			$(this).addClass('selected');
			$('.order-products input[name=order-discount]').val($(this).prop('class').match(/\d+/));
			add_order_counter();
		}
    });
		
	/*
	$( "#street_search" ).autocomplete({
		source: "address_search.php",
		minLength: 2,
		delay: 500,
		close: function( event, ui ) {
				$.getJSON("address_search.php?street=" + $("#street_search").val(),
				function(data){
					$.each(data, function(i,item){
						$("#house").val(item[0].value);
						$("#building").val(item[1].value);
					});
				});
		}
	});
	
	$( "#user_search" ).autocomplete({
		source: "script/user_search.php",
		minLength: 2,
		delay: 500,
		response: function( event, ui ) {
				$("#name, #mail, #birthday").removeAttr('readonly disabled').val('');
				$("img.ui-datepicker-trigger").show(0);
				$("#add_user").attr({
					name: 'add_user',
					value: 'Добавить клиента'
				});
				$("#tabs").hide();
		},
		close: function( event, ui ) {
				$.getJSON("user_search.php?phone=" + $("#user_search").val(),
				function(data){
						if (data[0].user_id != '') {
							$("#name, #mail, #birthday").prop('readonly', true);
							$("img.ui-datepicker-trigger").hide(0);
							$("#add_user").attr({
								name: 'get_address',
								value: 'Получить адрес'
							});
						}
						$("#user_id").val(data[0].user_id);
						$("#name").val(data[0].name);
						$("#mail").val(data[0].mail);
						$("#birthday").val(data[0].birthday);
				});
		},
	});

	$(document).on("keydown.autocomplete",".product_search",function(e){
		$(this).autocomplete({
			source: "product_search.php",
			minLength: 0,
			delay: 0,
			close: function( event, ui ) {
					var selector = $(this);
					$.getJSON("product_search.php?name=" + ($( selector ).closest("tr").find(".product_search").val()),
					function(data){
						$( selector ).closest("tr").find(".product_id").val(data[0].product_id);
						$( selector ).closest("tr").find(".price, .price_total").val(data[0].value + ".00");
						$( selector ).closest("tr").find(".amount").spinner( 'value', 1 );
						bill = 0;
						$( selector ).closest("table").find( ".price_total" ).each(function() {
							bill += parseFloat($(this).val());
						});
						if (bill 1500) {
							$( ".delivery" ).text("Бесплатно");
						} else if (bill == 0) {
							$( ".delivery" ).text("0.00");
						} else {
							$( ".delivery" ).text("250.00");
							bill += 250;
						}
						$( ".bill" ).text(bill + ".00");
						$( "input[name=bill]" ).val(bill + ".00");
					});
			}
		}).each(function() {
			$(this).data("autocomplete")._renderItem = function(ul, item) {
				return $('<li></li>')
					.data("item.autocomplete", item)
					.append("<a>" + item.value + "</a>")
					.appendTo(ul);
			};
		});
	});
					
	$( "#birthday" ).datepicker({
		yearRange: "-80:+0",
		showOn: "button",
		buttonImage: "css/images/calendar.png",
		buttonImageOnly: true,
		buttonText: "Календарь",
		dateFormat: "dd.mm.yy",
		changeMonth: true,
		changeYear: true
	});
	
	$( ".delivery_date" ).datepicker({
		yearRange: "-0:+1",
		altField: "input[name=delivery_date]",
		defaultDate: +1,
		dateFormat: "dd.mm.yy",
		changeMonth: true,
		changeYear: true
	});


	$("input[name='office']").change(function() {
		if(this.checked) {
			$("#office_yes").show();
			$("#office_no").hide();
		} else {
			$("#office_yes").hide();
			$("#office_no").show();
		}
	});
	
	$( ".time_range" ).slider({
		range: true,
		min: 10,
		max: 22,
		values: [ 10, 12 ],
		slide: function( event, ui ) {
			if (ui.values[1] - ui.values[0] < 2) {
				return false;
			} else {
				$( ".delivery_time" ).val( ui.values[ 0 ] + ":00 - " + ui.values[ 1 ] + ":00" );
			}
		}
	});
	
	$( ".delivery_time" ).val( $( ".time_range" ).slider( "values", 0 ) + ":00 - " + $( ".time_range" ).slider( "values", 1 ) + ":00" );

	$( "#tabs" ).tabs();
	
	$( "#dialog" ).dialog({ modal: true });
	
	$( ".orders" ).accordion({
		collapsible: true,
		heightStyle: "content"
	});
	
	$( '.amount' ).spinner({
		min: 1,
		change: function( event, ui ) {
			$( this ).closest("tr").find( ".price_total" ).val($( this ).spinner('value') * $( this ).closest("tr").find( ".price" ).val() + ".00");
			bill = 0;
			$( this ).closest("table").find( ".price_total" ).each(function() {
				bill += parseFloat($(this).val());
			});
			if (bill 1500) {
				$( ".delivery" ).text("Бесплатно");
			} else if (bill == 0) {
				$( ".delivery" ).text("0.00");
			} else {
				$( ".delivery" ).text("250.00");
				bill += 250;
			}
			$( ".bill" ).text(bill + ".00");
			$( "input[name=bill]" ).val(bill + ".00");
		}
	});
	
	$( ".button" ).button();
	
	$( ".addrow" ).click(function(e) {
		$('.new_order tbody:first tr:last-child').before("\
						<tr>\
							<th></th>\
							<th>\
								<input type='hidden' class='product_id' name='product_id[]'>\
								<input type='text' class='product_search' name='name'>\
							</th>\
							<th><input type='text' class='amount' name='amount[]'></th>\
							<th><input type='text' class='price' value='0.00' disabled='disabled' name='price'></th></th>\
							<th><input type='text' class='price_total' value='0.00' disabled='disabled' name='price_total'></th>\
							<th><span class='deleterow'></span></th>\
							<th></th>\
						</tr>");
		$( ".new_order tbody:first tr:not(:last-child) th:first-child" ).each(function(index, element) {
            $( this ).text( index + 1 );
        });
		$( ".deleterow" ).show();
		$( '.amount' ).spinner({
			min: 1,
			change: function( event, ui ) {
				$( this ).closest("tr").find( ".price_total" ).val($( this ).spinner('value') * $( this ).closest("tr").find( ".price" ).val() + ".00");
				bill = 0;
				$( this ).closest("table").find( ".price_total" ).each(function() {
					bill += parseFloat($(this).val());
				});
				if (bill 1500) {
					$( ".delivery" ).text("Бесплатно");
				} else if (bill == 0) {
					$( ".delivery" ).text("0.00");
				} else {
					$( ".delivery" ).text("250.00");
					bill += 250;
				}
				$( ".bill" ).text(bill + ".00");
				$( "input[name=bill]" ).val(bill + ".00");
			}
		});
	});
	
	$('.orders').on('spin.spinner', '.amount', function(event, ui) {
		$( this ).closest("tr").find( ".price_total" ).val(ui.value * $( this ).closest("tr").find( ".price" ).val() + ".00");
		bill = 0;
		$( this ).closest("table").find( ".price_total" ).each(function() {
			bill += parseFloat($(this).val());
		});
		if (bill 1500) {
			$( ".delivery" ).text("Бесплатно");
		} else if (bill == 0) {
			$( ".delivery" ).text("0.00");
		} else {
			$( ".delivery" ).text("250.00");
			bill += 250;
		}
		$( ".bill" ).text(bill + ".00");
		$( "input[name=bill]" ).val(bill + ".00");
	});
	
	$('.orders').on('click', '.deleterow', function() {
		$( this ).closest("tr").remove();
		$( ".new_order tbody:first tr:not(:last-child) th:first-child" ).each(function(index, element) {
            $( this ).text( index + 1 );
        });
		if ($( ".new_order tbody:first tr" ).length == 2) {
			$( ".deleterow" ).hide();
		}
		bill = 0;
		$( ".new_order" ).find( ".price_total" ).each(function() {
			bill += parseFloat($(this).val());
		});
		if (bill 1500) {
			$( ".delivery" ).text("Бесплатно");
		} else if (bill == 0) {
			$( ".delivery" ).text("0.00");
		} else {
			$( ".delivery" ).text("250.00");
			bill += 250;
		}
		$( ".bill" ).text(bill + ".00");
		$( "input[name=bill]" ).val(bill + ".00");
	});*/
	
});
// JavaScript Document
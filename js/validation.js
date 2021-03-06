$(document).ready(function(){
	var jVal = {
		'mail' : function(button) {
			
			if (!button.length) {
				var ele = $(this);
			} else {
				var ele = button.closest('form').find('input[name=user-email]');
			}
			
			if (!ele.next('.mailCaption').length) {
				ele.after('<span class="caption mailCaption"></span>');
			}
						
			var mailCaption = ele.next('.mailCaption');
			
			var patt = /^.+@.+[.].{2,}$/i;
		
			if(!patt.test(ele.val())) {
				jVal.errors = true;
				mailCaption.html('Введите существующий e-mail').show('normal');
				ele.parent().addClass('error');
			} else {
				mailCaption.hide('normal');
				ele.parent().removeClass('error');
			}
		},
		
		'pass' : function(button) {
			
			if (!button.length) {
				var ele = $(this);
			} else {
				var ele = button.closest('form').find('input[name=user-pass]');
			}
						
			if (!ele.next('.passCaption').length) {
				ele.after('<span class="caption passCaption"></span>');
			}
						
			var passCaption = ele.next('.passCaption');
					
			if(ele.val().length < 5) {
				jVal.errors = true;
				passCaption.html('Минимум 5 символов').show('normal');
				ele.parent().addClass('error');
			} else {
				passCaption.hide('normal');
				ele.parent().removeClass('error');
			}
		},
		
		'name' : function(button) {
			
			if (!button.length) {
				var ele = $(this);
			} else {
				var ele = button.closest('form').find('input[name=user-name]');
			}
			
			if (!ele.next('.nameCaption').length) {
				ele.after('<span class="caption nameCaption"></span>');
			}
						
			var nameCaption = ele.next('.nameCaption');
			
			var patt = /^[А-Яа-я]+$/i;
					
			if(!patt.test(ele.val())) {
				jVal.errors = true;
				nameCaption.html('Введите ваше настоящее имя на русском').show('normal');
				ele.parent().addClass('error');
			} else {
				nameCaption.hide('normal');
				ele.parent().removeClass('error');
			}
		},
		
		'pass_conf' : function(button) {
			
			if (!button.length) {
				var ele = $(this);
			} else {
				var ele = button.closest('form').find('input[name=user-pass-conf]');
			}
						
			if (!ele.next('.confCaption').length) {
				ele.after('<span class="caption confCaption"></span>');
			}
						
			var confCaption = ele.next('.confCaption');
			var conf = ele.closest('form').find('input[name=user-pass]');
					
			if(ele.val() != conf.val() || conf.val() == '' || ele.val().length < 5) {
				jVal.errors = true;
				confCaption.html('Пароли должны совпадать').show('normal');
				ele.parent().addClass('error');
			} else {
				confCaption.hide('normal');
				ele.parent().removeClass('error');
			}
		},
		
		'phone' : function(button) {
			
			if (!button.length) {
				var ele = $(this);
			} else {
				if (button.closest('form').find('input[name=user-phone]').length) {
					var ele = button.closest('form').find('input[name=user-phone]');
				} else if (button.closest('form').find('input[name="user-phone[]"]')) {
					var ele = button.closest('form').find('input[name="user-phone[]"]')
				}
			}
						
			if (!ele.next('.phoneCaption').length) {
				ele.after('<span class="caption phoneCaption"></span>');
			}
						
			//var phoneCaption = ele.next('.phoneCaption');
			
			$.each(ele, function(element) {
				if ($(ele[element]).prev('input').val() != 0) {
					var phoneCaption = $(ele[element]).next('.phoneCaption');
					if($(ele[element]).val().length < 5) {
						jVal.errors = true;
						phoneCaption.html('Формат: +7(999)999-99-99').show('normal');
						$(ele[element]).parent().addClass('error');
					} else {
						phoneCaption.hide('normal');
						$(ele[element]).parent().removeClass('error');
					}
				}
			});
		},
		
		'metro' : function(button) {
			
			if (!button.length) {
				var ele = $(this);
			} else {
				var ele = button.closest('form').find('input[name=user-metro]');
			}
						
			if (!ele.next('.metroCaption').length) {
				ele.after('<span class="caption metroCaption"></span>');
			}
						
			var metroCaption = ele.next('.metroCaption');
			
			var patt = /^[А-Я].*/i;
					
			if(!patt.test(ele.val())) {
				jVal.errors = true;
				metroCaption.html('Выберите метро из списка').show('normal');
				ele.parent().addClass('error');
			} else {
				metroCaption.hide('normal');
				ele.parent().removeClass('error');
			}
		},
		
		'street' : function(button) {
			
			if (!button.length) {
				var ele = $(this);
			} else {
				var ele = button.closest('form').find('input[name=user-street]');
			}
						
			if (!ele.next('.streetCaption').length) {
				ele.after('<span class="caption streetCaption"></span>');
			}
						
			var streetCaption = ele.next('.streetCaption');
			
			var patt = /^.{3,}/i;
					
			if(!patt.test(ele.val())) {
				jVal.errors = true;
				streetCaption.html('Введите название улицы').show('normal');
				ele.parent().addClass('error');
			} else {
				streetCaption.hide('normal');
				ele.parent().removeClass('error');
			}
		},
		
		'house' : function(button) {
			
			if (!button.length) {
				var ele = $(this);
			} else {
				var ele = button.closest('form').find('input[name=user-house]');
			}
						
			if (!ele.next('.houseCaption').length) {
				ele.after('<span class="caption houseCaption"></span>');
			}
						
			var houseCaption = ele.next('.houseCaption');
			
			var patt = /^\d{1,3}[а-яa-z]?$/i;
					
			if(!patt.test(ele.val())) {
				jVal.errors = true;
				houseCaption.html('Введите № дома').show('normal');
				ele.parent().addClass('error');
			} else {
				houseCaption.hide('normal');
				ele.parent().removeClass('error');
			}
		},
		
		'date' : function(button) {
			
			if (!button.length) {
				var ele = $(this);
			} else {
				var ele = button.closest('form').find('input[name=order-date]');
			}
						
			if (!ele.next('.dateCaption').length) {
				ele.after('<span class="caption dateCaption"></span>');
			}
						
			var dateCaption = ele.next('.dateCaption');
			
			var patt = /^\d{2,4}.\d{2}.\d{2,4}$/i;
					
			if(!patt.test(ele.val())) {
				jVal.errors = true;
				dateCaption.html('Формат: дд.мм.гггг').show('normal');
				ele.parent().addClass('error');
			} else {
				dateCaption.hide('normal');
				ele.parent().removeClass('error');
			}
		},
		
		'product' : function(button) {
			
			if (!button.length) {
				var ele = $(this);
			} else {
				var ele = button.closest('form').find('input[name=product-name]');
			}
						
			if (!ele.next('.productCaption').length) {
				ele.after('<span class="caption productCaption"></span>');
			}
						
			var productCaption = ele.next('.productCaption');
					
			if(ele.val().length < 10) {
				jVal.errors = true;
				productCaption.html('Выберите продукт из списка').show('normal');
				ele.parent().addClass('error');
			} else {
				productCaption.hide('normal');
				ele.parent().removeClass('error');
			}
		}

	};
	
	// =================================================================== //
	
	$('.login').keypress(function(e) {
		if ((e.keyCode || e.which) == 13) {
			$('.user-login').trigger('click');
		}
	});
	
	$('#register').keypress(function(e) {
		if ((e.keyCode || e.which) == 13) {
			$('#user-register').trigger('click');
		}
	});
	
	$('#profile-address').keypress(function(e) {
		if ((e.keyCode || e.which) == 13) {
			$('#profile-address .save-address').trigger('click');
		}
	});
	
	$('#forgot').keypress(function(e) {
		if ((e.keyCode || e.which) == 13) {
			$('#forgot a').trigger('click');
		}
	});
	
	$('#admin-add-user').keypress(function(e) {
		if ((e.keyCode || e.which) == 13) {
			$('.admin-add-user').trigger('click');
		}
	});
	
	$('#admin-order-products').keypress(function(e) {
		if ((e.keyCode || e.which) == 13) {
			$('.admin-order-products').trigger('click');
		}
	});
	
	$('.user-login').click(function (e){
		var that = $(this);
		var form = that.closest('.login');
		jVal.errors = false;
		jVal.mail(that);
		jVal.pass(that);
		if(!jVal.errors) {
			var serial = form.serialize();
			$.ajax({
				type: 'POST',
				url: '/user/login.php',
				data: serial,
				cache: false,
				dataType: 'json',
				success: function(data) {
					if (data.id == 1) {
						form.find('input[name=user-email]').parent().addClass('error');
						form.find('.mailCaption').html(data.text).show();
						form.find('input[name=user-pass]').val('');
					} else if (data.id == 2) {
						form.find('input[name=user-pass]').parent().addClass('error');
						form.find('.passCaption').html(data.text).show();
						form.find('input[name=user-pass]').val('');
					} else {
						location.reload();
					}
				}
			});
		}
		e.preventDefault();
	});
	
	$('#user-register').click(function (e){
		var that = $(this);
		var form = that.closest('#register');
		jVal.errors = false;
		jVal.name(that);
		jVal.mail(that);
		jVal.phone(that);
		jVal.pass(that);
		jVal.pass_conf(that);
		if(!jVal.errors) {
			var serial = form.serialize();
			$.ajax({
				type: 'POST',
				url: '/user/register.php',
				data: serial,
				cache: false,
				dataType: 'json',
				success: function(data) {
					if (data.id == 1) {
						form.find('input[name=user-email]').parent().addClass('error');
						form.find('.mailCaption').html(data.text).show();
					} else if (data.id == 2) {
						form.find('input[name=user-phone]').parent().addClass('error');
						form.find('.phoneCaption').html(data.text).show();
					} else {
						location.reload();
					}
				}
			});
		}
		e.preventDefault();
	});
	
	$('.wo-reg a').click(function (e){
		var that = $(this);
		jVal.errors = false;
		jVal.name(that);
		jVal.mail(that);
		jVal.phone(that);
		jVal.metro(that);
		jVal.street(that);
		jVal.house(that);
		jVal.date(that);
		if(!jVal.errors) {
			var order_raw_bill = '&order-raw-bill='+ parseInt($('.main-cart-sub-total .final-sum:first').text(), 10);
			var order_delivery = '&order-delivery='+ (parseInt($('.main-cart-sub-total .final-sum:eq(1)').text(), 10) || '');
			var order_bill = '&order-bill='+ parseInt($('.main-cart-sub-total .total-price .final-sum').text(), 10);
			var serial = $('#order').serialize() + order_raw_bill + order_delivery + order_bill;
			$.ajax({
				type: 'POST',
				url: '/user/add_order.php',
				data: serial,
				cache: false,
				dataType: 'json',
				success: function(data) {
					if (data.id == 1) {
						$('input[name=user-email]').parent().addClass('error');
						$('.mailCaption').html(data.text).show();
					} else if (data.id == 2) {
						$('input[name=user-phone]').parent().addClass('error');
						$('.phoneCaption').html(data.text).show();
					} else {
						window.location.href = that.prop('href');
					}
				}
			});
		}
		e.preventDefault();
	});
	
	// Save address button behaviour
	$('#profile-address .save-address').click(function(e) {
		var that = $(this);
		jVal.errors = false;
		jVal.metro(that);
		jVal.street(that);
		jVal.house(that);
		if(!jVal.errors) {
			var serial = $('#profile-address').serialize();
			$.ajax({
				type: 'POST',
				url: '/user/update_address.php',
				data: serial,
				cache: false,
				dataType: 'json',
				success: function(data) {
					that.closest('form').find('.change-success').slideDown().html('<h2>Изменения сохранены</h2>');
				}
			});
		}
		e.preventDefault();
    });
	
	$('#forgot a').click(function(e) {
		var that = $(this);
		jVal.errors = false;
		if ($('#forgot input[name=user-email]').length) {
			jVal.mail(that);
		} else {
			jVal.pass(that);
			jVal.pass_conf(that);
		}
		if(!jVal.errors) {
			var serial = $('#forgot').serialize();
			$.ajax({
				type: 'POST',
				url: '/user/forgot_password.php',
				data: serial,
				cache: false,
				dataType: 'json',
				success: function(data) {
					if (data.id == 1) {
						$('input[name=user-email]').parent().addClass('error');
						$('.mailCaption').html(data.text).show();
					} else {
						$('#forgot .forgot-success').slideDown();
					}
				}
			});
		}
		e.preventDefault();
    });
	
	// Add order button click
	$('.admin-add-order').click(function(e) {
        var that = $(this);
		jVal.name(that);
		jVal.phone(that);
		jVal.metro(that);
		jVal.street(that);
		jVal.house(that);
		jVal.product(that);
		jVal.date(that);
		if(!jVal.errors) {
			var order_raw_bill = '&order-raw-bill='+ parseInt($('.order-products .raw-bill').text(), 10);
			var order_delivery = '&order-delivery='+ (parseInt($('.order-products .delivery').text(), 10) || '');
			var order_bill = '&order-bill='+ parseInt($('.order-products .bill').text(), 10);
			var serial = $('#admin-add-order').serialize()+order_raw_bill+order_delivery+order_bill;
			$.ajax({
				type: 'POST',
				url: '/admin/script/add_order.php',
				data: serial,
				cache: false,
				dataType: 'json',
				success: function(data) {
					$('.add-success').slideDown();
				}
			});
		}
		e.preventDefault();
    });
	
	// Add change order
	$('.order-products').on('click', '.admin-change-order', function(e){
		var that = $(this);
		var form = $('#admin-change-order');
		jVal.name(that);
		jVal.phone(that);
		jVal.metro(that);
		jVal.street(that);
		jVal.house(that);
		jVal.product(that);
		jVal.date(that);
		if(!jVal.errors) {
			var order_raw_bill = '&order-raw-bill='+ parseInt(form.find('.order-products .raw-bill').text(), 10);
			var order_delivery = '&order-delivery='+ (parseInt(form.find('.order-products .delivery').text(), 10) || '');
			var order_bill = '&order-bill='+ parseInt(form.find('.order-products .bill').text(), 10);
			var serial = form.serialize()+order_raw_bill+order_delivery+order_bill;
			$.ajax({
				type: 'POST',
				url: '/admin/script/change_order.php',
				data: serial,
				cache: false,
				dataType: 'json',
				success: function(data) {
					$('.add-success').slideDown();
				}
			});
		}
		e.preventDefault();
    });
	
	$('.admin-add-user').click(function (e){
		var that = $(this);
		jVal.errors = false;
		jVal.name(that);
		jVal.phone(that);
		jVal.metro(that);
		jVal.street(that);
		jVal.house(that);
		if(!jVal.errors) {
			var serial = $('#admin-add-user').serialize();
			$.ajax({
				type: 'POST',
				url: '/admin/script/add_user.php',
				data: serial,
				cache: false,
				dataType: 'json',
				success: function(data) {
					if (data.id == 1) {
						$('input[name=user-phone]').parent().addClass('error');
						$('.phoneCaption').html(data.text).show();
					} else {
						$('.add-success').slideDown();
					}
				}
			});
		}
		e.preventDefault();
	});
	
	$('.admin-change-user').click(function (e){
		var that = $(this);
		jVal.errors = false;
		jVal.name(that);
		jVal.metro(that);
		jVal.street(that);
		jVal.house(that);
		if(!jVal.errors) {
			var serial = $('#admin-change-user').serialize();
			$.ajax({
				type: 'POST',
				url: '/admin/script/change_user.php',
				data: serial,
				cache: false,
				dataType: 'json',
				success: function(data) {
					if (data.id == 1) {
						$('input[name=user-phone-id]').parent().addClass('error');
						$('.phoneCaption').html(data.text).show();
					} else {
						$('.add-success').slideDown();
					}
				}
			});
		}
		e.preventDefault();
	});
		
	$('input[name=user-email]').change(jVal.mail);
	$('input[name=user-pass]').change(jVal.pass);
	$('input[name=user-pass-old]').change(jVal.pass);
	$('input[name=user-name]').change(jVal.name);
	$('input[name=user-pass-conf]').change(jVal.pass_conf);
	$('input[name=user-phone]').change(jVal.phone);
	$('input[name=user-metro]').change(jVal.metro);
	$('input[name=user-street]').change(jVal.street);
	$('input[name=user-house]').change(jVal.house);
	$('input[name=order-date]').change(jVal.date);
	$('input[name=product-name]').change(jVal.product);
	
	if (($('input[name="user-phone[]"]').length || $('input[name=user-phone]').length) && !$('section.su-popup').is(':visible')) {
		$('input[name="user-phone[]"], input[name=user-phone]').mask('+7(999)999-99-99');
	}
	
});
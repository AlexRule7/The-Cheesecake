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
		}
	};
	
	// ===================================================================//
	
	$('#login').keypress(function(e) {
		if ((e.keyCode || e.which) == 13) {
			$('#user-login').trigger('click');
		}
	});
	
	$('#register').keypress(function(e) {
		if ((e.keyCode || e.which) == 13) {
			$('#user-register').trigger('click');
		}
	});		

	$('#user-login').click(function (e){
		var that = $(this);
		jVal.errors = false;
		jVal.mail(that);
		jVal.pass(that);
		if(!jVal.errors) {
			var serial = $('#login').serialize();
			$.post('/user/login.php',
					serial,
					function(data){
						if (data == 1) {
							$('input[name=user-email]').addClass('error');
							$('.mailCaption').html('Пользователя с таким e-mail не существует').show();
							$('input[name=user-pass]').val('');
						} else if (data == 2) {
							$('input[name=user-pass]').addClass('error');
							$('.passCaption').html('Пароль неверный').show();
						} else {
							location.reload();
						}
			});
		}
		e.preventDefault();
	});
	
	$('#user-register').click(function (e){
		var that = $(this);
		jVal.errors = false;
		jVal.name(that);
		jVal.mail(that);
		jVal.pass(that);
		jVal.pass_conf(that);
		if(!jVal.errors) {
			var serial = $('#register').serialize();
			$.post('/user/register.php',
					serial,
					function(data){
						if (data == 1) {
							$('input[name=user-email]').parent().addClass('error');
							$('.mailCaption').html('Пользователь с таким e-mail уже зарегистрирован').show();
						} else {
							location.reload();
						}
			});
		}
		e.preventDefault();
	});
		
	$('input[name=user-email]').change(jVal.mail);
	$('input[name=user-pass]').change(jVal.pass);
	$('input[name=user-name]').change(jVal.name);
	$('input[name=user-pass-conf]').change(jVal.pass_conf);
	
});
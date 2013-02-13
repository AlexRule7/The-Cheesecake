$(document).ready(function(){
	var jVal = {
		'mail' : function(button) {
			
			$('body').append('<div id="mailInfo" class="info"></div>');
			
			if(typeof(button) != "undefined" && button !== null) {
				var ele = $(button).closest('form').find('input[name=user-email]');
			} else {
				var ele = $(this);
			}
			console.log(ele);
			$(button).closest('form').find('input[name=user-email]')
			
			var mailInfo = $('#mailInfo');
			var pos = ele.offset();

			mailInfo.css({
				top: pos.top-$(window).scrollTop()-3,
				left: pos.left+ele.width()+30
			});
			
			var patt = /^.+@.+[.].{2,}$/i;
		
			if(!patt.test(ele.val())) {
				jVal.errors = true;
				mailInfo.removeClass('correct').addClass('error').html('&larr; введите существующий e-mail, ок?').show();
				ele.removeClass('normal').addClass('wrong');
			} else {
				mailInfo.removeClass('error').addClass('correct').html('&radic;').show();
				ele.removeClass('wrong').addClass('normal');
			}
		},
		
		'pass' : function() {
			
			$('body').append('<div id="passInfo" class="info"></div>');
			
			var passInfo = $('#passInfo');
			var ele = $(this);
			var pos = ele.offset();

			passInfo.css({
				top: pos.top-$(window).scrollTop()-3,
				left: pos.left+ele.width()+30
			});
					
			if(ele.val().length < 5) {
				jVal.errors = true;
				passInfo.removeClass('correct').addClass('error').html('&larr; минимум 5 символов').show();
				ele.removeClass('normal').addClass('wrong');
			} else {
				passInfo.removeClass('error').addClass('correct').html('&radic;').show();
				ele.removeClass('wrong').addClass('normal');
			}
		}
	};
	
	// ===================================================================//
	
	$('#login').keypress(function(e) {
		if ((e.keyCode || e.which) == 13) {
			$('#user-login').trigger('click');
		}
	});	

	$('#user-login').click(function (e){
		jVal.errors = false;
		jVal.mail(this);
		jVal.pass();
		if(!jVal.errors) {
			var serial = $('#login').serialize();
			$.post('/user/login.php',
					serial,
					function(data){
						if (data == 1) {
							$('input[name=user-email]').removeClass('normal').addClass('wrong');
							$('#mailInfo').removeClass('correct').addClass('error').html('&larr; пользователя с таким e-mail не существует').show();
							$('input[name=user-pass]').val('');
							$('#passInfo').hide();
						} else if (data == 2) {
							$('input[name=user-pass]').removeClass('normal').addClass('wrong');
							$('#passInfo').removeClass('correct').addClass('error').html('&larr; пароль неверный').show();
						} else {
							location.reload();
						}
			});
		}
		e.preventDefault();
	});
		
	$('input[name=user-email]').change(jVal.mail);
	$('input[name=user-pass]').change(jVal.pass);
	
	
});
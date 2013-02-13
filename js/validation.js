$(document).ready(function(){
	var jVal = {
		'mail' : function() {
			
			$('body').append('<div id="mailInfo" class="info"></div>');
			
			var mailInfo = $('#mailInfo');
			var ele = $('input[name=user-email]');
			var pos = ele.offset();

			mailInfo.css({
				top: pos.top-3,
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
			var ele = $('input[name=user-pass]');
			var pos = ele.offset();

			passInfo.css({
				top: pos.top-3,
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
	
	$('#user-login').click(function (){
		jVal.errors = false;
		jVal.mail();
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
		return false;
	});
		
	$('input[name=user-email]').change(jVal.mail);
	$('input[name=user-pass]').change(jVal.pass);
});
$(document).ready(function(){
	var jVal = {
		'mail' : function() {
			$('body').append('<div id="mailInfo" class="info"></div>');
			
			var mailInfo = $('#mailInfo');
			var ele = $('input[name=user-email]');
			var pos = ele.offset();

			mailInfo.css({
				top: pos.top-3,
				left: pos.left+ele.width()+15
			});
			
			var patt = /^.+@.+[.].{2,}$/i;
		
			if(!patt.test(ele.val())) {
				jVal.errors = true;
				mailInfo.removeClass('correct').addClass('error').html('&larr; give me a valid email adress, ok?').show();
				ele.removeClass('normal').addClass('wrong');
			} else {
				mailInfo.removeClass('error').addClass('correct').html('&radic;').show();
				ele.removeClass('wrong').addClass('normal');
			}
		}
	};
	
	$('input[name=user-email]').change(jVal.mail);
});
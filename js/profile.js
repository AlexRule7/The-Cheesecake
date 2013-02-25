jQuery(document).ready(function($){
	
	// ========== Profile ========== //
	
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
	// Hide delete button if only 1 phone
	if ($('.profile-phone-holder:visible').length < 2) {
		$('.deleterow').hide();
		$('input.profile-phone').removeClass('profile-phone');
	}
	// Delete phone button
	$('#profile-personal .deleterow').click(function(e) {
		$(this).siblings('.text-input').val('');
        $(this).parent().slideUp('fast', function() {
			if ($('.profile-phone-holder:visible').length < 2) {
				$('.deleterow').hide();
				$('input.profile-phone').removeClass('profile-phone');
			}
		});
    });
	// Update user info
	$('#profile-personal a').click(function(e) {
		var form = $(this).closest('#profile-personal');
        var serial = $('#profile-personal').serialize();
		$.ajax({
			type: 'POST',
			url: '/user/update_profile.php',
			data: serial,
			cache: false,
			dataType: 'json',
			success: function(data) {
				if (data.id == 1) {
					form.find('.profile-phone-holder').parent().addClass('error');
					if (!form.find('input[value=0]').parent().find('.mailCaption').length) {
						form.find('input[value=0]').parent().append('<span class="caption mailCaption">'+ data.text+ '</span>');
					} else {
						form.find('input[value=0]').parent().find('.mailCaption').html(data.text).show();
					}
				} else {
					location.reload();
				}
			}
		});
    });
	
	// ========== Addresses ========== //
	
	// Hide delete button if no addresses yet or if "Add new address" selected
	if (!$('#profile-address select[name=user-address]').length) {
		$('#profile-address .delete-address').hide();
	}
	$('body').on('change', '#profile-address select[name=user-address]', function(e) {
		if ($(this).val() == 0) {
			$('#profile-address .delete-address').hide();
		} else {
			$('#profile-address .delete-address').show();
		}
	});
	// Delete address button behaviour
	$('#profile-address .delete-address').click(function(e) {
		var data = 'id='+ $('#profile-address select[name=user-address]').val();
		$.ajax({
			type: 'POST',
			url: '/user/update_address.php',
			data: data,
			cache: false,
			dataType: 'json',
			success: function(data) {
				location.reload();
			}
		});
    });
	
	// ========== Orders ========== //
	
	// Accordion initialization
	$('#profile-orders').accordion({
		collapsible: true,
		active: false,
		heightStyle: "content"
	});
});
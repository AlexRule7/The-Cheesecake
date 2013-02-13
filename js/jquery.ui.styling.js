jQuery(document).ready(function($){

    // Floatin user panel
    var eTop = $('.panel-fix-position').offset().top;
    $(window).scroll(function() {
        if (eTop - $(window).scrollTop() <= 15) {
            $('.panel-fix-position').css({'position':'fixed', 'top':'15px'});
        } else {
            $('.panel-fix-position').css({'position':'', 'top':''});
        }
    });


    // Set equal about grid borders
    var items = $('.information-part .grid'),
        height = 0;
        newHeight = 0;
    items.each(function(i){
        items.css({'min-height':'', 'height':''});
        var elem = $(this),
        newHeight = elem.outerHeight();
        if (newHeight >= height) {
            height = newHeight; 
        }
    });
    items.css({'min-height':height, 'height':height});


    // Close all popups
    function closePopup() {
        $('.popup-bg, .popup-container').hide();
    };

    // Show sign-in popup
    $('.si-popup-trigger').click(function(event){
        event.preventDefault();
        closePopup();
        $('.popup-bg, .si-popup').show();
		$('div.info').remove();
		$('input').val('');
    });

    // Show sign-up popup
    $('.su-popup-trigger').click(function(event){
        event.preventDefault();
        closePopup();
        $('.popup-bg, .su-popup').show();
		$('div.info').remove();
		$('input').val('');
    });

    // Close popup on close-btn
    $('.close-btn').click(function(event){
        event.preventDefault();
		$('div.info').remove();
        closePopup();
    });
	
	$('.spinner').hide();

	$(document)
		.ajaxStart(function(){
			$('.spinner').fadeIn('fast');
		})
		.ajaxStop(function(){
			$('.spinner').fadeOut('fast');
		})
	;
	
	$('#logout').click(function(e) {
        $.get('user/logout.php', function() {
			location.reload();
		});
		e.preventDefault();
    });
		
});
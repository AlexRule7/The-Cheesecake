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
		$('form .field').removeClass('error');
		$('form .caption').hide();
		$('input').val('');
    });

    // Show sign-up popup
    $('.su-popup-trigger').click(function(event){
        event.preventDefault();
        closePopup();
        $('.popup-bg, .su-popup').show();
		$('form .field').removeClass('error');
		$('form .caption').hide();
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
		
    // Mac OS X scroll bug-fix
    var heightFixer = $('.mini-height-scroll-container'),
        height,
        scrollHeight,
        scrollPoint;
    heightFixer.scrollTop(0);
    heightFixer.unbind('mousewheel');
    heightFixer.bind('mousewheel', function(event, delta) {
        height = heightFixer.height();
        scrollHeight = heightFixer.prop('scrollHeight');
        scrollPoint = scrollHeight - height;
        if(height >= scrollHeight) {
            end();
        } else if (($(this).scrollTop() == scrollPoint && delta < 0) || ($(this).scrollTop() == 0 && delta > 0)) {
            event.preventDefault();
        }
    });

    // Show/hide mini cart function
    function openMiniCart() {
        $('.mini-cart-container').toggleClass('opened');
    };

    // Show/hide mini cart on mini-cart click
    $('.mini-cart').click(function(event) {
        event.preventDefault();
        openMiniCart();
    });

});


/*! Copyright (c) 2011 Brandon Aaron (http://brandonaaron.net)
 * Licensed under the MIT License (LICENSE.txt).
 *
 * Thanks to: http://adomas.org/javascript-mouse-wheel/ for some pointers.
 * Thanks to: Mathias Bank(http://www.mathias-bank.de) for a scope bug fix.
 * Thanks to: Seamus Leahy for adding deltaX and deltaY
 *
 * Version: 3.0.6
 * 
 * Requires: 1.2.2+
 */
(function(a){function d(b){var c=b||window.event,d=[].slice.call(arguments,1),e=0,f=!0,g=0,h=0;return b=a.event.fix(c),b.type="mousewheel",c.wheelDelta&&(e=c.wheelDelta/120),c.detail&&(e=-c.detail/3),h=e,c.axis!==undefined&&c.axis===c.HORIZONTAL_AXIS&&(h=0,g=-1*e),c.wheelDeltaY!==undefined&&(h=c.wheelDeltaY/120),c.wheelDeltaX!==undefined&&(g=-1*c.wheelDeltaX/120),d.unshift(b,e,g,h),(a.event.dispatch||a.event.handle).apply(this,d)}var b=["DOMMouseScroll","mousewheel"];if(a.event.fixHooks)for(var c=b.length;c;)a.event.fixHooks[b[--c]]=a.event.mouseHooks;a.event.special.mousewheel={setup:function(){if(this.addEventListener)for(var a=b.length;a;)this.addEventListener(b[--a],d,!1);else this.onmousewheel=d},teardown:function(){if(this.removeEventListener)for(var a=b.length;a;)this.removeEventListener(b[--a],d,!1);else this.onmousewheel=null}},a.fn.extend({mousewheel:function(a){return a?this.bind("mousewheel",a):this.trigger("mousewheel")},unmousewheel:function(a){return this.unbind("mousewheel",a)}})})(jQuery)

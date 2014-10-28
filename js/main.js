var busy = false;   

jQuery(document).ready(function($){
	$('body.category .quote-post .text img').wrap('<div class="futured-image-holder"></div>');
	$('body.category .quote-post .text .futured-image-holder').each(function(){
		$(this).append('<span class="caption">' + $(this).find('img').attr('alt') + '</span>');
	});
	getCounts('.666');   
	setLargeSocialsCount();
    if (jQuery('.big-socials').length > 0) {
	   setSingleSocials('.big-socials');
    }

	jQuery('.btn-gotofooter').click(function(e){
		window.busy = true;
		var height = jQuery('html, body').height(); 
		jQuery('html, body').animate({"scrollTop": height }, 'slow'); 
		e.preventDefault();
	});

	 $(".various").fancybox({
			maxWidth	: 600,
			maxHeight	: 400
		});
	
	if(defaults.signup_show) 
	{
		jQuery('#modal-signup-show').fancybox({
			maxWidth: 450,
			maxHeight: 300,
			autoSize	: false,
			closeClick	: false,
			fitToView	: false,
		}).trigger('click');
		setTimeout(function(){
			jQuery.fancybox.close();
		}, 20000);
		
	}
	// ==============================================================
	// Newsletter submit click
	// ==============================================================
	jQuery('.mymail-form').submit(function(){
		_gaq.push(['_trackEvent', 'Newsletter', 'Signup', 'Signup new user']);
	});
})

/**
 * Promo click
 */
function addTrackEvent()
{
	_gaq.push(['_trackEvent', 'blog', 'promo-click', 'IM FREE']);
}

function add_height() {
	jQuery( ".images-box .box" ).each(function() {
		var imgHeight = jQuery(this).find('img').height();
		jQuery(this).find('a').height(imgHeight);
	});
}




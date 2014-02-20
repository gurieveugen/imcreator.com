jQuery(document).ready(function($){
	$('body.category .quote-post .text img').wrap('<div class="futured-image-holder"></div>');
	$('body.category .quote-post .text .futured-image-holder').each(function(){
		$(this).append('<span class="caption">' + $(this).find('img').attr('alt') + '</span>');
	});
    
})

function add_height() {
	jQuery( ".images-box .box" ).each(function() {
		var imgHeight = jQuery(this).find('img').height();
		jQuery(this).find('a').height(imgHeight);
	});
}


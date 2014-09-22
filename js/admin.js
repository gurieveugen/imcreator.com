jQuery(document).ready(function($) {
	var current_upload_target = '';
	var current_upload_button = '';
	var old_send = window.send_to_editor;

	$('a.upload_image_button').click(function() {
		current_upload_target = $(this).parent().children('input');
		formfield = current_upload_target.attr('name');
		current_upload_button = $(this);
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		window.send_to_editor = function(html) {
			imgurl = $('img',html).attr('src');
			current_upload_target.val(imgurl);
			current_upload_button.children('img').attr('src',imgurl);
			tb_remove();
			window.send_to_editor = old_send;
		}
		return false;
	});
});


/**
 * Upload media to server
 * @param  object event --- probably click event
 * @param  object obj   --- clicked object
 */
function uploadMedia(event, obj)
{
	var el = jQuery(obj);
	if (window.fraemwork_upload) 
	{
		window.fraemwork_upload.open();
	} 
	else 
	{
		window.fraemwork_upload = wp.media.frames.framework_upload = wp.media({			
			title: el.data('choose'),
			button: {
				text: el.data('update'),
				close: false
			}
		});

		window.fraemwork_upload.on( 'select', function() {			
			var attachment = window.fraemwork_upload.state().get('selection').first();
			window.fraemwork_upload.close();
			el.parent().find('input[type="text"]').val(attachment.attributes.url);			
			if ( attachment.attributes.type == 'image' ) 
			{
				el.parent().find('.screenshot').empty().hide().append('<img src="' + attachment.attributes.url + '"><a class="remove-image" href="#" onclick="removeMedia(event, this)"><i class="fa fa-trash-o fa-2x"></i></a>').slideDown('fast');
			}			
		});
	}

	window.fraemwork_upload.open();

	event.preventDefault();	
}

/**
 * Cean controls
 * @param  object event --- probably click event
 * @param  object obj   --- clicked object
 */
function removeMedia(event, obj)
{
	var el = jQuery(obj);	
	el.parent().parent().parent().find('input').val('');
	el.parent().parent().find('.screenshot').html('');
	
	event.preventDefault();	
}
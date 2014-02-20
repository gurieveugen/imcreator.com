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

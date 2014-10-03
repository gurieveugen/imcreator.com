<?php

class PostOptions{
	//                    __  __              __    
	//    ____ ___  ___  / /_/ /_  ____  ____/ /____
	//   / __ `__ \/ _ \/ __/ __ \/ __ \/ __  / ___/
	//  / / / / / /  __/ /_/ / / / /_/ / /_/ (__  ) 
	// /_/ /_/ /_/\___/\__/_/ /_/\____/\__,_/____/  

	public function __construct()
	{
		// =========================================================
		// HOOKS
		// =========================================================	
		add_action('add_meta_boxes', array($this, 'metaBoxPostOptions'));
		add_action('save_post', array($this, 'savePostOptions'), 0);
		add_action('admin_enqueue_scripts', array(&$this, 'adminStyles'));	
		//wp_enqueue_media();
	}

	public function adminStyles()
	{
		?>
		<style>
			.screenshot {
				float:left;
				margin-left:1px;
				position: relative;
				width:344px;
				margin-top:3px;
			}
			.screenshot img {
				background:#fafafa;
				border-color:#ccc #eee #eee #ccc;
				border-style:solid;
				border-width:1px;
				float:left;
				max-width: 339px;
				padding: 4px;
				margin-bottom:10px;
			}

			.screenshot .remove-image{
				position: absolute;
				top: 10px;
				right: 5px;
				cursor: pointer;
			}

			.screenshot .remove-image:hover i{
				text-shadow: 0 0 10px white;
			}

			.screenshot .remove-image i{
				color: white;
			}

			.screenshot .no_image .file_link {
				margin-left: 20px;
			}
			.screenshot .no_image .remove-button {
				bottom: 0px;
			}

			.control-media-screenshot{ 
				width: 100%;
				overflow: hidden;
			}

			.control-media input[type="text"]{
				margin: 3px 10px 0 0;
			}

			.form-field input[type="checkbox"]{
				float: left;
				width: auto;
			}
		</style>
		<?php
	}

	/**
	 * Add GCEvents meata box
	 */
	public function metaBoxPostOptions($post_type)
	{
		$post_types = array('post');
		if(in_array($post_type, $post_types))
		{
			add_meta_box('metaBoxPostOptions', __('Post Options'), array($this, 'metaBoxPostOptionsRender'), $post_type, 'normal', 'high');	
		}
		
	}

	/**
	 * render Slider Meta box
	 */
	public function metaBoxPostOptionsRender($post)
	{	
		$image_src = (string) get_post_meta($post->ID, 'po_image_src', true);	
		$image_url = (string) get_post_meta($post->ID, 'po_image_url', true);

		wp_nonce_field( 'post_options_box', 'post_options_box_nonce' );
		?>		
		<table>
			<tbody>
				<tr class="form-field">
					<th><label for="po_image_url"><?php _e('Image url'); ?>:</label></th>
					<td><input type="text" name="po_image_url" id="po_image_url"  class="widefat" value="<?php echo $image_url; ?>"></td>
				</tr>
				<tr class="form-field">
					<th scope="row">
						<label for="po_image_src">Image</label>
					</th>
					<td>
						<div class="control-media">
							<input type="text" id="po_image_src" name="po_image_src" class="widefat" value="<?php echo $image_src; ?>">
							<button type="button" class="button button-upload" onclick="uploadMedia(event, this)">Upload</button>
							<?php echo $this->getScreenshot($image_src); ?>
						</div>
						<p class="description">Load you image here.</p>
					</td>
				</tr>
			</tbody>
		</table>		
		<?php
	}

	/**
	 * Get screenshot HTML
	 * @param  string $value --- value
	 * @return string        --- HTML code
	 */
	private function getScreenshot($value = '')
	{
		$screenshot = '';
		if((string)$value != '')
		{
			$screenshot = sprintf('<img src="%s"><a class="remove-image" href="#" onclick="removeMedia(event, this)"><i class="fa fa-trash-o fa-2x"></i></a>', $value);
		}
		return sprintf('<div class="control-media-screenshot"><div class="screenshot">%s</div></div>', $screenshot);
	}   

	/**
	 * Save post
	 * @param  integer $post_id
	 * @return integer
	 */
	public function savePostOptions($post_id)
	{
		// =========================================================
		// Check nonce
		// =========================================================
		if(!isset( $_POST['post_options_box_nonce'])) return $post_id;
		if(!wp_verify_nonce($_POST['post_options_box_nonce'], 'post_options_box')) return $post_id;
		if(defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;

		// =========================================================
		// Check the user's permissions.
		// =========================================================
		if ( 'page' == $_POST['post_type'] ) 
		{			
			if (!current_user_can( 'edit_page', $post_id)) return $post_id;
		} 
		else 
		{
			if(!current_user_can( 'edit_post', $post_id)) return $post_id;
		}

		// =========================================================
		// Save
		// =========================================================		
		if(isset($_POST['po_image_src']))
		{			
			update_post_meta($post_id, 'po_image_src', $_POST['po_image_src']);
		}
		if(isset($_POST['po_image_url']))
		{			
			update_post_meta($post_id, 'po_image_url', $_POST['po_image_url']);
		}

		return $post_id;
	}
}

// =========================================================
// Launch
// =========================================================
$GLOBALS['post_options'] = new PostOptions();
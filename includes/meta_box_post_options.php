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
	}

	/**
	 * Add GCEvents meata box
	 */
	public function metaBoxPostOptions($post_type)
	{
		$post_types = array('post');
		if(in_array($post_type, $post_types))
		{
			add_meta_box('metaBoxPostOptions', __('Post Options'), array($this, 'metaBoxPostOptionsRender'), $post_type, 'side', 'high');	
		}
		
	}

	/**
	 * render Slider Meta box
	 */
	public function metaBoxPostOptionsRender($post)
	{		
		$post_options = get_post_meta($post->ID, 'post_options', true);	
		$facebook     = isset($post_options['facebook']) ? $post_options['facebook'] : '';
		$twitter      = isset($post_options['twitter']) ? $post_options['twitter'] : '';
		$google_plus  = isset($post_options['google_plus']) ? $post_options['google_plus'] : '';
		$linkedin     = isset($post_options['linkedin']) ? $post_options['linkedin'] : '';

		wp_nonce_field( 'post_options_box', 'post_options_box_nonce' );
		?>		
		<p>
			<label for="post_options_external_url"><?php _e('Facebook'); ?>:</label>
			<input type="text" name="post_options[facebook]" id="post_options_facebook" class="w100" style="width: 60%;" value="<?php echo $facebook; ?>">
		</p>
		<p>
			<label for="post_options_external_url"><?php _e('Twitter'); ?>:</label>
			<input type="text" name="post_options[twitter]" id="post_options_twitter" class="w100" style="width: 60%;" value="<?php echo $twitter; ?>">
		</p>
		<p>
			<label for="post_options_external_url"><?php _e('Google Plus'); ?>:</label>
			<input type="text" name="post_options[google_plus]" id="post_options_google_plus" class="w100" style="width: 60%;" value="<?php echo $google_plus; ?>">
		</p>
		<p>
			<label for="post_options_external_url"><?php _e('Linked IN'); ?>:</label>
			<input type="text" name="post_options[linkedin]" id="post_options_linkedin" class="w100" style="width: 60%;" value="<?php echo $linkedin; ?>">
		</p>
		<?php
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
		if(isset($_POST['post_options']))
		{			
			update_post_meta($post_id, 'post_options', $_POST['post_options']);
		}

		return $post_id;
	}
}

// =========================================================
// Launch
// =========================================================
$GLOBALS['post_options'] = new PostOptions();
<?php

class PostTypePromo{
	//                    __  __              __    
	//    ____ ___  ___  / /_/ /_  ____  ____/ /____
	//   / __ `__ \/ _ \/ __/ __ \/ __ \/ __  / ___/
	//  / / / / / /  __/ /_/ / / / /_/ / /_/ (__  ) 
	// /_/ /_/ /_/\___/\__/_/ /_/\____/\__,_/____/  
	public function __construct()
	{
		// =========================================================
		// Hooks and actions
		// =========================================================
		add_action('init', array($this, 'createPostTypePromo'));		
		add_action('add_meta_boxes', array($this, 'metaBoxPromotionsOptions'));
		add_action('save_post', array($this, 'savePromotionsOptions'), 0);	
		add_image_size('promo-img', 300, 250, true);
	}

	/**
	 * Create Promotions post type and his taxonomies
	 */
	public function createPostTypePromo()
	{

		$post_labels = array(
			'name'               => __('Promo'),
			'singular_name'      => __('Promo'),
			'add_new'            => __('Add new'),
			'add_new_item'       => __('Add new promo'),
			'edit_item'          => __('Edit promo'),
			'new_item'           => __('Add new promo'),
			'all_items'          => __('Promo'),
			'view_item'          => __('View Promo'),
			'search_items'       => __('Search promotions'),
			'not_found'          => __('Promotions no found'),
			'not_found_in_trash' => __('Promotions no found in trash'),
			'parent_item_colon'  => '',
			'menu_name'          => __('Promo'));

		$post_args = array(
			'labels'             => $post_labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'promo' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'author', 'thumbnail'));

		register_post_type('promo', $post_args);		
	}

	/**
	 * Add GCEvents meata box
	 */
	public function metaBoxPromotionsOptions($post_type)
	{
		$post_types = array('promo');
		if(in_array($post_type, $post_types))
		{
			add_meta_box('metaBoxPromotionsOptions', __('Promotions Options'), array($this, 'metaBoxPromotionsOptionsRender'), $post_type, 'normal', 'high');	
		}
		
	}

	/**
	 * render Slider Meta box
	 */
	public function metaBoxPromotionsOptionsRender($post)
	{		
		$promotions_options = get_post_meta($post->ID, 'promotions_options', true);	
		$external_url = isset($promotions_options['external_url']) ? $promotions_options['external_url'] : '';
		wp_nonce_field( 'promotions_options_box', 'promotions_options_box_nonce' );
		?>	
		<div class="gcslider">				
			<p>
				<label for="promotions_options_external_url"><?php _e('URL'); ?>:</label>
				<input type="text" name="promotions_options[external_url]" id="promotions_options_external_url" class="w100" style="width: 60%;" value="<?php echo $external_url; ?>">
			</p>	
		</div>		
		<?php
	}

	/**
	 * Save post
	 * @param  integer $post_id
	 * @return integer
	 */
	public function savePromotionsOptions($post_id)
	{
		// =========================================================
		// Check nonce
		// =========================================================
		if(!isset( $_POST['promotions_options_box_nonce'])) return $post_id;
		if(!wp_verify_nonce($_POST['promotions_options_box_nonce'], 'promotions_options_box')) return $post_id;
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
		if(isset($_POST['promotions_options']))
		{			
			update_post_meta($post_id, 'promotions_options', $_POST['promotions_options']);
		}

		return $post_id;
	}

	/**
	 * Get members objects
	 * @param  integer $count 
	 * @param  boolean $rand  
	 * @return array
	 */
	public function getPromotions($args = null)
	{
		$defaults = array(
			'posts_per_page'   => 500,
			'offset'           => 0,
			'order_by'		   => 'rand',
			'order'            => 'DESC',
			'post_type'        => 'promo',
			'post_status'      => 'publish',			
			'suppress_filters' => true );
		if($args) $arr = array_merge($defaults, $args);
		else $arr = $defaults;

		$promotions = get_posts($arr);
		foreach ($promotions as $key => $value) 
		{
			$value->meta = get_post_meta($value->ID, 'promotions_options', true);
			$out[]       = $value;
		}
		return $out; 
	}

	/**
	 * Filter unnecessary items
	 * @param  array   $arr   
	 * @param  integer $count 
	 * @return array         
	 */
	public function filterPromotions($arr, $count = 3)
	{
		$new_arr = array();

		foreach ($arr as $key => $value) 
		{
			if($count-- == 0) return $new_arr;

			if(has_post_thumbnail($value->ID))
			{
				$value->img = get_the_post_thumbnail($value->ID, 'promo-img');
				$new_arr[]  = $value;
			}
		}
		return $new_arr;
	}

	/**
	 * Get HTML Promotions Block
	 * @param  array   $args  
	 * @param  integer $count 
	 * @return array          
	 */
	public function getPromoBlock($args = null, $count = 3, $class = '')
	{
		$promotions = $this->getPromotions($args);
		$promotions = $this->filterPromotions($promotions);

		if($promotions)
		{
			$block = '<div class="promotions-section'.$class.'"><h3>PROMOTIONS</h3><div class="holder">';
			foreach ($promotions as $key => $value) 
			{
				$block.= '<div class="promo"><a href="'.$value->meta['external_url'].'">'.$value->img.'</a></div>';
			}	
			$block.= '</div><!-- holder --></div><!-- promotions-section -->';
		}
		return $block;
	}
}

// =========================================================
// LAUNCH
// =========================================================
$GLOBALS['post_type_promo'] = new PostTypePromo();
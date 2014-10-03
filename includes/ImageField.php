<?php

class ImageField{
	//                                       __  _          
	//     ____  _________  ____  ___  _____/ /_(_)__  _____
	//    / __ \/ ___/ __ \/ __ \/ _ \/ ___/ __/ / _ \/ ___/
	//   / /_/ / /  / /_/ / /_/ /  __/ /  / /_/ /  __(__  ) 
	//  / .___/_/   \____/ .___/\___/_/   \__/_/\___/____/  
	// /_/              /_/                                 
	private $name;

	//                    __  __              __    
	//    ____ ___  ___  / /_/ /_  ____  ____/ /____
	//   / __ `__ \/ _ \/ __/ __ \/ __ \/ __  / ___/
	//  / / / / / /  __/ /_/ / / / /_/ / /_/ (__  ) 
	// /_/ /_/ /_/\___/\__/_/ /_/\____/\__,_/____/  
	public function __construct($taxonomy_name = 'category')
	{
		$this->name = $taxonomy_name;

		add_action('admin_enqueue_scripts', array(&$this, 'adminStyles'));
		add_action($this->name.'_edit_form_fields', array(&$this, 'editFormFields')); 
		add_action($this->name.'_add_form_fields', array(&$this, 'addFormFields'));
		add_action('edited_'.$this->name, array(&$this, 'save'));
		add_action('created_'.$this->name, array(&$this, 'save'));
		add_filter('deleted_term_taxonomy', array(&$this, 'delete'));
		add_action( 'admin_enqueue_scripts', array(&$this, 'my_enqueue_media') );
		wp_enqueue_style('font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css');
			
	}	 

	public function my_enqueue_media() 
	{
		if(function_exists('wp_enqueue_media')) {
            wp_enqueue_media();
        }   
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
    * Edit form fields
    * @param object $term --- term object
    */
	public function editFormFields($term)
	{
		$value = get_option(sprintf('tax_%s_%s', $term->term_id, 'uploaded_image'));
		$image_url = get_option(sprintf('tax_%s_%s', $term->term_id, 'image_url'));

		?>
		<table class="form-table">
			<tbody>
				<tr class="form-field">
					<th scope="row">
						<label for="uploaded_image">Image</label>
					</th>
					<td>
						<div class="control-media">
							<input type="text" id="uploaded_image" name="uploaded_image" value="<?php echo $value; ?>">
							<button type="button" class="button button-upload" onclick="uploadMedia(event, this)">Upload</button>
							<?php echo $this->getScreenshot($value); ?>
						</div>
						<p class="description">Load you image here.</p>
					</td>
				</tr>
				<tr class="form-field">
					<th><label for="image_url"><?php _e('Image url'); ?>:</label></th>
					<td><input type="text" name="image_url" id="image_url"  class="widefat" value="<?php echo $image_url; ?>"></td>
				</tr>
			</tbody>
		</table>
		<?php
	}     

	/**
     * Add form fields
     * @param object $term --- term object
     */        
	public function addFormFields($term)
	{
		?>
		<table class="form-table">
			<tbody>
				<tr class="form-field">
					<th scope="row">
						<label for="uploaded_image">Image</label>
					</th>
					<td>
						<div class="control-media">
							<input type="text" id="uploaded_image" name="uploaded_image" value="">
							<button type="button" class="button button-upload" onclick="uploadMedia(event, this)">Upload</button>
							<?php echo $this->getScreenshot(); ?>
						</div>
						<p class="description">Load you image here.</p>
					</td>
				</tr>
				<tr class="form-field">
					<th><label for="image_url"><?php _e('Image url'); ?>:</label></th>
					<td><input type="text" name="image_url" id="image_url"  class="widefat" value=""></td>
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
	 * Save taxonomy
	 * @param  integer $term_id --- term id
	 */   
	public function save($term_id)
	{
		if(isset($_POST['uploaded_image'])) update_option(sprintf('tax_%s_%s', $term_id, 'uploaded_image'), $_POST['uploaded_image']);
        else delete_option(sprintf('tax_%s_%s', $term_id, 'uploaded_image'));

        if(isset($_POST['image_url'])) update_option(sprintf('tax_%s_%s', $term_id, 'image_url'), $_POST['image_url']);
        else delete_option(sprintf('tax_%s_%s', $term_id, 'image_url'));
	}              

	/**
     * Delete taxonomy
     * @param  integer $term_id --- term id
     */
	public function delete($term_id)
	{
		if($_POST['taxonomy'] == $this->name)
        {
            if(get_option(sprintf('tax_%s_%s', $term_id, 'uploaded_image'))) delete_option(sprintf('tax_%s_%s', $term_id, 'uploaded_image'));                    
            if(get_option(sprintf('tax_%s_%s', $term_id, 'image_url'))) delete_option(sprintf('tax_%s_%s', $term_id, 'image_url'));                    
        }
	}
}

$image_field = new ImageField();
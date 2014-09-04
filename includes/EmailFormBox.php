<?php

class EmailFormBox{
	//                                       __  _          
	//     ____  _________  ____  ___  _____/ /_(_)__  _____
	//    / __ \/ ___/ __ \/ __ \/ _ \/ ___/ __/ / _ \/ ___/
	//   / /_/ / /  / /_/ / /_/ /  __/ /  / /_/ /  __(__  ) 
	//  / .___/_/   \____/ .___/\___/_/   \__/_/\___/____/  
	// /_/              /_/                                 
	private $post_id;

	//                    __  __              __    
	//    ____ ___  ___  / /_/ /_  ____  ____/ /____
	//   / __ `__ \/ _ \/ __/ __ \/ __ \/ __  / ___/
	//  / / / / / /  __/ /_/ / / / /_/ / /_/ (__  ) 
	// /_/ /_/ /_/\___/\__/_/ /_/\____/\__,_/____/  
	public function __construct($post_id)
	{
		$this->post_id = $post_id;		
	}	 

	public function getImageURL()
	{
		$image = $this->getImageFromCategory();
		if($image !== false) return $image;

		$image = $this->getImageFromPromo();
		if($image !== false) return $image;

		return 'http://placehold.it/600x250/0A6ABF/F2E744';
	}                         

	/**
	 * Get image from category field
	 * @return mixed --- if success return image url | false if not
	 */
	public function getImageFromCategory()
	{
		$terms = wp_get_post_terms($this->post_id, array('category'));
		if(is_array($terms))
		{
			foreach ($terms as &$term) 
			{
				$image = get_option(sprintf('IM_category_custom_%s', $term->term_id));				
				if($image !== false AND isset($image[0][2])) return $this->getImageThumb($image[0][2]);
			}
		}
		return false;
	}

	/**
	 * Get imaage from promo post
	 * @return mixed --- if success return image url | false if not
	 */
	public function getImageFromPromo()
	{		
		$promos = get_posts(
			array(
				'post_type'      => 'promo',
				'posts_per_page' => -1
			)
		);
		if(is_array($promos))
		{
			foreach ($promos as $promo) 
			{
				$url = wp_get_attachment_image_src(get_post_thumbnail_id($promo->ID), 'category_thumb');
				if($url !== false) return $url[0];
			}
		}
		return false;
	}

	/**
	 * Get thumbnail image
	 * @param  string  $src  --- image url
	 * @param  integer $w    --- width
	 * @param  integer $h    --- height
	 * @param  integer $q    --- quality
	 * @param  boolean $crop --- crop or no
	 * @return string        --- thumbnail url
	 */
	public static function getImageThumb($src, $w = 600, $h = 250, $q = 95, $crop = true) 
	{   
	    $thumb_url = $src;
	    $ext       = EmailFormBox::getExtension($src);

	    if( !$ext ) return $thumb_url;

	    
	    $cache      = md5($src . "$w-$h-$q-$crop-gc");
	    $uploads    = wp_upload_dir();
	    $cache_dir  = $uploads["basedir"]."/2014/00";
	    $thumb_url  = $uploads["baseurl"]."/2014/00/$cache.$ext";
	    $thumb_dir  = $cache_dir;
	    $thumb_file = $thumb_dir . "/$cache.$ext";
	    
	    if(!dir($cache_dir)) 
	    {
	        mkdir($cache_dir, 0744, true);
	    }

	    if(!is_file($thumb_file)) 
	    {
	        $editor = wp_get_image_editor($src);
	        if( !is_wp_error($editor)) 
	        {
	            $editor->resize($w, $h, $crop);
	            $editor->set_quality($q);
	            $editor->save($thumb_file);
	        } 
	        else 
	        {
	            $thumb_url = $src;
	        }
	    }
	    return $thumb_url;

	}

	/**
	* Returns file extension or false, if it's not supported
	*
	* @param string url or path to image
	* @return string
	*/
	public static function getExtension($src) 
	{	
		$src  = explode('?', $src);
		$src  = $src[0];	
	    $type = wp_check_filetype( $src );

	    return (isset($type["ext"])) ? $type["ext"] : false;
	}                   
}
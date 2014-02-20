<?php
/*
 * @package WordPress
 * @subpackage HivistaSoft_Theme
 */
error_reporting(0);

include('theme-admin.php');
include('inc/nav.php');

global $matrix_cat_str;
$matrix_cat_str = $TO->get_option('check-cat');

$content_width = 600;				// Defines maximum width of images in posts
add_editor_style();					// Allows editor-style.css to configure editor visual style.
add_theme_support('post-thumbnails');
add_image_size( 'post-matrix', 296);
add_image_size( 'blog-thumb', 280);

define('TDU', get_bloginfo('template_url'));

function scripts_method() {
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', TDU .'/js/jquery-1.9.1.min.js');    
	wp_enqueue_script( 'jquery' );
}
add_action('wp_enqueue_scripts', 'scripts_method');

register_sidebar( array(
	'description' => 'The primary widget area',
	'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
) );

register_sidebar( array(
	'name' => 'Secondary Sidebar',
	'description' => 'The secondary widget area',
	'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
) );

register_nav_menus( array(
	'main' => 'Main Navigation Menu',
	'secondary' => 'Secondary navigation Menu',
	'main_child' => 'Main child Navigation Menu'
) );

function get_top_menu(){
  wp_nav_menu(array(
  'container'       => '', 			// tag name '' - for no container.
  'container_id'    => '',    // tag id
  'menu_class'      => 'main-navigation',				// ul class
  'menu_id'			=> 'nav',			// ul id
  'echo'            => true,
  'theme_location'  => 'main'));		// menu location name ('main' or 'secondary' by default)
}

function get_top_menu_child(){
  wp_nav_menu(array(
  'container'       => '', 			// tag name '' - for no container.
  'container_id'    => '',    // tag id
  'menu_class'      => 'blog-links',				// ul class
  'menu_id'			=> 'nav_child',			// ul id
  'echo'            => true,
  'walker'          => new Custom_Walker_Nav_Menu,
  'theme_location'  => 'main_child'));		// menu location name ('main' or 'secondary' by default)
}

function base_theme_filter_title( $title, $separator = '|') {
	if ( is_feed() ) return $title;
	global $paged, $page;

	if ( is_search() ) {
		$title = 'Search results for '. get_search_query();
		if ( $paged >= 2 )
			$title .= " $separator Page " . $paged;
		$title .= " $separator " . get_bloginfo( 'name', 'display' );
		return $title;
	}

	$title .= get_bloginfo( 'name', 'display' );
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $separator " . $site_description;
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $separator Page ". max( $paged, $page );
	return $title;
}

add_filter( 'wp_title', 'base_theme_filter_title', 10, 2 );


function remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'remove_recent_comments_style' );

function show_posted_in() {
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.';
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.';
	} else {
		$posted_in = 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.';
	}
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}

add_theme_support( 'automatic-feed-links' );

function short_content($content,$sz = 500,$more = '...') {
	if (strlen($content)<$sz) return $content;
	$p = strpos($content, " ",$sz);
    if (!$p) return $content;
        $content = strip_tags($content,"<ul><li>");
        if (strlen($content)<$sz) return $content;
        $p = strpos($content, " ",$sz);
        if (!$p) return $content;
	return substr($content, 0, $p).$more;
}


class Category_Custom {

	/*var $image  = '';
	var $quote  = '';
	var $author = '';
	var $sign   = '';
	var $photo  = '';
	var $caption= '';
	var $template= '';*/
	var $option  = '';
	var $term_id = '';
	const OPTION_NAME  = 0;
	const OPTION_TITLE = 1;
	const OPTION_VALUE = 2;
	const OPTION_TYPE  = 3;
	const OPTION_STRING= 0;
	const OPTION_TEXT  = 1;


	function Category_Custom() {
		add_action('edit_category_form_fields',array(&$this,'admin'));
		add_action('edit_category',array(&$this,'update'));
		add_action('template_redirect',array(&$this,'autoinit'));
	}

	function autoinit () {
		global $wp_query;
		if (is_category()) {
			$this->init($wp_query->get_queried_object_id());
		}

	}

	function optionName($option){
		return 'IM_category_'.$this->term_id.'_'.$option[Category_Custom::OPTION_NAME];
	}

	function init($nID) {
		if (is_object($nID)) {
			$nID = $nID->term_id;
		}
		$this->term_id = $nID;
		$this->option = get_option('IM_category_custom_'.$nID);
		if (!$this->option) {
			$this->option = array(
				array('image','Image','',0),
				array('quote','Quote','',1),
				array('author','Author Name','',0),
				array('sign','Author sign','',0),
				array('photo','Author photo','',0),
				array('caption','Photo caption','',0)
			);
		} 
	}

	function update($nID) {
		$this->init($nID);
		foreach ($this->option as $key=>$option){
			if (in_array($option[Category_Custom::OPTION_NAME],array('photo','caption'))) continue;
			$this->option[$key][Category_Custom::OPTION_VALUE] = $_POST[$this->optionName($option)];
		}
		update_option('IM_category_custom_'.$nID,$this->option);
	}

	function admin ($tag) {
		$this->init($tag);
		foreach ($this->option as $option):
			if (in_array($option[Category_Custom::OPTION_NAME],array('photo','caption'))) continue;
			echo '<tr class="form-field"><th valign="top" scope="row">'.$option[Category_Custom::OPTION_TITLE].'</th><td><fieldset>';
			switch ($option[Category_Custom::OPTION_TYPE]) {
				case Category_Custom::OPTION_STRING :
					echo '<input name="'.$this->optionName($option).'"
							value="'.$option[Category_Custom::OPTION_VALUE].'" size="100" />';
						break;
				case Category_Custom::OPTION_TEXT :
					echo '<textarea name="'.$this->optionName($option).'"
							cols="100" rows="5">'.$option[Category_Custom::OPTION_VALUE].'</textarea>';
						break;				
			}
			echo "</fieldset></td></tr>\n";
		endforeach;
	}

	function get_option($sName) {
		foreach ($this->option as $option) {
			if ($sName == $option[Category_Custom::OPTION_NAME]) return $option[Category_Custom::OPTION_VALUE];
		}
		return false;
	}
}
global $CategoryCustom;
$CategoryCustom = new Category_Custom();
function get_category_custom($sName) {
	global $CategoryCustom;
	return $CategoryCustom->get_option($sName);
}

function display_waterfall_of_posts ( $cid = '', $except_pid = '', $page = '', $s = '', $tag = '' ) {
	global $wpdb, $matrix_cat_str;
    $matrix_cat = explode(',', $matrix_cat_str);
	
	$content = '';
	$args = array(
		'post_type' => 'post',
		'post_status' => 'publish',
        'order' => 'DESC',
        'orderby' => 'date',
		'posts_per_page' => 20
	);

	if ( isset($cid) ) {
	   $cats = get_categories('parent='.$cid);
       if ($cats) {
           foreach($cats as $cat) {
            if (in_array($cat->term_id, $matrix_cat)) {
                $c_id .= ','.$cat->term_id;
            }
           }
        $args['category__in'] = explode(",", $cid);
       } else {
        $args['cat'] = $cid;
       }
	   	   
	}    

	if ( strlen($except_pid) ) {
		$pid = array($except_pid);
		$args['post__not_in'] = $pid;
	}

	if ( strlen($page) ) $args['paged'] = $page;    

	if ( strlen($s) ) $args['s'] = $s;
	if ( strlen($tag) ) $args['tag'] = $tag;

	$w_posts = new WP_Query ( $args );
    /*echo "<!--<pre>";
    var_dump($w_posts);
    echo "</pre>-->";*/
	if ( $w_posts->have_posts() ) {		
		while ( $w_posts->have_posts() ) {
			$w_posts->the_post();
			$wp_title = get_the_title();
			$wp_permalink = get_permalink($post->ID);
			$creator = '';
			$creator = get_post_meta(get_the_ID(), 'creator', true);
			$class = 'box';			

			$content .= '<div class="'.$class.'">';
			if ( has_post_thumbnail() ) {				
				$content .= get_the_post_thumbnail($post->ID, 'post-matrix');
			}
			$content .= '<a href="'.$wp_permalink.'" class="image">';
			$content .= '<div class="text">';
			$content .= '<h4>'. $wp_title .'</h4>';
			if ( strlen( $creator ) ) $content .= '<span>by '.$creator.'</span>';
			$content .= '</div>';
			$content .= '</a>';
			$content .= '</div>';
		}
		//wp_reset_postdata();		
	} 
	echo $content;
}

function get_thumb($attach_id, $width, $height, $crop = false) {
	if (is_numeric($attach_id)) {
		$image_src = wp_get_attachment_image_src($attach_id, 'full');
		$file_path = get_attached_file($attach_id);
	} else {
		$imagesize = getimagesize($attach_id);
		$image_src[0] = $attach_id;
		$image_src[1] = $imagesize[0];
		$image_src[2] = $imagesize[1];
		$file_path = $_SERVER["DOCUMENT_ROOT"].str_replace(get_bloginfo('siteurl'), '', $attach_id);
		
	}
	
	$file_info = pathinfo($file_path);
	$extension = '.'. $file_info['extension'];

	// image path without extension
	$no_ext_path = $file_info['dirname'].'/'.$file_info['filename'];

	$cropped_img_path = $no_ext_path.'-'.$width.'x'.$height.$extension;

	// if file size is larger than the target size
	if ($image_src[1] > $width || $image_src[2] > $height) {
		// if resized version already exists
		if (file_exists($cropped_img_path)) {
			return str_replace(basename($image_src[0]), basename($cropped_img_path), $image_src[0]);
		}

		if (!$crop) {
			// calculate size proportionaly
			$proportional_size = wp_constrain_dimensions($image_src[1], $image_src[2], $width, $height);
			$resized_img_path = $no_ext_path.'-'.$proportional_size[0].'x'.$proportional_size[1].$extension;			

			// if file already exists
			if (file_exists($resized_img_path)) {
				return str_replace(basename($image_src[0]), basename($resized_img_path), $image_src[0]);
			}
		}

		// resize image if no such resized file
		$new_img_path = image_resize($file_path, $width, $height, $crop);
		$new_img_size = getimagesize($new_img_path);
		return str_replace(basename($image_src[0]), basename($new_img_path), $image_src[0]);
	}

	// return without resizing
	return $image_src[0];
}

function get_featured_image_id($pid) { 
	return get_post_meta($pid, '_thumbnail_id', true);
}

if ( isset($_POST['ajax_load_img']) && $_POST['ajax_load_img'] == 'load' ) {

	$m_cat_id = $_POST['m_cat_id'];
	$except_pid = $_POST['except_pid'];
	$paged = $_POST['page'];
	$s_val = $_POST['s_val'];
	$m_tag = $_POST['m_tag'];

	display_waterfall_of_posts($m_cat_id, $except_pid, $paged, $s_val, $m_tag);

	exit();
}

function exclude_pages_from_search($query) {
	global $matrix_cat_str;
	/*echo '<pre>';
	var_dump($query);
	echo '</pre>';
	exit;*/
	if ($query->is_search && ($query->query['cat'] == $matrix_cat_str)) {
		$query->set('post_type', 'post');
		//$query->set( 'tag' , $query->query['s'] );
		set_query_var('posts_per_archive_page', 20);
	}
	return $query;
}
add_filter('pre_get_posts','exclude_pages_from_search');

function manage_my_category_columns($columns, $catID)
{    
    if ( !isset($_GET['taxonomy']) || $_GET['taxonomy'] != 'category' )
    return $columns;
    
    if ( $posts = $columns['description'] ){ 
        unset($columns['description']);    
    } 
    return $columns;
}
add_filter('manage_edit-category_columns','manage_my_category_columns');

function wp_get_cat_postcount($id) {
    $cat = get_category($id);
    $count = (int) $cat->count;
    $taxonomy = 'category';
    $args = array(
      'child_of' => $id,
    );
    $tax_terms = get_terms($taxonomy,$args);
    foreach ($tax_terms as $tax_term) {
        $count +=$tax_term->count;
    }
    return $count;
}

/**
 * Search tags and the same
 */
function my_smart_search( $search, &$wp_query ) {
    global $wpdb;
 
    if ( empty( $search ))
        return $search;
 
    $terms = $wp_query->query_vars[ 's' ];
    $exploded = explode( ' ', $terms );
    if( $exploded === FALSE || count( $exploded ) == 0 )
        $exploded = array( 0 => $terms );
         
    $search = '';
    foreach( $exploded as $tag ) {
        $search .= " AND (
            (wp_posts.post_title LIKE '%$tag%')
            OR (wp_posts.post_content LIKE '%$tag%')
            OR EXISTS
            (
                SELECT * FROM wp_comments
                WHERE comment_post_ID = wp_posts.ID
                    AND comment_content LIKE '%$tag%'
            )
            OR EXISTS
            (
                SELECT * FROM wp_terms
                INNER JOIN wp_term_taxonomy
                    ON wp_term_taxonomy.term_id = wp_terms.term_id
                INNER JOIN wp_term_relationships
                    ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
                WHERE taxonomy = 'post_tag'
                    AND object_id = wp_posts.ID
                    AND wp_terms.name LIKE '%$tag%'
            )
        )";
    }
 
    return $search;
}
add_image_size( 'post_thumb', 550, 466, true ); 
add_filter( 'posts_search', 'my_smart_search', 500, 2 );

/**
 * Get all post categories
 * @param  integer $post_id
 * @return array
 */
function getPostCategories($post_id)
{
	$post_categories = wp_get_post_categories( $post_id );
	$cats            = array();
		
	foreach($post_categories as $c)
	{
		$cats[] = get_category($c);
	}
	return $cats;
}

/**
 * Get first post category
 * @param  integer  $post_id 
 * @param  boolean $print   
 * @return mixed
 */
function getFirstCategory($post_id)
{
	$obj  = "";
	$cats = getPostCategories($post_id);
	if($cats)
	{
		$obj = $cats[0];
	}
	return $obj;
}


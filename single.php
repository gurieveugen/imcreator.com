<?php
/**
 *
 * @package WordPress
 * @subpackage HivistaSoft_Theme
 */
get_header();
$title_container = 'h2';
?>
<div id="main">	
<?php if ( have_posts() ) : the_post(); ?>	
<div class="single-bar">
	<a href="<?php echo home_url('/'); ?>" class="left"><img src="<?php echo TDU; ?>/images/logo-im-s.png" alt=""></a>
	<?php get_top_menu_child(); ?>
</div>
<script>
	jQuery(function(){
		var w = jQuery(window).width();
		jQuery('.page-image img').width(w);
		
		jQuery(window).resize(function(){
			var w = jQuery(window).width();
			jQuery('.page-image img').width(w);
		});
	
		$('.post-socials-row').sticky({ topSpacing: 0, className: 'sticky', wrapperClassName: 'p-soc-wrap' });
	});
</script>
<div class="page-image">
	<?php if(has_post_thumbnail()) echo get_the_post_thumbnail( get_the_ID(), 'full'); ?>
</div>
<div class="single-content">
	<article class="article">
		<?php $categories = get_the_category(); ?>
		<?php $cat = getFirstCategory(get_the_ID()); ?>
		<div class="post-socials-row">
			<div class="center-wrap cf">
				<h5 class="data-row"><a href="<?php echo home_url('/'); ?>">IMNOW</a> / <a href="<?php echo get_category_link($cat->cat_ID); ?>"><?php echo $cat->name; ?></a></h5>
				<?php 
				// =========================================================
				// INITIALIZE SOCIAL URLS
				// =========================================================
				$options         = $GLOBALS['gcoptions']->getAllOptions();
				$default_socials = array(
					'facebook'    => $options['default_facebook_page'],
					'twitter'     => $options['default_twitter_username'],
					'google_plus' => $options['default_google_plus'],
					'linkedin'    => $options['default_linkedin']);
				
				echo $GLOBALS['socialshare']->getButtons($default_socials); ?>
			</div>
		</div>
		<h1><?php the_title(); ?></h1>
		<span class="meta"><?php the_time('j.m.y'); ?> By <a href="<?php the_author_url(); ?>" target="_blank" ><?php the_author(); ?></a> <a href="<? comments_link(); ?>"><? comments_number('No comments','1 Comment','% Comments'); ?></a></span>		
		<div class="content">
			<?php the_content(); ?>
			<br>
			<div class="btn-red">IM LIVE</div>
		</div>
	</article>
	<?php 

	echo $GLOBALS['post_type_promo']->getPromoBlock(null, 3, ' promotions-single'); 
	?>	
	<h3 class="more-title">MORE</h3>
	<div class="posts-holder">
		<?php 		
		if($categories)
		{
			foreach ($categories as $key => $value) 
			{
				$all_cats[] = $value->slug;
			}	
			$all_cats_str = implode(",", $all_cats);
		}
		
		query_posts(array('category_name' => $all_cats_str, 'post__not_in' => array(get_the_ID())));
		if(have_posts())
		{
			include("loop.php"); 
		}
		?>	
	</div>
</div>
<? endif; ?>
</div>
<a href="#footer-container" class="btn-gotofooter"><img src="<?php echo TDU; ?>/images/btn-footer.png" alt=""></a>
<? get_footer(); ?>
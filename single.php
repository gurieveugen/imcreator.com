<?php
/**
 *
 * @package WordPress
 * @subpackage HivistaSoft_Theme
 */
include('includes/EmailFormBox.php');
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
				<?php echo $GLOBALS['socialshare']->getSocialsBig(get_permalink(), get_the_title(get_the_ID())); ?>
			</div>
		</div>
		<h1><?php the_title(); ?></h1>
		<span class="meta"><?php the_time('j.m.y'); ?> By <a href="<?php the_author_url(); ?>" target="_blank" ><?php the_author(); ?></a> <a href="<? comments_link(); ?>"><? comments_number('No comments','1 Comment','% Comments'); ?></a></span>		
		<div class="content">
			<?php the_content(); ?>
            <?php /* ?>
			<br>
			<div class="btn-red">IM LIVE</div>
            <?php */ ?>
		</div>
	</article>
	<?php 

	//echo $GLOBALS['post_type_promo']->getPromoBlock(null, 3, ' promotions-single'); 
	?>
	<div class="promotions-section promotions-s-form">
		<div class="holder">
			<div class="promo promo-wide">
				<?php 
				$email_form_box = new EmailFormBox(get_the_ID());
				$image          = $email_form_box->getImageURL();
				?>
				<a href="<?php echo $image[1]; ?>"><img src="<?php echo $image[0]; ?>" alt=""></a>
			</div>
			<div class="promo promo-form">
				<h4>Signup for the newsletter</h4>
				<?php echo do_shortcode('[newsletter_signup_form id=1]'); ?>	
			</div>
		</div>
	</div>
	<div class="comments-section">
		<a href="#" class="btn-see-comments">See / Add Comments</a>
		<?php comments_template( '', true ); ?>
		<script>
		jQuery(function(){
			jQuery('.btn-see-comments').click(function(){
				jQuery('#comments').toggle();
				return false;
			});
		});
		</script>
	</div>
	
	
    <?php // comments_template( '', true ); ?>
	<h3 class="more-title">MORE POSTS</h3>	
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
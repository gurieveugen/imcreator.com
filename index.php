<?php
/**
 * @package WordPress
 * @subpackage HivistaSoft_Theme
 */
?>
<? get_header(); ?>

<?php 
GLOBAL $TO; 
$socialshare = $GLOBALS['socialshare'];
?>
<!-- main -->
<div id="main" class="main-blog">	
	<div class="top-section">
		<div class="logo-date">
			<h1><a href="<?php bloginfo('url'); ?>">im now</a></h1>
			<p>Real-time resources and inspiration from the imcreator team</p>
			<div class="date"><?php echo date('j.n.Y'); ?></div>
		</div>
		<div class="top-post">
			<a href="<?=$TO->get_option('rm_link','hpfeatured');?>"><img src="<?=$TO->get_option('image','hpfeatured');?>" alt=""></a>
			<div class="holder">
				<h3><a href="<?=$TO->get_option('rm_link','hpfeatured');?>"><?=str_ireplace("\n","</h2><h2>",$TO->get_option('title','hpfeatured'));?></a></h3>
				<a href="<?=$TO->get_option('rm_link','hpfeatured');?>"><?=wpautop($TO->get_option('content','hpfeatured'));?></a>
				<a href="<?=$TO->get_option('rm_link','hpfeatured');?>" class="link-more">more</a>
			</div>
		</div>
	</div>
	<div class="blog-bar">
		<?php get_top_menu_child(); ?>
		<!-- <ul class="blog-links">
			<li><a href="#">Resources</a></li>
			<li><a href="#">Marketing/SEO</a></li>
			<li><a href="#">Design Tips</a></li>
			<li><a href="#">Client Spotlight</a></li>
			<li><a href="#">More</a></li>
		</ul> -->
		<?php echo $GLOBALS['socialshare']->getButtons(); ?>
		<!-- <ul class="socials">
			<li><a target="_blank" onclick="click_facebook(this); return false;" href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(get_bloginfo('url')); ?>&t=<?php wp_title('|',true,'right'); ?>&src=sp"><img src="<?php echo TDU; ?>/images/ico-facebook.png" alt=""></a><span>32</span></li>
			<li><a target="_blank" href="#"><img src="<?php echo TDU; ?>/images/ico-twitter.png" alt=""></a><span>263</span></li>
			<li><a target="_blank" href="#"><img src="<?php echo TDU; ?>/images/ico-google.png" alt=""></a><span>123</span></li>
			<li><a target="_blank" href="#"><img src="<?php echo TDU; ?>/images/ico-in.png" alt=""></a><span>1234</span></li>
		</ul> -->
	</div>
	
	<div class="posts-holder">		
		<? include("loop.php"); ?>	
	</div>
	
</div>
<a href="#footer-container" class="btn-gotofooter"><img src="<?php echo TDU; ?>/images/btn-footer.png" alt=""></a>
<? get_footer(); ?>
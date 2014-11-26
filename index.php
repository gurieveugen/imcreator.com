<?php
/**
 * @package WordPress
 * @subpackage HivistaSoft_Theme
 */
?>
<? get_header(); ?>

<?php 
GLOBAL $TO; 
error_reporting(E_ALL);

$banner2 = blog_get_banner(2);
$banner3 = blog_get_banner(3);
// =========================================================
// INITIALIZE SOCIAL URLS
// =========================================================
$options         = $GLOBALS['gcoptions']->getAllOptions();
$default_socials = array(
	'facebook'    => $options['default_facebook_page'],
	'twitter'     => $options['default_twitter_username'],
	'google_plus' => $options['default_google_plus'],
	'linkedin'    => $options['default_linkedin']);
?>
<!-- main -->
<div id="main" class="main-blog">	
	<div class="top-section">
		<div class="logo-date">
			<h1><a href="<?php bloginfo('url'); ?>">im now</a></h1>
			<p>Real-time resources and inspiration from the IM Creator team.</p>
			<div class="date"><?php echo date('j.n.Y'); ?></div>
		</div>
		<?php if (strlen($banner3)) { ?><div class="header-banner"><?php echo $banner3; ?></div><?php } ?>
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
		<?php echo $socialshare->getButtons($default_socials); ?>
		<?php if (strlen($banner2)) { ?><div class="undercats-home-banner"><?php echo $banner2; ?></div><?php } ?>
	</div>
	
	<div class="posts-holder">	
		<?php get_template_part('loop'); ?>
	</div>
	
</div>
<a href="#footer-container" class="btn-gotofooter"><img src="<?php echo TDU; ?>/images/btn-footer.png" alt=""></a>
<? get_footer(); ?>
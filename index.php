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
error_reporting(E_ALL);
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
		<?php echo $socialshare->getButtons(); ?>
	</div>
	
	<div class="posts-holder">		
		<?php get_template_part('loop'); ?>
	</div>
	
</div>
<a href="#footer-container" class="btn-gotofooter"><img src="<?php echo TDU; ?>/images/btn-footer.png" alt=""></a>
<? get_footer(); ?>
<?php
/**
 *
 * @package WordPress
 * @subpackage HivistaSoft_Theme
 * Template Name: Home-page
 */
Global $TO;
get_header();
if (have_posts ()) : the_post(); ?>

	<!-- main -->
	<div id="main">
		<div class="main-holder">
			<!-- top-infobox-holder -->
			<div class="top-infobox-holder">
				<div class="top-infobox-frame">
					<?php
					for($i = 1; $i < 5; $i++ ) {
						$link =	$TO->get_option('rm_link',"hblock$i");
						$title = $TO->get_option('title',"hblock$i");
						$image = $TO->get_option('image',"hblock$i");
						$text = $TO->get_option('text',"hblock$i");
						echo '
							<div class="info-box">
								<h3>'.$title.'</h3>
								<div class="text">
									<p>'.$text.'</p>
								</div>
								<div class="img-holder">
									<a href="'.$link.'"><img src="'.$image.'"  height="70" alt="" /></a>
								</div>
							</div>
						';
					}
					 ?>
				</div>
			</div>
			<script type="text/javascript">
				$('#main .top-infobox-holder .info-box:eq(0)').addClass('first-child');
				$('#main .top-infobox-holder .info-box:eq(1)').addClass('second-child');
				$('#main .top-infobox-holder .info-box:eq(2)').addClass('third-child');
				$('#main .top-infobox-holder .info-box:eq(3)').addClass('fourth-child');
			</script>
			<!-- center-infobox-holder -->
			<div class="center-infobox-holder">
				<div class="slogan-holder">
					<strong><?=$TO->get_option('quote','hpquote');?></strong>
					<div class="author-signature-home">
						<span class="author"><?=$TO->get_option('author','hpquote');?></span>
						<img src="<?=$TO->get_option('sign','hpquote');?>" height="27" alt="" />
					</div>
				</div>
				<a href="<?=$TO->get_option('link','hpquote');?>" class="link-become"><img src="<?=$TO->get_option('image','hpquote');?>" alt="" width="199" height="106" /></a>
			</div>
			<!-- bottom-infobox-holder -->
			<div class="bottom-infobox-holder">
				<div class="img-holder">
					<a href="<?=$TO->get_option('rm_link','hpfeatured');?>"><img src="<?=$TO->get_option('image','hpfeatured');?>" alt=""/></a>
				</div>
				<div class="text-holder">
					<h2><?=str_ireplace("\n","</h2><h2>",$TO->get_option('title','hpfeatured'));?></h2>
					<?=wpautop($TO->get_option('content','hpfeatured'));?>
					<p><span class="btn-holder"><a href="<?=$TO->get_option('rm_link','hpfeatured');?>">more</a></span></p>
				</div>
			</div>
		</div>
	</div>
</div>

<? endif; ?>
<? get_footer(); ?>
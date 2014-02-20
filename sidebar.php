<?php
/**
 * @package WordPress
 * @subpackage HivistaSoft_Theme
 */
?>
<div id="sidebar">
	<? if ( is_singular()) : ?>
		<div class="widget-container">
			<div class="box-author">
				<a href="<?the_author_url();?>" target="_blank"><?=get_avatar( get_the_author_ID(),  70 ); ?></a>
				<div class="info">
					<span>About the author:</span>
					<p><?=short_content(get_the_author_meta( 'description' ),70,'(...)')?></p>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<? if (!dynamic_sidebar()) : ?>

	<? endif; ?>
</div>
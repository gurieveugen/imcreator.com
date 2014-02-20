<?php
/**
 * @package WordPress
 * @subpackage HivistaSoft_Theme
 */
?>
<div id="comments">

	<? if ( post_password_required() ) : ?>
		<p class="nopassword">This post is password protected. Enter the password to view any comments.</p>
</div>
	<? return; endif; ?>

	<? if ( have_comments() && comments_open()) : ?>
		<h3>
			<? comments_number('No Responses to ', 'One Response to ', '% Responses to ') ?><span><? the_title() ?></span>
		</h3>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :  ?>
		<div class="navigation">
			<div class="nav-previous"><? previous_comments_link('<span class="meta-nav">&larr;</span> Older Comments'); ?></div>
			<div class="nav-next"><? next_comments_link('Newer Comments <span class="meta-nav">&rarr;</span>'); ?></div>
		</div>
		<? endif; ?>
		<ol class="commentlist">
			<?	wp_list_comments();	?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<div class="navigation">
			<div class="nav-previous"><? previous_comments_link('<span class="meta-nav">&larr;</span> Older Comments'); ?></div>
			<div class="nav-next"><? next_comments_link('Newer Comments <span class="meta-nav">&rarr;</span>'); ?></div>
		</div>
		<? endif; ?>

	<? endif; ?>

	<? comment_form(); ?>

</div>
<?php
/**
 * @package WordPress
 * @subpackage HivistaSoft_Theme
 */
?>
<?php 
global $title_container, $wp_query;
if($title_container == "")
{
	$title_container = "h2";
}
?>
<!-- 404 post -->
<? if ( ! have_posts() ) : ?>
	<div class="topic-holder">
		<h2>Not Found</h2>
		<div class="topic-content">
			<p>Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.</p>
			<? get_search_form(); ?>
		</div>
	</div>
<? endif; ?>

<!-- posts -->
<?php 
$i = 0;

// $start = microtime(true);

// $posts = get_posts($wp_query->query_vars);
// foreach ($posts as $key => $value) 
// {
// 	$urls[$value->ID] = get_permalink($value->ID);
// }
// $GLOBALS['socialshare']->initializeCounts($urls);
// var_dump($urls);

// $time = microtime(true) - $start;
// printf('Скрипт выполнялся %.4F сек.', $time);

while ( have_posts() ) : the_post(); 
$i++;
if($i == 1)
{
	?>
	<article class="hentry featured-post full-width-post">
		<?php
		if(has_post_thumbnail())
		{
		?>
			<a href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail( get_the_ID(), 'full') ?></a>
		<?php
		}
		?>
		<div class="center-wrap">
			<div class="content">
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<span class="meta"><?php the_time('j.m.y'); ?> By
					<?php if (get_the_author_url()) { ?>
						<a href="<?php the_author_url(); ?>" target="_blank"><?php the_author(); ?></a><?php } else { the_author();
					} ?>
					 <a href="<? comments_link(); ?>"><? comments_number('No comments','1 Comment','% Comments'); ?></a></span>
				<?php
				$cont = short_content(get_the_content(), 250);
				?>
				<p><?php echo $cont; ?></p>
				<a href="<?php echo get_permalink(); ?>" class="link-more">more</a>
			</div>
		</div>
	</article>
	<?php
}
else if ($i == 5)
{
	$i = 0;
	echo $GLOBALS['post_type_promo']->getPromoBlock();
	?>
	<?php
}
else
{
	?>
	<article class="hentry <?php echo getLoopRand(); ?>" data-url="<?php echo get_permalink(); ?>">
		<?php
		if(has_post_thumbnail())
		{
		?>
			<a href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail( get_the_ID(), 'post_thumb') ?></a>
		<?php
		}
		?>
		
		<div class="holder">			
			<<?php echo $title_container; ?>><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></<?php echo $title_container; ?>>
			<span class="meta"><?php the_time('j.m.y'); ?> By 
				<?php if (get_the_author_url()) { ?>
					<a href="<?php the_author_url(); ?>" target="_blank"><?php the_author(); ?></a><?php } else { the_author();
				} ?>
				 <a href="<? comments_link(); ?>"><? comments_number('No comments','1 Comment','% Comments'); ?></a></span>
			<?php echo $GLOBALS['socialshare']->getButtons(get_permalink(), 2, '', get_the_title()); ?>	
			<div class="entry-content">
			<?php			
			$cont = short_content(get_the_content());
			echo '<p><a href="'.get_permalink().'" class="content-link">'.$cont.'</a></p>';
			?>
			</div>
			<a href="<?php the_permalink(); ?>" class="link-more">more</a>
		</div>
		<? comments_template( '', true ); ?>
	</article>	
	<?php
}
?>
<? endwhile; ?>
<script type="text/javascript">
	jQuery(function(){
		var w = jQuery(window).width();
		var offset = jQuery('#main').offset();
		jQuery('.full-width-post').css({'width':w, 'margin-left': -offset.left});
		
		jQuery(window).resize(function(){
			var w = jQuery(window).width();
			jQuery('.page-image img').width(w);
		});
		
		$('#s-sticky').sticky({ topSpacing: 0, className: 'sticky', wrapperClassName: 'main-menu-wrapper' });
	});
</script>
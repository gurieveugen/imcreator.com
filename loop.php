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
if(is_author())
{
	?>
	<div class="biographical-info">
		 <?php the_author_description(); ?> 
	</div>
	<?php
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
$banner1 = blog_get_banner(1);

while ( have_posts() ) : the_post(); 
$i++;
if($i == 1)
{
	$title = get_the_title(get_the_id());
	$count = count(explode(' ', $title));
    $long  = '';
	$long  = ( $count > 10 && $count < 15 ) ? 'long' : '';
    $long  = $count >= 15 ? 'long2' : '';
    $thumb_bg = '';

    if(has_post_thumbnail())
    {
    	$thumb_bg = sprintf(
    		'style="background: url(%s) no-repeat; background-size: cover;"',
    		getThumbnailURL(get_the_ID())
    	);
    }
	?>
	<article class="hentry featured-post full-width-post" <?php echo $thumb_bg; ?>>
		<div class="center-wrap">
			<div class="content">

				<h2 class="<?php echo $long; ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<span class="meta"><?php the_time('j.m.y'); ?> By
					<?php if (get_the_author_url()) { ?>
						<a href="<?php the_author_url(); ?>" target="_blank"><?php the_author(); ?></a><?php } else { the_author();
					} ?>
					 <a href="<? comments_link(); ?>"><? comments_number('No comments','1 Comment','% Comments'); ?></a></span>
				<?php
				$cont = short_content(get_the_content(), 250);
				$cont = get_the_excerpt();
				?>
				<p><?php echo $cont; ?></p>
				<a href="<?php echo get_permalink(); ?>" class="link-more">more</a>
			</div>
		</div>
	</article>
	<?php
}
else if ($i == 4)
{
	?>
	<article class="hentry <?php echo getLoopRand(); ?>" data-url="<?php echo get_permalink(); ?>" data-last="true">
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
			<?php echo $GLOBALS['socialshare']->getSocials(get_permalink(), 'mini', get_the_title(get_the_ID())); ?>	
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
	$i = 0;
	//echo $GLOBALS['post_type_promo']->getPromoBlock();
	if (strlen($banner1)) { ?>
		<div class="posts-banner">
			<?php echo $banner1; ?>
		</div>
	<?php
	}
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
			<?php echo $GLOBALS['socialshare']->getSocials(get_permalink(), 'mini', get_the_title(get_the_ID())); ?>	
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

		jQuery('.full-width-post').each(function(){
			jQuery(this).css({
				width: w, 
				'margin-left': -offset.left, 
				height: jQuery(this).find('.content').height()+200
			});
		});
		
		jQuery(window).resize(function(){
			var w = jQuery(window).width();
			jQuery('.page-image img').width(w);
		});
		
		$('#s-sticky').sticky({ topSpacing: 0, className: 'sticky', wrapperClassName: 'main-menu-wrapper' });
	});
</script>
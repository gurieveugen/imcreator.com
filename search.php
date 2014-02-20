<?php
/**
 *
 * @package WordPress
 * @subpackage HivistaSoft_Theme
 */
?>
<? get_header(); ?>
<!-- main -->
<div id="main">
	<div class="main-holder">
		<?php if ( !isset( $_GET['cat'] ) ) : ?>			
			<!-- content -->
			<div id="content">
				<div class="content-holder">
					<? if (have_posts ()) : ?>
						<h1>Search Results for: <span> <? echo get_search_query() ?></span></h1>					
						<? include('loop.php'); ?>						
					<? else : ?>
					<div class="topic-holder">
						<h1>Nothing Found</h1>
						<div class="topic-content">
							<p>Sorry, but nothing matched your search criteria. Please try again with some different keywords.</p>
							<? get_search_form(); ?>
						</div>
					</div>

					<? endif; ?>
				</div>
			</div>
			<!-- sidebar -->
			<? get_sidebar(); ?>

		<?php else : ?>

			<h1>Search Results for: <span> <? echo get_search_query() ?></span></h1>
			<div class="images-box">
				
				<? if (have_posts ()) : 
					$content = '';
					while ( have_posts() ) : the_post(); 								
						$wp_title = get_the_title();
						$wp_permalink = get_permalink($post->ID);
						$creator = '';
						$creator = get_post_meta(get_the_ID(), 'creator', true);
						$class = 'box';
						if ( $i % 2 ) $class = 'box w2';

						$content .= '<div class="'.$class.'">';
						if ( has_post_thumbnail() ) {
							$content .= get_the_post_thumbnail($post->ID, 'post-matrix');
						}
						$content .= '<a href="'.$wp_permalink.'" class="image">';
						$content .= '<div class="text">';
						$content .= '<h4>'. $wp_title .'</h4>';
						if ( strlen( $creator ) ) $content .= '<span>by '.$creator.'</span>';
						$content .= '</div>';
						$content .= '</a>';
						$content .= '</div>';
					endwhile;
					echo $content;
				endif; ?>
			</div>
		<?php endif; ?>		
	</div>		
</div>		
<? get_footer(); ?>
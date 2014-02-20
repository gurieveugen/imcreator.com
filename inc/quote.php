	<?php $sQoute = false; if ($sQuote = get_post_meta(get_the_ID(),'quote',true)) :?>
	<div class="quote-holder content-column-left">
		<blockquote>
			<div>
				<p><?=str_ireplace("\n","</p><p>",$sQuote);?></p>
			</div>
		</blockquote>
		<div class="author-signature">
			<span class="author"><?=get_post_meta(get_the_ID(),'quote_author',true)?></span>
			<?php if ($sSign = get_post_meta(get_the_ID(),'quote_sign',true)) : ?>
				<img src="<?=$sSign;?>" alt="User signature" />
			<?endif;?>
		</div>
	</div>
	<?endif?>
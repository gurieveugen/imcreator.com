<? if ($sImage = get_category_custom('image')) : ?>
<img src="<?=$sImage?>" width="680" alt=""  class="futured-image"/>
<?endif?>
<div class="quote-post">
	<div class="quote-holder">
		<blockquote>
			<div>
				<p><?=str_ireplace("\n","</p><p>",get_category_custom('quote'));?></p>
			</div>
		</blockquote>
		<span class="author"><?=get_category_custom('author');?></span>
	</div>
	<div class="text">
		<?php
		if (class_exists("RichCategoryEditor")) {
			RichCategoryEditor::display_desc();
		} else {
			echo category_description();
			if ($sPhoto = get_category_custom('photo')) : ?>
			<img src="<?=$sPhoto?>" width="380" alt=""/>
			<span class="caption"><?=get_category_custom('caption');?></span>
			<?endif;?>
		<? } ?>
	</div>
</div>
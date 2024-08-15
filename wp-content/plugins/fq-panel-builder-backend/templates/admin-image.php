<?php
/**
 * Template part for admin image shower
 * 
 */
?>

<figure style="margin:18px 0 10px;" class="panel-builder-admin-image">
	<div style="text-align:center;height:32px;">
		<img style="max-width:12%;transform:rotate(-90deg) translate(-50%, -50%);transform-origin:center top;line-height:0;" src="<?php echo $src_path; ?>" />
	</div>
	<figcaption style="">
		<?php echo $image; ?>
	</figcaption>
</figure>
<hr />
<?php
/**
 * Template part for displaying post excerpt
 * @package FQ_Bones_Theme
 */

?>

<?php if ( has_post_thumbnail() ) : ?>
	<div class="featured-image">
		<?php the_post_thumbnail( 'horiz-m' ); ?>
	</div>
<?php endif; ?>

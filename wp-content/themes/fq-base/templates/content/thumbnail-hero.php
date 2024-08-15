<?php
/**
 * Template part for displaying post excerpt
 * @package FQ_Bones_Theme
 */

?>

<?php
	if ( ! has_post_thumbnail() ) {
		return;
	} else {
		$size = 'hero-xl';
	}
?>

<div class="hero-section featured-image-hero">
	<?php the_post_thumbnail( $size ); ?>
	<div class="hero-overlay"></div>
	<div class="hero-content">
		<h1><?php the_title(); ?></h1>
	</div>
</div>

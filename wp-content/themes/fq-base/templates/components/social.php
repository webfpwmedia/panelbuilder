<?php
/**
 * The template for displaying links to social media.
 * @package FQ_Bones_Theme
 */

	if ( ! class_exists('ACF') || ! have_rows( 'social_channels', 'option' ) ) {
		return;
	}
?>

<ul class="icon-row icon-links social-links">

	<?php while ( have_rows( 'social_channels', 'option'  ) ) : the_row(); ?>

		<li>
			<a href="<?php the_sub_field( 'url' ); ?>" target="_blank" rel="noopener" aria-label="Go to <?php bloginfo( 'name' ); ?> <?php the_sub_field( 'channel' ) ?> page">
				<i class="fab fa-<?php the_sub_field( 'icon' ); ?>"></i>
			</a>
		</li>

	<?php endwhile; ?>

</ul>

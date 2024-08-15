<?php
/**
 * The main loop file
 * @package FQ_Bones_Theme
 */
?>
<?php

	$args = [
		'post_type' => $post_type,
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC',
	];
	$custom_query = new WP_Query( $args );
?>


<?php if ( $custom_query->have_posts() ) : ?>

	<div class="page-articles grid-wrapper">

		<?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>

			<?php get_template_part( 'templates/content/content', 'grid' ); ?>

		<?php endwhile; ?>

	</div><!-- .page-articles -->

<?php endif; ?>

<?php wp_reset_postdata(); ?>

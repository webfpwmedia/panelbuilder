<?php
/**
 * The main loop file
 * @package FQ_Bones_Theme
 */


?>

<?php if ( have_posts() ) : ?>

    <?php get_template_part( 'templates/content/breadcrumbs', fq_get_template_part_type() ); ?>
    <?php do_action( 'fq_above_loop' ); ?>

	<div class="page-articles">

		<?php while ( have_posts() ) : the_post(); ?>

			<div>
				<?php if ( fq_should_show_page_title() ): ?>
					<?php get_template_part( 'templates/content/title', fq_get_template_part_type() ); ?>
				<?php endif; ?>

				<?php get_template_part( 'templates/content/content', fq_get_template_part_type() ); ?>
			</div>

		<?php endwhile; ?>

	</div><!-- .page-articles -->

	<?php if ( ! is_singular() && $wp_query->max_num_pages > 1 ) : ?>

		<?php get_template_part( 'templates/components/pagination' ); ?>

	<?php endif; ?>

<?php endif; ?>

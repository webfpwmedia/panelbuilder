<?php
/**
 * The main template file
 * @package FQ_Bones_Theme
 */
?>

<?php get_header(); ?>
	<div id="content" class="page-body">
		<main id="main" class="page-content" role="main">
			<?php get_template_part( 'templates/loops/loop', fq_get_template_part_type() ); ?>
		</main><!-- #main -->
	</div><!-- #content -->
<?php get_footer(); ?>

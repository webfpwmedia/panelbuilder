<?php
/**
 * Main template part for displaying post content, if not more more specific template part
 * @package FQ_Bones_Theme_Parent
 */
?>

<article class="entry nothing-found">

	<header class="entry-header">
		<h1 class="entry-title"><?php esc_html_e( 'Oops!', 'fq-custom-theme' ); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-body">
		<h3 class="section-head"><?php esc_html_e( 'The page you tried to reach cannot be found.', 'fq-custom-theme' ); ?></h3>

		<div class="body-text">
			<p class="help-message"><?php esc_html_e( 'Check that you have the right URL, or try searching for what you wanted.', 'fq-custom-theme' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .body-text -->

	</div>

</article><!-- .content-entry -->

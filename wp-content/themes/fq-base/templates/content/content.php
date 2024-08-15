<?php
/**
 * Main template part for displaying post content, if not more more specific template part
 * @package FQ_Bones_Theme_Parent
 */

?>

<article class="entry <?php if ( get_field( 'use_top_page_padding' ) ): ?>has-top-padding<?php endif; ?>">
	<?php
		// if ( ! fq_has_hero() ) {
		// 	get_template_part( 'templates/content/title' );
		// } else {
		// 	get_template_part( 'templates/content/thumbnail', 'hero' );
		// }
		if ( is_singular() ) {
			fq_the_breadcrumbs();
			get_template_part( 'templates/content/body' );
		} else {
			get_template_part( 'templates/content/excerpt' );
		}
	?>
</article><!-- .entry -->

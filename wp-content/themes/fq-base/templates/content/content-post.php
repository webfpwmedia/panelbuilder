<?php
/**
 * Main template part for displaying post content, if not more more specific template part
 * @package FQ_Bones_Theme_Parent
 */

?>

<article class="entry">
	<?php

		if ( is_single() ) {

			get_template_part( 'templates/content/thumbnail', 'horiz' );
			get_template_part( 'templates/content/title' );
			get_template_part( 'templates/content/date' );
			get_template_part( 'templates/content/body' );
			get_template_part( 'templates/content/meta', 'post' );

		} else {

			get_template_part( 'templates/content/thumbnail' );
			get_template_part( 'templates/content/excerpt', 'container' );
		}

	?>
</article><!-- .entry -->

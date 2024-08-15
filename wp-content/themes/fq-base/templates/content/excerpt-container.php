<?php
/**
 * Main template part for displaying post content, if not more more specific template part
 * @package FQ_Bones_Theme_Parent
 */

?>

<div class="entry-container">
	<?php

		get_template_part( 'templates/content/title', 'linked' );
		get_template_part( 'templates/content/date' );
		get_template_part( 'templates/content/excerpt' );

	?>
</div><!-- .entry-container -->

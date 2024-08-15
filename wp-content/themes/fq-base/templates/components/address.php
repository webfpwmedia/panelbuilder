<?php
/**
 * The template for displaying links to social media.
 * @package FQ_Bones_Theme
 */

if ( ! class_exists('ACF') || ! get_field( 'contact_address', 'option' ) ) {
	return;
}

?>

<div class="contact-info contact-info-address">
	<p><?php the_field( 'contact_address', 'option' ); ?></p>
</div>

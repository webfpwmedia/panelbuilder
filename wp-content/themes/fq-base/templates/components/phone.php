<?php
/**
 * The template for displaying links to social media.
 * @package FQ_Bones_Theme
 */


if ( ! class_exists('ACF') || ! get_field( 'contact_phone', 'option' ) ) {
	return;
}

?>

<div class="contact-info contact-info-phone">
   <p>Toll free: 
	  <a href="tel:<?php the_field( 'contact_phone', 'option' ); ?>"><?php the_field( 'contact_phone', 'option' ); ?></a>
   </p>
</div>

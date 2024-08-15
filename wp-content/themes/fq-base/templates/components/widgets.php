<?php
/**
 * The template for displaying the footer widgets.
 * @package FQ_Bones_Theme
 */
?>

<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) ) : ?>

    <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
		<?php dynamic_sidebar( 'footer-1' ); ?>
    <?php endif; ?>

    <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
		<?php dynamic_sidebar( 'footer-2' ); ?>
    <?php endif; ?>

<?php endif; ?>

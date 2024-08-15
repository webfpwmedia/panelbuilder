<?php
/**
 * The template for displaying a call-to-action link.
 * @package FQ_Bones_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php

$nav_location = 'call-to-action';
$nav_args = array(
	'theme_location' => $nav_location,
	'depth' => 1,
	'container_id'    => 'cta-nav-wrapper',
	'container_class' => 'menu-wrapper',
	'menu_id'         => 'cta-nav-list',
	'menu_class'      => 'menu-items',
);

?>

<?php if ( has_nav_menu( $nav_location ) ) : ?>
	<?php wp_nav_menu( $nav_args ); ?>
<?php endif; ?>

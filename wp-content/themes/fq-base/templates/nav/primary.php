<?php
/**
 * The template for displaying the main nav.
 * @package FQ_Bones_Theme
 */
?>

<?php

	$primary_nav_args = array(
		'theme_location'  => 'primary',
		'depth'           => 2,  // 1 = no dropdowns, 2 = with dropdowns.
		'container'       => 'nav',
		'container_id'    => 'main-nav-wrapper',
		'container_class' => 'menu-wrapper',
		'menu_id'         => 'header-nav-list',
		'menu_class'      => 'menu-items',
	);

	wp_nav_menu( $primary_nav_args );
?>

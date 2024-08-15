<?php
/**
 * The template for displaying a sitemap-style nav, as in the footer usually.
 * @package FQ_Bones_Theme
 */
?>

<?php

// These will be the individual sections or columns, each with a heading;
// Setup separate locations in the main theme setup array and then set up
// menus attached to those locations in the WP menus admin.

// TODO: The elements in this array need to match nav location elements in the main theme setup array; figure out how to make these share the same variable to make it more DRY.
$sitemap_nav_locations = [
	'footer-1',
	'footer-2',
	'footer-3',
	'footer-4',
	'footer-5',
];

?>

<nav class="sitemap-nav" role="navigation">

	<?php foreach( $sitemap_nav_locations as $sitemap_nav_location ) : ?>

		<?php if ( has_nav_menu( $sitemap_nav_location ) ) : ?>

			<?php

				$sitemap_nav_args = array(
				   'theme_location'  => $sitemap_nav_location,
				   'depth'           => 1,
				   'container'       => 'div',
				   'container_id'    => 'sitemap-nav-wrapper',
				   'container_class' => 'menu-wrapper',
				   'menu_id'         => false,
				   'menu_class'      => 'menu-items',
				);

				$all_locations = get_nav_menu_locations();

				if ( isset( $all_locations[ $sitemap_nav_location ] ) ) {
					$nav_menu_id = $all_locations[ $sitemap_nav_location ];
					$nav_menu = wp_get_nav_menu_object( $nav_menu_id );
					$menu_header = $nav_menu->name;
				}
			?>

			<div class="sitemap-nav-section">

				<h3 class="footer-heading"><?php echo $menu_header; ?></h3>

			    <?php
				    wp_nav_menu( $sitemap_nav_args );
			    ?>

			</div>

		<?php endif; ?>

	<?php endforeach; ?>

</nav>

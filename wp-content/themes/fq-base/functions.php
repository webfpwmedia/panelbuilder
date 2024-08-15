<?php
/**
 * WP Bootstrap Starter functions and definitions
 * @package FQ_Bones_Theme_Parent
 */

use FigoliQuinn\StatesIndustries\PanelSequences\PanelSequenceCPT;

// ====================================================================================================
// # Set args to handle basic theme setup: One-stop shop for stuff that often gets changed
// ====================================================================================================

$setup_args = array(
	'production_domain' => 'statesind.com',
	'google_fonts' => false,
	'typekit_id' => 'nvq5sik',	// kit ID
	'fontawesome_kit' => '380b2a1704', // false,  // kit ID -- e.g., '2391611a7d'
	'content_width' => 1200,
	'excerpt_length' => 35,
	'excerpt_more' => 'Full article',
	// false, true for defaults, or array; Enable Featured Images by default on these post types (default: array( 'post', 'page' ) )
	'thumbnails' => array( 'post', PanelSequenceCPT::SLUG ),
	// set up a custom palette of predefined one-click colors in Gutenberg editor; match slug to sass color variable name for easier styling!
	'color_palette' => array(
		array(
			'name' => 'Black',
			'hex' => '#000000',
			'slug' => 'black',
		),
		array(
			'name' => 'Darkest Gray',
			'hex' => '#3F403C',
			'slug' => 'gray-1',
		),
		array(
			'name' => 'Dark Gray',
			'hex' => '#6D6E67',
			'slug' => 'gray-2',
		),
		array(
			'name' => 'Medium Gray',
			'hex' => '#B9BAB3',
			'slug' => 'gray-3',
		),
		array(
			'name' => 'Light Gray',
			'hex' => '#D9D8CE',
			'slug' => 'gray-4',
		),
		array(
			'name' => 'Super Light Gray',
			'hex' => '#f6f5f0',
			'slug' => 'gray-5',
		),
		array(
			'name' => 'White',
			'hex' => '#FFFFFF',
			'slug' => 'white',
		),
		array(
			'name' => 'States Red',
			'hex' => '#ed1c25',
			'slug' => 'primary',
		),
		array(
			'name' => 'States Beige',
			'hex' => '#fffde9',
			'slug' => 'beige',
		),
	),
	'allow_custom_colors' => false,	// set to false to disable the custom color picker in the Gut editor
	'allow_custom_font_sizes' => false,
	'allow_gradients' => false, // if false, there will be no gradient stuff in the block editor UI; the following two properties will be ignored.
	'allow_custom_gradients' => false,	// false to disable the custom gradient color picker in the Gut editor, and to allow only preset gradients.
	'custom_gradients_presets' => array(	// set our own preset gradients to replace default ones.
		// array(
		// 	'name'     => 'Primary gradient',
		// 	'gradient' => 'linear-gradient(135deg,rgba(0,208,132,1) 0%,rgba(6,147,227,1) 100%)',
		// 	'slug'     => 'primary',
		// ),
		// array(
		// 	'name'     => 'Secondary gradient',
		// 	'gradient' => 'linear-gradient(135deg,rgba(255,105,0,1) 0%,rgb(207,46,46) 100%)',
		// 	'slug'     => 'secondary',
		// ),
	), // array of presets or empty array for none ( see: https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-gradient-presets )
	'google_maps_api_key' => false,		// string; Example: 'AIzaSyB9K4bI2dkIqnU_HkM-5sEVvPKpy78EuXs' (default: false)
	'localize_vars' => array(			// array; Anything we need to pass over to main theme js file (default null)
		'url' => admin_url( 'admin-ajax.php' ),
		// 'gmap_lat' => '44.0440417',
		// 'gmap_lng' => '-123.0952906',
		// 'gmap_marker_title' => 'Name',
		// 'gmap_content' => 'Name Here',
	),
	'tracking' => array(
		'google_ua_code' => 'UA-29000129-1',			// string; (default: false)  UA-125348636-1 ???
		'google_tag_manager_id' => false,	// string; (default: false)  GTM-123456
		'google_aw_code' => false,			// string; (default: false)
		'facebook_pixel_id' => false,		// string; (default: false)
		'track_woo_sales' => false,			// boolean; (default: false)
	),
	'has_options_page' => true,						// boolean Instantiates the options page class
	'menu_locations' => array(
		'primary' => esc_html__( 'Primary header nav', 'fq-custom-theme' ),
		'footer-1' => esc_html__( 'Footer column 1', 'fq-custom-theme' ),
		'footer-2' => esc_html__( 'Footer column 2', 'fq-custom-theme' ),
		'footer-3' => esc_html__( 'Footer column 3', 'fq-custom-theme' ),
		'footer-4' => esc_html__( 'Footer column 4', 'fq-custom-theme' ),
		'footer-5' => esc_html__( 'Footer column 5', 'fq-custom-theme' ),
	),
	'hide_comment_url' => true,						// boolean; Hides the "Website" field on default comments template
	'image_sizes' => array(							// array; Add custom image sizes here
		array( 'hero-xl', 1600, 725, true ),
		array( 'hero-lg', 1200, 319, true ),
		array( 'hero-m', 900, 239, true ),
		array( 'hero-s', 400, 106, true ),
		array( 'square-l', 800, 800, true ),
		array( 'square-m', 400, 400, true ),
		array( 'square-s', 200, 200, true ),
		array( 'horiz-l', 700, 500, true ),
		array( 'horiz-m', 350, 250, true ),
		array( 'horiz-s', 175, 125, true ),
		array( 'admin', 85, 85, true ),
	),
	'widgets' => false,							// array of widget params to add or false for no widgets.
	// 'widgets' => array(
	// 	array(
	// 		'id' => 'sidebar-1',
	// 		'name' => 'Sidebar',
	// 		'description' => 'Put stuff in here',
	// 	),
	// 	array(
	// 		'id' => 'some-1',
	// 		'name' => 'Yo ho ho',
	// 		'description' => 'enter here yall',
	// 	),
	// ),
	'woo' => false,									// boolean; Adds Woocommerce support (default: false)
);

// ========================================================================
// # Include all our classes and instantiate theme setup class
// ========================================================================

require_once( get_template_directory() . '/inc/class-fq-theme-setup.php' );
require_once( get_template_directory() . '/inc/class-fq-images.php' );
require_once( get_template_directory() . '/inc/class-fq-widgets.php' );
require_once( get_template_directory() . '/inc/class-fq-tracking.php' );
require_once( get_template_directory() . '/inc/class-fq-acf-options-page.php' );
require_once( get_template_directory() . '/inc/fq-helper-functions.php' );
require_once( get_template_directory() . '/inc/Blocks/RegisterBlocks.php' );
require_once( get_template_directory() . '/inc/class-fq-breadcrumbs.php' );

$fq_site = new FQ_Theme_Setup( $setup_args );

// ========================================================================
// THAT'S ALL, FOLKS!
// ========================================================================

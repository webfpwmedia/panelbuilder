# Bob’s Figoli Quinn Boilerplate Theme

## How to use

1. Add the theme to your project.

2. Typically, you will probably want to change the name of the theme, which is two things:
	a. theme folder
	b. theme name in the comment at the top of ui/scss/style.scss

3. Activate the theme

4. Configure the args at the top of functions.php to set up lots of stuff you normally configure in a theme:

```php
$setup_args = array(
	'production_domain' => 'xxxxxxxxxxx.com',
	'google_fonts' => 'Noto+Sans:400,400i,700,700i',
	'typekit_id' => false,
	'content_width' => 1200,
	'excerpt_length' => 35,
	'excerpt_more' => '<i class="read-more-link fas fa-arrow-alt-circle-right"></i>',
	// false, true for defaults, or array; Enable Featured Images by default on these post types (default: array( 'post', 'page' ) )
	'thumbnails' => true,
	// set up a custom palette of predefined one-click colors in Gutenberg editor; match slug to sass color variable name for easier styling!
	'color_palette' => array(
		array(
			'name' => 'Black',
			'hex' => '#020202',
			'slug' => 'black',
		),
		array(
			'name' => 'Dark',
			'hex' => '#402B26',
			'slug' => 'dark',
		),
		array(
			'name' => 'Medium',
			'hex' => '#BFBB7A',
			'slug' => 'medium',
		),
		array(
			'name' => 'Light',
			'hex' => '#FFD08A',
			'slug' => 'light',
		),
		array(
			'name' => 'White',
			'hex' => '#ffffff',
			'slug' => 'white',
		),
		array(
			'name' => 'Primary Brand Color',
			'hex' => '#7E8037',
			'slug' => 'primary',
		),
		array(
			'name' => 'Secondary Brand Color',
			'hex' => '#A3DFE6',
			'slug' => 'secondary',
		),
		array(
			'name' => 'Tertiary Brand Color',
			'hex' => '#ED561E',
			'slug' => 'tertiary',
		),
	),
	'custom_colors_allowed' => true,	// set to false to disable the custom color picker in the Gut editor
	'google_maps_api_key' => false,		// string; Example: 'AIzaSyB9K4bI2dkIqnU_HkM-5sEVvPKpy78EuXs' (default: false)
	'localize_vars' => array(			// array; Anything we need to pass over to js (default null)
		'url' => admin_url( 'admin-ajax.php' ),		// if we're going to do any ajax, we'll need this.
		// 'gmap_lat' => '44.0440417',
		// 'gmap_lng' => '-123.0952906',
		// 'gmap_marker_title' => 'Name',
		// 'gmap_content' => 'Name Here',
	),
	'tracking' => array(
		'google_ua_code' => false,					// string; (default: false)  UA-125348636-1 ???
		'google_tag_manager_id' => false,			// string; (default: false)  GTM-123456
		'google_aw_code' => false,					// string; (default: false)
		'facebook_pixel_id' => false,				// string; (default: false)
		'track_woo_sales' => false,					// boolean; (default: false)
	),
	'has_options_page' => true,						// boolean Instantiates the options page class
	'menu_locations' => array(
		'primary' => esc_html__( 'Primary header nav', 'fq-custom-theme' ),
		'footer' => esc_html__( 'Footer site map', 'fq-custom-theme' ),
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
	'woo' => false,									// boolean; Adds Woocommerce support (default: false)
);
```

5. Set up base styling
	 a. reset any Sass variables for colors, type, spacing, etc in ui/scss/_base--config.scss
	 b. setup any other base styling in other "_base-" .scss partials in ui/scss/base folder
	 c. wp block styling can be adjusted in the block sass partials in ui/scss/wp-blocks
	 c. use inc/ folder for classes etc to add php functionality.


## TODO (future improvements)
	1. finish ripping out Bourbon

<?php
/**
 * Define basic theme setup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'FQ_Theme_Setup' ) ) {

	class FQ_Theme_Setup {

		private $defaults = array(
			'production_domain'		=> '',
			'google_fonts'			=> false,
			'typekit_id'			=> false,
			'fontawesome_kit'		=> false,
			'content_width'			=> 1170,
			'formats'				=> false,
			'excerpt_length'		=> false,
			'excerpt_more'			=> false,
			'thumbnails'			=> true,
			'google_maps_api_key'	=> false,
			'localize_vars'			=> array(
				'url'				=> '',
			),
			'color_palette'			=> false,
			'allow_custom_colors'	=> true,
			'allow_custom_font_sizes' => true,
			'allow_gradients'		=> false,
			'allow_custom_gradients' => false,
			'custom_gradients_presets' => false,
			'gmap_vars'				=> array(
				'gmap_lat'				=> '',
				'gmap_lng'				=> '',
				'gmap_marker'			=> '',
				'gmap_content'			=> '',
			),
			'menu_locations'		=> array(
				'primary' 			=> 'Primary',
			),
			'woo'					=> false,
			'hide_comment_url'		=> false,
			'image_sizes'			=> false,
			'widgets'				=> false,
			'tracking'				=> false,
			'has_options_page'		=> false,
		);
		private $this_domain = false;
		private $settings = array();

		/**
		 * Constructor for the class.
		 */
		public function __construct( $args ) {

			$this->set_theme_settings( wp_parse_args( $args, $this->get_defaults() ) );
			$this->set_this_domain();

			add_filter( 'after_setup_theme', array( $this, 'theme_support' ) );
			add_filter( 'after_setup_theme', array( $this, 'theme_menus' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'theme_scripts' ) );
			add_filter( 'comment_form_default_fields', array( $this, 'hide_comment_url_field' ), 25 );
			add_filter( 'excerpt_length', array( $this, 'excerpt_length' ), 999 );
			add_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );
			add_filter( 'script_loader_tag', array( $this, 'add_async_defer_to_script' ), 10, 2 );
			add_filter( 'script_loader_tag', array( $this, 'add_fontawesome_attributes' ), 11, 2 );
			add_action( 'wp_dashboard_setup', array( $this, 'dashboard_environment_notice' ) );

			$this->theme_content_width();

			if ( class_exists( 'acf' ) && class_exists( 'FQ_ACF_Options_Page' ) && $this->get_has_options_page() ) {
				new FQ_ACF_Options_Page();
			}
			if ( class_exists( 'FQ_Images' ) && $this->settings['image_sizes'] ) {
				new FQ_Images( $this->settings['image_sizes'] );
			}
			if ( class_exists( 'FQ_Widgets' ) && $this->settings['widgets'] ) {
				new FQ_Widgets( $this->settings['widgets'] );
			}
			if ( class_exists( 'FQ_Tracking' ) && $this->settings['tracking'] ) {
				new FQ_Tracking( $this->settings['tracking'], $this->is_production_environment() );
			}
			if ( ! $this->is_production_environment() ) {
			//	new FQ_Dev_Mailtrap();
			}

			// Remove emoji b.s.
			remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
			remove_action( 'wp_print_styles', 'print_emoji_styles' );
		}

		// SETTERS
		private function set_theme_settings( $settings ) {
			$this->settings = $settings;
		}

		/**
		 * Sets the value of the domain this site is currently running on (used for checking if we are on production).
		 * @param  n/a
		 * @return array $fields after modification
		 */
		public function set_this_domain() {
			if ( ! isset( $_SERVER['HTTP_HOST'] ) ) {
				$this->this_domain = 'idle';
				return;
			}
			$domain = $_SERVER['HTTP_HOST']; // Grab the current host from the server variable
			$domain = str_replace( 'www.', '', $domain ); // Remove www if it exists
			$this->this_domain = $domain;
		}

		// GETTERS
		public function get_defaults() {
			return $this->defaults;
		}
		public function get_google_fonts() {
			return $this->settings['google_fonts'];
		}
		public function get_typekit() {
			return $this->settings['typekit_id'];
		}
		public function get_fontawesome_kit() {
			return $this->settings['fontawesome_kit'];
		}
		public function get_content_width() {
			return $this->settings['content_width'];
		}
		public function get_formats() {
			return $this->settings['formats'];
		}
		public function get_excerpt_length() {
			return $this->settings['excerpt_length'];
		}
		public function get_excerpt_more() {
			return $this->settings['excerpt_more'];
		}
		public function get_thumbnails() {
			return $this->settings['thumbnails'];
		}
		public function get_block_editor_color_palette() {
			return $this->settings['color_palette'];
		}
		public function get_allow_custom_color_picker() {
			return $this->settings['allow_custom_colors'];
		}
		public function get_allow_gradients() {
			return $this->settings['allow_gradients'];
		}
		public function get_allow_custom_gradients() {
			return $this->settings['allow_custom_gradients'];
		}
		public function get_allow_custom_font_sizes() {
			return $this->settings['allow_custom_font_sizes'];
		}
		public function get_custom_gradients_presets() {
			return $this->settings['custom_gradients_presets'];
		}
		public function get_localize_vars() {
			return $this->settings['localize_vars'];
		}
		public function get_gmap_vars() {
			return $this->settings['gmap_vars'];
		}
		public function get_menu_locations() {
			return $this->settings['menu_locations'];
		}
		public function get_hide_comment_url() {
			return $this->settings['hide_comment_url'];
		}
		public function get_woo() {
			return $this->settings['woo'];
		}
		public function get_this_domain() {
			return $this->this_domain;
		}
		public function get_production_domain() {
			$domain = $this->settings['production_domain'];
			$domain = str_replace( 'www.', '', $domain ); // We're not supposed to have www even if it exists, but just in case, remove it
			return $domain;
		}
		public function get_google_maps_api_key() {
			return $this->settings['google_maps_api_key'];
		}
		public function get_has_options_page() {
			return $this->settings['has_options_page'];
		}

		/**
		 * Queue up all our css and js.
		 *
		 * @param  n/a
		 * @return void
		 */

		public function theme_scripts() {
			$this->enqueue_css();
			$this->enqueue_js();
		}

		/**
		 * Sets up theme defaults and registers support for various WordPress features.
		 *
		 * @param  n/a
		 * @return void
		 */

		public function theme_support() {

			// Make theme available for translation.
			load_theme_textdomain( 'fq-custom-theme', get_template_directory() . '/languages' );

			// Add default posts and comments RSS feed links to head.
			add_theme_support( 'automatic-feed-links' );

			// Let WordPress manage the document title.
			add_theme_support( 'title-tag' );

			// Allow Gutenberg extra alignment options.
			add_theme_support( 'align-wide' );

			// Allow editor styles to be loaded (still not sure about this)
			add_theme_support( 'editor-styles' );

			// Related to options for custom colors and gradients in Gutenberg editor
			if ( ! $this->get_allow_custom_color_picker() ) {
				add_theme_support( 'disable-custom-colors' );
			}
			if ( ! $this->get_allow_gradients() ) {
				add_theme_support( 'disable-custom-gradients' );
				add_theme_support('editor-gradient-presets', array() );
			}
			if ( ! $this->get_allow_custom_gradients() ) {
				add_theme_support( 'disable-custom-gradients' );
			}
			if ( $this->get_custom_gradients_presets() ) {
				add_theme_support( 'editor-gradient-presets', $this->get_custom_gradients_presets() );
			}
			if ( ! $this->get_allow_custom_font_sizes() ) {
				add_theme_support( 'disable-custom-font-sizes' );
			}

			// Add Woocommerce support
			if ( $this->get_woo() ) {
				add_theme_support( 'woocommerce' );
			}

			// Enable support for Post Thumbnails on specific post types.
			//      ( To add post thumbnail support for custom post types, you can add the post slug
			//        to the theme-setup defaults, or alternatively (usually preferably) add support
			// 		  while registering the post type. )
			if ( is_array( $this->get_thumbnails() ) ) {
				add_theme_support( 'post-thumbnails', $this->get_thumbnails() );
			} elseif ( $this->get_thumbnails() ) {
				add_theme_support( 'post-thumbnails' );
			}

			if ( $this->get_formats() ) {
				add_theme_support( 'post-formats', $this->get_formats() );
			}

			// Switch default core markup for search form, comment form, and comments
			add_theme_support( 'html5', array(
				'comment-form',
				'comment-list',
				'caption',
			) );

			// Add support for custom color palettes in Gutenberg -- to limit one-click colors available
			// the add_theme_support( 'editor-color-palette' ) function normally has a second param that is an array of colors (see below),
			// so it can be disabled entirely if the second param is empty.

			if ( $this->get_block_editor_color_palette() ) {

				foreach ( $this->get_block_editor_color_palette() as $color ) {

					if ( empty( $color['slug'] ) ) {
						$color['slug'] = sanitize_file_name( $color['name'] );
					}
					$color_settings = array(
						'name' => esc_html__( $color['name'], 'fq-custom-theme' ),
						'slug' => $color['slug'],
						'color' => $color['hex'],
					);
					$colors[] = $color_settings;
				}

				add_theme_support( 'editor-color-palette', $colors );
			}

			if ( $this->get_typekit() ) {
				add_editor_style( 'https://use.typekit.net/' . $this->get_typekit() . '.css' );
			}

		}

		/**
		 * Sets the WP global variable $content_width, related to max width for images and embeds.
		 *
		 * @param  n/a
		 * @return void
		 */

		public function theme_content_width() {

			global $content_width;

			if ( ! isset( $content_width ) ) {
				$content_width = $this->get_content_width();
			}
		}

		/**
		 * Registers theme menus.
		 *
		 * @param  n/a
		 * @return void
		 */

		public function theme_menus() {

			// Register our nav menus ( the register_nav_menu function automatically enables theme support for menus ).
			if ( $this->get_menu_locations() ) {
				register_nav_menus( $this->get_menu_locations() );
			}
		}

		/**
		 * Enqueue all our css.
		 * @param  n/a
		 * @return n/a
		 */
		public function enqueue_css() {
			if ( $this->get_google_fonts() ) {
				wp_enqueue_style( 'googlefonts', $this->get_google_fonts() );
			}
			if ( $this->get_typekit() ) {
				wp_enqueue_style( 'typekit', 'https://use.typekit.net/' . $this->get_typekit() . '.css', array(), '' );
			}
			wp_enqueue_style( 'theme', get_template_directory_uri() . '/style.css' );
		}

		/**
		 * Enqueue all our necessary js
		 * @param  n/a
		 * @return n/a
		 */
		public function enqueue_js() {

			if ( $this->get_google_maps_api_key() ) {
				$google_maps_api_url = 'https://maps.googleapis.com/maps/api/js?key=' . $this->get_google_maps_api_key() . '&callback=initMap';
				wp_enqueue_script( 'google-maps-api', $google_maps_api_url, array( 'gmap' ), null, true );
				wp_register_script( 'gmap', get_stylesheet_directory_uri() . '/js/google-map.js', array( 'jquery' ), '', true );
				if ( $this->get_localize_vars() ) {
					wp_localize_script( 'gmap', 'fq_map', $this->get_gmap_vars() );
				}
				wp_enqueue_script( 'gmap' );
			}

			wp_register_script( 'theme', get_stylesheet_directory_uri() . '/js/dist/theme.js', array( 'jquery' ), '', true );
			if ( $this->get_localize_vars() ) {
				wp_localize_script( 'theme', 'fq_site', $this->get_localize_vars() );
			}
			wp_enqueue_script( 'theme' );

			if ( $this->get_fontawesome_kit() ) {
				wp_enqueue_script( 'fontawesome', 'https://kit.fontawesome.com/' . $this->get_fontawesome_kit() . '.js', null, null, false );
			}

		}

		public function add_async_defer_to_script( $tag, $handle ) {
			if ( 'google-maps-api' !== $handle ) {
				return $tag;
			}
			return str_replace( ' src', ' async defer src', $tag );
		}

		public function add_fontawesome_attributes( $tag, $handle ) {
		    if ( 'fontawesome' !== $handle ) {
				return $tag;
		    }
			return str_replace( '>', ' crossorigin="anonymous">', $tag );
		}

		/**
		 * Hide the "website/url field on comments".
		 * @param  array $fields the default fields
		 * @return array $fields after modification
		 */
		public function hide_comment_url_field( $fields ) {
			if ( $this->get_hide_comment_url() ) {
			    unset( $fields['url'] );
			}
		    return $fields;
		}

		/**
		 * Checks to see if we are in the production environment or not, that is, are in a local or staging environment.
		 * @param  n/a
		 * @return bool -- true if production site
		 */
		public function is_production_environment() {
			if( $this->get_this_domain() == $this->get_production_domain() ) {
				return true;
			}
			return false;
		}

		/**
		 * Changes the default length of the post excerpt. (modify for different post types if you like)
		 * @param  integer $length The WP default
		 * @return integer $length The filtered value
		 */
		public function excerpt_length( $length ) {
			if ( ! $this->get_excerpt_length() ) {
				return $length;
			}
			return $this->get_excerpt_length();
		}

		/**
		 * Changes the test or html that comes after an excerpt truncates.
		 * @param  n/a
		 * @return bool -- true if production site
		 */
		public function excerpt_more( $more ) {
			global $post;
			if ( ! $this->get_excerpt_more() ) {
				return $more;
			}
			return '<span class="read-more">... <a href="' . get_the_permalink() . '">' . $this->get_excerpt_more() . '</a></span>';
		}

		/**
		 * Displays a message on the admin dashboard that we are in a dev enviroment if that is the case.
		 * @param  n/a
		 */
		public function dashboard_environment_notice() {
			global $wp_meta_boxes;
			wp_add_dashboard_widget( 'custom_help_widget', 'Working in dev environment!!!', array( $this, 'dev_environment_message_content' ) );
		}
		/**
		 * Displays a message on the admin dashboard that we are in a dev enviroment if that is the case.
		 * @param  n/a
		 */
		public function dev_environment_message_content() {
			echo '<p>We are currently in a development environment. This domain is <strong>' . $this->get_this_domain() . '</strong>. The production environment is <strong>' . $this->get_production_domain() . '</strong></p>';
		}


 	}
}

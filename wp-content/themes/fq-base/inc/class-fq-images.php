<?php
/**
 * Sets up stuff in the theme related to images; makes adjustments to make auto-generated classes more "Bootstrap-friendly"
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'FQ_Images' ) ) {

	class FQ_Images {

		private $sizes = false;

		/**
		 * Constructor for the class.
		 */
		public function __construct( $sizes ) {
			$this->set_sizes( $sizes );
			add_action( 'after_setup_theme', array( $this, 'custom_image_sizes' ) );
		}

		public function set_sizes( $sizes ) {
			$this->sizes = $sizes;
		}

		public function get_sizes() {
			return $this->sizes;
		}

		/**
		 * Make WP custom images sizes based on array input.
		 *
		 * @param  n/a
		 * @return n/a
		 */
		public function custom_image_sizes() {
			$sizes = $this->get_sizes();
			if ( $sizes ) {
				foreach ( $sizes as $size ) {
				    add_image_size( $size[0], $size[1], $size[2], $size[3] );
				}
			}
		}
	}
}

<?php

/**
 *
 * Add post type and related functions
 *
 *
 * @package
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'FQPBBE_CPT_Species' ) ) {

	class FQPBBE_CPT_Species extends FQPBBE_CPT {

		protected $slug = FQPBBE_DATA_TYPE;
		protected $dashicon = 'dashicons-tagcloud';
		protected $custom_icon = false;
		protected $icon;
		protected $singular_label = 'Veneers';
		protected $plural_label = 'Veneer';
		protected $no_singles = true;
		protected $adjust_queries = false;
		protected $cpt_args;
		protected $cpt_labels;

		/**
		 * Class constructor.
		 */
		public function __construct() {
			$this->init();
			add_action( 'add_meta_boxes', [ $this, 'image_meta_box' ], 20, 2 );
		}

		protected function set_args() {

			$args = array(
				'label' => $this->get_singular_label(),
				'description' => '',
				'labels' => $this->get_cpt_labels(),
				'hierarchical' => false,
				'public' => true,
				'show_ui' => true,
				'show_in_menu' => true,
				'menu_position' => 21,
				'menu_icon' => $this->get_icon(),
				'show_in_admin_bar' => true,
				'show_in_nav_menus' => true,
				'exclude_from_search' => false,
				'supports' => array( 'title' ),
				'show_in_rest' => false,
				'has_archive' => false,
			);

			$this->cpt_args = $args;
		}

		public function image_meta_box( $post_type, $post ) {

			if ( $post_type == $this->slug ) {
				add_meta_box(
					'veneer_images',
					__( 'Images for this veneer', 'fqpbbe-panel-builder' ),
					[ $this, 'show_images' ],
					$post_type,
					'side',
					'default'
				);
			}
		}

		public function show_images( $post ) {
			$images = scandir( FQPBBE_VENEER_IMAGES_PATH );

			foreach ( $images as $image ) {

				if ( strpos( $image, $post->post_name ) !== false ) {
					$src_path = trailingslashit( FQPBBE_VENEER_IMAGES_SRC ) . $image;

					ob_start();
					include( trailingslashit( FQPBBE_TEMPLATES_PATH ) . 'admin-image.php' );
					$html = ob_get_clean();
					echo $html;
				}
			}

		}
	}

	new FQPBBE_CPT_Species();
}

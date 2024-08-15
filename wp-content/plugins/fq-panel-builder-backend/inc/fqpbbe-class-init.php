<?php

/**
 * Class to initiate the plugin
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'FQPBBE_Init' ) ) {

	class FQPBBE_Init {

		public function __construct() {
			$this->dependencies();
			$this->hooks();
		}

		public function dependencies() {
			require_once FQPBBE_PATH . 'inc/fqpbbe-class-logger.php';
			require_once FQPBBE_PATH . 'inc/fqpbbe-class-cpt.php';
			require_once FQPBBE_PATH . 'inc/fqpbbe-class-cpt-species.php';
			require_once FQPBBE_PATH . 'inc/fqpbbe-class-api-routes.php';
			require_once FQPBBE_PATH . 'inc/fqpbbe-class-fetch-data.php';
            require_once FQPBBE_PATH . 'inc/fqpbbe-class-register-blocks.php';
            require_once FQPBBE_PATH . 'inc/fqpbbe-class-download-csi-spec.php';
			require_once FQPBBE_PATH . 'admin/fqpbbe-class-settings-page.php';
			require_once FQPBBE_PATH . 'admin/fqpbbe-class-uploader-page.php';
			require_once FQPBBE_PATH . 'admin/fqpbbe-class-acf.php';
		}
        
		public function hooks() {
			// WE DON'T NEED ANY STYLES OR JS FOR THIS PLUGIN CURRENTLY

			// add_filter( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
			// add_filter( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}

		public function enqueue_styles() {
			wp_enqueue_style( FQPBBE_PREFIX . 'style', FQPBBE_URL . 'assets/css/style.css' );
		}

		public function enqueue_scripts() {

			wp_register_script( FQPBBE_PREFIX . 'plugin', FQPBBE_URL . 'assets/js/plugin.js', array( 'jquery' ), '', true );
			if ( $this->get_localize_vars() ) {
				wp_localize_script( FQPBBE_PREFIX . 'plugin', FQPBBE_PREFIX . 'site', $this->get_localize_vars() );
			}
			wp_enqueue_script( FQPBBE_PREFIX . 'plugin' );
		}

		public function get_localize_vars() {

			$localize_vars = [
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			];

			return $localize_vars;
		}

	}	// end class
}

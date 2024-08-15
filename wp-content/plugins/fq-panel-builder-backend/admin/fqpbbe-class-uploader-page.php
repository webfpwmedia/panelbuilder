<?php

/**
 * Class to create a settings page for this plugin
 *
 *
 * @package emwest_parts_lookup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'FQPBBE_Uploader_Page' ) ) {

	class FQPBBE_Uploader_Page {

		public $veneer_images_dir = FQPBBE_VENEER_IMAGES_PATH;
		public $title = 'Panel Builder Image Uploader';
		public $menu_title = 'Veneer Image Uploader';
		public $capability = 'manage_options';
		public $page_slug = 'fqpbbe-uploader';
		public $section_settings;

		public function __construct() {
			$this->set_section_settings();
			$this->set_hooks();
		}

		public function set_hooks() {
			add_action( 'admin_menu', [ $this, 'settings_page' ] );
			add_action( 'admin_init', [ $this, 'init_settings' ] );
		}

		public function settings_page() {

			add_submenu_page(
				'tools.php',
				$this->title,
				$this->menu_title,
				$this->capability,
				$this->page_slug,
				[ $this, 'render' ]
			);
		}

		private function set_section_settings() {

			$section_settings = [
				[
					'id' => FQPBBE_PREFIX . 'uploader',
					'title' => 'Upload veneer images for panel builder',
					'callback' => 'render_section_choices',
					'settings' => $this->do_fields(),
				],
			];

			$this->section_settings = $section_settings;
		}

		public function get_section_settings() {
			return $this->section_settings;
		}

		public function do_fields() {
			$fields = [];
			$fields[] = [
				'id' => FQPBBE_PREFIX . 'image_uploader',
				'title' => 'Upload .zip of images',
				'callback' => 'file_html',
				'args' => []
			];
			return $fields;
		}

		public function init_settings() {

			$section_settings = $this->get_section_settings();

			foreach ( $section_settings as $section ) {

				add_settings_section(
					$section['id'],
					$section['title'],
					[ $this, $section['callback'] ],
					$this->page_slug
				);

				foreach ( $section['settings'] as $setting ) {

					$args = $setting['args'] ? $setting['args'] : [];
					$args['name'] = $setting['id'];
					$args['id'] = $setting['id'];

					$setting_options = [
						'type'              => 'string',
						'sanitize_callback' => [ $this, 'handle_file_upload' ],
					];

					register_setting( $this->page_slug, $setting['id'], $setting_options );

					add_settings_field(
						$setting['id'],
						$setting['title'],
						[ $this, $setting['callback'] ],
						$this->page_slug,
						$section['id'],
						$args
					);
				}
			}
		}

		public function render() {
			echo '<div class="wrap">';
			echo '<h2>' . $this->title . '</h2>';
			echo '<form method="post" enctype="multipart/form-data" class="wp-upload-form" action="options.php">';
			settings_fields( $this->page_slug );
			do_settings_sections( $this->page_slug );
			submit_button( 'Upload images' );
			echo '</form>';
			echo '</div>';
		}

		function handle_file_upload( $option ) {

			if ( empty( $_FILES['veneerimageszip']['tmp_name'] ) ) {
				return;   
			}

			$folder_name = str_replace( '.zip', '', $_FILES['veneerimageszip']['name'] );
			$zip_filename = $_FILES['veneerimageszip']['tmp_name'];

			$zip = new ZipArchive();
			$zip_open = $zip->open( $zip_filename );

			if ( $zip_open !== false ) {
				$zip->extractTo( FQPBBE_VENEER_IMAGES_PATH . '/tmp' );
			}

			$zip->close();

			$files = scandir( FQPBBE_VENEER_IMAGES_PATH . '/tmp/' . $folder_name );

			foreach ( $files as $file ) {
				rename( FQPBBE_VENEER_IMAGES_PATH . '/tmp/' . $folder_name . '/' . $file, FQPBBE_VENEER_IMAGES_PATH . '/' . $file );
			}

			$this->deleteDir( FQPBBE_VENEER_IMAGES_PATH . '/tmp/' . $folder_name );
			$this->deleteDir( FQPBBE_VENEER_IMAGES_PATH . '/tmp' );

			return $option;
		}

		public function render_section_choices() {
			echo get_option( FQPBBE_PREFIX . 'image_uploader' );
    		echo '<ol>';
			echo '<li>Crop each flitch image in a vertical orientation to exactly 202 x 1680 pixels</li>';
			echo '<li>Save as a .jpg image</li>';
			echo '<li>Naming the files is essential to how the panel builder works! The filename must be written in the format: <code>species-cut-grade.jpg</code>, all lowercase with hyphens separating the three parts. For instance: <em>oak-plain-aa.jpg</em></li>';
			echo '<li>The "species" part of the name must match the slug of the Veneer item</li>';
			echo '<li>Place all the images you wish to upload into a folder and compress that folder into a .zip file</li>';
			echo '<li>Upload the .zip file here; only one zip file maybe uploaded at a time, but it can include any number of images</li>';
			echo '</ol>';
		}

		public function file_html( $args ) {
			$html = '<input type="file" id="veneerimageszip" name="veneerimageszip" accept=".zip" />';
			echo $html;
		}

		public function deleteDir($dirPath) {
			if (! is_dir($dirPath)) {
				throw new InvalidArgumentException("$dirPath must be a directory");
			}
			if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
				$dirPath .= '/';
			}
			$files = glob($dirPath . '*', GLOB_MARK);
			foreach ($files as $file) {
				if (is_dir($file)) {
					self::deleteDir($file);
				} else {
					unlink($file);
				}
			}
			rmdir($dirPath);
		}


	}	// end class

	new FQPBBE_Uploader_Page();
}

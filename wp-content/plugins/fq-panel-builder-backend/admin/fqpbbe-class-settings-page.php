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

if ( ! class_exists( 'FQPBBE_Settings_Page' ) ) {

	class FQPBBE_Settings_Page {

		public $characteristics = FQPBBE_DATA_CHARACTERISTICS;
		public $title = 'Panel Builder Settings';
		public $menu_title = 'Panel Builder';
		public $capability = 'manage_options';
		public $page_slug = 'fqpbbe-settings';
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
					'id' => FQPBBE_PREFIX . 'parameter_setup',
					'title' => 'Set options that will be available for the various panel characteristics',
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
			foreach ( $this->characteristics as $characteristic ) {
				$fields[] = [
					'id' => FQPBBE_PREFIX . $characteristic['key'],
					'title' => 'Choices for ' . $characteristic['title'],
					'callback' => 'textarea_html',
					'args' => []
				];
			}
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

					register_setting( $this->page_slug, $setting['id'] );

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
			echo '<form action="options.php" method="post">';
			settings_fields( $this->page_slug );
			do_settings_sections( $this->page_slug );
			submit_button();
			echo '</form>';
			echo '</div>';
		}

		public function render_section_choices() {
    		echo '<p>Put each choice on its own line, in the style: <strong><em>quarter : Quarter sawn</em></strong></p>';
		}

		public function textarea_html( $args ) {
			$value = get_option( $args['name'] ) ? get_option( $args['name'] ) : '';
			$html = '<textarea style="width:450px;" rows="6" id="'  . $args['id'] . '" name="'  . $args['name'] . '">' . $value . '</textarea>';
			echo $html;
		}

		// public function text_input_html( $args ) {
		// 	$value = get_option( $args['name'] ) ? get_option( $args['name'] ) : '';
		// 	$html = '<input type="text" id="'  . $args['id'] . '" name="'  . $args['name'] . '" value="' . $value . '">';
		// 	echo $html;
		// }

		// public function checkbox_html( $args ) {
		// 	$value = get_option( $args['name'] ) ? get_option( $args['name'] ) : $args['origin'];
		// 	$html = '<input type="checkbox" id="'  . $args['id'] . '" name="'  . $args['name'] . '" value="1" ' . checked( 1, $value, false ) . '/>';
		// 	echo $html;
		// }

	}	// end class

	new FQPBBE_Settings_Page();
}

<?php
/**
 *
 * @package xtracycle
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'FQPBBE_Fields' ) ) {

	class FQPBBE_Fields {

		public $characteristics = FQPBBE_DATA_CHARACTERISTICS;

		public function __construct() {
			add_action( 'acf/init', [ $this, 'fields' ] );
			add_filter( 'acf/load_field', [ $this, 'set_choices' ] );
		}

		public function set_choices( $field ) {

			$settings = get_option( FQPBBE_PREFIX . $field['name'] );
			$choices = preg_split("/\r\n|[\r\n]/", $settings );

			$is_characteristic = false;

			foreach ( $this->characteristics as $characteristic ) {
				if ( $characteristic['key'] == $field['name'] ) {
					$is_characteristic = true;
				}
			}

			if ( ! $is_characteristic ) {
				return $field;
			}

			foreach ( $choices as $choice ) {
				$choice_parts = explode( ':', $choice );
				$formatted_choices[ trim( $choice_parts[0] ) ] = trim( $choice_parts[1] );
				$formatted_defaults[] = trim( $choice_parts[0] );
			}

			$field['choices'] = $formatted_choices;
			$field['default_value'] = $formatted_defaults;
			return $field;
		}

		public function fields() {
			acf_add_local_field_group( $this->get_fields() );
		}

		public function format_fields() {

			$fields = [];
			$fields[] = $this->unavailable_field();

			foreach( $this->characteristics as $characteristic ) {
				$fields[] = [
					'key' => $characteristic['acf_key'],
					'label' => $characteristic['plural'] . ' available for this veneer',
					'name' => $characteristic['key'],
					'type' => 'checkbox',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'allow_custom' => 0,
					'layout' => 'horizontal',
					'toggle' => 0,
					'return_format' => 'value',
					'save_custom' => 0,
				];
			}
			return $fields;
		}

		public function unavailable_field() {
			$field = [
				'key' => 'field_633193876ff0d',
				'label' => 'Panel Builder availability',
				'name' => 'currently_unavailable',
				'type' => 'true_false',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'message' => '',
				'default_value' => 0,
				'ui' => 1,
				'ui_on_text' => 'Unavailable',
				'ui_off_text' => 'Available',
			];
			return $field;
		}

		public function get_fields() {

			return array(
				'key' => 'group_6330d96f5ef53',
				'title' => 'Veneer options',
				'fields' => $this->format_fields(),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => FQPBBE_DATA_TYPE,
						),
					),
				),
				'menu_order' => 0,
				'position' => 'acf_after_title',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => '',
				'show_in_rest' => 0,
			);
		}

	} // class end
}

new FQPBBE_Fields();

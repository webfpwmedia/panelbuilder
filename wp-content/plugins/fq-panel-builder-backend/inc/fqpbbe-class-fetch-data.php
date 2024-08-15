<?php
/**
 *
 * @package xtracycle
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'FQPBBE_Fetch_Data' ) ) {

    class FQPBBE_Fetch_Data {

        private $data_type = FQPBBE_DATA_TYPE;
        private $characteristics = FQPBBE_DATA_CHARACTERISTICS;
        private $data;

        public function __construct() {
            $this->set_data();
        }

        private function set_data() {

            $settings = $this->format_characteristics();
            $settings[$this->data_type] = $this->format( $this->query( $this->data_type ) );

            $data = [
                'settings' => $settings,
            ];

            $this->data = $data;
        }

        public function get_data() {
            return $this->data;
        }
        
        private function query( $type ) {

            $args = [
                'posts_per_page' => -1,
                'post_type' => $type,
            ];

            $query = new WP_Query( $args );
            return $query->get_posts();
        }

        private function format( $posts ) {

            $formatted = [];

            if ( ! $posts || empty( $posts ) ) {
                return $formatted;
            }

            foreach ( $posts as $post ) {

                $item = [
                    'title' => $post->post_title,
                    'key' => $post->post_name,
                ];

                foreach ( $this->characteristics as $characteristic ) {
                    $veneer_choices = get_field( $characteristic['key'], $post->ID );
                    $valid_choices = $this->validate_choices( $veneer_choices, $characteristic['key'] );
                    $item[$characteristic['availability_key']] = $valid_choices;
                }

                $item['currently_unavailable'] = get_field( 'currently_unavailable', $post->ID ) ? true : false;

                $formatted[] = $item;
            }

            return $formatted;
        }

        private function validate_choices( $choices_in_meta, $key ) {

            $choice_settings = get_option( FQPBBE_PREFIX . $key );
            $settings_choices = preg_split("/\r\n|[\r\n]/", $choice_settings );
            $valid_choices = [];
            $validated_choices = [];


            foreach ( $settings_choices as $settings_choice ) {
                $choice_parts = explode( ':', $settings_choice );
                $valid_choices[] = trim( $choice_parts[0] );
            }

            foreach ( $choices_in_meta as $choice ) {
                if ( in_array( $choice, $valid_choices ) ) {
                    $validated_choices[] = $choice;
                }
            }

            return $validated_choices;
        }

        private function format_characteristics() {

            $settings = [];
            foreach ( $this->characteristics as $characteristic ) {
                $choice_settings = get_option( FQPBBE_PREFIX . $characteristic['key'] );
                $choices = preg_split("/\r\n|[\r\n]/", $choice_settings );

                $formatted_choices = [];
                foreach ( $choices as $choice ) {
                    $choice_parts = explode( ':', $choice );
                    $formatted_choices[] = [
                        'key' => trim( $choice_parts[0] ),
                        'title' => trim( $choice_parts[1] ),
                    ];
                }

                $settings[$characteristic['key']] = $formatted_choices;
            }
            return $settings;
        }

    } // class end
}

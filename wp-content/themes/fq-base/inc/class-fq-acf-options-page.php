<?php
/**
 * ACF Options page
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'FQ_ACF' ) ) {

	class FQ_ACF_Options_Page {

		/**
		 * Constructor for the class.
		 */
		public function __construct() {

			$this->add_options_pages();
		}

		/**
		 * Add ACF options pages.
		 *
		 * @param  n/a
		 * @return n/a
		 */
		public function add_options_pages() {
			if( function_exists( 'acf_add_options_page' ) ) {
				acf_add_options_page( array(
					'page_title' 		=> 'Sitewide contact and general info',
					'menu_title'		=> 'General info',
					'menu_slug' 		=> 'fq-settings',
					'capability'		=> 'edit_posts',
					'redirect'			=> false,
					'icon_url'			=> 'dashicons-info',
				) );
				acf_add_options_sub_page( array(
					'page_title'		=> 'Social media links',
					'menu_title'		=> 'Social media',
					'parent_slug'		=> 'fq-settings',
				) );
				acf_add_options_sub_page( array(
					'page_title'		=> 'Top banner message and activation',
					'menu_title'		=> 'Top banner',
					'parent_slug'		=> 'fq-settings',
				) );
				acf_add_options_sub_page( array(
					'page_title'		=> 'Special notice for login page',
					'menu_title'		=> 'Login notice',
					'parent_slug'		=> 'fq-settings',
				) );
			}
		}
	}
}

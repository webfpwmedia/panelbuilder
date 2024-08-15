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

if ( ! class_exists( 'FQPBBE_CPT' ) ) {

	abstract class FQPBBE_CPT {

		// Properties

		protected $slug = 'abstract-post-type';
		protected $dashicon = 'dashicons-admin-post';
		protected $custom_icon = false;
		protected $icon;
		protected $singular_label = 'MyPost';
		protected $plural_label = 'MyPosts';
		protected $redirect_singles = 'archive'; // 'archive', 'home', or other string that is an acceptable page
		protected $adjust_queries = false;
		protected $cpt_args;
		protected $cpt_labels;

		// Main init method: Need to call this in the constructor of any child class

		protected function init() {
			$this->set_icon();
			$this->set_labels();
			$this->set_args();

			add_action( 'init', array( $this, 'register_cpt' ) );

			if ( $this->redirect_singles ) {
				add_action( 'template_redirect', array( $this, 'disable_single_views' ) );
			}

			if ( $this->adjust_queries ) {
				add_action( 'pre_get_posts', array( $this, 'adjust_default_queries' ) );
			}
		}

		// Setters

		protected function set_args() {

			$args = array(
				'label' => $this->get_singular_label(),
				'labels' => $this->get_cpt_labels(),
				'menu_icon' => $this->get_icon(),
			);

			$this->cpt_args = $args;
		}

		protected function set_labels() {

			$labels = array(
				'name' => $this->get_plural_label(),
				'singular_name' => $this->get_singular_label(),
				'menu_name' => $this->get_plural_label(),
				'name_admin_bar' => $this->get_singular_label(),
				'parent_item_colon' => $this->get_singular_label() . ": ",
				'all_items' => $this->get_plural_label(),
				'add_new_item' => 'Add New ' . $this->get_singular_label(),
				'add_new' => 'Add New',
				'new_item' => 'New ' . $this->get_singular_label(),
				'edit_item' => 'Edit ' . $this->get_singular_label(),
				'update_item' => 'Update ' . $this->get_singular_label(),
				'view_item' => 'View ' . $this->get_singular_label(),
				'search_items' => 'Search Item',
				'not_found' => 'Not found',
				'not_found_in_trash' => 'Not found in Trash',
			);

			$this->cpt_labels = $labels;
		}

		protected function set_icon() {

			if ( $this->get_custom_icon() ) {
				$this->icon = get_stylesheet_directory_uri() . '/static/images/' . $this->get_custom_icon();
			} else {
				$this->icon = $this->get_dashicon();
			}

		}

		// Getters

		protected function get_slug() {
			return $this->slug;
		}
		protected function get_singular_label() {
			return $this->singular_label;
		}
		protected function get_plural_label() {
			return $this->plural_label;
		}
		protected function get_cpt_args() {
			return $this->cpt_args;
		}
		protected function get_cpt_labels() {
			return $this->cpt_labels;
		}
		protected function get_custom_icon() {
			return $this->custom_icon;
		}
		protected function get_dashicon() {
			return $this->dashicon;
		}
		protected function get_icon() {
			return $this->icon;
		}

		// Workers

		public function adjust_default_queries( $query ) {
	    if ( is_admin() || ! $query->is_main_query() ) {
	    	return;
	    }
		if ( is_post_type_archive( $this->get_slug() ) ) {
	        $query->set( 'posts_per_page', -1 );
	    }
		}

		public function disable_single_views() {

			$redirect = $this->redirect_singles;

			if ( is_single() && get_query_var( 'post_type' ) == $this->get_slug() ) {
				if ( 'archive' == $redirect ) {
					$redirect = '/' . get_query_var( 'post_type' ) . '/';
				} elseif ( 'home' == $redirect ) {
					$redirect = '';
				}

				wp_redirect( home_url( $redirect ), 301 );
				exit;
			}
		}

		/**
		 * Register the post type
		 *
		 * @return void
		 */
		public function register_cpt() {
			register_post_type( $this->get_slug(), $this->get_cpt_args() );
		}
	}
}

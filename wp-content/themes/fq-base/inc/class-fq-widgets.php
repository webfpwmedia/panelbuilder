<?php
/**
 * Define our widgets and things
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'FQ_Widgets' ) ) {

	class FQ_Widgets {

		private $widgets = false;

		/**
		 * Constructor for the class.
		 */
		public function __construct( $widgets ) {
			$this->set_widgets( $widgets );
			add_action( 'widgets_init', array( $this, 'theme_widgets' ) );
		}

		public function set_widgets( $widgets ) {
			$this->widgets = $widgets;
		}

		public function get_widgets() {
			return $this->widgets;
		}

		/**
		 * Register our sidebar areas.
		 * @param  n/a
		 * @return n/a
		 */
		public function theme_widgets() {

			foreach ( $this->get_widgets() as $widget ) {

				if ( empty( $widget['id'] ) ) {
					continue;
				}

				$name = $widget['name'] ? $widget['name'] : 'Widget';
				$description = $widget['description'] ? $widget['description'] : 'Add items here.';

				register_sidebar( array(
					'name'          => esc_html__( $name, 'fq-custom-theme' ),
					'id'            => $widget['id'],
					'description'   => esc_html__( $description, 'fq-custom-theme' ),
					'before_widget' => '<section id="%1$s" class="widget %2$s">',
					'after_widget'  => '</section>',
					'before_title'  => '<h3 class="widget-title">',
					'after_title'   => '</h3>',
				) );
			}
		}
	}
}

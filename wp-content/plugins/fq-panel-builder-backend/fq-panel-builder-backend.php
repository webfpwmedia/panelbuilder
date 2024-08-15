<?php
/**
 * Plugin Name: FQ States Industries Panel Builder Backend & API
 * Version: 1.0.0
 * Plugin URI: http://www.figoliquinn.com/
 * Description: Provides editing and api for data needed for the front-end panel builder.
 * Author: Bob Passaro, Figoli Quinn & Associates
 * 
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/vendor/autoload.php';

// some constants
if ( ! defined( 'FQPBBE_FILE' ) ) {
	define( 'FQPBBE_FILE', __FILE__ );
}
if ( ! defined( 'FQPBBE_PREFIX' ) ) {
	define( 'FQPBBE_PREFIX', 'fqpbbe_' );
}
if ( ! defined( 'FQPBBE_URL' ) ) {
	define( 'FQPBBE_URL', plugin_dir_url( __FILE__ ) );
}
if ( ! defined( 'FQPBBE_PATH' ) ) {
	define( 'FQPBBE_PATH', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'FQPBBE_TEMPLATES_PATH' ) ) {
	define( 'FQPBBE_TEMPLATES_PATH', trailingslashit( FQPBBE_PATH ) . 'templates' );
}
if ( ! defined( 'FQPBBE_VENEER_IMAGES_PATH' ) ) {
	define( 'FQPBBE_VENEER_IMAGES_PATH', trailingslashit( FQPBBE_PATH ) . 'images/veneers' );
}
if ( ! defined( 'FQPBBE_VENEER_IMAGES_SRC' ) ) {
	define( 'FQPBBE_VENEER_IMAGES_SRC', trailingslashit( FQPBBE_URL ) . 'images/veneers' );
}
if ( ! defined( 'FQPBBE_DATA_TYPE' ) ) {
	define( 'FQPBBE_DATA_TYPE', 'species' );
}
if ( ! defined( 'FQPBBE_DATA_CHARACTERISTICS' ) ) {
	define( 'FQPBBE_DATA_CHARACTERISTICS', [
		[
			'key' => 'core',
			'title' => 'Core',
			'plural' => 'Cores',
			'availability_key' => 'cores_available',
			'acf_key' => 'field_63dne6t14c9a',
		],
		[
			'key' => 'size',
			'title' => 'Size',
			'plural' => 'Sizes',
			'availability_key' => 'sizes_available',
			'acf_key' => 'field_6330dhrsveoc9a',
		],
		[
			'key' => 'thickness',
			'title' => 'Thickness',
			'plural' => 'Thicknessees',
			'availability_key' => 'thicknesses_available',
			'acf_key' => 'field_6330da8516yge',
		],
		[
			'key' => 'cut',
			'title' => 'Cut',
			'plural' => 'Cuts',
			'availability_key' => 'cuts_available',
			'acf_key' => 'field_6330da8514c9a',
		],
		[
			'key' => 'grade',
			'title' => 'Grade',
			'plural' => 'Grades',
			'availability_key' => 'grades_available',
			'acf_key' => 'field_6330dje7ysl92',
		],
		[
			'key' => 'back_grade',
			'title' => 'Back Grade',
			'plural' => 'Back Grades',
			'availability_key' => 'back_grades_available',
			'acf_key' => 'field_6330da3bcbe61',
		],
		[
			'key' => 'match',
			'title' => 'Match',
			'plural' => 'Matches',
			'availability_key' => 'matches_available',
			'acf_key' => 'field_6330d9aa93181',
		], 
	] );
}

// include init class and fire up the plugin
require plugin_dir_path( __FILE__ ) . 'inc/fqpbbe-class-init.php';

new FQPBBE_Init();
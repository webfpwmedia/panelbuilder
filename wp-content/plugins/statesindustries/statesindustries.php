<?php 
/*
  Plugin Name: States Industries
  Author: Figoli Quinn & Associates
  Description: Functionality for States Industries.
  Version: 1.0
*/	

if ( !defined( 'ABSPATH' ) ) exit;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/../better-custom-post-types/vendor/autoload.php';
require_once __DIR__ . '/../ewp-query/vendor/autoload.php';

if ( ! defined( 'STATES_INDUSTRIES_PLUGIN_DIR_URI' ) ) {
    define( 'STATES_INDUSTRIES_PLUGIN_DIR_URI', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'STATES_INDUSTRIES_PLUGIN_DIR' ) ) {
    define( 'STATES_INDUSTRIES_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

use FigoliQuinn\StatesIndustries\StatesIndustriesPlugin;

new StatesIndustriesPlugin();
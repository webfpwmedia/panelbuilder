<?php

/**
 * Class to initiate the plugin
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'FQPBBE_Api_Routes' ) ) {

    class FQPBBE_Api_Routes {

        public function __construct() {
            $this->hooks();
        }

        public function hooks() {
            add_action( 'rest_api_init', [ $this, 'register_panel_data_route' ] );
            add_action( 'rest_api_init', [ $this, 'register_panel_download_route' ] );
        }

        public function register_panel_data_route() {

            $options = [
                'methods' => 'GET',
                'callback' => [ $this, 'fetch_species' ],
                'permission_callback' => [ $this, 'authenticate_data_request' ]
            ];
        
            register_rest_route( 'panel-builder/v1', '/all-species', $options );
        }

        public function register_panel_download_route() {

            $options = [
                'methods' => 'POST',
                'callback' => [ $this, 'download_csi_spec' ],
                'permission_callback' => [ $this, 'authenticate_data_request' ]
            ];
        
            register_rest_route( 'panel-builder/v1', '/csi-spec', $options );
        }

        public function fetch_species( WP_REST_Request $request ) {
            $fetch = new FQPBBE_Fetch_Data();
            $response = $fetch->get_data();
            return rest_ensure_response( $response );
        }

        public function download_csi_spec( WP_REST_Request $request ) 
        {
            // Download response as Word File.
            // header("Content-Type: application/vnd.msword");
            // header("Content-Disposition: attachment; filename=CSISpec.docx");

            $csiSpec = new FQPBBE_Download_CSI_Spec();

            return $csiSpec->download($request);
        }

        public function authenticate_data_request( $request ) {
            // $valid_keys = get_option( 'fqpbbe_api_keys' );
            // $key = get the current key from the request
            // return in_array( $key, $valid_keys );
            return true;
        }

    }	// end class

    new FQPBBE_Api_Routes();
}

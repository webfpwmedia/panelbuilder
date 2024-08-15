<?php

/**
 * Class to initiate the plugin
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'FQPBBE_Logger' ) ) {

	class FQPBBE_Logger {

		public function __construct() {
			$this->remove_old();
		}

		public function get_log_dir() {
			return FQPBBE_PATH . 'logs/';
		}

		public function log( $msg, $intro = 'Entry', $file = 'github' ) {

			$log_file = $this->setup_log_file( $file );

			$datetime = new DateTime( 'now', new DateTimeZone( 'America/Los_Angeles' ) );
			$time = $datetime->format( 'm-d-Y H:i:s' );

			$log_text = $intro . ' at ' . $time . ': ';
			$log_text .= "\n";
			$log_text .= print_r( $msg, true ) . "\n\n";
		
			error_log( $log_text, 3, $log_file );
		}

		public function setup_log_file( $file ) {

			$datetime = new DateTime( 'now', new DateTimeZone( 'America/Los_Angeles' ) );
			$file_date = $datetime->format( 'Ymd' );
			$dir = $this->get_log_dir();
			$file = $dir . $file . '_' . $file_date . '.php';

			if ( ! file_exists( $dir ) || is_file( $dir ) ) {
				mkdir( $dir );
			}

			if ( ! file_exists( $file ) || ! is_file( $file ) ) {
				touch( $file );
			}

			return $file;
		}

		public function remove_old() {

			$dir = $this->get_log_dir();
			$files = scandir( $dir );
			$now = time();

			foreach ( $files as $file ) {
				if ( ! is_file( $file ) || '.' == $file || '..' == $file ) {
					continue;
				}
				if ( $now - filemtime( $file ) >= 60 * 60 * 24 * 30 ) { // remove files older than 30 days
					unlink( $file );
				}
			}
		}

	}	// end class
}

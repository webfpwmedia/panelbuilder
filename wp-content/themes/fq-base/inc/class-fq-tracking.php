<?php

/**
 * Place tracking pixels etc
 *
 * @package fq_xtracycle_custom
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'FQ_Tracking' ) ) {

	class FQ_Tracking {
		
		private $tracking;
		
		/**
		 * Class constructor.
		 */
		public function __construct( $tracking, $production_environment = false ) {
			if ( ! $production_environment ) {
					return;
			}

				$this->set_tracking( $tracking );
				$this->init_tracking_codes();
		}
		
		/*--------------------------------------------------------------
		# Getters and setters
		--------------------------------------------------------------*/
		
		public function set_tracking( $tracking ) {
			$this->tracking = $tracking;
		}
		
		public function get_ua_code() {
			return $this->tracking['google_ua_code'];
		}
		
		public function get_adwords_code() {
			return $this->tracking['google_aw_code'];
		}
		
		public function get_google_tag_manager_id() {
			return $this->tracking['google_tag_manager_id'];
		}
		
		public function get_facebook_id() {
			return $this->tracking['facebook_pixel_id'];
		}

		public function track_woo_sales() {
			return $this->tracking['track_woo_sales'];
		}
		
		/*--------------------------------------------------------------
		# Our main init function
		--------------------------------------------------------------*/
		
		/**
		 * Hooks in to add the tracking codes to their appropriate spots.
		 *
		 * @return void
		 */
		public function init_tracking_codes() {
			add_action( 'wp_head', array( $this, 'google_site_tag' ), 10 );
			add_action( 'wp_head', array( $this, 'google_tag_manager' ), 11 );
			add_action( 'wp_head', array( $this, 'facebook_pixel' ), 99 );
			add_action( 'woocommerce_thankyou', array( $this, 'order_complete_conversion_pixels' ), 20 );
		}
		
		/**
		 * Add Google global site tag configured for analytics and adwards.
		 *
		 * @return void
		 */
		public function google_site_tag() {
			if ( ! $this->get_ua_code() && ! $this->get_adwords_code() ) {
				return;
			}
			
			$output = "<!-- Global site tag (gtag.js) - Google Analytics -->";
			$output .= "<script async src=\"https://www.googletagmanager.com/gtag/js?id=" . $this->get_ua_code() . "\"></script>";
			$output .= "<script>window.dataLayer = window.dataLayer || [];";
			$output .= "function gtag(){dataLayer.push(arguments);}";
			$output .= "gtag('js', new Date());";
			if ( $this->get_ua_code() ) {
				$output .= "gtag('config', '" . $this->get_ua_code() . "');";
			}
			if ( $this->get_adwords_code() ) {
				$output .= "gtag('config','" . $this->get_adwords_code() . "');";
			}
		    $output .= "</script>";
			
			echo $output;
		}
	
		public function google_tag_manager() {
			
			if ( ! $this->get_google_tag_manager_id() ) {
				return;
			}
		
			echo "<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','" . $this->get_google_tag_manager_id() . "');</script>
		<!-- End Google Tag Manager -->";
		}

		public function facebook_pixel() {
			
			if ( ! $this->get_facebook_id() ) {
				return;
			}
			
			echo "<!-- Facebook Pixel Code -->
				<script>
				!function(f,b,e,v,n,t,s)
				{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
				n.callMethod.apply(n,arguments):n.queue.push(arguments)};
				if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
				n.queue=[];t=b.createElement(e);t.async=!0;
				t.src=v;s=b.getElementsByTagName(e)[0];
				s.parentNode.insertBefore(t,s)}(window,document,'script',
				'https://connect.facebook.net/en_US/fbevents.js');
				fbq('init', '" . $this->get_facebook_id() . "'); 
				fbq('track', 'PageView');
				</script>
				<noscript>
				 <img height=\"1\" width=\"1\" 
				src=\"https://www.facebook.com/tr?id=" . $this->get_facebook_id() . "&ev=PageView
				&noscript=1\"/>
				</noscript>
				<!-- End Facebook Pixel Code -->";
		}
		
		/**
		 * Place conversion pixels on the thank you/order received page.
		 *
		 * @return void
		 */
		public function order_complete_conversion_pixels( $order_id ) {
			
			if ( ! $this->track_woo_sales() ) {
				return;
			}
			
			
			$order = wc_get_order( $order_id );
			
			if ( ! $order->has_status( 'failed' ) ) {
				echo "<!-- Event snippet for woo sales conversions -->
					<script>
					  gtag('event', 'conversion', {
					      'send_to': '" . $order->get_adwords_code() . "',
					      'value': " . $order->get_total() . ",
					      'currency': 'USD',
					      'transaction_id': " . $order->get_order_number() . "
					   });
					</script>
					<script>
						fbq('track', 'Purchase', {value:" . $order->get_total() . ", currency: 'USD'});
					</script>";
			}
		}
		
	}  // end class

}

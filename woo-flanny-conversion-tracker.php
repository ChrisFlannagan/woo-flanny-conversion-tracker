<?php
/**
 * Plugin Name: Quick Tracking Conversions for WooCommerce
 * Description: Create any tracking code you'd like and attach to links.  When someone clicks the link to your site they will be tracked for purchase
 * Version:     0.5
 * Author:      Chris Flannagan
 * Author URI:  https://whoischris.com
 */

if ( ! class_exists( 'QTC_Woo' ) ) {
	class QTC_Woo {
		/**
		 * QTC_Woo constructor.
		 *
		 * Build only what we need to, init our static sessions object to record only if we
		 * have a qtc woo tracking request.
		 * Run conversion only if cookie set.
		 */
		public function __construct() {
			require_once( sprintf( "%s/control/qtc_session.php", dirname( __FILE__ ) ) );
			if ( isset( $_GET['qtc_woo_tracking_code'] ) ) {
				add_action( 'plugins_loaded', [ 'QTC_Session', 'initialize' ] );
			}
			if ( isset ( $_COOKIE['qtc_woo_tracking_code'] ) ) {
				add_action( 'woocommerce_thankyou', [ 'QTC_Session', 'record_conversion' ] );
			}
			// Prepare our admin page
			add_action( 'admin_menu', array( $this, 'qct_admin_page' ) );
		}

		public function qct_admin_page() {
			//Place a link to our settings page under the Wordpress "Settings" menu
			add_menu_page( 'Woo Conversion Tracking', 'Woo Conversion Tracking', 'manage_options', 'qtc-woo-page', array(
				$this,
				'template_page'
			) );
		}

		public function template_page() {
			//Include our settings page template
			require_once( sprintf( "%s/control/qtc_results.php", dirname( __FILE__ ) ) );
			include( sprintf( "%s/views/qtc_admin_page.php", dirname( __FILE__ ) ) );
		}
	}
}

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	$QTC_Woo = new QTC_Woo();
}
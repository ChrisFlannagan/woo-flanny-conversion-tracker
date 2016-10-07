<?php
/**
 * Plugin Name: Quick Conversion Tracking for WooCommerce
 * Description: Create any tracking code you'd like and attach to links.  When someone clicks the link to your site they will be tracked for purchase
 * Version:     0.5
 * Author:      Chris Flannagan
 * Author URI:  https://whoischris.com
 */

if ( ! class_exists( 'QCT_WOO' ) ) {
	class QCT_WOO {
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'qct_admin_page' ) );
		}

		public function qct_admin_page() {
			//Place a link to our settings page under the Wordpress "Settings" menu
			add_menu_page( 'Woo Conversion Tracking', 'Woo Conversion Tracking', 'manage_options', 'dabaracc-page', array(
				$this,
				'template_page'
			) );
		}

		public function template_page() {
			//Include our settings page template
			include( sprintf( "%s/views/qtc_admin_page.php", dirname( __FILE__ ) ) );
		}
	}
}

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	$QCT_WOO = new QCT_WOO();
}
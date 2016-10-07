<?php
/**
 * QTC Session Class
 * 
 * This tracks the user visiting the page and when they convert
 */
class QTC_SESSION {
	public static function initialize() {
		// Begin a session if not already going
		if ( ! session_id() ) {
			session_start();
		}
		// Add tracking code to session
		if ( isset( $_GET['qtc_woo_tracking_code'] ) ) {
			$_SESSION['qtc_woo_tracking_code'] = sanitize_text_field( $_GET['qtc_woo_tracking_code'] );
		}
	}

	public static function record_conversion( $order_id ) {
		if ( isset ( $_SESSION['qtc_woo_tracking_code'] ) ) {
			$order = new WC_Order( $order_id );
			update_post_meta( $order_id, "_qtc_woo_tracked_" . $_SESSION['qtc_woo_tracking_code'], 1 );
		}
	}
}

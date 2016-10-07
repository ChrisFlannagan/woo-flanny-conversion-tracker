<?php
/**
 * QTC Session Class
 * 
 * This tracks the user visiting the page and when they convert
 */
class QTC_SESSION {
	/**
	 * Initialize a session if there's a tracking link attached to the url
	 */
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

	/**
	 * This funciton is called when the woocommerce_thankyou hook fires.  It means an order has just been
	 * finalized and the hook passes in the $order_id param which we use to store post_meta of the tracking
	 * code connected to the specific order
	 * 
	 * @param $order_id
	 */
	public static function record_conversion( $order_id ) {
		if ( isset ( $_SESSION['qtc_woo_tracking_code'] ) ) {
			update_post_meta( $order_id, "_qtc_woo_tracked_" . $_SESSION['qtc_woo_tracking_code'], 1 );
		}
	}
}

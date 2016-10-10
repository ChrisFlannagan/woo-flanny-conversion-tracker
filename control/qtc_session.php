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
		// Add tracking code to session
		setcookie( 'qtc_woo_tracking_code', sanitize_key( $_GET['qtc_woo_tracking_code'] ), time() + ( 3 * 86400 ), COOKIEPATH, COOKIE_DOMAIN );
	}

	/**
	 * This funciton is called when the woocommerce_thankyou hook fires.  It means an order has just been
	 * finalized and the hook passes in the $order_id param which we use to store post_meta of the tracking
	 * code connected to the specific order
	 * 
	 * @param $order_id
	 */
	public static function record_conversion( $order_id ) {
		update_post_meta( $order_id, '_qtc_woo_tracked_' . $_COOKIE['qtc_woo_tracking_code'], 1 );
	}
}

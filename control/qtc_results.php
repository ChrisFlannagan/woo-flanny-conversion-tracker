<?php
/**
 * Created by PhpStorm.
 * User: Chris
 * Date: 10/7/16
 * Time: 3:07 PM
 */

class QTC_Results {
	private $orders = array();

	public function __construct( $tracking_code ) {
		global $wpdb;
		$prefix = $wpdb->prefix;
		$order_ids = $wpdb->get_col( $wpdb->prepare( " 
 			SELECT post_id
			FROM $wpdb->postmeta 
			WHERE meta_key=%s",
			'_qtc_woo_tracked_' . $tracking_code ) );
		foreach ( $order_ids as $id ) {
			$this->orders[] = new WC_Order( $id );
		}
	}

	public function get_count() {
		return count( $this->orders );
	}

	public function get_total_value() {
		if ( $this->get_count() > 0 ) {
			$total_value = 0;
			$order_currency = '';
			foreach ( $this->orders as $order ) {
				$total_value += $order->get_total();
				$order_currency = $order->get_order_currency();
			}
			return wc_price( $total_value, array( 'currency' => $order_currency ) );
		} else {
			return 0;
		}
	}
}
<?php
/**
 * Created by PhpStorm.
 * User: Chris
 * Date: 10/7/16
 * Time: 3:07 PM
 */

class QTC_RESULTS {
	private $orders = array();

	public function __construct( $tracking_code ) {
		global $wpdb;
		$prefix = $wpdb->get_prefix();
		$order_ids = $wpdb->get_col( $wpdb->prepare( " 
 			SELECT post_id
			FROM $wpdb->postmeta 
			WHERE meta_key=%s",
			$tracking_code ) );
		foreach ( $order_ids as $id ) {
			$orders[] = new WC_Order( $id );
		}
	}
}
<?php
/**
 * Plugin Name: Google Analytics and Tracking for Sock Fancy
 * Description: Analytics & Enhanced Ecommerce for Tracking Affiliate Codes
 * Version:     0.1
 * Author:      Chris Flannagan
 * Author URI:  https://whoischris.com
 */

/**
 * In the future this will be the one true location for managing Google analytics
 */

/**
 * Register all Google scripts
 */
add_action( 'wp_enqueue_scripts', function() {
	wp_register_script( 'google-ads-conversion',  '//www.googleadservices.com/pagead/conversion.js' );
} );

/**
 * register affiliate tracking variable if attached
 */
add_action( 'init', function() {
	// Add tracking code to session
	if ( ! session_id() ) {
		session_start();
	}
	if ( isset( $_GET['sf_affiliate_ee_tracking_code'] ) ) {
		$_SESSION['sf_affiliate_ee_tracking_code'] = sanitize_text_field( $_GET['sf_affiliate_ee_tracking_code'] );
	}

});

/**
 * Add analytics and enhanced ecommerce to every page & check header for affiliate code.
 */
add_action( 'wp_head', function() {
	/**
	 * Add analytics.js to every page
	 */
	if ( isset( $_SESSION['sf_affiliate_ee_tracking_code'] ) ) {
		echo '<!-- Session: ' . $_SESSION['sf_affiliate_ee_tracking_code'] . '//-->';
	}
	/**
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-39529472-1', 'auto');
		ga("require", "ec");
		ga('send', 'pageview');

	</script>
	**/

} );

/**
 * Print customsocks conversion & analytics.js for enhanced ecommerce tracking
 */
add_action( 'wp_footer', function(){
	/**
	 * Add conversion tracking on succcess page only
	 */
	if( ! is_page( 'customsocks-success' ) ){
		return;
	}

	wp_enqueue_script( 'google-ads-conversion' );
	/**
	<script type="text/javascript">
		/* <![CDATA[ */
	/**
		var google_conversion_id = 975301049;
		var google_conversion_language = "en";
		var google_conversion_format = "3";
		var google_conversion_color = "ffffff";
		var google_conversion_label = "ZITYCMyf1WkQudOH0QM";
		var google_remarketing_only = false;
	**/
	/* ]]> */

	/**
	</script>
	<script type="text/javascript" src="">
	</script>
	<noscript>
		<div style="display:inline;">
			<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/975301049/?label=ZITYCMyf1WkQudOH0QM&amp;guid=ON&amp;script=0"/>
		</div>
	</noscript>
    **/
});

function ecommerce_tracking_code( $order_id ) {
	if ( ! session_id() ) {
		session_start();
	}
	if ( isset ( $_SESSION['sf_affiliate_ee_tracking_code'] ) ) {
		$order = new WC_Order( $order_id );
		?>
		<script>
			ga("ec:setAction","purchase", {
					"id": "<?php echo esc_js( $order->get_order_number() ); ?>",
					"affiliation":  "<?php echo esc_js( $_SESSION['sf_affiliate_ee_tracking_code']); ?>",
					"revenue": "<?php echo esc_js( $order->get_total() ); ?>""
				});
			ga("send", "event", "Enhanced-Ecommerce","load", "order_confirmation", {"nonInteraction": 1});
		</script>
		<?php
	    update_post_meta( $order_id, "_tracked_" . $_SESSION['sf_affiliate_ee_tracking_code'], 1 );
	}
}
add_action( "woocommerce_thankyou", "ecommerce_tracking_code" );

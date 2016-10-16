<?php
/**
 * QTC Enhanced Ecommerce
 *
 * An admin setting allows site owners to include google enhanced ecommerce analytics for conversion
 * and will include the affiliate tracking code.
 *
 * It is best if they have all other google analytics plugins/scripts turned off as to not interfere
 * with pageview counts
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class QTC_Enhanced_Ecommerce {
	public static function drop_script() {
		if ( get_option( 'qtc_analytics_on' ) !== false ) {
			?><!-- Google Analytics -->
			<script>
				(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
						(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
					m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

				ga('create', '<?php echo esc_attr( get_option( 'qtc_analytics_ua_code' ) ); ?>', 'auto');
				ga('send', 'pageview');
			</script>
			<!-- End Google Analytics --><?php
		}
	}

	public static function record_conversion( $order_id ) {
		$order = new WC_Order( $order_id );
		?><script>
		ga('require', 'ec');
		ga('ec:setAction', 'purchase', {          // Transaction details are provided in an actionFieldObject.
		  'id': <?php echo $order_id; ?>,
		  'affiliation': '<?php echo esc_attr( $_COOKIE['qtc_woo_tracking_code'] ); ?>',
		  'revenue': '<?php echo $order->get_total(); ?>'
		});
		</script><?php
	}
}
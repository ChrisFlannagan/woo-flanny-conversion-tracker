<?php
/**
 * 
 */

class QTC_Enhanced_Ecommerce {
	public static function drop_script() {
		if ( get_option( 'qtc_analytics_on' ) !== false ) {
			?><!-- Google Analytics -->
			<script>
				(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
						(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
					m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

				ga('create', '<?php echo get_option( 'qtc_analytics_ua_code' ); ?>', 'auto');
				ga('send', 'pageview');
				ga('require', 'ec');
			</script>
			<!-- End Google Analytics --><?php
		}
	}

	public static function record_conversion( $order_id ) {
		$order = new WC_Order( $order_id );
		?><script>
		ga('ec:setAction', 'purchase', {          // Transaction details are provided in an actionFieldObject.
		  'id': <?php echo $order_id; ?>,
		  'affiliation': '<?php echo $_COOKIE['qtc_woo_tracking_code']; ?>,
		  'revenue': <?php echo $order->get_total(); ?>
		});
		</script><?php
	}
}
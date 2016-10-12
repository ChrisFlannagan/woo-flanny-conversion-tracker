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

	public static function record_conversion( $order ) {
		?><script>
		ga('ec:setAction', 'purchase', {          // Transaction details are provided in an actionFieldObject.
		  'id': 'T12345',                         // (Required) Transaction id (string).
		  'affiliation': 'Google Store - Online', // Affiliation (string).
		  'revenue': '37.39',                     // Revenue (currency).
		  'tax': '2.85',                          // Tax (currency).
		  'shipping': '5.34',                     // Shipping (currency).
		  'coupon': 'SUMMER2013'                  // Transaction coupon (string).
		});
		</script><?php
	}
}
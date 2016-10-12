<?php
if( ! current_user_can( 'manage_options' ) ) {
	exit();
}
$ua_code = '';
if ( get_option( 'qtc_analytics_ua_code' ) !== false ) {
	$ua_code = get_option( 'qtc_analytics_ua_code' );
}

if( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'] ) ) {
	$ua_code = $_POST['ua_code'];
	update_option( 'qtc_analytics_ua_code', $_POST['ua_code'] );
	//wp_redirect( );
}
?>
<div class="wrap">
	<h2>Woo Conversion Tracking Settings</h2>
	<p>This plugin will insert analytics.js so if you are using google analytics anywhere else you should turn it off or risk double counting visits.</p>
	<form action="" method="POST">
		<?php wp_nonce_field(); ?>
		<p>
			Enable Enhanced Ecommerce: <input type="checkbox" name="enabled_enhanced_analytics" />
		</p>
		<p>
			Google Analytics: UA-<input type="text" value="<?php echo $ua_code ?>" name="ua_code" />-1
		</p>
		<p>
			<button type="submit">Save Settings</button>
		</p>
	</form>
	<?php
	?>
</div>
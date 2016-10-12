<?php
if( ! current_user_can( 'manage_options' ) ) {
	exit();
}
$ua_code = '';
$ua_on = '';

if( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'] ) ) {
	update_option( 'qtc_analytics_ua_code', $_POST['ua_code'] );
	if ( isset( $_POST['ua_on'] ) ) {
		update_option( 'qtc_analytics_on', true );
		$ua_on = ' checked';
	} else {
		delete_option( 'qtc_analytics_on' );
	}
	//wp_redirect( );
}

if ( get_option( 'qtc_analytics_ua_code' ) !== false ) {
	$ua_code = get_option( 'qtc_analytics_ua_code' );
}
if ( get_option( 'qtc_analytics_on' ) !== false ) {
	$ua_on = ' checked';
}
?>
<div class="wrap">
	<h2>Woo Conversion Tracking Settings</h2>
	<p>This plugin will insert analytics.js so if you are using google analytics anywhere else you should turn it off or risk double counting visits.</p>
	<form action="" method="POST">
		<?php wp_nonce_field(); ?>
		<p>
			Enable Enhanced Ecommerce: <input type="checkbox"<?php echo $ua_on; ?> name="ua_on" />
		</p>
		<p>
			Google Analytics (UA-######-1): <input type="text" value="<?php echo $ua_code ?>" name="ua_code" />
		</p>
		<p>
			<button type="submit">Save Settings</button>
		</p>
	</form>
</div>
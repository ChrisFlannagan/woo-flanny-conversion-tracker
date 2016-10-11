<?php
if( ! current_user_can( 'manage_options' ) ) {
	exit();
}
?>
<div class="wrap">
	<h2>Woo Conversion Tracking</h2>
	<form action="" method="POST">
		<p>
			<?php wp_nonce_field(); ?>
			Tracking Code: <input type="text" name="tracking_code" />
		</p>
		<p>
			<button type="submit">View Results</button>
		</p>
	</form>
	<?php
	if( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'] ) ) {
		$qtc_results = new QTC_RESULTS( $_POST['tracking_code'] );
		echo '<p>Total Conversions: ' . $qtc_results->get_count() . '</p>';
		echo '<p>Total Value: ' . $qtc_results->get_total_value() . '</p>';
	}
	?>
</div>
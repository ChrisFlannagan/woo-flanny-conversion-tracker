<?php
if( ! current_user_can( 'manage_options' ) ) {
	exit();
}

$saved = '';

if( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'] ) ) {
	
}
?>
<div class="wrap">
	<h2>Woo Conversion Tracking</h2>
	<?php echo $saved; ?>
	<form action="" method="POST">
		<p>
			<?php wp_nonce_field(); ?>
			Tracking Code: <input type="text" name="tracking_code" />
		</p>
		<p>
			<button type="submit">View Results</button>
		</p>
	</form>
</div>
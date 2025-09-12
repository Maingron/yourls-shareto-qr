<?php
/*
Plugin Name: Share as QR Code: quickshare
Plugin URI: http://yourls.org/
Description: Add QR Code to the list of Quick Share destinations
Version: 1.0
Author: Maingron
Author URI: https://maingron.com

Thanks to Peter Ryan Berbec for the "Mailto: quickshare" plugin, which this is based on.
*/

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();

yourls_add_action( 'share_links', 'mg_yourls_share_qr' );

function mg_yourls_share_qr( $args ) {
	list( $longurl, $shorturl, $title, $text ) = $args;
	$shorturl = rawurlencode( $shorturl );

	$mg_path = YOURLS_PLUGINURL . '/' . yourls_plugin_basename( dirname(__FILE__) );
	$mg_icon = $mg_path.'/qr_code.png';

	echo <<<HTML

		<style type="text/css">
		#share_mg_qr{
			background:transparent url("$mg_icon") left center no-repeat;
			background-size: contain;
		}
		</style>

		<a id="share_mg_qr"
			title="Show QR Code"
			onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,height=300,width=300,left=100,top=100');return false;"
			href="#">
			QR Code
		</a>

		<script type="text/javascript">
			// Dynamically update Mailto link
			// when user clicks on the "Share" Action icon, event $('#tweet_body').keypress() is fired, so we'll add to this
			$('#tweet_body').keypress(function(){
				let qr_url = $('#copylink').val();
				$('#share_mg_qr').attr('href', "//api.qrserver.com/v1/create-qr-code/?size=200x200&qzone=2&ecc=M&data=" + qr_url);
			});
		</script>
	HTML;
}

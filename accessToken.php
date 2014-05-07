<?php 
	$curl = curl_init( "https://public-api.wordpress.com/oauth2/token" );
	curl_setopt( $curl, CURLOPT_POST, true );
	curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
	'client_id' => '35013'
	'redirect_url' => 'http://wordpress-sb1.socialbro.me'
	'client_secret' => 'ME2h3KMvpC9kADBy8fVBiIgce1G0PDw0E5Ek9Qw3jI1aCD3g37picKMSnEMbGhnZ'
	'code' => '4ijBZJB2Sy'
	'grant_type' => 'authorization_code'
	) );
	curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1);
	$auth = curl_exec( $curl );
	$secret = json_decode($auth);
	echo $secret->access_token;
 ?>
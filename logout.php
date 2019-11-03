<?php
session_start();
session_regenerate_id();

if ( $_SESSION[ 'logged_in' ] != 1 ) {
	header( "location: index.php" );
	exit();
}

if ( ini_get( "session.use_cookies" ) ) {
	$params = session_get_cookie_params();
	setcookie( session_name(), '', time() - 3600 * 24, $params[ "path" ],
		$params[ "domain" ], $params[ "secure" ], $params[ "httponly" ] );
}
$_SESSION = array();
session_destroy();
header( "location: index.php" );
exit();
?>

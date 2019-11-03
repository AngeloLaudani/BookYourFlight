<?php

if ( isset( $_POST[ 'email' ] ) && isset( $_POST[ 'password' ] ) ) {
	$username = mysqli_real_escape_string( $mysqli, $_POST[ 'email' ] );
	$password = $_POST[ 'password' ];
	$result = $mysqli->query( "SELECT id, username, password FROM users WHERE username='$username'" );
	$user = $result->fetch_assoc();

	if ( !filter_var( $_POST[ 'email' ], FILTER_VALIDATE_EMAIL ) ) {
		echo "<div class=\"php-message error\">Not valid e-mail address!</div>";
	} elseif ( $result->num_rows == 0 ) {
		echo "<div class=\"php-message error\">E-mail is wrong, try again!</div>";
	}
	elseif ( !( password_verify( $password, $user[ 'password' ] ) ) ) { // User exists
		echo "<div class=\"php-message error\">Password is wrong, try again!</div>";
	}
	else {
		$_SESSION[ 'username' ] = $user[ 'username' ];
		$_SESSION[ 'user_id' ] = $user[ 'id' ];
		$_SESSION[ 'logged_in' ] = true;
		$_SESSION[ 'timestamp' ] = time();

		header( "location: personal-page.php" );
		exit();
	}
} else {
	echo "<div class=\"php-message error\">Input Error!</div>";
}

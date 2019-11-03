<?php

if ( isset( $_POST[ 'email' ] ) && isset( $_POST[ 'password' ] ) ) {
	$username = mysqli_real_escape_string( $mysqli, $_POST[ 'email' ] );
	$password = password_hash( $_POST[ 'password' ], PASSWORD_BCRYPT );
	$password_check = $_POST[ 'password' ];

	// Password pattern check
	$lowercase = preg_match( '@[a-z]@', $password_check );
	$uppercase = preg_match( '@[A-Z]@', $password_check );
	$number = preg_match( '@[0-9]@', $password_check );

	$result = $mysqli->query( "SELECT username FROM users WHERE username='$username'" );

	if ( !filter_var( $_POST[ 'email' ], FILTER_VALIDATE_EMAIL ) ) {
		echo "<div class=\"php-message error\">Not valid e-mail address!</div>";
	} elseif ( $result->num_rows > 0 ) {
		// Check if user with that email already exists
		echo "<div class=\"php-message error\">E-mail already exists</div>";
	}
	elseif ( !$lowercase || ( !$number && !$uppercase ) ) {
		echo "<div class=\"php-message error\">Wrong password format!</div>";
	}
	elseif ( $_POST[ 'password' ] != $_POST[ 'password_confirmation' ] ) {
		echo "<div class=\"php-message error\">Password confirmation failed!</div>";
	} else {
		try {
			mysqli_autocommit( $mysqli, false );
			$sql = "INSERT INTO users (username, password) "
				. "VALUES ('$username','$password')";

			// Add user to the database
			if ( !$mysqli->query( $sql ) ) throw new Exception( "<div class=\"php-message error\">Database error, try again!</div>" );
			$get_id = $mysqli->query( "SELECT id FROM users WHERE username='$username'" )->fetch_assoc();

			mysqli_commit( $mysqli );
			$_SESSION[ 'username' ] = $username;
			$_SESSION[ 'user_id' ] = $get_id[ 'id' ];
			$_SESSION[ 'logged_in' ] = true;
			$_SESSION[ 'timestamp' ] = time();

			header( "location: personal-page.php" );
			exit();

		} catch ( Exception $e ) {
			$mysqli->rollback();
			echo $e->getMessage();
		}
		mysqli_autocommit( $mysqli, true );
	}
} else {
	echo "<div class=\"php-message error\">Input Error!</div>";
}

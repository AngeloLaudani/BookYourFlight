<?php
require './php/dbcontroller.php';
session_start();

if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

if ( isset( $_SESSION[ 'logged_in' ] ) && $_SESSION[ 'logged_in' ] == 1 ) {
	header( "location: personal-page.php" );
  exit();
}

?>
<!doctype html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="vendors/css/normalize.css">
	<link rel="stylesheet" type="text/css" href="vendors/css/grid.css">
	<link rel="stylesheet" type="text/css" href="vendors/css/animate.css">
	<link rel="stylesheet" type="text/css" href="resources/css/style.css">
	<link rel="stylesheet" type="text/css" href="resources/css/queries.css">
	<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,300italic" rel="stylesheet" type="text/css">
	<title>ByF - Login</title>
</head>

<body>
	<div class="no-cookies-msg">
		<h2>Your cookies are disabled.<br>Please enable cookies in your browser to access this site.</h2>
		<h3>Thank you, the ByF Team.</h3>
	</div>
	<div class="pagecontainer">
	<script>
		document.body.className += ' fade-out';
	</script>
	<div class="full-screen">
		<div class="section-form">
			<div class="contact-box js--wp-2">
				<div class="row"> <a href="index.php">
				<h1><b>B</b>y<b>F</b></h1>
				</a>

				</div>
				<div class="row">
					<h2>Enter Your Account</h2>
				</div>
				<div class="row">
					<form method="post" action="#" class="user-form">
						<div class="row">
							<label for="email">Email</label>
						</div>
						<div class="row">
							<input type="email" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" placeholder="Your email" required/>
						</div>
						<div class="row">
							<label for="password">Password</label>
						</div>
						<div class="row">
							<input type="password" name="password" id="password" placeholder="Your password" required/>
						</div>
						<div class="row">
							<input type="submit" name="login" value="Login">
						</div>
						<div class="row">
							<label>&nbsp;</label>
						</div>
						<div class="row">
							<p>Don't have an account?&nbsp;<a href="signup.php">Sign up now</a>
							</p>
						</div>
						<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (isset($_POST['login'])) {
        require './php/login_controller.php';
    }
}
?>
					</form>
				</div>
			</div>
		</div>
		<noscript>
		<!--
    <style type="text/css">
        .pagecontainer {display:none;}
    </style>
		-->
    <div class="no-javascript-msg">
    <h2>Javascript disabled.<br>Please enable Javascript to properly use ByF.</h2><h3>Thank you, the ByF Team.</h3>
    </div>
	</noscript>
	</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="vendors/js/jquery.waypoints.min.js"></script>
	<script src="resources/js/script.js"></script>
  <script>
    $( document ).ready( function () {
      var msg = document.getElementsByClassName('php-message');
      setTimeout(function(){ $(msg).empty().hide() }, 2000);
    } );
  </script>
</body>
</html>

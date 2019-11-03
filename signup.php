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
	<link rel="stylesheet" type="text/css" href="vendors/css/tooltipster.bundle.min.css">
	<link rel="stylesheet" type="text/css" href="vendors/css/tooltipster-sideTip-light.min.css">
	<link rel="stylesheet" type="text/css" href="vendors/css/normalize.css">
	<link rel="stylesheet" type="text/css" href="vendors/css/grid.css">
	<link rel="stylesheet" type="text/css" href="vendors/css/animate.css">
	<link rel="stylesheet" type="text/css" href="resources/css/style.css">
	<link rel="stylesheet" type="text/css" href="resources/css/queries.css">
	<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,300italic" rel="stylesheet" type="text/css">
	<link href="https://unpkg.com/ionicons@4.1.2/dist/css/ionicons.min.css" rel="stylesheet">
	<title>ByF - Signup</title>
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
	<div class="signup-background">
		<header class="signup-header">
			<nav>
				<div class="row">
					<div class="nav-center"> <a href="index.php">
					<h1><b>B</b>y<b>F</b></h1>
					</a>
						<h3>Book your Flight</h3>
					</div>
					<div class="nav-right"> <a class="info-nav" href="index.php">Info</a> <a class="btn btn-ghost" href="login.php">Login</a> </div>
				</div>
			</nav>
		</header>
		<div class="section-form" id="signup-form">
			<div class="contact-box js--wp-2">
				<div class="row">
					<h2>Create Your Account</h2>
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
							<label for="password">Password</label><i class="ion-ios-help-circle-outline icon-small tooltip-description" title="Insert at least one lowercase character and one uppercase character or a number"></i>
						</div>
						<div class="row">
							<input type="password" name="password" id="password" pattern="^(?=.*[a-z])(?=.*[A-Z \d]).*$" placeholder="Your password" required/>
						</div>
						<div class="row">
							<label for="password_confirmation">Confirm Password</label>
						</div>
						<div class="row">
							<input type="password" name="password_confirmation" id="password_confirmation" pattern="^(?=.*[a-z])(?=.*[A-Z \d]).*$" placeholder="Repeat password" required/>
						</div>
						<div class="row">
							<input type="submit" name="register" value="Register">
						</div>
					</form>
				</div>
			</div>
		</div>
		<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (isset($_POST['register'])) {
        require './php/registration_controller.php';
    }
}
?>
	</div>
	<footer>
		<div class="row">
			<div class="col span-1-of-2">
				<ul class="footer-nav">
					<li><a href="#">Info</a>
					</li>
					<li><a href="#">Contact Us</a>
					</li>
					<li><a href="#">iOS App</a>
					</li>
					<li><a href="#">Android App</a>
					</li>
				</ul>
			</div>
			<div class="col span-1-of-2">
				<ul class="social-links">
					<li><a href="#"><i class="ion-logo-facebook"></i></a>
					</li>
					<li><a href="#"><i class="ion-logo-twitter"></i></a>
					</li>
					<li><a href="#"><i class="ion-logo-googleplus"></i></a>
					</li>
					<li><a href="#"><i class="ion-logo-instagram"></i></a>
					</li>
				</ul>
			</div>
		</div>
		<div class="row">
			<p> Copyright &#9400; 2019 by ByF - Book your Flight. All right reserved. </p>
		</div>
	</footer>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="vendors/js/jquery.waypoints.min.js"></script>
	<script src="resources/js/script.js"></script>
	<script src="vendors/js/tooltipster.bundle.min.js"></script>
	<script>
		$( document ).ready( function () {
			$( '.tooltip-description' ).tooltipster( {
				theme: 'tooltipster-light',
				touchDevices: true
			} );
      var msg = document.getElementsByClassName('php-message');
      setTimeout(function(){ $(msg).empty().hide() }, 2000);
		} );
	</script>
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
</body>
</html>

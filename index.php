<?php
require './php/dbcontroller.php';
session_start();
?>
<!DOCTYPE html>
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
	<link href="https://unpkg.com/ionicons@4.1.2/dist/css/ionicons.min.css" rel="stylesheet">
	<title>ByF - Book your Flight</title>
</head>

<body>
	<div class="no-cookies-msg">
		<h2>Your cookies are disabled.<br>Please enable cookies in your browser to access this site.</h2>
		<h3>Thank you, the ByF Team.</h3>
	</div>
	<div class="pagecontainer">
		<header class="main-header">
			<nav>
				<div class="row js--wp-1"> <img src="resources/img/logo-black.png" alt="ByB logo" class="logo-black">
					<ul class="main-nav js--main-nav">
						<li><a href="#grid">Seat Map</a>
						</li>
						<li><a href="#works">How it works</a>
						</li>
						<li><a href="#reviews">Our Reviews</a>
						</li>
						<li><a href="#subscribe">Upgrade Now</a>
						</li>
					</ul>
					<a class="mobile-nav-icon js--nav-icon"><i class="ion-ios-list"></i></a> </div>
			</nav>
			<div class="hero-text-box js--wp-1">
				<div class="row">
					<h1><b>B</b>y<b>F</b><br>Book your Flight</h1>
				</div>
				<div class="row">
					<div class="col span-1-of-2">
						<?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']==1): ?>
						<a class="btn btn-full" href="personal-page.php">Personal Page</a>
						<?php else: ?>
						<a class="btn btn-full" href="login.php">Sign In</a>
						<?php endif; ?>
					</div>
					<div class="col span-1-of-2">
						<a class="btn btn-ghost js--scroll-to-start" href="#">Show me more!</a>
					</div>
				</div>
			</div>
		</header>
		<div class="sidenav">
			<div class="language-select"> <a href="#"><i class="ion-ios-globe"></i>EN</a> </div>
			<div class="nav">
				<ul class="mini-menu-drop">
					<?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']==1): ?>
					<li class="nav-drop"><a href="personal-page.php">Personal Page&nbsp;<i class="ion-ios-add"></i></a>
					</li>
					<li class="nav-drop"><a href="logout.php">Logout&nbsp;<i class="ion-ios-add"></i></a>
					</li>
					<?php else: ?>
					<li class="nav-drop"><a href="login.php">Login&nbsp;<i class="ion-ios-add"></i></a>
					</li>
					<li class="nav-drop"><a href="signup.php">Sign Up&nbsp;<i class="ion-ios-add"></i></a>
					</li>
					<?php endif; ?>
				</ul>
			</div>
			<div class="nav-social">
				<ul>
					<li><i class="ion-logo-facebook"></i>
					</li>
					<li><i class="ion-logo-twitter"></i>
					</li>
				</ul>
			</div>
		</div>
		<div class="sidenav-icon"><i class="ion-ios-menu"></i>
		</div>
		<section class="section-features js--section-features">
			<div class="row">
				<h2>Reserve your seat now!</h2>
				<p class="long-copy"> Hello, we're ByF, the seat reservation site for planes you've been waiting for. Check the seat map of your flight, select a seat and enjoy your travel in full comfort! </p>
			</div>
			<div class="row js--wp-2">
				<div class="col span-1-of-3 box"> <i class="ion-ios-infinite icon-big"></i>
					<h3>Up to 365 days/year</h3>
					<p> Our service is available every day of the year! Book your favourite seat for every flight, whether you are travelling in summer or for your christmas holidays. Change the way you fly, with extra comfort! </p>
				</div>
				<div class="col span-1-of-3 box"> <i class="ion-ios-airplane icon-big"></i>
					<h3>Available everywhere</h3>
					<p> Choose your seat on every airline and for every flight you want! ByF will allow you to customize your booking just as you desire. Stop sitting just in between the window and the aisle! </p>
				</div>
				<div class="col span-1-of-3 box"> <i class="ion-ios-card icon-big"></i>
					<h3>Unbeatable offers</h3>
					<p> Our seat reservation service online is completely free, but you can check our great premium plans to improve your travel experience. Gain advantages and exclusive early booking offers! </p>
				</div>
			</div>
		</section>
		<section class="section-grid" id="grid">
			<div class="row">
				<h2>Seat Map</h2>
			</div>
			<div class="row">
				<div class="stat-column col span-1-of-8">
					<?php  ?>
					<div class="row">
						<i class="ion-ios-code" style="color: rgb(0,0,255);"></i><p>Total: </p><p class="p-total"></p>
					</div>
					<div class="row">
						<i class="ion-ios-code" style="color: rgb(0,128,0);"></i><p>Free: </p><p class="p-free"></p>
					</div>
					<div class="row">
						<i class="ion-ios-code" style="color: rgb(255,0,0);"></i><p>Booked: </p><p class="p-booked"></p>
					</div>
					<div class="row">
						<i class="ion-ios-code" style="color: rgb(255,165,0);"></i><p>Reserved: </p><p class="p-reserved_other"></p>
					</div>
				</div>
				<div class="col span-7-of-8">
				<table id="stage">
					<tr>
						<td class="cell-col_num"></td>
						<?php
                        $alphas = range('A', 'Z');
                        for ($column=0; $column<=$seats_width-1; $column++): ?>
						<td class="cell-col_num"><?= nl2br(htmlentities($alphas[$column])) ?></td>
						<?php if ($column==2): ?>
						<td class="cell-col_num"></td>
						<?php endif; ?>
						<?php endfor; ?>
					</tr>
					<?php
                    $sql = "SELECT row, col, status FROM seats FOR UPDATE";
                    $seats = $mysqli->query($sql);
                    for ($row=1; $row<=$seats_height; $row++): ?>
					<tr>
						<td class="cell-row_num"><?= nl2br(htmlentities($row)) ?></td>
						<?php for ($column=1; $column<=$seats_width; $column++): ?>
						<?php $booked=false;
                                    $reserved=false; ?>
						<?php foreach ($seats as $seat): ?>
						<?php if ($row==$seat['row'] && $alphas[($column-1)]==$seat['col']): ?>
						<?php if ($seat['status']=='booked'): ?>
						<td class="cell-booked"></td>
						<?php $booked=true; ?>
					<?php else: ?>
						<td class="cell-reserved-other"></td>
						<?php $reserved=true; ?>
					<?php endif; ?>
						<?php endif; ?>
						<?php endforeach; ?>
						<?php if (!$booked && !$reserved): ?>
						<td class="cell"></td>
						<?php endif; ?>
						<?php if ($column==3): ?>
						<td class="cell-row_num"></td>
						<?php endif; ?>
						<?php endfor; ?>
						<td class="cell-row_num"><?= nl2br(htmlentities($row)) ?></td>
					</tr>
					<?php endfor; ?>
				</table>
				</div>
			</div>
		</section>
		<section class="section-steps" id="works">
			<div class="row">
				<h2>How it works &mdash; Just 3 easy steps!</h2>
			</div>
			<div class="row">
				<div class="col span-1-of-2 steps-box"> <img src="resources/img/howto.jpg" alt="ByB Computer Sample" class="app-screen js--wp-3"> </div>
				<div class="col span-1-of-2 steps-box js--wp-4">
					<div class="works-step clearfix">
						<div>1</div>
						<p>Choose the desired seat from plane map, make your decision: window, center or aisle.</p>
					</div>
					<div class="works-step clearfix">
						<div>2</div>
						<p>Check if the selected seat is still available: free seats are displayed in green, reserved seats in orange and already booked ones in red.</p>
					</div>
					<div class="works-step clearfix">
						<div>3</div>
						<p>Make your choice and enjoy your flight!</p>
					</div>
					<a href="#" class="btn-app"><img src="resources/img/download-app.svg" alt="App Store Button"></a> <a href="#" class="btn-app"><img src="resources/img/download-app-android.png" alt="Play Store Button"></a> </div>
			</div>
		</section>
		<section class="section-reviews" id="reviews">
			<div class="row">
				<h2>Our user reviews</h2>
			</div>
			<div class="row js--wp-6">
				<div class="col span-1-of-3">
					<blockquote> ByF is the real deal! Now I will never be forced to sit in the middle seat again! Goodbye boaring view on the wings! Thank you ByF. <cite><img src="resources/img/user1.jpg" alt="customer-1">Angelo Laudani</cite> </blockquote>
				</div>
				<div class="col span-1-of-3">
					<blockquote> I travel almost everyday for work, a service that allows me to reserve my favourite seat on every airplane is just what I needed! The premium package is just awesome! <cite><img src="resources/img/user2.jpg" alt="customer-2">John Smith</cite> </blockquote>
				</div>
				<div class="col span-1-of-3">
					<blockquote> Finally I'm able to easily check all the available seats on my flight! Now I can book them in advance for travelling together with my family, and for a good price! <cite><img src="resources/img/user3.jpg" alt="customer-3">Claire Shepard</cite> </blockquote>
				</div>
			</div>
		</section>
		<section class="section-plans" id="subscribe">
			<div class="row">
				<h2>Subscribe our premium offers</h2>
			</div>
			<div class="row">
				<div class="col span-1-of-3">
					<div class="plan-box js--wp-7">
						<div>
							<h3>Deluxe</h3>
							<p class="plan-price">60&#8364; <span>/ month</span>
							</p>
							<p class="plan-price-description">For the real flight enthusiast.</p>
						</div>
						<div>
							<ul>
								<li><i class="ion-ios-checkmark icon-small"></i>Extra comfort seats</li>
								<li><i class="ion-ios-checkmark icon-small"></i>No additional fees</li>
								<li><i class="ion-ios-checkmark icon-small"></i>Unlimited meals on board</li>
								<li><i class="ion-ios-checkmark icon-small"></i>Unlimited extra luggage</li>
							</ul>
						</div>
						<div> <a href="#" class="btn btn-full">Subscribe now</a> </div>
					</div>
				</div>
				<div class="col span-1-of-3">
					<div class="plan-box">
						<div>
							<h3>Pro</h3>
							<p class="plan-price">30&#8364; <span>/ month</span>
							</p>
							<p class="plan-price-description">Best value for money.</p>
						</div>
						<div>
							<ul>
								<li><i class="ion-ios-checkmark icon-small"></i>Extra comfort seats</li>
								<li><i class="ion-ios-checkmark icon-small"></i>No additional fees</li>
								<li><i class="ion-ios-checkmark icon-small"></i>4 meals on board per month</li>
								<li><i class="ion-ios-checkmark icon-small"></i>2 extra luggages</li>
							</ul>
						</div>
						<div> <a href="#" class="btn btn-ghost">Subscribe now</a> </div>
					</div>
				</div>
				<div class="col span-1-of-3">
					<div class="plan-box">
						<div>
							<h3>Basic</h3>
							<p class="plan-price">15&#8364; <span>/ month</span>
							</p>
							<p class="plan-price-description">The basic bundle.</p>
						</div>
						<div>
							<ul>
								<li><i class="ion-ios-checkmark icon-small"></i>Extra comfort seats</li>
								<li><i class="ion-ios-checkmark icon-small"></i>No additional fees</li>
								<li><i class="ion-ios-close icon-small"></i>Meals on board</li>
								<li><i class="ion-ios-close icon-small"></i>Extra luggage</li>
							</ul>
						</div>
						<div> <a href="#" class="btn btn-ghost">Subscribe now</a> </div>
					</div>
				</div>
			</div>
		</section>
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
	<script>
		$( document ).ready( function () {
      updateStats();
		} );
	</script>
	<script>
  function updateStats() {
    $.get("./php/reservation_controller.php", {dummy: "dummy"}).done(function(data) {
       var stats = jQuery.parseJSON(data);
       var p = document.getElementsByClassName('p-total');
       $(p).empty().append(stats.total_seats);
       var p = document.getElementsByClassName('p-free');
       $(p).empty().append(stats.total_seats - stats.total);
       var p = document.getElementsByClassName('p-booked');
       $(p).empty().append(stats.booked);
       var p = document.getElementsByClassName('p-reserved_other');
       $(p).empty().append(stats.reserved_other);
    });
  }
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

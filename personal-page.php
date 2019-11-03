<?php
require './php/dbcontroller.php';
session_start();
session_regenerate_id();

if (empty($_SESSION[ 'token' ])) {
    $_SESSION[ 'token' ] = bin2hex(random_bytes(32));
}
$token = $_SESSION[ 'token' ];

if ($_SESSION[ 'logged_in' ] != 1) {
    header("location: index.php");
    exit();
} else {
    $a = $_SESSION[ 'username' ];
    $arr = explode("@", $a, 2);
    $username = $arr[ 0 ];
}

if (isset($_SESSION[ 'timestamp' ])) {
    $idletime = 120;
    if (time() - $_SESSION[ 'timestamp' ] > $idletime) {
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 3600 * 24,
                $params[ "path" ],
                $params[ "domain" ],
                $params[ "secure" ],
                $params[ "httponly" ]
            );
        }
        $_SESSION = array();
        session_destroy();
        header("location: login.php");
        exit();
    } else {
        $_SESSION[ 'timestamp' ] = time();
    }
}

?>
<!DOCTYPE html>
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
	<title>ByF - Personal Page</title>
</head>

<body>
	<div class="no-cookies-msg">
		<h2>Your cookies are disabled.<br>Please enable cookies in your browser to access this site.</h2>
		<h3>Thank you, the ByF Team.</h3>
	</div>
	<div class="pagecontainer">
		<header>
			<nav class="sticky">
				<div class="row js--wp-1"> <img src="resources/img/logo-black.png" alt="ByB logo" class="logo-black">
					<ul class="main-nav js--main-nav">
						<li>
							<a href="personal-page.php">
								<?= nl2br(htmlentities($username)) ?>
							</a>
						</li>
						<li><a href="logout.php">Logout</a>
						</li>
						<li><a href="index.php">Home</a>
						</li>
					</ul>
					<a class="mobile-nav-icon js--nav-icon"><i class="ion-ios-list"></i></a> </div>
			</nav>
		</header>
		<div class="sidenav">
			<div class="language-select"> <a href="#"><i class="ion-ios-globe"></i>EN</a> </div>
			<div class="nav">
				<ul class="mini-menu-drop">
					<li class="nav-drop check-grid"><a href="#">Seat Map&nbsp;<i class="ion-ios-add"></i></a>
					</li>
					<li class="nav-drop check-rules"><a href="#">Explanation&nbsp;<i class="ion-ios-add"></i></a>
					</li>
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
		<div class="sidenav-icon sticky-icon"><i class="ion-ios-menu"></i>
		</div>
		<section class="personal-section">
			<div class="personal-grid show">
				<?php
                if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST' || 'GET') {
                    if (!(time() - $_SESSION[ 'timestamp' ] > $idletime)) {
                        if (isset($_POST['submit'])) {
                            require './php/booking_controller.php';
                        }
                    }
                }
                ?>
				<div class="row">
					<h2>Book your Seat</h2>
				</div>
        <div class="msg_row"></div>
				<form method="post">
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
                <i class="ion-ios-code" style="color: rgb(255,165,0);"></i><p>Reserved (others): </p><p class="p-reserved_other"></p>
              </div>
              <div class="row">
                <i class="ion-ios-code" style="color: rgb(255,255,0);"></i><p>Reserved (you): </p><p class="p-reserved_you"></p>
              </div>
            </div>
						<div class="col span-6-of-8">
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
                                $sql = "SELECT user_id, row, col, status FROM seats FOR UPDATE";
                                $seats = $mysqli->query($sql);
                                $my_id = $_SESSION[ 'user_id' ];
                                $submit=0;
                                for ($row=1; $row<=$seats_height; $row++): ?>
								<tr>
									<td class="cell-row_num"><?= nl2br(htmlentities($row)) ?></td>
									<?php for ($column=1; $column<=$seats_width; $column++): ?>
									<?php $booked=false;
                        $reserved=false; ?>
									<?php foreach ($seats as $seat): ?>
									<?php if ($row==$seat['row'] && $alphas[($column-1)]==$seat['col']):
                    if ($seat['status']=='booked'): ?>
									<td class="cell-booked"></td>
                  <?php $booked=true; ?>
                <?php elseif ($seat['status']=='reserved'): ?>
                  <?php if ($seat['user_id']==$my_id): ?>
                  <td class="cell-reserved selected"title="<?php echo nl2br(htmlentities($row)); ?>_<?= nl2br(htmlentities($alphas[($column-1)])) ?>" onclick="gridFunction.removeFields(this, 'cell');">
                  <input type="hidden" name="selected_cell[]" value="<?php echo nl2br(htmlentities($row)); ?>" /><input type="hidden" name="selected_cell[]" value="<?= nl2br(htmlentities($alphas[($column-1)])) ?>" />
                  </td>
                  <?php $submit++; ?>
                <?php else: ?>
                  <td class="cell-reserved-other selected"title="<?php echo nl2br(htmlentities($row)); ?>_<?= nl2br(htmlentities($alphas[($column-1)])) ?>" onclick="gridFunction.addFields(this, 'cell');"></td>
                <?php endif; ?>
                  <?php $reserved=true; ?>
                  <?php endif; ?>
									<?php endif; ?>
									<?php endforeach; ?>
									<?php if (!$booked && !$reserved): ?>
									<td class="cell" title="<?php echo nl2br(htmlentities($row)); ?>_<?= nl2br(htmlentities($alphas[($column-1)])) ?>" onclick="gridFunction.addFields(this, 'cell');"></td>
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
						<div class="btn-column col span-1-of-8">
							<div class="row submit-row">
                <?php if ($submit != 0): ?>
                <input type="submit" name="submit" value="Book">
              <?php else: ?>
								<div class="btn-null-submit">Book</div>
              <?php endif; ?>
							</div>
							<div class="row">
								<div class="btn btn-full" onClick="window.location.reload();">Update</div>
							</div>
						</div>
					</div>
					<input type="hidden" name="token" value="<?php echo $token; ?>">
				</form>
			</div>
			<div class="personal-rules hide">
				<div class="row">
					<h2>How it Works</h2>
				</div>
				<div class="rules-box">
					<div class="row">
						<i class="ion-ios-checkmark icon-big"></i>
						<p>Click on a green seat to reserve it. Your reservation will be shown in yellow.</p>
					</div>
					<div class="row">
						<i class="ion-ios-checkmark icon-big"></i>
						<p>Reservations made by other users are displayed in orange.</p>
					</div>
					<div class="row">
						<i class="ion-ios-checkmark icon-big"></i>
						<p>You can click on orange reservations, as long they are not confirmed, to reserve the seat yourself.</p>
					</div>
					<div class="row">
						<i class="ion-ios-checkmark icon-big"></i>
						<p>Click on "Book" button to confirm your booking. If you are the owner of all the reserved seats, they will be booked and shown in red.</p>
					</div>
					<div class="row">
						<i class="ion-ios-checkmark icon-big"></i>
						<p>Click on "Update" to reload the seat map.</p>
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
	<script src="vendors/js/tooltipster.bundle.min.js"></script>
	<script>
		$( document ).ready( function () {
			$( '.tooltip-description' ).tooltipster( {
				theme: 'tooltipster-light',
				touchDevices: true
			} );
      var msg = document.getElementsByClassName('php-message');
      setTimeout(function(){ $(msg).empty().hide() }, 2000);
      updateStats();
		} );
	</script>
	<script>
  var gridFunction = (function() {

    var x, y;

    return {

      addFields: function(obj, abc) {
        var title_var = obj.title;
        var coordinate = title_var.split('_');
        x = parseInt(coordinate[0]);
        y = escape(coordinate[1]);

        $(obj).addClass("selected");
        $(obj).css('background-color', '#FFFF00');
        $(obj).append('<input type="hidden" name="selected_cell[]" value="' + x + '" /><input type="hidden" name="selected_cell[]" value="' + y + '" />');
        $(obj).attr("onclick", "gridFunction.removeFields(this, 'cell')");

        var is_selected = document.getElementsByClassName('selected');
        if (is_selected.length != 0) {
          var submit = document.getElementsByClassName('submit-row');
          $(submit).empty();
          $(submit).append('<input type="submit" name="submit" value="Book">');
        }

        $.post("./php/reservation_controller.php", {
          row: x,
          col: y
        }).done(function(data) {
          var data = jQuery.parseJSON(data);
          var msg = document.getElementsByClassName('msg_row');
          if (data.response) {
            $(msg).append(data.response);
            setTimeout(function() {
              $(msg).empty()
            }, 2500);
          }
          if (data.exception) {
            $(obj).each(function() {
              while (this.attributes.length > 0)
                this.removeAttribute(this.attributes[0].name);
            });
            $(obj).addClass("cell-booked");
            $(obj).empty();
            $(msg).append(data.exception);
            setTimeout(function() {
              $(msg).empty()
            }, 2500);
          }
          if (data.redirect) {
            window.location.href = data.redirect;
          }
          updateStats();
        });

        return;
      },

      removeFields: function(obj, abc) {
        var title_var = obj.title;
        var coordinate = title_var.split('_');
        x = parseInt(coordinate[0]);
        y = escape(coordinate[1]);

        $(obj).removeClass("selected");
        $(obj).css('background-color', '#008000');
        $(obj).empty();
        $(obj).attr("onclick", "gridFunction.addFields(this, 'cell')");

        var is_selected = document.getElementsByClassName('selected');
        if (is_selected.length == 0) {
          var submit = document.getElementsByClassName('submit-row');
          $(submit).empty();
          $(submit).append('<div class="btn-null-submit">Book</div>');
        }
        $.post("./php/reservation_controller.php", {
          row: x,
          col: y
        }).done(function(data) {
          var data = jQuery.parseJSON(data);
          var msg = document.getElementsByClassName('msg_row');
          if (data.response) {
            $(msg).append(data.response);
            setTimeout(function() {
              $(msg).empty()
            }, 2500);
          }
          if (data.redirect) {
            window.location.href = data.redirect;
          }
          updateStats();
        });

        return;
      }
    }
  })();
	</script>
  <script>
  function updateStats() {
    $.get("./php/reservation_controller.php").done(function(data) {
      var stats = jQuery.parseJSON(data);
      var p = document.getElementsByClassName('p-total');
      $(p).empty().append(stats.total_seats);
      var p = document.getElementsByClassName('p-free');
      $(p).empty().append(stats.total_seats - stats.total);
      var p = document.getElementsByClassName('p-booked');
      $(p).empty().append(stats.booked);
      var p = document.getElementsByClassName('p-reserved_other');
      $(p).empty().append(stats.reserved_other);
      var p = document.getElementsByClassName('p-reserved_you');
      $(p).empty().append(stats.reserved_you);
    });
  }
  </script>
  <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
	<noscript>
		<style type="text/css">
			.pagecontainer {
				display: none;
			}
		</style>
		<div class="no-javascript-msg-personal">
			<h2>Javascript disabled.<br>Please enable Javascript to properly use ByF.</h2>
			<h3>Thank you, the ByF Team.</h3>
		</div>
	</noscript>
</body>
</html>

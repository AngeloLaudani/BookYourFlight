<?php
$servername = "localhost";
$username = "s253177";
$password = "cmicathr";
$dbname = "s253177";

$GLOBALS['seats_width'] = 6;
$GLOBALS['seats_height'] = 10;
$total_seats = $GLOBALS['seats_width']*$GLOBALS['seats_height'];

// Create connection
$mysqli = mysqli_connect($servername, $username, $password, $dbname);
mysqli_set_charset($mysqli,"utf8");
// Check connection
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_errno());
}
?>

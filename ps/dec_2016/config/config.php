<?php
$db_hostname = "localhost";
$db_username = "ps";
#$db_password = "maxe!(%^GSM6591";
$db_password = "PS12345678900987654321PS";


$em = 11;
$ey = 2016;

if($em=='5') {
	
	$db="exam_may_".$ey;
	$exam_session = "May, ".$ey;
}
else {
	$db="exam_dec_".$ey;
	$exam_session = "November, ".$ey;
}
$conn = mysql_connect($db_hostname,$db_username,$db_password) or die("Could not connect: " . mysql_error());
$mysqli_conn = mysqli_connect($db_hostname,$db_username,$db_password, $db) or die("Connection failed: " . mysqli_connect_error());

mysql_select_db($db,$conn);


?>

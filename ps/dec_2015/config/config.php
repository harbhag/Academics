<?php
$db_hostname = "localhost";
$db_username = "ps";
#$db_password = "maxe!(%^GSM6591";
$db_password = "PS12345678900987654321PS";


$conn = mysql_connect($db_hostname,$db_username,$db_password) or die("Could not connect: " . mysql_error());

mysql_select_db("exam_dec_2015",$conn);

$exam_session = 'November, 2015';
?>

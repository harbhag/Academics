<?php
$db_hostname = "localhost";
$db_username = "ps";
#$db_password = "maxe!(%^GSM6591";
$db_password = "PS12345678900987654321";


$conn = mysql_connect($db_hostname,$db_username,$db_password) or die("Could not connect: " . mysql_error());

mysql_select_db("demo_exam",$conn);

$exam_session = 'Nov.-Dec., 2014';
?>

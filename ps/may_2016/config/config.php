<?php
$db_hostname = "localhost";
$db_username = "ps";
$db_password = "PS12345678900987654321PS";


$conn = mysql_connect($db_hostname,$db_username,$db_password) or die("Could not connect: " . mysql_error());

mysql_select_db("exam_may_2016",$conn);

$exam_session = 'May, 2016';
?>

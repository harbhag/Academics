<?php
$sup_details_sql = mysql_query("SELECT * FROM users where username='".$_SESSION['username']."' AND usertype='superintendent'") or die(mysql_error());

$sup_details = mysql_fetch_assoc($sup_details_sql);


if(date('n') == 3 || date('n') == 4 || date('n') == 5 || date('n') == 6 || date('n') == 7) 
{
	$month='5';
}

if( date('n') == 8 || date('n') == 9 || date('n') == 10 || date('n') == 11 || date('n') == 12 || date('n') == 1) 
{
	$month='11';
}


$year = date('Y');

$dup = mysql_query("SELECT * FROM exam_centre_duties WHERE 
duty_uploaded_by='".$_SESSION['username']."' AND 
date_of_exam='".date("Y-m-d")."'") or die(mysql_error());

if(mysql_num_rows($dup)!=0) {
	mysql_query("UPDATE exam_centre_duties SET backup='1' WHERE
	duty_uploaded_by='".$_SESSION['username']."' AND
	date_of_exam='".date("Y-m-d")."' AND
	backup=0") or die(mysql_error());
}

for($i=1;$i<=$_POST['total_count']-1;$i++) {
	
	$un = "username".$i;
	$n = "staffname".$i;
	$ds = "duty_status".$i;
	$r = "remarks".$i;
	$rm = "room_no".$i;
	
	$staff_details_sql = mysql_query("SELECT * FROM users WHERE
	ucentre='".$sup_details['ucentre']."' AND
	usession='".$sup_details['usession']."' AND
	username='".$_POST[$un]."'
	") or die(mysql_error());
	$staff_details = mysql_fetch_assoc($staff_details_sql);
	
	mysql_query("INSERT INTO  `exam_centre_duties` (
	`username` ,
	`name` ,
	`appointment_type` ,
	`department` ,
	`duty_type` ,
	`date_of_exam` ,
	`usession` ,
	`ucentre` ,
	`room_no` ,
	`duty_status` ,
	`duty_uploaded_by` ,
	`exam_month` ,
	`exam_year`,
	`remarks`
	)
	VALUES (
	'".$_POST[$un]."',  
	'".$staff_details['name']."',  
	'".$staff_details['appointment_type']."',  
	'".$staff_details['department']."',  
	'".$staff_details['duty_type']."',  
	'".date('Y-m-d')."',  
	'".$staff_details['usession']."',  
	'".$staff_details['ucentre']."',  
	'".$_POST[$rm]."',  
	'".$_POST[$ds]."',  
	'".$_SESSION['username']."',  
	'".$month."',  
	'".$year."',
	'".$_POST[$r]."'
	)"
	) or die(mysql_error());
}

show_label('success','Attendance Successfully Marked for '.date('d-m-Y').' !');
echo "<br/>";
?>
<center>
<form action='' method='post'>
<input type='hidden' name='sup_lock_staff_attendance' value='' />
<input type='submit' class='btn btn-small btn-danger' value='Click Here To LOCK Attendance' onclick="return confirm_action('Do you want to Lock attendace? Updations are not allowed once locked.')"/>
</form>
</center>

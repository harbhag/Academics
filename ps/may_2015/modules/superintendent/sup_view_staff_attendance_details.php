<?php

$dates_sql = mysql_query("SELECT DISTINCT DATE_FORMAT(date_of_exam, '%d-%M-%Y') AS date_of_exam FROM exam_centre_duties 
WHERE 
duty_uploaded_by='".$_SESSION['username']."' AND 
backup='0' AND 
locked='1'") or die(mysql_error());

echo "
<table class='table table-bordered table-condensed '>
	<tr>
		<th style='background-color:#D9EDF7'>Sr. No.</th>
		<th style='background-color:#D9EDF7'>Name</th>
		<th style='background-color:#D9EDF7'>Department</th>
		<th style='background-color:#D9EDF7'>Appointment Type</th>
		<th style='background-color:#D9EDF7'>Duty Type</th>";
		
		
		while($d = mysql_fetch_assoc($dates_sql)) {
			echo 
			"<th style='background-color:#D9EDF7'>".$d['date_of_exam']."</th>";
		}
		
		echo "
		<th style='background-color:#D9EDF7'>Total Duties</th>
		</tr>";


$count = 1;


$staff = mysql_query("SELECT DISTINCT username,name,department,appointment_type,duty_type FROM exam_centre_duties WHERE 
duty_uploaded_by='".$_SESSION['username']."' AND 
backup='0' AND 
locked='1' ORDER BY duty_type,department,appointment_type") or die(mysql_error());

$dates_sql = mysql_query("SELECT DISTINCT date_of_exam FROM exam_centre_duties 
WHERE 
duty_uploaded_by='".$_SESSION['username']."' AND 
backup='0' AND 
locked='1'") or die(mysql_error());

$dates_array = array();

while($d = mysql_fetch_assoc($dates_sql)) {
	$dates_array[] = $d['date_of_exam'];
}


while($s = mysql_fetch_assoc($staff)) {	
$total_duties = 0;	
	echo"
	<tr>
	<td>".$count."</td>
	<td>".$s['name']."</td>
	<td>".$s['department']."</td>
	<td>".$s['appointment_type']."</td>
	<td>".$s['duty_type']."</td>";
	foreach($dates_array as $d) {
		$duty_status_sql = mysql_query("SELECT duty_status FROM exam_centre_duties WHERE
		duty_uploaded_by='".$_SESSION['username']."' AND 
		username='".$s['username']."' AND 
		name='".$s['name']."' AND 
		department='".$s['department']."' AND 
		appointment_type='".$s['appointment_type']."' AND 
		duty_type='".$s['duty_type']."' AND 
		date_of_exam='".$d."' AND 
		backup='0' AND 
		locked='1'") or die(mysql_error());
		
		$duty_status = mysql_fetch_assoc($duty_status_sql);
		
		if($duty_status['duty_status']=='P') {
			$total_duties++;
			//$ds = "<span style='color:green;font-weight:bold'>P(".$duty_status['room_no'].")</span>";
			$ds = "<span style='color:green;font-weight:bold'>P</span>";
		}
		else {
			//$ds = "<span style='color:red;font-weight:bold'>N/A(".$duty_status['room_no'].")</span>";
			$ds = "<span style='color:red;font-weight:bold'>N/A</span>";
		}
		echo 
		"<td>".$ds."</td>";
	}
	echo 
	"<td><span style='color:blue;font-weight:bold'>".$total_duties."</span></td>";
	$count++;
}

echo "
</table>";


?>

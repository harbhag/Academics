<?php

$sup_details_sql = mysql_query("SELECT * FROM users where username='".$_SESSION['username']."' AND usertype='superintendent'") or die(mysql_error());

$sup_details = mysql_fetch_assoc($sup_details_sql);



$staff_details = mysql_query("SELECT * FROM users WHERE
ucentre='".$sup_details['ucentre']."' AND
usession='".$sup_details['usession']."' AND
appointment_type!=''") or die(mysql_error());

$dy_sup_sql = mysql_query("SELECT * FROM users WHERE
ucentre='".$sup_details['ucentre']."' AND
usession='".$sup_details['usession']."' AND
duty_type='Deputy Superintendent'") or die(mysql_error());

$dy_sup = mysql_fetch_assoc($dy_sup_sql);

$lock = mysql_query("SELECT * FROM exam_centre_duties WHERE 
duty_uploaded_by='".$_SESSION['username']."' AND 
date_of_exam='".date('Y-m-d')."' AND
locked='1'") or die(mysql_error());

$chk = mysql_query("SELECT * FROM exam_centre_duties WHERE 
duty_uploaded_by='".$_SESSION['username']."' AND 
date_of_exam='".date('Y-m-d')."' AND
backup='0'") or die(mysql_error());

$dt = date('d-m-Y');


echo "
<table class='table table-bordered table-condensed container'>
	<tr>
		<th style='background-color:#D9EDF7'>Date of Exam (DD-MM-YYYY)</th>
		<th style='background-color:#D9EDF7'>Centre No.</th>
		<th style='background-color:#D9EDF7'>Session</th>
		<th style='background-color:#D9EDF7'>Superintendent</th>
		<th style='background-color:#D9EDF7'>Deputy Superintendent</th>
		<th style='background-color:#D9EDF7'>Lock Attendance</th>
		<th style='background-color:#D9EDF7'>View Details</th>
		
	</tr>
	
	<tr>
	<td>".date('d-m-Y')."</td>
	<td>".$sup_details['ucentre']."</td>
	<td>".$sup_details['usession']."</td>
	<td>".$sup_details['name']."</td>
	<td>".$dy_sup['name']."</td>";
	
	if(mysql_num_rows($chk)==0) {
		
		echo "<td>
			<form action='' method='post'>
			<input type='hidden' name='sup_lock_staff_attendance' value='' />
			<input type='submit' disabled='disabled' class='btn btn-mini btn-danger btn-disabled' value='Attendance Not Marked for $dt' onclick='return confirm_action(\"Do you want to Lock attendace? Updations are not allowed once locked.\")'/>
			</form>
			</td>";
		
	}
	else {
		if(mysql_num_rows($lock)!=0) {
			
			echo "<td>
			<form action='' method='post'>
			<input type='hidden' name='sup_lock_staff_attendance' value='' />
			<input type='submit' disabled='disabled' class='btn btn-mini btn-danger btn-disabled' value='Attendance Already LOCKED for $dt' onclick='return confirm_action(\"Do you want to Lock attendace? Updations are not allowed once locked.\")'/>
			</form>
			</td>";
			
		}
		else {
			echo "<td>
			<form action='' method='post'>
			<input type='hidden' name='sup_lock_staff_attendance' value='' />
			<input type='submit' class='btn btn-mini btn-danger' value='LOCK Attendance for $dt' onclick='return confirm_action(\"Do you want to Lock attendace? Updations are not allowed once locked.\")'/>
			</form>
			</td>";
		}
	}
	
	echo"<td>
	
			<form action='' method='post'>
			<input type='hidden' name='sup_view_staff_attendance_details' value='' />
			<input type='submit' class='btn btn-mini btn-danger' value='View Details'/>
			</form>
	</td>
	</tr>
</table>";



if(mysql_num_rows($lock)!=0) {
	show_label('important','Attendance Already LOCKED for '.date('d-m-Y').' !');
	exit();
}

?>

<form action='' method='post'/>
<table class='table table-bordered table-condensed container striped sortable table-hover'>
	<tr>
		<th>Sr. No.</th>
		<th>Name</th>
		<th>Department</th>
		<th>Appointment Type</th>
		<th>Duty Type</th>
		<th>Duty Status</th>
		<th>Room No.</th>
		<!--<th>Remarks</th>-->
	</tr>

<?php
$count = 1;
while($row = mysql_fetch_assoc($staff_details)) {
	
	$prev_att_sql = mysql_query("SELECT * FROM exam_centre_duties 
	WHERE 
	duty_uploaded_by='".$_SESSION['username']."' AND
	date_of_exam='".date('Y-m-d')."' AND
	username='".$row['username']."' AND
	name='".$row['name']."' AND
	backup='0'") or die(mysql_error());
	
		
		echo "<tr class='warning'>
			<td>".$count."</td>
			<td>".strtoupper($row['name'])."</td>
			<input type='hidden' name='username$count' value='".$row['username']."' />
			<input type='hidden' name='staffname$count' value='".$row['name']."' />
			
			<td>".$row['department']."</td>
			<td>".$row['appointment_type']."</td>
			<td>".$row['duty_type']."</td>";
			
			if(mysql_num_rows($prev_att_sql)==1) {
				$prev_att = mysql_fetch_assoc($prev_att_sql);
				
				if($prev_att['duty_status']=='P') {
					$ds = "Present";
				}
				else {
					$ds = "N/A";
				}
				
				echo "<td>
				<select name='duty_status$count'>
				<option selected='selected' value='".$prev_att['duty_status']."'>".$ds."</option>
				<option value='NA'>N/A</option>
				<option value='P'>Present</option>
				</select>
				
				</td>";
				
			}
			else {
				
				echo "<td>
				<select name='duty_status$count'>
				<option value='NA'>N/A</option>
				<option value='P'>Present</option>
				</select>
				
				</td>";
				
			}
			
			$rooms = mysql_query("SELECT DISTINCT room_no FROM exam_centre_rooms WHERE ucentre='".$sup_details['ucentre']."'") or die(mysql_error());
			
			if(mysql_num_rows($prev_att_sql)==1) {
				
				echo "<td>
				<select name='room_no$count'>
				<option selected='selected' value='".$prev_att['room_no']."'>".$prev_att['room_no']."</option>";
				while($row=mysql_fetch_assoc($rooms)) {
					echo "
					<option value='".$row['room_no']."'>".$row['room_no']."</option>
					";
				}
				echo"
				</select>
				
				</td>";
			}
			else {
				echo "<td>
				<select name='room_no$count'>";
				while($row=mysql_fetch_assoc($rooms)) {
					echo "
					<option value='".$row['room_no']."'>".$row['room_no']."</option>
					";
				}
				echo"
				</select>
				
				</td>";
			}
			
			
			
			if(mysql_num_rows($prev_att_sql)==1) {
				//echo "<td>
			//<input type='text' name='remarks$count' value='".$prev_att['remarks']."'>
			
			//</td>";
			}
			else {
				//echo "<td>
				//<input type='text' name='remarks$count'>
				
				//</td>";
			}
			
			
			
			$count++;
		
}
?>
</table>
<input type='hidden' name='total_count' value='<?php echo $count; ?>' />
<input type='hidden' name='sup_mark_staff_attendance' value='' />
<input type='submit' class='btn btn-block btn-danger' value='Click Here To Mark Attendance' onclick="return confirm_action('Do you want to continue')"/>
</form>

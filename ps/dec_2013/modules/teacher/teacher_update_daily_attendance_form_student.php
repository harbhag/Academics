<?php
//exit();

$allowd_ip = mysql_query("SELECT ip_address FROM ip_address WHERE ip_address='".$_SERVER['REMOTE_ADDR']."' AND module_name='daily_attendance' AND allowed='Y'") or die(mysql_error());


if(mysql_num_rows($allowd_ip)!=1) {
	show_label('important','You are not allowed to update attendance from this network.');
	exit();
}
?>

<form action='' method='post'/>
<table class='table table-bordered table-condensed container sortable'>
	<tr>
		<th>Sr. No.</th>
		<th>University Roll No.</th>
		<th>College Roll No.</th>
		<th>Student Name</th>
		
		<th>Subject Code</th>
		<th>Subject Title</th>
		<th>Semester</th>
		<th>Date/Period</th>
		<th>Mark Attendance</th>
		<!--<th>Remarks</th>-->
	</tr>
<?php



$roll_nos = fetch_resource_db_att_daily('daily_attendance_student',
		array('course_code',
		'attendance_date',
		'attendance_period',
		'teacher_username',
		'branch_code',
		'shift',
		'ssection',
		'sgroup',
		'semester',
		'aicte_rc',
		'full_part_time',
		'backup'),
		array($_POST['course_code'],
		$_POST['attendance_date'],
		$_POST['attendance_period'],
		$_SESSION['username'],
		$_POST['branch_code'],
		$_POST['shift'],
		$_POST['ssection'],
		$_POST['sgroup'],
		$_POST['semester'],
		$_POST['aicte_rc'],
		$_POST['full_part_time'],
		'0'),
		'resource','');
	



$count = 1;
//echo mysql_num_rows($roll_nos);
//echo $_POST['regular_reappear'];
/*echo $_POST['branch_code'];
echo $_POST['subject_title'];
echo $_POST['theory_practical'];
echo $_POST['regular_reappear'];
echo mysql_num_rows($roll_nos);*/
while($row = mysql_fetch_assoc($roll_nos)) {
	
	$sfname = fetch_resource_db('student_info',array('university_roll_no'),array($row['university_roll_no']),'resource_array_value','ptu_student_name');
	
	$college_roll_no = fetch_resource_db('student_info',array('university_roll_no'),array($row['university_roll_no']),'resource_array_value','college_roll_no');
		
		echo "<tr class='warning'>
			<td>".$count."</td>
			<td>".$row['university_roll_no']."</td>
			<td>".$college_roll_no."</td>
			<input type='hidden' name='university_roll_no$count' value='".$row['university_roll_no']."' />
			<input type='hidden' name='autoid$count' value='".$row['autoid']."' />
			<input type='hidden' name='revision$count' value='".$row['revision']."' />
			<input type='hidden' name='p_attendance$count' value='".$row['attendance']."' />
			<td>".strtoupper($sfname)."</td>
			
			<td>".$_POST['subject_code']."</td>
			<td>".$_POST['subject_title']."</td>
			<td>".$_POST['semester']."</td>
			<td>".$_POST['attendance_date']." / ".$_POST['attendance_period']."</td>
			<td>
			<select name='attendance$count' id='attendance$count'>
			<option value='".$row['attendance']."' selected='selected'>".$row['attendance']."</option>
			<option value='Present'>Present</option>
			<option value='Absent'>Absent</option>
			</select></td>
			
			<!--<td><input class='input-small' size='16' value='".$row['remarks']."' type='text' name='remarks$count'></td>-->
			</tr>";
			$count++;
		
}
?>
</table>
<input type='hidden' name='teacher_update_daily_attendance' value='<?php echo $count; ?>' />
<input type='hidden' name='total_count' value='<?php echo $count; ?>' />
<input type='hidden' name='exam_month' value='<?php echo $_POST['exam_month']; ?>' />
<input type='hidden' name='exam_year' value='<?php echo $_POST['exam_year']; ?>' />
<input type='submit' class='btn btn-block btn-danger' value='Click Here To Mark Attendance' onclick="return attendance_details('<?php echo $count; ?>')"/>
</form>


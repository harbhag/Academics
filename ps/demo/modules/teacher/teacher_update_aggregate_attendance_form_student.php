<?php

show_label('info','Mark Attendance');
echo "<br/>";

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
		<th>Total Lectures</th>
		<th>Attended Lectures</th>
		<th>Attendance Marks</th>
		<!--<th>Remarks</th>-->
	</tr>
<?php



if($_POST['theory_practical']=='T') {
			
		$roll_nos = mysql_query("SELECT * FROM aggregate_attendance_student WHERE
		course_code='".$_POST['course_code']."' AND
		branch_code='".$_POST['branch_code']."' AND
		shift='".$_POST['shift']."' AND
		ssection='".$_POST['ssection']."' AND
		semester='".$_POST['semester']."' AND
		start_date='".$_POST['start_date']."' AND
		end_date='".$_POST['end_date']."' AND
		subject_code='".$_POST['subject_code']."' AND
		
		aicte_rc='".$_POST['aicte_rc']."' AND
		full_part_time='".$_POST['full_part_time']."' AND
		backup='0' 
		
		ORDER BY university_roll_no ASC") or die(mysql_error());
		
}

if($_POST['theory_practical']=='P') {
	$roll_nos = mysql_query("SELECT * FROM aggregate_attendance_student WHERE
		course_code='".$_POST['course_code']."' AND
		branch_code='".$_POST['branch_code']."' AND
		shift='".$_POST['shift']."' AND
		ssection='".$_POST['ssection']."' AND
		sgroup='".$_POST['sgroup']."' AND
		semester='".$_POST['semester']."' AND
		start_date='".$_POST['start_date']."' AND
		end_date='".$_POST['end_date']."' AND
		subject_code='".$_POST['subject_code']."' AND
		aicte_rc='".$_POST['aicte_rc']."' AND
		full_part_time='".$_POST['full_part_time']."' AND
		backup='0' 
		
		ORDER BY university_roll_no ASC") or die(mysql_error());
		
}	



$count = 1;
//echo mysql_num_rows($roll_nos);
//echo $_POST['regular_reappear'];
/*echo $_POST['branch_code'];
echo $_POST['subject_title'];
echo $_POST['theory_practical'];
echo $_POST['regular_reappear'];
echo mysql_num_rows($roll_nos);*/
while($row = mysql_fetch_assoc($roll_nos)) {
	
	$studentName = fetch_resource_db('student_info',array('university_roll_no'),array($row['university_roll_no']),'resource_array_value','ptu_student_name');
	$sfname = fetch_resource_db('student_info',array('university_roll_no'),array($row['university_roll_no']),'resource_array_value','sfname');
	$smname = fetch_resource_db('student_info',array('university_roll_no'),array($row['university_roll_no']),'resource_array_value','smname');
	$ssname = fetch_resource_db('student_info',array('university_roll_no'),array($row['university_roll_no']),'resource_array_value','ssname');
	$college_roll_no = fetch_resource_db('student_info',array('university_roll_no'),array($row['university_roll_no']),'resource_array_value','college_roll_no');
		
		echo "<tr class='warning'>
			<td>".$count."</td>
			<td>".$row['university_roll_no']."</td>
			<td>".$college_roll_no."</td>
			<input type='hidden' name='university_roll_no$count' value='".$row['university_roll_no']."' />
			<input type='hidden' name='college_roll_no$count' value='".$row['college_roll_no']."' />
			<input type='hidden' name='autoid$count' value='".$row['autoid']."' />
			<input type='hidden' name='revision$count' value='".$row['revision']."' />
			<td>".strtoupper($studentName)."</td>
			
			<td>".$_POST['subject_code']."</td>
			<td>".$_POST['subject_title']."</td>
			<td>".$_POST['semester']."</td>
			<td>".$_POST['total_lectures']."</td>
			<td><input class='input-small' size='16' value='".$row['attended_lectures']."' type='text' autocomplete='off' id='attended_lectures$count' name='attended_lectures$count'></td>
			<input class='input-small' size='16' value='".$row['attended_lectures']."' type='hidden' id='p_attended_lectures$count' name='p_attended_lectures$count'>
			<script>
							var attended_lectures$count = new LiveValidation('attended_lectures$count',{ validMessage: 'ok', wait: 500});
							attended_lectures$count.add(Validate.Presence,{failureMessage:'X'});
							attended_lectures$count.add(Validate.Numericality,{ onlyInteger: true,minimum:0,maximum:".$_POST['total_lectures']."},{ onlyInteger: true });
							attended_lectures$count.add(Validate.Format,{pattern: /^[0-9]+$/, failureMessage:'X'});
			</script>
			
			<td><input class='input-small' size='16' value='".$row['attendance_marks']."' type='text' id='attendance_marks$count' name='attendance_marks$count'></td>
			<input class='input-small' size='16' value='".$row['attendance_marks']."' type='hidden' autocomplete='off'  id='p_attendance_marks$count' name='p_attendance_marks$count'>
			<script>
							var attendance_marks$count = new LiveValidation('attendance_marks$count',{ validMessage: 'ok', wait: 500});
							attendance_marks$count.add(Validate.Presence,{failureMessage:'X'});
							attendance_marks$count.add(Validate.Numericality,{ onlyInteger: true,minimum:0,maximum:6},{ onlyInteger: true });
							attendance_marks$count.add(Validate.Format,{pattern: /^[0-9]+$/, failureMessage:'X'});
			</script>
			</td>
			
			<!--<td><input class='input-small' size='16' value='".$row['remarks']."' type='text' name='remarks$count'></td>-->
			</tr>";
			$count++;
		
}
?>
</table>
<input type='hidden' name='teacher_update_aggregate_attendance' value='<?php echo $count; ?>' />
<input type='hidden' name='exam_month' value='<?php echo $_POST['exam_month']; ?>' />
<input type='hidden' name='exam_year' value='<?php echo $_POST['exam_year']; ?>' />
<input type='hidden' name='total_count' value='<?php echo $count; ?>' />
<input type='hidden' name='id' value='<?php echo $_POST['autoid']; ?>' />
<input type='submit' class='btn btn-block btn-danger' value='Click Here To Update Attendance' onclick="return confirm_action('Do you want to continue ?')"/>
</form>


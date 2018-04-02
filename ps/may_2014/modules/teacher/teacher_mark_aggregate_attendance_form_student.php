<?php

show_label('info','Aggregate Attendance');
echo "<br/>";

$_POST['start_date']="2013-08-02";
$_POST['end_date']="2013-11-14";

if($_POST['theory_practical']=='T') {
	
		$dup = mysql_query("SELECT * FROM aggregate_attendance_student WHERE
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
		teacher_username='".$_SESSION['username']."' AND
		full_part_time='".$_POST['full_part_time']."'") or die(mysql_error());
		
}

if($_POST['theory_practical']=='P') {
	$dup = mysql_query("SELECT * FROM aggregate_attendance_student WHERE
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
		teacher_username='".$_SESSION['username']."' AND
		full_part_time='".$_POST['full_part_time']."'") or die(mysql_error());
		
}

if(mysql_num_rows($dup)!=0) {
	show_label('warning','Attendance already marked. Check "Aggregate Attendance Record" to update the attendance');
	exit();
}
?>


<form action='' method='post'/>
<table class='table table-bordered table-condensed container'>
	<tr>
		<th>Sr. No.</th>
		<th>University Roll No.</th>
		<th>College Roll No.</th>
		<th>Student Name</th>
		
		<th>Subject Code</th>
		<th>Subject Title</th>
		<th>Semester</th>
		<!--<th>Date/Period</th>-->
		<th>Total Lectures</th>
		<th>Attended Lectures</th>
		<th>Attendance Marks</th>
		<!--<th>Remarks</th>-->
	</tr>
<?php

if($_POST['theory_practical']=='P') {
	
	if($_POST['semester']==1 or $_POST['semester']==2) {
		$roll_nos = mysql_query("SELECT * FROM student_info WHERE
		course_code = '".$_POST['course_code']."' AND
		branch_code = '".$_POST['branch_code']."' AND
		shift = '".$_POST['shift']."' AND
		ssection = '".$_POST['ssection']."' AND
		sgroup = '".$_POST['sgroup']."' AND
		semester = '".$_POST['semester']."' AND
		aicte_rc = '".$_POST['aicte_rc']."' AND
		full_part_time = '".$_POST['full_part_time']."' AND
		student_status='Onroll'

		ORDER BY college_roll_no ASC") or die(mysql_error());
	}
	
	else{

		$roll_nos = mysql_query("SELECT * FROM student_info WHERE
		course_code = '".$_POST['course_code']."' AND
		branch_code = '".$_POST['branch_code']."' AND
		shift = '".$_POST['shift']."' AND
		ssection = '".$_POST['ssection']."' AND
		sgroup = '".$_POST['sgroup']."' AND
		semester = '".$_POST['semester']."' AND
		aicte_rc = '".$_POST['aicte_rc']."' AND
		full_part_time = '".$_POST['full_part_time']."' AND
		student_status='Onroll'

		ORDER BY university_roll_no ASC") or die(mysql_error());
	}

}

if($_POST['theory_practical']=='T') {
	
	if($_POST['semester']==1 or $_POST['semester']==2) {
		$roll_nos = mysql_query("SELECT * FROM student_info WHERE
		course_code = '".$_POST['course_code']."' AND
		branch_code = '".$_POST['branch_code']."' AND
		shift = '".$_POST['shift']."' AND
		ssection = '".$_POST['ssection']."' AND
		semester = '".$_POST['semester']."' AND
		aicte_rc = '".$_POST['aicte_rc']."' AND
		full_part_time = '".$_POST['full_part_time']."' AND
		student_status='Onroll'

		ORDER BY college_roll_no ASC") or die(mysql_error());
	}
	else {
		$roll_nos = mysql_query("SELECT * FROM student_info WHERE
		course_code = '".$_POST['course_code']."' AND
		branch_code = '".$_POST['branch_code']."' AND
		shift = '".$_POST['shift']."' AND
		ssection = '".$_POST['ssection']."' AND
		semester = '".$_POST['semester']."' AND
		aicte_rc = '".$_POST['aicte_rc']."' AND
		full_part_time = '".$_POST['full_part_time']."' AND
		student_status='Onroll'

		ORDER BY university_roll_no ASC") or die(mysql_error());
	}
	
	
	

	
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
		
		echo "<tr class='warning'>
			<td>".$count."</td>
			<td>".$row['university_roll_no']."</td>
			<td>".$row['college_roll_no']."</td>
			<input type='hidden' name='university_roll_no$count' value='".$row['university_roll_no']."' />
			<input type='hidden' name='college_roll_no$count' value='".$row['college_roll_no']."' />
			<td>".strtoupper($row['ptu_student_name'])."</td>
			
			<td>".$_POST['subject_code']."</td>
			<td>".$_POST['subject_title']."</td>
			<td>".$_POST['semester']."</td>
			<!--<td>".$_POST['attendance_date']." / ".$_POST['attendance_date']."</td>-->
			<td>".$_POST['total_lectures']."</td>
			<td><input class='input-small' size='16' type='text' id='attended_lectures$count' autocomplete='off' name='attended_lectures$count'>
			<script>
							var attended_lectures$count = new LiveValidation('attended_lectures$count',{ validMessage: 'ok', wait: 500});
							attended_lectures$count.add(Validate.Presence,{failureMessage:'X'});
							attended_lectures$count.add(Validate.Numericality,{ onlyInteger: true,minimum:0,maximum:".$_POST['total_lectures']."},{ onlyInteger: true });
							attended_lectures$count.add(Validate.Format,{pattern: /^[0-9]+$/, failureMessage:'X'});
			</script>
			</td>
			
			<td><input class='input-small' size='16' type='text' id='attendance_marks$count' autocomplete='off' name='attendance_marks$count'>
			<script>
							var attendance_marks$count = new LiveValidation('attendance_marks$count',{ validMessage: 'ok', wait: 500});
							attendance_marks$count.add(Validate.Presence,{failureMessage:'X'});
							attendance_marks$count.add(Validate.Numericality,{ onlyInteger: true,minimum:0,maximum:6},{ onlyInteger: true });
							attendance_marks$count.add(Validate.Format,{pattern: /^[0-9]+$/, failureMessage:'X'});
			</script>
			</td>
			
			<!--<td><input class='input-small' size='16' type='text' name='remarks$count'></td>-->
			</tr>";
			$count++;
		
}
?>
</table>
<input type='hidden' name='teacher_mark_aggregate_attendance' value='<?php echo $count; ?>' />
<input type='hidden' name='total_count' value='<?php echo $count; ?>' />
<input type='hidden' name='theory_practical' value='<?php echo $_POST['theory_practical']; ?>' />
<input type='hidden' name='autoid' value='<?php echo $_POST['autoid']; ?>' />
<input type='hidden' name='exam_month' value='<?php echo $_POST['exam_month']; ?>' />
<input type='hidden' name='exam_year' value='<?php echo $_POST['exam_year']; ?>' />
<input type='hidden' name='total_lectures' value='<?php echo $_POST['total_lectures']; ?>' />
<input type='hidden' name='start_date' value='<?php echo $_POST['start_date']; ?>' />
<input type='hidden' name='end_date' value='<?php echo $_POST['end_date']; ?>' />
<input type='hidden' name='overall_remarks' value='<?php echo $_POST['overall_remarks']; ?>' />
<input type='hidden' name='paper_id' value='<?php echo $_POST['paper_id']; ?>' />
<input type='hidden' name='subject_title' value='<?php echo $_POST['subject_title']; ?>' />
<input type='hidden' name='ssection' value='<?php echo $_POST['ssection']; ?>' />
<input type='hidden' name='sgroup' value='<?php echo $_POST['sgroup']; ?>' />
<input type='hidden' name='subject_code' value='<?php echo $_POST['subject_code']; ?>' />
<input type='hidden' name='branch_code' value='<?php echo $_POST['branch_code']; ?>' />
<input type='hidden' name='course_code' value='<?php echo $_POST['course_code']; ?>' />
<input type='hidden' name='semester' value='<?php echo $_POST['semester']; ?>' />
<input type='hidden' name='aicte_rc' value='<?php echo $_POST['aicte_rc']; ?>' />
<input type='hidden' name='full_part_time' value='<?php echo $_POST['full_part_time']; ?>' />
<input type='hidden' name='shift' value='<?php echo $_POST['shift']; ?>' />
<input type='submit' class='btn btn-block btn-danger' value='Click Here To Mark Attendance' onclick="return confirm_action('Do you want to continue ?')"/>
</form>


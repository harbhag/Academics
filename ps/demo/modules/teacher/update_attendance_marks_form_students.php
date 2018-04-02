<?php
show_label('info','Attendance Marks');
echo "<br/>";

?>



<form action='' method='post'/>
<table class='table table-bordered table-condensed container sortable table-hover'>
	<tr>
		<th>Sr. No.</th>
		<th>University Roll No.</th>
		<th>College Roll No.</th>
		<th>Student Name</th>
		
		<th>Subject Code</th>
		<th>Subject Title</th>
		<th>Semester</th>
	    <th>Attendance Marks</th>
	</tr>
<?php




$details = fetch_resource_db('time_table',array('autoid'),array($_POST['autoid']),'resource_array','');
		

if($_POST['elective_details']=='Compulsory') {
	$roll_nos = mysql_query("SELECT distinct university_roll_no FROM student_attendance_marks_record WHERE
		course_code = '".$_POST['course_code']."' AND
		branch_code = '".$_POST['branch_code']."' AND
		shift = '".$_POST['shift']."' AND
		subject_code='".$_POST['subject_code']."' AND
		ssection = '".$_POST['ssection']."' AND
		semester = '".$_POST['semester']."' AND
		aicte_rc = '".$_POST['aicte_rc']."' AND
		full_part_time = '".$_POST['full_part_time']."'
		ORDER BY college_roll_no ASC") or die(mysql_error());
	
	
}

else {
	$roll_nos = mysql_query("SELECT  distinct university_roll_no FROM student_attendance_marks_record WHERE
		course_code = '".$_POST['course_code']."' AND
		branch_code = '".$_POST['branch_code']."' AND
		shift = '".$_POST['shift']."' AND
		subject_code='".$_POST['subject_code']."' AND
		ssection = '".$_POST['ssection']."' AND
		semester = '".$_POST['semester']."' AND
		aicte_rc = '".$_POST['aicte_rc']."' AND
		full_part_time = '".$_POST['full_part_time']."' AND
	
		student_attendance_marks_record.university_roll_no IN 
		(SELECT university_roll_no FROM student_elective_subjects WHERE 
		
		course_code = '".$_POST['course_code']."' AND
		branch_code = '".$_POST['branch_code']."' AND
		semester = '".$_POST['semester']."' AND
		elective_details = '".$_POST['elective_details']."' AND
		subject_code='".$_POST['subject_code']."')
		ORDER BY college_roll_no ASC") or die(mysql_error());
	
}
	

if(mysql_num_rows($roll_nos)==0) {
	show_label('info','No Record Found !');
	exit();
}

$count = 1;
while($row = mysql_fetch_assoc($roll_nos)) {
	
	$attendance_marks_sql = mysql_query("SELECT distinct attendance_marks,autoid FROM student_attendance_marks_record WHERE
		course_code = '".$_POST['course_code']."' AND
		branch_code = '".$_POST['branch_code']."' AND
		shift = '".$_POST['shift']."' AND
		subject_code='".$_POST['subject_code']."' AND
		ssection = '".$_POST['ssection']."' AND
		semester = '".$_POST['semester']."' AND
		aicte_rc = '".$_POST['aicte_rc']."' AND
		full_part_time = '".$_POST['full_part_time']."' AND
		university_roll_no = '".$row['university_roll_no']."' AND
		backup='0'
		ORDER BY college_roll_no ASC") or die(mysql_error());
	
	$attendance_marks = mysql_fetch_assoc($attendance_marks_sql);
	
	
	$student_details = fetch_resource_db('student_info',array('university_roll_no'),array($row['university_roll_no']),'resource_array','');
		
		echo "<tr class='warning'>
			<td>".$count."</td>
			<td>".$row['university_roll_no']."</td>
			<td>".$student_details['college_roll_no']."</td>
			<input type='hidden' name='university_roll_no$count' value='".$row['university_roll_no']."' />
			<input type='hidden' name='attendance_id$count' value='".$attendance_marks['autoid']."' />
			<td>".$student_details['ptu_student_name']."</td>
			<td>".$_POST['subject_code']."</td>
			<td>".$_POST['subject_title']."</td>
			<td>".$_POST['semester']."</td>";
			
			if($_POST['course_code']==1) {
				$attendance_max = 6;
				
			}
			if($_POST['course_code']==3 or $_POST['course_code']==4) {
				$attendance_max = 10;
			}
			if($_POST['course_code']==2) {
				$attendance_max = 8;
			}
			
			
			echo "<input class='input-small' size='16' type='hidden' value='".$attendance_marks['attendance_marks']."' id='p_q$count' name='p_q$count'>";
			
			
			echo "<td><input class='input-small' size='16' value='".$attendance_marks['attendance_marks']."' type='text' id='q$count' name='q$count'>
			<script>
								var q$count = new LiveValidation('q$count',{ validMessage: 'ok', wait: 500});
								q$count.add(Validate.Presence,{failureMessage:'X'});
								q$count.add(Validate.Numericality,{minimum:0,maximum:".$attendance_max."});
								q$count.add(Validate.Format,{pattern: /^[0-9.]+$/, failureMessage:'X'});
			</script>
			</td>";
			
			
			echo "
			<!--<td><input class='input-small' type='text' value='".$row['remarks']."' name='remarks$count'></td>-->
			</tr>";
			$count++;
		
}
?>
</table>
<input type='hidden' name='teacher_update_attendance_marks' value='<?php echo $count; ?>' />
<input type='hidden' name='total_count' value='<?php echo $count; ?>' />
<input type='hidden' name='total_qcount' value='<?php echo $total_qcount; ?>' />
<input type='hidden' name='autoid' value='<?php echo $_POST['autoid']; ?>' />
<input type='hidden' name='assignment_max_marks' value='<?php echo $_POST['assignment_max_marks']; ?>' />
<input type='hidden' name='assignment_no' value='<?php echo $_POST['assignment_no']; ?>' />
<input type='hidden' name='assignment_date' value='<?php echo $_POST['assignment_date']; ?>' />
<input type='hidden' name='assignment_topic' value='<?php echo $_POST['assignment_topic']; ?>' />
<input type='hidden' name='autoid' value='<?php echo $_POST['autoid']; ?>' />
<input type='hidden' name='exam_month' value='<?php echo $_POST['exam_month']; ?>' />
<input type='hidden' name='exam_year' value='<?php echo $_POST['exam_year']; ?>' />
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
<input type='submit' class='btn btn-block btn-danger' value='Click Here To Update Attendance Marks' onclick="return confirm_action('Do you want to continue ?')"/>
</form>




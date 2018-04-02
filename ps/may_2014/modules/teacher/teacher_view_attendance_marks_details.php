<?php

show_label('info','Attendance Marks Details');
echo "<br/>";

$total_questions = mysql_query("SELECT * FROM internal_question_structure WHERE ass_tool='P' AND course_code='".$_POST['course_code']."'") or die(mysql_query());

$total_qcount = mysql_num_rows($total_questions);

$number_array = array();
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
	
	$student_details = fetch_resource_db('student_info',array('university_roll_no'),array($row['university_roll_no']),'resource_array','');
	
	$att_marks_sql = mysql_query("SELECT attendance_marks FROM student_attendance_marks_record WHERE
			university_roll_no='".$row['university_roll_no']."' AND
			subject_code = '".$_POST['subject_code']."' AND
			backup = '0'") or die(mysql_error());
			
	$att_marks = mysql_fetch_assoc($att_marks_sql);
	
		
	echo "<tr class='warning'>
	<td>".$count."</td>
	<td>".$row['university_roll_no']."</td>
	<td>".$student_details['college_roll_no']."</td>
	<input type='hidden' name='university_roll_no$count' value='".$row['university_roll_no']."' />
	<input type='hidden' name='sessional_id$count' value='".$row['autoid']."' />
	<td>".$student_details['ptu_student_name']."</td>
	<td>".$_POST['subject_code']."</td>
	<td>".$_POST['subject_title']."</td>";
	echo "<td>".$att_marks['attendance_marks']."</td>";
	
	$count++;

}
?>
</table>
<input type='hidden' name='teacher_print_internal_marks_record' value='<?php echo $count; ?>' />
<input type='hidden' name='total_count' value='<?php echo $count; ?>' />
<input type='hidden' name='autoid' value='<?php echo $_POST['autoid']; ?>' />
<input type='hidden' name='sessional_no' value='<?php echo $_POST['sessional_no']; ?>' />
</form>




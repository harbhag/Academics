<?php

show_label('info','Assignment Marks');
echo "<br/>";

$total_questions = mysql_query("SELECT * FROM internal_question_structure WHERE ass_tool='A' AND course_code='".$_POST['course_code']."'") or die(mysql_query());

$total_qcount = mysql_num_rows($total_questions);

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
		<th>Assignment No.</th>
	<?php
		for($i=1;$i<=mysql_num_rows($total_questions);$i++) {
			
			$qmm_sql = mysql_query("SELECT * FROM internal_question_structure WHERE ass_tool='A' AND course_code='".$_POST['course_code']."'
			AND question_no='".$i."'") or die(mysql_query());
			$qmm = mysql_fetch_assoc($qmm_sql);
		
		$row_iqs_qn = mysql_fetch_assoc($result_iqs_qn);
			echo "<th>Q".$i." Obt. Marks<br>(MM:".$qmm['max_marks'].")</th>";
		}
		?>
		<!--<th>Remarks</th>-->
	</tr>
<?php




$details = fetch_resource_db('time_table',array('autoid'),array($_POST['autoid']),'resource_array','');
		
if($_POST['elective_details']=='Compulsory') {
	$roll_nos = mysql_query("SELECT distinct university_roll_no FROM student_assignment_record WHERE
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
	$roll_nos = mysql_query("SELECT distinct university_roll_no FROM student_assignment_record WHERE
		course_code = '".$_POST['course_code']."' AND
		branch_code = '".$_POST['branch_code']."' AND
		shift = '".$_POST['shift']."' AND
		subject_code='".$_POST['subject_code']."' AND
		ssection = '".$_POST['ssection']."' AND
		semester = '".$_POST['semester']."' AND
		aicte_rc = '".$_POST['aicte_rc']."' AND
		full_part_time = '".$_POST['full_part_time']."' AND
		
		student_assignment_record.university_roll_no IN 
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
	
	
	$autoid_sql = mysql_query("SELECT distinct autoid FROM student_assignment_record WHERE
		course_code = '".$_POST['course_code']."' AND
		branch_code = '".$_POST['branch_code']."' AND
		shift = '".$_POST['shift']."' AND
		subject_code='".$_POST['subject_code']."' AND
		ssection = '".$_POST['ssection']."' AND
		semester = '".$_POST['semester']."' AND
		aicte_rc = '".$_POST['aicte_rc']."' AND
		full_part_time = '".$_POST['full_part_time']."' AND
		university_roll_no = '".$row['university_roll_no']."' AND
		assignment_no = '".$_POST['assignment_no']."' AND
		backup='0'
		ORDER BY college_roll_no ASC") or die(mysql_error());
	
	$autoid = mysql_fetch_assoc($autoid_sql);
	
	$total_questions = mysql_query("SELECT * FROM internal_question_structure WHERE ass_tool='A' AND course_code='".$_POST['course_code']."'") or die(mysql_query());
	$qcount = 1;
	
	$student_details = fetch_resource_db('student_info',array('university_roll_no'),array($row['university_roll_no']),'resource_array','');
		
		echo "<tr class='warning'>
			<td>".$count."</td>
			<td>".$row['university_roll_no']."</td>
			<td>".$student_details['college_roll_no']."</td>
			<input type='hidden' name='university_roll_no$count' value='".$row['university_roll_no']."' />
			<input type='hidden' name='assignment_id$count' value='".$autoid['autoid']."' />
			<td>".$student_details['ptu_student_name']."</td>
			<td>".$_POST['subject_code']."</td>
			<td>".$_POST['subject_title']."</td>
			<td>".$_POST['semester']."</td>
			<td>".$_POST['assignment_no']."</td>";
			
			
			while($rows = mysql_fetch_assoc($total_questions)) {
				$question_id = $count.$qcount;
				$dquestion_id = "q".$qcount;
				
				
				$qmm_sql = mysql_query("SELECT * FROM internal_question_structure WHERE ass_tool='A' AND course_code='".$_POST['course_code']."'
				AND question_no='".$qcount."'") or die(mysql_query());
				$qmm = mysql_fetch_assoc($qmm_sql);
				
				
				
				
				
				$assignment_marks_sql = mysql_query("SELECT distinct ".$dquestion_id." FROM student_assignment_record WHERE
				course_code = '".$_POST['course_code']."' AND
				branch_code = '".$_POST['branch_code']."' AND
				shift = '".$_POST['shift']."' AND
				subject_code='".$_POST['subject_code']."' AND
				ssection = '".$_POST['ssection']."' AND
				semester = '".$_POST['semester']."' AND
				aicte_rc = '".$_POST['aicte_rc']."' AND
				full_part_time = '".$_POST['full_part_time']."' AND
				university_roll_no = '".$row['university_roll_no']."' AND
				assignment_no = '".$_POST['assignment_no']."' AND
				backup='0'
				ORDER BY college_roll_no ASC") or die(mysql_error());
			
				$assignment_marks = mysql_fetch_assoc($assignment_marks_sql);
				
			
				
				
				
				
				
				echo "<input class='input-small' size='16' type='hidden' value='".$assignment_marks[$dquestion_id]."' id='p_q$question_id' name='p_q$question_id'>";
			
			
				echo "<td><input class='input-small' size='16' value='".$assignment_marks[$dquestion_id]."' type='text' id='q$question_id' name='q$question_id'>
				<script>
								var q$question_id = new LiveValidation('q$question_id',{ validMessage: 'ok', wait: 500});
								q$question_id.add(Validate.Presence,{failureMessage:'X'});
								q$question_id.add(Validate.Numericality,{minimum:0,maximum:".$qmm['max_marks']."});
								q$question_id.add(Validate.Format,{pattern: /^[0-9.]+$/, failureMessage:'X'});
				</script>
				</td>";
				$qcount++;
			}
			
			
			echo "
			<!--<td><input class='input-small' type='text' value='".$row['remarks']."' name='remarks$count'></td>-->
			</tr>";
			$count++;
		
}
?>
</table>
<input type='hidden' name='teacher_update_assignment_marks' value='<?php echo $count; ?>' />
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
<input type='submit' class='btn btn-block btn-danger' value='Click Here To Update Assignment Marks' onclick="return confirm_action('Do you want to continue ?')"/>
</form>



<?php

show_label('info','Assignment Details');
echo "<br/>";

$total_questions = mysql_query("SELECT * FROM internal_question_structure WHERE ass_tool='A' AND course_code='".$_POST['course_code']."'") or die(mysql_query());

$total_qcount = mysql_num_rows($total_questions);

$number_array = array();
?>

<form action='' method='post'/>
<table class='table table-bordered table-condensed sortable'>
	<tr>
		<th>Sr. No.</th>
		<th>University Roll No.</th>
		<th>College Roll No.</th>
		<th>Student Name</th>
		<th>Subject Code</th>
		<th>Subject Title</th>
		<?php
		for($k=1;$k<=3;$k++) {
			for($i=1;$i<=mysql_num_rows($total_questions);$i++) {
				
				$qmm_sql = mysql_query("SELECT * FROM internal_question_structure WHERE ass_tool='A' AND course_code='".$_POST['course_code']."'
				AND question_no='".$i."'") or die(mysql_query());
				$qmm = mysql_fetch_assoc($qmm_sql);
			
				$row_iqs_qn = mysql_fetch_assoc($result_iqs_qn);
				echo "<th>Q".$i."<br/>(MM:".$qmm['max_marks'].")</th>";
			}
			echo "<th>A-".$k." (Total)</th>";
		}
		?>
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
	
	$student_details = fetch_resource_db('student_info',array('university_roll_no'),array($row['university_roll_no']),'resource_array','');
	
		
	$total_questions = mysql_query("SELECT * FROM internal_question_structure WHERE ass_tool='A' AND course_code='".$_POST['course_code']."'") or die(mysql_query());

	$total_qcount = mysql_num_rows($total_questions);
		
	echo "<tr class='warning'>
	<td>".$count."</td>
	<td>".$row['university_roll_no']."</td>
	<td>".$student_details['college_roll_no']."</td>
	<input type='hidden' name='university_roll_no$count' value='".$row['university_roll_no']."' />
	<input type='hidden' name='sessional_id$count' value='".$row['autoid']."' />
	<td>".$student_details['ptu_student_name']."</td>
	<td>".$_POST['subject_code']."</td>
	<td>".$_POST['subject_title']."</td>";
	for($k=1;$k<=3;$k++) {
			for($i=1;$i<=mysql_num_rows($total_questions);$i++) {
				
				$question_id = 'q'.$i;
				
				$qmm_sql = mysql_query("SELECT * FROM internal_question_structure WHERE ass_tool='A' AND course_code='".$_POST['course_code']."'
				AND question_no='".$i."'") or die(mysql_query());
				$qmm = mysql_fetch_assoc($qmm_sql);
			
				$amarks_sql = mysql_query("SELECT $question_id FROM student_assignment_record WHERE
				university_roll_no='".$row['university_roll_no']."' AND
				subject_code = '".$_POST['subject_code']."' AND
				assignment_no = '".$k."' AND
				backup = '0'") or die(mysql_error());
				
				$amarks = mysql_fetch_assoc($amarks_sql);
				
				$question_id = "q".$i;
				
				
				echo "<td>".$amarks[$question_id]."</td>";
				
				$number_array[] = $amarks[$question_id];
			}
			
				
				
			echo "<td style='background-color:#BBD5F2'>".array_sum($number_array)."</td>";
			unset($number_array);		
	}
	
	
	
	$count++;

}
?>
</table>
<input type='hidden' name='teacher_print_internal_marks_record' value='<?php echo $count; ?>' />
<input type='hidden' name='total_count' value='<?php echo $count; ?>' />
<input type='hidden' name='autoid' value='<?php echo $_POST['autoid']; ?>' />
<input type='hidden' name='sessional_no' value='<?php echo $_POST['sessional_no']; ?>' />
</form>



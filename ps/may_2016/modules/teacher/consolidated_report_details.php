<?php

show_label('info','Consolidated Report Details');
echo "<br/>";

$number_array = array();
$sessional_marks_array = array();
$assignment_marks_array = array();
$sess3=0;
$internal_marks = array();

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
			echo "<th>S-".$k."</th>";
		}
		
		echo "<th>(Total)</th>";
		
		for($k=1;$k<=3;$k++) {
			echo "<th>A-".$k."</th>";
		}
		
		echo "<th>(Average)</th>";
		?>
		<th>Attendance Marks</th>
		<th>Obtained Marks</th>
	</tr>
<?php


$details = fetch_resource_db('time_table',array('autoid'),array($_POST['autoid']),'resource_array','');


$roll_nos = mysql_query("SELECT * FROM student_info WHERE
		course_code='".$_POST['course_code']."' AND
		branch_code='".$_POST['branch_code']."' AND
		shift='".$_POST['shift']."' AND
		ssection='".$_POST['ssection']."' AND
		semester='".$_POST['semester']."' AND
		aicte_rc='".$_POST['aicte_rc']."' AND
		full_part_time='".$_POST['full_part_time']."' AND
		student_status='Onroll' AND university_roll_no IN
		
		(SELECT distinct university_roll_no from student_sessionals_record WHERE
		course_code='".$_POST['course_code']."' AND
		branch_code='".$_POST['branch_code']."' AND
		shift='".$_POST['shift']."' AND
		ssection='".$_POST['ssection']."' AND
		semester='".$_POST['semester']."' AND
		aicte_rc='".$_POST['aicte_rc']."' AND
		full_part_time='".$_POST['full_part_time']."' AND
		subject_code='".$_POST['subject_code']."' AND
		teacher_username='".$_SESSION['username']."' )
		
		ORDER BY university_roll_no ASC") or die(mysql_error());


if(mysql_num_rows($roll_nos)==0) {
	show_label('info','No Record Found !');
	exit();
}

$count = 1;
while($row = mysql_fetch_assoc($roll_nos)) {
	
	$student_details = fetch_resource_db('student_info',array('university_roll_no'),array($row['university_roll_no']),'resource_array','');
	
		
	echo "<tr class='warning'>
	<td>".$count."</td>
	<td>".$row['university_roll_no']."</td>
	<td>".$student_details['college_roll_no']."</td>
	<input type='hidden' name='university_roll_no$count' value='".$row['university_roll_no']."' />
	<input type='hidden' name='sessional_id$count' value='".$row['autoid']."' />
	<td>".$student_details['ptu_student_name']."</td>
	<td>".$_POST['subject_code']."</td>
	<td>".$_POST['subject_title']."</td>";
	
	//Process Sessional Marks
	
	for($k=1;$k<=3;$k++) {
		$total_questions = mysql_query("SELECT * FROM internal_question_structure WHERE ass_tool='S' AND course_code='".$_POST['course_code']."' AND sessional_no='".$k."'") or die(mysql_query());

		$total_qcount = mysql_num_rows($total_questions);
			
			for($i=1;$i<=mysql_num_rows($total_questions);$i++) {
				
				$question_id = 'q'.$i;
				
				$qmm_sql = mysql_query("SELECT * FROM internal_question_structure WHERE ass_tool='S' AND course_code='".$_POST['course_code']."'
				AND question_no='".$i."' AND sessional_no='".$k."'") or die(mysql_query());
				$qmm = mysql_fetch_assoc($qmm_sql);
			
				$amarks_sql = mysql_query("SELECT $question_id FROM student_sessionals_record WHERE
				university_roll_no='".$row['university_roll_no']."' AND
				subject_code = '".$_POST['subject_code']."' AND
				sessional_no = '".$k."' AND
				backup = '0'") or die(mysql_error());
				
				$amarks = mysql_fetch_assoc($amarks_sql);
				
				$question_id = "q".$i;
				
				$number_array[] = $amarks[$question_id];
				
			}
				
				
			echo "<td>".round(array_sum($number_array))."</td>";
			
			
			$sessional_marks_array[] = round(array_sum($number_array));

			if($k==3) {
				$sess3 = round(array_sum($number_array));
			}
			unset($number_array);
					
	}

	if($_POST['course_code']==1) {
		$tmp = array_pop($sessional_marks_array);
	}
	
	rsort($sessional_marks_array);
	
	
	$max1 = $sessional_marks_array[0];

	if($_POST['course_code']==1) {
		$max2 = $sess3;
	}
	else {
		$max2 = $sessional_marks_array[1];
	}
	
	$average = round((($max1)+($max2))/(2));
	
	$internal_marks[] = $average;
	
	echo "<td style='background-color:#BBD5F2'>".$average."</td>";
	unset($sessional_marks_array);
	
	
	//Process Assignment Marks
	
	for($k=1;$k<=3;$k++) {
		$total_questions = mysql_query("SELECT * FROM internal_question_structure WHERE ass_tool='A' AND course_code='".$_POST['course_code']."'") or die(mysql_query());

		$total_qcount = mysql_num_rows($total_questions);
			
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
				
				$number_array[] = $amarks[$question_id];
				
			}
				
				
			echo "<td>".round(array_sum($number_array))."</td>";
			
			$assignment_marks_array[] = round(array_sum($number_array));
			unset($number_array);
					
	}
	
	
	$average = round((array_sum($assignment_marks_array))/(3));
	
	$internal_marks[] = $average;
	
	echo "<td style='background-color:#BBD5F2'>".$average."</td>";
	unset($assignment_marks_array);
	
	
	//Process Attendance Marks
	$amarks_sql = mysql_query("SELECT attendance_marks FROM student_attendance_marks_record WHERE
			 university_roll_no='".$row['university_roll_no']."' AND
			 subject_code = '".$_POST['subject_code']."' AND
			 backup = '0'") or die(mysql_error());
			 
	$amarks = mysql_fetch_assoc($amarks_sql);
	
	echo "<td style='background-color:#BBD5F2'>".$amarks['attendance_marks']."</td>";
	
	$internal_marks[] = round($amarks['attendance_marks']);
	
	
	//Final Internal
	echo "<td style='background-color:#BBD5F2'>".round(array_sum($internal_marks))."</td>";
	$count++;
	
	unset($internal_marks);

}
?>
</table>
<input type='hidden' name='teacher_print_internal_marks_record' value='<?php echo $count; ?>' />
<input type='hidden' name='total_count' value='<?php echo $count; ?>' />
<input type='hidden' name='autoid' value='<?php echo $_POST['autoid']; ?>' />
<input type='hidden' name='sessional_no' value='<?php echo $_POST['sessional_no']; ?>' />
</form>




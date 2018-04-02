<?php
//$details = fetch_resource_db('time_table',array('autoid'),array($_POST['autoid']),'resource_array','');

$htm = array();
$sess3=0;
$details_sql  = mysql_query("SELECT * FROM time_table  WHERE
		course_code='".$_POST['course_code']."' AND
		branch_code='".$_POST['branch_code']."' AND
		shift='".$_POST['shift']."' AND
		ssection='".$_POST['ssection']."' AND
		semester='".$_POST['semester']."' AND
		teacher_username='".$_SESSION['username']."' AND
		subject_code='".$_POST['subject_code']."' AND
		
		aicte_rc='".$_POST['aicte_rc']."' AND
		full_part_time='".$_POST['full_part_time']."'") or die(mysql_error());
		
$details = mysql_fetch_assoc($details_sql);
//$roll_nos = mysql_query("SELECT DISTINCT university_roll_no FROM student_sessionals_record WHERE id='".$_POST['autoid']."' AND backup='0' ORDER BY university_roll_no ASC") or die(mysql_error());
$teacher_username = fetch_resource_db('users',array('username'),array($details['teacher_username']),'resource_array_value','name');

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



$branch_name = fetch_resource_db('branch_code',array('branch_code'),array($_POST['branch_code']),'resource_array_value','branch_name');
$course_name = fetch_resource_db('course_code',array('course_code'),array($_POST['course_code']),'resource_array_value','course_name');

$count = 1;

$htm[] ="
<head>
<style type='text/css'>
body {
	font-size:12px;
}
</style>
<body>

<span style='font-size:15px'>
<table style='width:100%'>
			<tr>
			<td align='center'> 
			<table width='100%'>
			<tr>
			<td width='15%' align='center'><img src='images/gndec_logo.jpg' height='100' /></td>
			<td width='70%' align='center'><h4> GURU NANAK DEV ENGINEERING COLLEGE, LUDHIANA </h4>			<h4> ( An Autonomous College Under UGC Act - 1956 [2(f) and 12(B)] )
			<br /> Affiliated to Punjab Technical University</h4>
			<td width='15%' align='center'><img src='images/ptu_logo.jpg' height='100' /></td>
		</tr>
	  </table></td></tr></table>
</span>
	  <br>
	  <table border='1' cellpadding='2' style='border-collapse:collapse;width:100%'>
	  <tr>
			<td colspan='4' align='center'><h3>Internal(Sessional) Theory Awards for Examination ".$exam_session."</h3></td>
			</tr>
			<tr>
			<th align='left'><b>Course & Branch</b></th>
			<td>".$course_name."(".$branch_name.")</td>
			<th ><b>Semester</b></th>
			<td>".$details['semester']."</td>
			</tr>
			<tr>
			<th align='left'><b>Subject Name & Subject Code / Paper ID</b></th>
			<td colspan='3'>".$details['subject_title']."(".$details['subject_code']." / ".$details['paper_id'].")</td>
			</tr>
			<tr>
			<th colspan='2' align='left'><b>Shift / Full Time or Part Time / AICTE or RC</b></th>
			<td colspan='2'>".$details['shift']." / ".$details['full_part_time']." / ".$details['aicte_rc']."</td>
			</tr>
			<tr>
			<td><b>E-Printed On </b></td><td align='center'> ".date('d-m-Y')." </td>
			<td><b>Section</b></td><td align='center'> ".$details['ssection']." </td>
			<!--<td><b>Max. Marks (Internal) </b></td><td> 40 </td>-->
			</tr>
	  </table>
	   <br><br>";
	  
	  $htm[]=" <table border='1' style='border-collapse:collapse;width:100%'>
	   <tr>
			<th>Sr. No.</th>
		<th>University Roll No.</th>
		<th>College Roll No.</th>
		<th>Student Name</th>
		<th>Subject Code</th>
		<!--<th>Subject Title</th>-->";
		
		if($_POST['course_code']==1) {
		
			for($k=1;$k<=3;$k++) {
				$htm[] =  "<th>S-".$k."<br/>(MM:24)</th>";
			}
			
			$htm[] = "<th>(Total)</th>";
			
			for($k=1;$k<=3;$k++) {
				$htm[] = "<th>A-".$k."<br/>(MM:10)</th>";
			}
			
			$htm[] = "<th>(Average)</th>
			<th>Attendance Marks<br/>(MM:6)</th>
			<th>Obtained Marks<br/>(MM:40)</th>";
		}
			
		if($_POST['course_code']==2) {
		
			for($k=1;$k<=3;$k++) {
				$htm[] =  "<th>S-".$k."<br/>(MM:30)</th>";
			}
			
			$htm[] = "<th>(Total)</th>";
			
			for($k=1;$k<=3;$k++) {
				$htm[] = "<th>A-".$k."<br/>(MM:12)</th>";
			}
			
			$htm[] = "<th>(Average)</th>
			<th>Attendance Marks<br/>(MM:8)</th>
			<th>Obtained Marks<br/>(MM:50)</th>";
		}
			
		if($_POST['course_code']==3) {
		
			for($k=1;$k<=3;$k++) {
				$htm[] =  "<th>S-".$k."<br/>(MM:24)</th>";
			}
			
			$htm[] = "<th>(Total)</th>";
			
			for($k=1;$k<=3;$k++) {
				$htm[] = "<th>A-".$k."<br/>(MM:8)</th>";
			}
			
			$htm[] = "<th>(Average)</th>
			<th>Attendance Marks<br/>(MM:8)</th>
			<th>Obtained Marks<br/>(MM:40)</th>";
		}
			
		if($_POST['course_code']==4) {
		
			for($k=1;$k<=3;$k++) {
				$htm[] =  "<th>S-".$k."<br/>(MM:30)</th>";
			}
			
			$htm[] = "<th>(Total)</th>";
			
			for($k=1;$k<=3;$k++) {
				$htm[] = "<th>A-".$k."<br/>(MM:12)</th>";
			}
			
			$htm[] = "<th>(Average)</th>
			<th>Attendance Marks<br/>(MM:8)</th>
			<th>Obtained Marks<br/>(MM:50)</th>";
		}
			
//$roll_nos = mysql_query("SELECT DISTINCT university_roll_no FROM student_sessionals_record WHERE id='".$_POST['autoid']."' AND backup='0' ORDER BY university_roll_no ASC") or die(mysql_error());

$page_count=0;
$page_no = 1;

while($row = mysql_fetch_assoc($roll_nos)) {
	
	$student_details = fetch_resource_db('student_info',array('university_roll_no'),array($row['university_roll_no']),'resource_array','');
	
		
	$htm[] = "<tr class='warning'>
	<td>".$count."</td>
	<td>".$row['university_roll_no']."</td>
	<td>".$student_details['college_roll_no']."</td>
	<input type='hidden' name='university_roll_no$count' value='".$row['university_roll_no']."' />
	<input type='hidden' name='sessional_id$count' value='".$row['autoid']."' />
	<td>".$student_details['ptu_student_name']."</td>
	<td>".$_POST['subject_code']."</td>
	<!--<td>".$_POST['subject_title']."</td>-->";
	
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
				
				
			$htm[] = "<td align='center'>".round(array_sum($number_array))."</td>";
			
			
			$sessional_marks_array[] = round(array_sum($number_array));
			
			if($k==3) {
				$sess3 = round(array_sum($number_array));
			}
			
			unset($number_array);
					
	}
	
	/*
	if($_POST['course_code']==1) {
		$tmp = array_pop($sessional_marks_array);
	}
	*/
	
	rsort($sessional_marks_array);
	
	$max1 = $sessional_marks_array[0];
	$max2 = $sessional_marks_array[1];
	
	/*
	if($_POST['course_code']==1) {
		$max2 = $sess3;
	}
	else {
		$max2 = $sessional_marks_array[1];
	}
	*/
	
	$average = round((($max1)+($max2))/(2));
	
	$internal_marks[] = $average;
	
	$htm[] =  "<td style='font-weight:bold' align='center'>".$average."</td>";
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
				
				
			$htm[] =  "<td align='center'>".round(array_sum($number_array))."</td>";
			
			$assignment_marks_array[] = round(array_sum($number_array));
			unset($number_array);
					
	}
	
	
	$average = round((array_sum($assignment_marks_array))/(3));
	
	$internal_marks[] = $average;
	
	$htm[] =  "<td style='font-weight:bold' align='center'>".$average."</td>";
	unset($assignment_marks_array);
	
	
	//Process Attendance Marks
	$amarks_sql = mysql_query("SELECT attendance_marks FROM student_attendance_marks_record WHERE
			 university_roll_no='".$row['university_roll_no']."' AND
			 subject_code = '".$_POST['subject_code']."' AND
			 backup = '0'") or die(mysql_error());
			 
	$amarks = mysql_fetch_assoc($amarks_sql);
	
	$htm[] = "<td style='font-weight:bold' align='center'>".$amarks['attendance_marks']."</td>";
	
	$internal_marks[] = round($amarks['attendance_marks']);
	
	
	//Final Internal
	$htm[] = "<td style='background-color:lightgrey' align='center'>".round(array_sum($internal_marks))."</td>";
	$count++;
	
	unset($internal_marks);
};
		
		if($_POST['course_code']==1 && ($_POST['semester']==1 OR $_POST['semester']==2)) {
			$hod['name']="Dr. R.P. Singh";
		}
			
	  $htm[] = "</table>
	  <br><br>
	  <table border='1' cellpadding='2' style='border-collapse:collapse;width:100%'>
	  <tr>
	  <td colspan='3' align='left'><b>Certified that all the candidates have completed the prescribed course of study. The above marks have been matched with original award of each student. In case of any discrepancy in the award list, Subject teachers shall be responsible for the consequences. </b></td>
	  </tr>
		<tr><td colspan='3'>Sign. of Subject Teacher(s):</td></tr>
		<tr><td> <br><br> 1..............................</td><td> <br><br> 2..............................</td><td><br><br>  3..............................</td></tr>
	  
			<tr>
			<td align='center'><b>Uploaded by User ID :</b><br> ".$details['teacher_username']." </td>
			<td align='center'><b>Sign. of Class Academic Incharge</b></td>
			<td><b>Name & Sign. of Department Exam Coordinator</b></td>
			</tr>
			<tr>
			<td> <br><br> Sign..................................<br>(".$teacher_username.") </td>
			<td> <br><br>Sign..................................</td>
			<td><br/><br/>Sign..................................<br></td>
			</tr>
	  </table>
<b>Note:- Subject Teacher(s) are required to sign. on every page with date. </b>
</body>";
		

$html = implode('',$htm);

//echo $html;


$dompdf = new DOMPDF();
$dompdf->set_paper("a4","landscape");
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream($details['subject_title']."_".$details['subject_code']."_".$details['semester'].".pdf");

?>


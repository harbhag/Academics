<?php
//$details = fetch_resource_db('time_table',array('autoid'),array($_POST['autoid']),'resource_array','');

$htm = array();

$details_sql  = mysql_query("SELECT * FROM time_table  WHERE
		course_code='".$_POST['course_code']."' AND
		branch_code='".$_POST['branch_code']."' AND
		shift='".$_POST['shift']."' AND
		ssection='".$_POST['ssection']."' AND
		semester='".$_POST['semester']."' AND
		teacher_username='".$_SESSION['username']."' AND
		subject_code='".$_POST['subject_code']."' AND
		exam_month='".$_POST['exam_month']."' AND
		exam_year='".$_POST['exam_year']."' AND
		
		aicte_rc='".$_POST['aicte_rc']."' AND
		full_part_time='".$_POST['full_part_time']."'") or die(mysql_error());
		
$details = mysql_fetch_assoc($details_sql);
//$roll_nos = mysql_query("SELECT DISTINCT university_roll_no FROM student_sessionals_record WHERE id='".$_POST['autoid']."' AND backup='0' ORDER BY university_roll_no ASC") or die(mysql_error());
$teacher_username = fetch_resource_db('users',array('username'),array($details['teacher_username']),'resource_array_value','name');

$roll_nos = mysql_query("SELECT DISTINCT university_roll_no FROM student_sessionals_record WHERE
		course_code='".$_POST['course_code']."' AND
		branch_code='".$_POST['branch_code']."' AND
		shift='".$_POST['shift']."' AND
		ssection='".$_POST['ssection']."' AND
		semester='".$_POST['semester']."' AND
		teacher_username='".$_SESSION['username']."' AND
		subject_code='".$_POST['subject_code']."' AND
		exam_month='".$_POST['exam_month']."' AND
		exam_year='".$_POST['exam_year']."' AND
		
		aicte_rc='".$_POST['aicte_rc']."' AND
		full_part_time='".$_POST['full_part_time']."' AND
		backup='0' 
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
			<h4>Department of Information Technology</h4></td>
			<td width='15%' align='center'><img src='images/ptu_logo.jpg' height='100' /></td>
		</tr>
	  </table></td></tr></table>
</span>
	  <br>
	  <table border='1' cellpadding='2' style='border-collapse:collapse;width:100%'>
	  <tr>
			<td colspan='6' align='center'><h3>Internal(Sessional) Theory Awards for Examination ".$exam_session."</h3></td>
			</tr>
			<tr>
			<th><b>Course & Branch</b></th>
			<td>".$course_name."(".$branch_name.")</td>
			<th colspan='3'><b>Semester</b></th>
			<td>".$details['semester']."</td>
			</tr>
			<tr>
			<th><b>Subject Name & Subject Code / Paper ID</b></th>
			<td colspan='5'>".$details['subject_title']."(".$details['subject_code']." / ".$details['paper_id'].")</td>
			</tr>
			<tr>
			<th colspan='2' align='left'><b>Shift / Full Time or Part Time / AICTE or RC</b></th>
			<td colspan='4'>".$details['shift']." / ".$details['full_part_time']." / ".$details['aicte_rc']."</td>
			</tr>
			<tr>
			<td><b>E-Printed On </b></td><td align='center'> ".date('d-m-Y')." </td>
			<td><b>Section</b></td><td align='center'> ".$details['ssection']." </td>
			<td><b>Max. Marks (Internal) </b></td><td> 40 </td>
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
			<th>T-1</th>
			<th>T-2</th>
			<th>T-3</th>
			<th>Avg.</th>
			<th>Attendance Marks</th>
			<th>Assignment Marks</th>
			<th>Internal Obt. Marks</th>
			</tr>";
			
//$roll_nos = mysql_query("SELECT DISTINCT university_roll_no FROM student_sessionals_record WHERE id='".$_POST['autoid']."' AND backup='0' ORDER BY university_roll_no ASC") or die(mysql_error());

$page_count=0;
$page_no = 1;

while($row = mysql_fetch_assoc($roll_nos)) {
	
	$student_details = fetch_resource_db('student_info',array('university_roll_no'),array($row['university_roll_no']),'resource_array','');
	
	$details1 = fetch_resource_db('student_sessionals_record',array('university_roll_no','sessional_no','backup','subject_code'),array($row['university_roll_no'],'1','0',$_POST['subject_code']),'resource_array','');
	
	$details2 = fetch_resource_db('student_sessionals_record',array('university_roll_no','sessional_no','backup','subject_code'),array($row['university_roll_no'],'2','0',$_POST['subject_code']),'resource_array','');
	
	$details3 = fetch_resource_db('student_sessionals_record',array('university_roll_no','sessional_no','backup','subject_code'),array($row['university_roll_no'],'3','0',$_POST['subject_code']),'resource_array','');
	
	$details_agg_att = fetch_resource_db('aggregate_attendance_student',array('university_roll_no','backup','subject_code'),array($row['university_roll_no'],'0',$_POST['subject_code']),'resource_array','');
	
	$adetails1 = fetch_resource_db('student_assignment_record',array('university_roll_no','assignment_no','backup','subject_code'),array($row['university_roll_no'],'1','0',$_POST['subject_code']),'resource_array','');
	
	$adetails2 = fetch_resource_db('student_assignment_record',array('university_roll_no','assignment_no','backup','subject_code'),array($row['university_roll_no'],'2','0',$_POST['subject_code']),'resource_array','');
	
	$adetails3 = fetch_resource_db('student_assignment_record',array('university_roll_no','assignment_no','backup','subject_code'),array($row['university_roll_no'],'3','0',$_POST['subject_code']),'resource_array','');
	
	
	$aaverage = round((($adetails1['assignment_obtained_marks'])+($adetails2['assignment_obtained_marks'])+($adetails3['assignment_obtained_marks']))/1);
	
	if($details1['attendance_status']=='Absent') {
		$details1['obtained_marks']='A';
	}
	else {
		$number_array[] = $details1['obtained_marks'];
	}
	
	if($details2['attendance_status']=='Absent') {
		$details2['obtained_marks']='A';
	}
	else {
		$number_array[] = $details2['obtained_marks'];
	}
	
	if($details3['attendance_status']=='Absent') {
		$details3['obtained_marks']='A';
	}
	else {
		$number_array[] = $details3['obtained_marks'];
	}
	
	$total_att = $details_agg_att['total_lectures'];
	$attd_att = $details_agg_att['attended_lectures'];
	
	//$final_att = ((($attd_att)/($total_att))*6);
	$final_att = $details_agg_att['attendance_marks'];
	
	
	rsort($number_array);
	
	$max1 = $number_array[0];
	$max2 = $number_array[1];
	
	$average = round((($max1)+($max2))/(2));
	
	if($page_no==1) {
		$limit = 25;
	}
	else {
		$limit = 40;
	}
	
	if($page_count==$limit) { 
		$page_count = 0;
		$page_no++;
		
		$htm[] = "
		<tr>
		<td colspan='12' height='20'>Sign of Subject Teacher(s):................................</td>
		</tr>
		</table>
		<div style='page-break-after:always'></div>";
		$htm[]=" <table border='1' style='border-collapse:collapse;width:100%'>
	   <tr>
			<th>Sr. No.</th>
			<th>University Roll No.</th>
			<th>College Roll No.</th>
			<th>Student Name</th>
			<th>Subject Code</th>
			<th>T-1</th>
			<th>T-2</th>
			<th>T-3</th>
			<th>Avg.</th>
			<th>Attendance Marks</th>
			<th>Assignment Marks</th>
			<th>Internal Obt. Marks</th>
			</tr>";
		
		
		
	}
	
			$htm[]= "<tr>
			<td align='left' >".$count."</td>
		<td align='left' >".$row['university_roll_no']."</td>
		<td align='left' >".$student_details['college_roll_no']."</td>
		<td align='left' >".$student_details['ptu_student_name']."</td>
		<td align='left' >".$details['subject_code']."</td>
		<td align='left' >".$details1['obtained_marks']."</td>
		<td align='left' >".$details2['obtained_marks']."</td>
		<td align='left' >".$details3['obtained_marks']."</td>
		<td align='left' >".$average."</td>
		<td align='left' >".round($final_att)."</td>
		<td align='left' >".$aaverage."</td>
		<td align='left' >".(($average)+(round($final_att))+($aaverage))."</td>
			</tr>";
			unset($number_array);		
			$count++;
			$page_count++;
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
			<td><br/><br/>Sign..................................<br>(Parminder Kaur Wadhwa)</td>
			</tr>
	  </table>
<b>Note:- Subject Teacher(s) are required to sign. on every page with date. </b>
</body>";
		

$html = implode('',$htm);
$dompdf = new DOMPDF();
$dompdf->set_paper("a4","landscape");
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream($details['subject_title']."_".$details['subject_code']."_".$details['semester'].".pdf");

?>

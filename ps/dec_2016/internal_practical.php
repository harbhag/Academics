<?php


$result_analysis_sql = mysql_query("select distinct 

count(`university_roll_no`) total_students,

sum(case when `internal_attendance_status`='Present'  then 1 end) Appeared,
sum(case when `internal_obtained_marks` >=0.4*internal_max_marks  then 1 end) Pass, 
(sum(case when `internal_obtained_marks` >=0.4*internal_max_marks  then 1 end))/(sum(case when internal_attendance_status='Present'  then 1 end)) *100 pass_percentage, 

sum(case when `internal_obtained_marks` <0.4*internal_max_marks  then 1 end) Fail,

(sum(case when `internal_obtained_marks` <0.4*internal_max_marks  then 1 end))/(sum(case when `internal_attendance_status`='Present'  then 1 end)) *100 fail_percentage 

from student_internal_marks

where 

subject_code = '".$_POST['subject_code']."' AND
		course_code = '".$_POST['course_code']."' AND
		branch_code = '".$_POST['branch_code']."' AND
		aicte_rc = '".$_POST['aicte_rc']."' AND
		shift = '".$_POST['shift']."' AND
		full_part_time = '".$_POST['full_part_time']."' AND
		exam_month = '".$_POST['exam_month']."' AND
		exam_year = '".$_POST['exam_year']."' AND
		theory_practical = 'P' AND
		semester = '".$_POST['semester']."' AND
		paper_id = '".$_POST['paper_id']."' AND
		regular_reappear = '".$_POST['regular_reappear']."' AND
		internal_external = 'I' AND
		internal_lock_status = '1' AND
		internal_max_marks = '".$_POST['internal_max_marks']."' AND
		teacher_username = '".$_SESSION['username']."'

group by student_internal_marks.`branch_code`,subject_code,theory_practical,`semester`,internal_external, `regular_reappear`  order by student_internal_marks.branch_code,`semester`,`subject_code`,`theory_practical`,`regular_reappear` ") or die(mysql_error());

$result_analysis = mysql_fetch_assoc($result_analysis_sql);

//Grade System
$result_analysis_normalized_sql = mysql_query("select distinct 

count(`university_roll_no`) total_students,

sum(case when `internal_attendance_status`='Present'  then 1 end) Appeared,
sum(case when `normalized_marks` >=0.4*internal_max_marks  then 1 end) Pass, 
(sum(case when `normalized_marks` >=0.4*internal_max_marks  then 1 end))/(sum(case when internal_attendance_status='Present'  then 1 end)) *100 pass_percentage, 

sum(case when `normalized_marks` <0.4*internal_max_marks  then 1 end) Fail,

(sum(case when `normalized_marks` <0.4*internal_max_marks  then 1 end))/(sum(case when `internal_attendance_status`='Present'  then 1 end)) *100 fail_percentage 

from student_internal_marks

where 

subject_code = '".$_POST['subject_code']."' AND
		course_code = '".$_POST['course_code']."' AND
		branch_code = '".$_POST['branch_code']."' AND
		aicte_rc = '".$_POST['aicte_rc']."' AND
		shift = '".$_POST['shift']."' AND
		full_part_time = '".$_POST['full_part_time']."' AND
		exam_month = '".$_POST['exam_month']."' AND
		exam_year = '".$_POST['exam_year']."' AND
		theory_practical = 'T' AND
		semester = '".$_POST['semester']."' AND
		paper_id = '".$_POST['paper_id']."' AND
		regular_reappear = '".$_POST['regular_reappear']."' AND
		internal_external = 'I' AND
		internal_lock_status = '1' AND
		internal_max_marks = '".$_POST['internal_max_marks']."' AND
		teacher_username = '".$_SESSION['username']."'

group by student_internal_marks.`branch_code`,subject_code,theory_practical,`semester`,internal_external, `regular_reappear`  order by student_internal_marks.branch_code,`semester`,`subject_code`,`theory_practical`,`regular_reappear` ") or die(mysql_error());

$result_analysis_normalized = mysql_fetch_assoc($result_analysis_normalized_sql);
//Grade System End

$data_sql = mysql_query("SELECT * FROM student_internal_marks WHERE
		subject_code = '".$_POST['subject_code']."' AND
		course_code = '".$_POST['course_code']."' AND
		branch_code = '".$_POST['branch_code']."' AND
		aicte_rc = '".$_POST['aicte_rc']."' AND
		shift = '".$_POST['shift']."' AND
		full_part_time = '".$_POST['full_part_time']."' AND
		exam_month = '".$_POST['exam_month']."' AND
		exam_year = '".$_POST['exam_year']."' AND
		theory_practical = 'P' AND
		semester = '".$_POST['semester']."' AND
		regular_reappear = '".$_POST['regular_reappear']."' AND
		internal_external = 'I' AND
		internal_lock_status = '1' AND
		internal_max_marks = '".$_POST['internal_max_marks']."' AND
		teacher_username = '".$_SESSION['username']."' ORDER BY university_roll_no ASC") or die(mysql_error());
		
$data = mysql_fetch_assoc($data_sql);
$att_date = new DateTime($data['attendance_last_updated_on']);
$att_date_f = $att_date->format('d-m-Y');

$data_present = mysql_query("SELECT * FROM student_internal_marks WHERE
		subject_code = '".$_POST['subject_code']."' AND
		course_code = '".$_POST['course_code']."' AND
		branch_code = '".$_POST['branch_code']."' AND
		aicte_rc = '".$_POST['aicte_rc']."' AND
		shift = '".$_POST['shift']."' AND
		full_part_time = '".$_POST['full_part_time']."' AND
		exam_month = '".$_POST['exam_month']."' AND
		exam_year = '".$_POST['exam_year']."' AND
		theory_practical = 'P' AND
		semester = '".$_POST['semester']."' AND
		regular_reappear = '".$_POST['regular_reappear']."' AND
		internal_external = 'I' AND
		internal_lock_status = '1' AND
		internal_attendance_status = 'Present' AND
		internal_max_marks = '".$_POST['internal_max_marks']."' AND
		teacher_username = '".$_SESSION['username']."' ORDER BY university_roll_no ASC") or die(mysql_error());
		
$data_detained = mysql_query("SELECT * FROM student_internal_marks WHERE
		subject_code = '".$_POST['subject_code']."' AND
		course_code = '".$_POST['course_code']."' AND
		branch_code = '".$_POST['branch_code']."' AND
		aicte_rc = '".$_POST['aicte_rc']."' AND
		shift = '".$_POST['shift']."' AND
		full_part_time = '".$_POST['full_part_time']."' AND
		exam_month = '".$_POST['exam_month']."' AND
		exam_year = '".$_POST['exam_year']."' AND
		theory_practical = 'P' AND
		semester = '".$_POST['semester']."' AND
		regular_reappear = '".$_POST['regular_reappear']."' AND
		internal_external = 'I' AND
		internal_lock_status = '1' AND
		internal_attendance_status = 'Detained' AND
		internal_max_marks = '".$_POST['internal_max_marks']."' AND
		teacher_username = '".$_SESSION['username']."' ORDER BY university_roll_no ASC") or die(mysql_error());

$branch_name = fetch_resource_db('branch_code',array('branch_code'),array($_POST['branch_code']),'resource_array_value','branch_name');
$course_name = fetch_resource_db('course_code',array('course_code'),array($_POST['course_code']),'resource_array_value','course_name');

$internal_examinar = fetch_resource_db('users',array('username'),array($_SESSION['username']),'resource_array','');


$sql = mysql_query("SELECT branch_name from branch_code WHERE branch_code=".$_POST['branch_code']." AND course_code=".$_POST['course_code']."") or die(mysql_error());

$department = mysql_fetch_assoc($sql);

$cbs_parameters = mysql_query("SELECT DISTINCT grading_type,mean,std_dev,total_students FROM student_internal_marks

WHERE 

theory_practical = '".$_POST['theory_practical']."' AND
subject_code = '".$_POST['subject_code']."' AND
semester = '".$_POST['semester']."' AND
branch_code = '".$_POST['branch_code']."' AND
regular_reappear = '".$_POST['regular_reappear']."' AND
aicte_rc = '".$_POST['aicte_rc']."' AND
shift = '".$_POST['shift']."' AND
teacher_username = '".$_SESSION['username']."' AND
internal_external = '".$_POST['internal_external']."'") or die(mysql_error());

$cbs = mysql_fetch_assoc($cbs_parameters);

if(in_array($_POST['course_code'],array(1,3,4))) {
	
	
	$hod = fetch_resource_db('users',array('course','designation','department'),array($_POST['course_code'],'HOD',$department['branch_name']),'resource_array','');
}

if(in_array($_POST['course_code'],array(2))) {
	$hod = fetch_resource_db('users',array('course','usertype','department'),array($_POST['course_code'],'course_admins',$department['branch_name']),'resource_array','');
}

$count = 1;

$html1="
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
			<br /> Affiliated to IKG Punjab Technical University</h4></td><td width='15%' align='center'><img src='images/ptu_logo.jpg' height='100' /></td>
		</tr>
	  </table></td></tr></table></span>
	  <br>
	  <table border='1' cellpadding='2' style='border-collapse:collapse;width:100%'>
	  <tr>
			<td colspan='6' align='center'><h3>Internal Practical Awards (".$_POST['regular_reappear'].") for Examination ".$exam_session."</h3></td>
			</tr>
			<tr>
			<th><b>Course & Branch</b></th>
			<td>".$course_name."(".$branch_name.")</td>
			<th colspan='3'><b>Semester</b></th>
			<td>".$_POST['semester']."</td>
			</tr>
			<tr>
			<th><b>Subject Name & Subject Code</b></th>
			<td colspan='5'>".$_POST['subject_title']."(".$_POST['subject_code'].")</td>
			</tr>
			<tr>
			<th colspan='2' align='left'><b>Shift / Full Time or Part Time / AICTE or RC</b></th>
			<td colspan='4'>".$_POST['shift']." / ".$_POST['full_part_time']." / ".$_POST['aicte_rc']."</td>
			</tr>
			<tr>
			<td><b>E-Printed On </b></td><td align='center'> ".date('d-m-Y')." </td>
			<td><b>Attendance Marked On </b></td><td align='center'> ".$att_date_f." </td>
			<td><b>Max. Marks (Internal) </b></td><td> ".$_POST['internal_max_marks']." </td>
			</tr>
			</table>
			<br><br>";
			
//Grade System		  
/*	 if (($_POST['semester']=='1' ) or ($_POST['semester']=='2' and $_POST['regular_reappear']=='Regular') )
{

	  $html1 .= "<table border='1' style='border-collapse:collapse;width:100%'>
	   <tr>
			<th  align='center'>Grading Type</th>
			<th  align='center'>Mean</th>
			<th  align='center'>Standard Deviation</th>
		</tr>
		
		<tr>
			<td  align='center'>".$cbs['grading_type']."</td>
			<td  align='center'>".$cbs['mean']."</td>
			<td  align='center'>".$cbs['std_dev']."</td>
		</tr>
		</table>
		<br/>
		<br/>";
		}*/
		
	    $html1 .=  "<table border='1' style='border-collapse:collapse;width:100%'>
	   <tr>
			<th  align='center' cellpadding='2'>Sr. No.</th>
			<th  align='center'>University Roll Number</th>
			<th  align='center'>Subject Code / Paper ID</th>
			<th  align='center'>Attendance</th>
			<th  align='center'>Obtained Int. Marks</th>
			<th  align='center'>Obtained Int. Marks in words</th>
	
	<!--		<th  align='center'>Final Normalized Marks</th>
			<th  align='center'>Grade Letter</th>-->";
	 $html1 .= "</tr>";
			
$data = mysql_query("SELECT * FROM student_internal_marks WHERE
		subject_code = '".$_POST['subject_code']."' AND
		course_code = '".$_POST['course_code']."' AND
		branch_code = '".$_POST['branch_code']."' AND
		aicte_rc = '".$_POST['aicte_rc']."' AND
		shift = '".$_POST['shift']."' AND
		full_part_time = '".$_POST['full_part_time']."' AND
		exam_month = '".$_POST['exam_month']."' AND
		exam_year = '".$_POST['exam_year']."' AND
		theory_practical = 'P' AND
		semester = '".$_POST['semester']."' AND
		regular_reappear = '".$_POST['regular_reappear']."' AND
		internal_external = 'I' AND
		internal_max_marks = '".$_POST['internal_max_marks']."' AND
		teacher_username = '".$_SESSION['username']."' ORDER BY university_roll_no ASC") or die(mysql_error());


while($row = mysql_fetch_assoc($data)) {
	$num_to_word = convert_number_to_words($row['internal_obtained_marks']);
	if($row['internal_attendance_status']!='Present') {
		$row['internal_obtained_marks'] = $row['internal_attendance_status'];
		$num_to_word = $row['internal_attendance_status'];
	}
			$html2 .= "<tr>
			<td align='center' >".$count."</td>
			<td align='center' >".$row['university_roll_no']."</td>
			<td align='center' >".$_POST['subject_code']." / I</td>
			<td align='center' >".$row['internal_attendance_status']."</td>
			<td align='center' >".$row['internal_obtained_marks']."</td>
			<td align='left' >".$num_to_word."</td>
		<!--	<td align='left' >".$row['normalized_marks']."</td>
			<td align='left' >".$row['grade_letter']."</td>-->";
			
	$html2 .="</tr>";
	$count++;
	};
		
		if($_POST['course_code']==1 && ($_POST['semester']==1 OR $_POST['semester']==2)) {
			$hod['name']="Dr. R.P. Singh";
		}
			
	  $html3 = "</table>
	  <br><br>
	  
	  <table border='1' cellpadding='2' style='border-collapse:collapse;width:100%'>
	  <tr>
	  <td colspan='6'>Result Analysis of students excluding Detained students.</td>
	  </tr>
	<tr>
		<td><b>Total Students:</b> ".$result_analysis['total_students']."</td>
		<td><b>Appeared:</b> ".$result_analysis['Appeared']."</td>
		<td><b>No. of Pass Students:</b> ".$result_analysis['Pass']."</td>
		<td><b>Pass Percentage:</b> ".round($result_analysis['pass_percentage'],2)." %</td>
		<td><b>No. of Fail Students:</b> ".$result_analysis['Fail']."</td>
		<td><b>Fail Percentage:</b> ".round($result_analysis['fail_percentage'],2)." %</td>
			
	</tr>
			
	  </table>";
//Grade System			
/*	if (($_POST['semester']=='1' ) or ($_POST['semester']=='2' and $_POST['regular_reappear']=='Regular') )
{

	  $html3 .= "<br><br><table border='1' cellpadding='2' style='border-collapse:collapse;width:100%'>
	  <tr>
	  <td colspan='6'>Result Analysis of students excluding Detained students. (Based on Normalized Marks)</td>
	  </tr>
	<tr>
		<td><b>Total Students:</b> ".$result_analysis_normalized['total_students']."</td>
		<td><b>Appeared:</b> ".$result_analysis_normalized['Appeared']."</td>
		<td><b>No. of Pass Students:</b> ".$result_analysis_normalized['Pass']."</td>
		<td><b>Pass Percentage:</b> ".round($result_analysis_normalized['pass_percentage'],2)." %</td>
		<td><b>No. of Fail Students:</b> ".$result_analysis_normalized['Fail']."</td>
		<td><b>Fail Percentage:</b> ".round($result_analysis_normalized['fail_percentage'],2)." %</td>
	</tr>
	  </table>";
		}*/
// End Grade System
	  $html3 .= "<br><br>
	  
	  <table border='1' cellpadding='2' style='border-collapse:collapse;width:100%'>
	  <tr>
		<td colspan='2'>Certified that marks submitted for further transmission to Examination Branch through Department
		will not be unlocked, if their is need of unlocking before final submission then only the 
		revised hardcopy is to be submitted as per the schedule.
		</td>	
		</tr>
	
	<tr>
		<td><br/>Sign..................................<br/>Deptt.Exam Co-ordinator</td>
		
		<td><br/>Sign..................................<br/>Uploaded by(".$internal_examinar['username'].") </td>
			
	</tr>
			
	  </table>
	  <br><br>
	  
	  <table border='1' cellpadding='2' style='border-collapse:collapse;width:80%'><tr>
			<th  align='left'>Total Number of Candidates Present </th><td  align='center'>".mysql_num_rows($data_present)."</td></tr>
			<tr><th align='left'>Total Number of Candidates Detained</th><td align='center'>".mysql_num_rows($data_detained)."</td</tr>
			
	  </table>
	  <br><br>
	  <table border='1' cellpadding='2' style='border-collapse:collapse;width:100%'>
	  <tr>
	  <td colspan='3' align='left'><b>Certified that all the candidates have completed the prescribed course of study and fulfilled all the conditions laid down in the Regulations for the examination and are eligible. The above marks have been matched with original award of each student. In case of any discrepancy in the award list, Internal examiners shall be responsible for the consequences. 
	  
	<!--  <br/>
	  <br/>
	  It is further certified that the computation of grades have been done by using software from IKGPTU website and all necessary guidelines
	  issued by Deam Academics, GNDEC, Ludhiana(vide no. SS/CBS/507 dated 13/1/2016) have been fulfilled.-->
	  
	  </b></td>
	  </tr>
		<tr><td colspan='3'>Sign of Subject Teacher(s):</td></tr>
		<tr><td> <br><br> 1..............................</td><td> <br><br> 2..............................</td><td><br><br>  3..............................</td></tr>
	  
			<tr>
			<!--<td align='center'><b>Uploaded by User ID :</b><br> ".$internal_examinar['username']." </td>-->
			<td align='center'></td>
			<td align='center'><b>Sign of HOD</b></td>
			<td><b>Members of Examination Committee</b></td>
			</tr>
			<tr>
			<td> <br><br> Sign..................................<br>(".$internal_examinar['name'].") </td>
			<td> <br><br>Sign..................................<!--<br>(".$hod['name'].")--></td>
			<td></td>
			</tr>
	  </table>
<b>Note:- Internal Examiner(s) are required to sign on every page with date. </b></body>";

$html = $html1.$html2.$html3;
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream($_POST['subject_title']."_".$_POST['subject_code']."_".$_POST['semester']."_Internal(P).pdf");

?>

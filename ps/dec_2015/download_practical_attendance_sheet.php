<?php

$subject_sql = mysql_query("SELECT * FROM subject_master WHERE subject_master_id='".$_POST['subject_master_id']."'") or die(mysql_error());

$subject_master = mysql_fetch_assoc($subject_sql);

		
$data = mysql_query("SELECT * FROM ptu_subjects WHERE 
FRM_BRID = '".$subject_master['branch_code']."' AND
Sub_Sem = '".$subject_master['semester']."' AND
SUB_CODE = '".$subject_master['subject_code']."' AND
SUB_TP = '".$subject_master['theory_practical']."' AND
Ed_Ext = '1' AND
shift='".$subject_master['shift']."' AND
full_part_time='".$subject_master['full_part_time']."' AND
Regular_Reappear = '".$subject_master['regular_reappear']."' AND
aicte_rc = '".$subject_master['aicte_rc']."' AND
received_status = 'Y' AND
eligibility = 'Y' ORDER BY ptu_subjects.ED_RollNo ASC") or die(mysql_error());


$branch_name = fetch_resource_db('branch_code',array('branch_code'),array($subject_master['branch_code']),'resource_array_value','branch_name');
$course_name = fetch_resource_db('course_code',array('course_code'),array($subject_master['course_code']),'resource_array_value','course_name');

$internal_examinar = fetch_resource_db('users',array('username'),array($_SESSION['username']),'resource_array','');


$sql = mysql_query("SELECT branch_name from branch_code WHERE branch_code=".$subject_master['branch_code']." AND course_code=".$subject_master['course_code']."") or die(mysql_error());

$department = mysql_fetch_assoc($sql);

if(in_array($subject_master['course_code'],array(1,3,4))) {
	
	
	$hod = fetch_resource_db('users',array('course','designation','department'),array($subject_master['course_code'],'HOD',$department['branch_name']),'resource_array','');
}

if(in_array($subject_master['course_code'],array(2))) {
	$hod = fetch_resource_db('users',array('course','usertype','department'),array($subject_master['course_code'],'course_admins',$department['branch_name']),'resource_array','');
}

$total_entries = mysql_num_rows($rolls);
$entries_per_page = 10;

$count=1;
$scount=1;
$footer_displayed=0;

$overflow = $total_entries%$entries_per_page;

$rem_number = $total_entries-$overflow;

$total_pages = $rem_number/$entries_per_page;

if($total_pages==0) {
	$total_pages=1;
}

if($rem_number!=0) {
	$total_pages++;
}

$page_no=1;

$count = 1;

$html = array();

$html[] = "
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
			<td width='70%' align='center'><h4> GURU NANAK DEV ENGINEERING COLLEGE, LUDHIANA</h4>			<h4> ( An Autonomous College Under UGC Act - 1956 [2(f) and 12(B)] )
			<br /> Affiliated to Punjab Technical University</h4></td><td width='15%' align='center'><img src='images/ptu_logo.jpg' height='100' width='90' /></td>
		</tr>
	  </table></td></tr></table>
</span>
	  <br>
	  <table border='1' cellpadding='2' style='border-collapse:collapse;width:100%'>
	  <tr>
			<td colspan='4' align='center'><h3>Attendance Sheet for Practical Examinations (".$subject_master['regular_reappear'].") ".$exam_session."</h3></td>
			</tr>
			
			<tr>
			<th align='left'><b>Course & Branch</b></th>
			<td>".$course_name."(".$branch_name.")</td>
			
			<th align='left'><b>Semester</b></th>
			<td align='center'>".$subject_master['semester']."</td>
			</tr>
			
			<tr>
			<th align='left'><b>Subject Name & Code</b></th>
			<td colspan='3'>".$subject_master['subject_title']."(".$subject_master['subject_code'].")</td>
			</tr>
			
			<tr>
			<td><b>E-Printed On</b></td>
			<td align='center'> ".date('d-m-Y')." </td>
			
			<td><b>Date of Exam </b></td>
			<td align='left'> </td>
			</tr>
			
	  </table>
	   <br><br>
	   <table border='1' style='border-collapse:collapse;width:100%'>
	   <tr>
			<th  align='center' cellpadding='2'>Sr. No.</th>
			<th  align='center'>University Roll Number</th>
			<th  align='center'>Subject Name & Code</th>
			<th  align='center'>Student Name</th>
			<th  align='center'>Signature of Student</th>
			</tr>";
$dcount = 0;

		
while($row = mysql_fetch_assoc($data)) {
	
//	$shift_ft = mysql_query("SELECT * FROM student_info WHERE university_roll_no='".$row['ED_RollNo']."'") or die(mysql_error());
//	
//	 if($shift_ft['shift']!=$subject_master['shift'] OR $shift_ft['full_part_time']!=$subject_master['full_part_time']) {
//		continue;
//	}
	
	$detained_status = mysql_query("SELECT * FROM detainee_list WHERE 
	university_roll_no='".$row['ED_RollNo']."' AND
	semester='".$subject_master['semester']."' AND
	subject_code='".$subject_master['subject_code']."' AND
	theory_practical='".$subject_master['theory_practical']."' AND
	detained_status='Y' AND
	locked='Y'");
	
	if(mysql_num_rows($detained_status)==1) {
		$sign = 'Detained';
		$dcount++;
	}
	else {
		$sign = '';
	}
	
			$html[] = "<tr>
			<td align='left' >".$count."</td>
			<td align='left' >".$row['ED_RollNo']."</td>
			<td align='left' width='30%'>".$subject_master['subject_title']."(".$subject_master['subject_code'].")</td>
			<td align='left' >".ucwords(strtolower($row['StudentName']))."</td>
			<td align='center' width='35%'><br/>".$sign."<br/></td>
			</tr>";
			
			$count++;
		};
		
		if($_POST['course_code']==1 && ($_POST['semester']==1 OR $_POST['semester']==2)) {
			$hod['name']="Dr. R.P. Singh";
		}
		
		$html[] = "</table>
	  <br><br>
	  
	  <table border='1' cellpadding='2' style='border-collapse:collapse;width:100%'>
	  <tr>
		<td><b>No. of Candidates Detained: ".$dcount."</b></td><td><b>No. of Candidates Present: </b></td><td><b>No. of Candidates Absent: </b></td>
	</tr>	
	  </table>";
			
	  $html[] = "
	  <br><br>
	  
	  <table border='1' cellpadding='2' style='border-collapse:collapse;width:100%'>
	  <tr>
		<td><b>Internal Examiner</b></td>
		<td><b>External Examiner</b></td>	
	</tr>
	
	<tr>
		<td><br/>Sign..................................<br/><br/>Name..................................<br/><br/>Date..................................</td>
		<td><br/>Sign..................................<br/><br/>Name..................................<br/><br/>Date..................................</td>
	</tr>
			
	  </table>
	<b>Note:- Both Internal and External Examiner(s) are required to sign on every page with date. </b></body>";

$htm = implode(" ",$html);
$html = $htm;
$dompdf = new DOMPDF();
$dompdf->set_paper("a4","portrait");
//$dompdf->font('times', '', 9);
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream($subject_master['subject_title']."_".$subject_master['subject_code']."_".$subject_master['semester']."_External(P).pdf");

?>

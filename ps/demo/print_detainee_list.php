<?php

$branch_sql = mysql_query("SELECT department FROM users WHERE username='".$_SESSION['username']."'");
$dept_sql = mysql_fetch_assoc($branch_sql);
$dept = $dept_sql['department'];

mysql_query("UPDATE detainee_list SET print_taken='Y', print_taken_on='".date('d-m-Y H:i:s')."'");

$exam_coordinator = fetch_resource_db('users',array('username'),array($_SESSION['username']),'resource_array_value','name');
$hod = fetch_resource_db('users',array('department','designation'),array($dept,'HOD'),'resource_array_value','name');

$rolls = mysql_query("SELECT * FROM detainee_list WHERE
detained_by = '".$_SESSION['username']."' AND
detained_status='Y' AND
cleared_status='N' AND
theory_practical = '".$_POST['theory_practical']."' ORDER BY university_roll_no") or die(mysql_error());

$ccode_sql = mysql_query("SELECT course FROM users WHERE username='".$_SESSION['username']."'");
$ccode = mysql_fetch_assoc($ccode_sql);

if($_POST['theory_practical']=='T') {
	$th_pr = "Theory Subjects";
}
else {
	$th_pr = "Practical Subjects";
}




if($ccode['course']==1) {
	$dean='Dean Academics';
}
if($ccode['course']==2) {
	$dean='Dean PG/Coordinator PTU Regional Centre';
}

$ht = array();
$count = 1;

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

$ht[] =  "
<html>
<head>
<style type='text/css'>
table {
	width:100%;
	border-collapse:collapse;
}

#mypage {
	page-break-after:always
}

th {
font-size:8px;

}
td {
font-size:10px;

}

#page_no {
	font-size:10px;
	font-weight:bold;
}

</style>
</head>
<br/>";

$ht[] = "<table cellpadding='4'><tr>
			<!--<td width='15%' align='center'><img src='images/gndec_logo.jpg' height='100' /></td>-->
			<td width='70%' align='center'><span style='font-size:20px'><br /> GURU NANAK DEV ENGINEERING COLLEGE, LUDHIANA </span>
			<br/><span style='font-size:16px;'>DEPARTMENT OF ".strtoupper($dept)."</span>
			<!--<td width='15%' align='center'><img src='images/ptu_logo.jpg' height='100' width='90' /></td>-->
		</tr>
	  </table>";

$ht[]="<br/><br/><table><tr>
<td align='left' style='font-size:15px'>No. _________________</td>
<td align='right' style='font-size:15px'>Dated: ________________</td>
</tr>
</table>";

$ht[] ="<h4><u>".$dean."</u></h4> 

Following students of current session and previous semesters are detained in ".$th_pr." due to shortage of attendance for End Semester Examinations, ".$exam_session."  as per details given below:-<br/><br/><br/>";

$ht[] = "<table border='1px'>
		<tr>
		<th>Sr. No.</th>
		<th>Course(Branch)</th>
		<th>FT-PT / AICTE-RC</th>
		<th>University Roll No.</th>
		<th>Name / <br/> Father Name</th>
		<th>Sem.</th>
		<th>Subject Code</th>";
		if($_POST['theory_practical']=='T') {
			$ht[] =  "<th>Paper ID</th>";
		}
		$ht[] =  "
		<th>Subject Name</th>
		<th>T/P</th>
		<th>Detained (Exam Session)</th>
		</tr>";

while($row = mysql_fetch_assoc($rolls)) {
	
	$course = fetch_resource_db('course_code',array('course_code'),array($row['course_code']),'resource_array_value','course_name');
	$branch = fetch_resource_db('branch_code',array('branch_code'),array($row['branch_code']),'resource_array_value','branch_name');
		
		$student_data_si_sql = mysql_query("SELECT * FROM student_info WHERE 
		university_roll_no='".$row['university_roll_no']."'
		") or die(mysql_error());
		$student_data_si = mysql_fetch_assoc($student_data_si_sql);
		
		

		$ht[]= "<tr>
		<td>".$scount."</td>
		<td>".$course."(".$branch.")</td>
		<td>".$student_data_si['full_part_time']." / ".$student_data_si['aicte_rc']."</td>
		<td>".$row['university_roll_no']."</td>
		<td>".strtoupper($student_data_si['ptu_student_name'])." / ".strtoupper($student_data_si['ptu_father_name'])."</td>
		<td>".$row['semester']."</td>
		<td>".$row['subject_code']."</td>";
		if($_POST['theory_practical']=='T') {
			$ht[] = "<td>".$row['paper_id']."</td>";
		}
		$ht[] = "
		<td>".$row['subject_title']."</td>
		<td>".$row['theory_practical']."</td>
		<td>".$row['d_exam_month'].", ".$row['d_exam_year']."</td>
		</tr>";
		
		if($count==$entries_per_page) {
			
			$ht[] = "</table><br/><br/><br/><table><tr>
			<td align='left' style='font-size:12px'>(".$exam_coordinator.")
			<br/>Department Exam Co-ordinator
			</td>

			<td align='right' style='font-size:12px'>
			<br/>HOD
			</td>


			</tr>
			</table>";
			
			$ht[] = "<br/><table>
	<tr>
	<td>Note:
		<br/>1. Signing Officials must ensure that incase a student is not listed in the examination portal then
		information have to be sent separately also.
		<br/>2. B.Tech.(1st Year) students must also be considered while submitting detention record.
	</td>
	</tr>
	</table>";

			$ht[] = "
			<br/>
	  
			<table><tr>
			<td align='left'><span id='page_no'>Printed On: ".date('d-m-Y H:i:s')." </span></td>
			<td align='right'><span id='page_no'>Page: ".$page_no." of ".$total_pages."</span></td>
			</tr></table>";
			$ht[]="<div id='mypage'></div>";
			
			if($scount!=$total_entries) {
				$ht[] = "<table border='1px'>
				<tr>
				<th>Sr. No.</th>
				<th>Course(Branch)</th>
				<th>FT-PT / AICTE-RC</th>
				<th>University Roll No.</th>
				<th>Name / <br/> Father Name</th>
				<th>Sem.</th>
				<th>Subject Code</th>
				";
				if($_POST['theory_practical']=='T') {
					$ht[] =  "<th>Paper ID</th>";
				}
				$ht[] =  "
				<th>Subject Name</th>
				<th>T/P</th>
				<th>Detained (Exam Session)</th>
				</tr>";
			}

			$count=0;
			$page_no++;
			$footer_displayed++;
		}
		$count++;
		$scount++;
}

if($page_no==$total_pages) {
	$ht[] = "<br/><br/><br/></table><table><tr>
	<td align='left' style='font-size:12px'>(".$exam_coordinator.")
	<br/>Department Exam Co-ordinator
	</td>

	<td align='right' style='font-size:12px'>
	<br/>HOD
	</td>


	</tr>
	</table>";
	
	$ht[] = "<br/><table>
	<tr>
	<td>Note:
		<br/>1. Signing Officials must ensure that incase a student is not listed in the examination portal then
		information have to be sent separately also.
		
	</td>
	</tr>
	</table>";

	$ht[] = "
	  <br/>
	  <table><tr>
	  <td align='left'><span id='page_no'>Printed On: ".date('d-m-Y H:i:s')." </span></td>
	  <td align='right'><span id='page_no'>Page: ".$page_no." of ".$total_pages."</span></td>
	  </tr></table>";
	  $footer_displayed=0;
}


$htm = implode(" ",$ht);

//echo $htm;

$html = $htm;
$dompdf = new DOMPDF();
$dompdf->set_paper("a4","landscape");

$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("Detainee List_".$_POST['theory_practical']."_".date('d-m-Y H:i:s').".pdf");

?>

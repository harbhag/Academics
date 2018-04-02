<?php

$course_branch = explode(',',$_POST['branch_code']);

$htm = array();

$course_name = mysql_fetch_assoc(mysql_query("SELECT course_name FROM course_code WHERE course_code='".$course_branch[0]."'"));
$branch_name = mysql_fetch_assoc(mysql_query("SELECT branch_name FROM branch_code WHERE branch_code='".$course_branch[1]."'"));

$subject_details= mysql_query("SELECT distinct date_of_exam,Sub_PaperID,SUB_CODE FROM ptu_subjects WHERE 
FRM_BRID='".$course_branch[1]."'AND 
course_code='".$course_branch[0]."'AND 
Sub_Sem='".$_POST['semester']."' AND 
aicte_rc='".$_POST['aicte_rc']."' AND 
full_part_time='".$_POST['full_part_time']."' AND 
Regular_Reappear='".$_POST['regular_reappear']."' AND 
ucentre='".$_POST['ucentre']."' AND 
usession='".$_POST['usession']."' AND 
SUB_TP='T' ORDER BY date_of_exam ASC") or die(mysql_error());

$rollno_details = mysql_query("SELECT distinct ED_RollNo FROM ptu_subjects WHERE 
FRM_BRID='".$course_branch[1]."'AND 
course_code='".$course_branch[0]."'AND 
Sub_Sem='".$_POST['semester']."' AND 
eligibility='Y' AND
received_status='Y' AND
aicte_rc='".$_POST['aicte_rc']."' AND 
full_part_time='".$_POST['full_part_time']."' AND 
Regular_Reappear='".$_POST['regular_reappear']."' AND 
ucentre='".$_POST['ucentre']."' AND 
usession='".$_POST['usession']."' AND 
SUB_TP='T' ORDER BY ED_RollNo ASC") or die(mysql_error());



$htm[] = "<center><table cellpadding='4' width='100%'><tr>
			
			<td width='70%' align='center'><span style='font-size:20px'><br /> GURU NANAK DEV ENGINEERING COLLEGE, LUDHIANA </span>
			<br/><span style='font-size:16px;font-weight:bold'>*An Autonomous College Under UGC Act - 1956 [2(f) and 12(B)]</span>
			<br/><span style='font-size:18px'>Affiliated to I.K. Gujral Punjab Technical University</span>
			<br/><span style='font-size:14px'>END SEMESTER EXAMINATIONS, ".$exam_session."</span>
			<br/><span style='font-size:14px'>ATTENDANCE SHEET FOR THEORY EXAMINATIONS</span>
			<br/><span style='font-size:14px'>(To be returned to the Controller of Examination after completion of End Semester Examination)</span></td>
			
		</tr>
		
		<tr>
		<td align='center' style='font-size:16px'>Centre No:<b>".$_POST['ucentre']."</b> Session: <b>".$_POST['usession']."</b> Course (B.Tech./M.Tech./MBA/MCA):<b>".$course_name['course_name']."</b>FT/PT:<b>".$_POST['full_part_time']."</b>AICTE/RC:<b>".$_POST['aicte_rc']."</b> Branch:<b>".$branch_name['branch_name']."</b> Semester:<b>".$_POST['semester']."</b> Regular/ Reappear:<b>".$_POST['regular_reappear']."</b> Total Candidates:<b>".mysql_num_rows($rollno_details)."</b></td>
		</tr>
	  </table></center>";

$htm[] =  "<table border='1' cellpadding='2' style='border-collapse:collapse;width:100%'>

<tr>

<td width='4%' style='font-size:8px'>Sr. No.</td>
<!--<td width='10%' style='font-size:8px'>Photo</td>-->
<td width='10%' style='font-size:8px'>Roll No.</td>

<td>

</td>";

$sub_count=0;
$run_status = 1;


while($row=mysql_fetch_assoc($subject_details)) {
	
	$htm[] = "
	<td style='font-size:8px'>
	Date = <b>".$row['date_of_exam']."</b>
	<br/>Paper ID = <b>".$row['Sub_PaperID']."</b>
	<br/>Sub Code = <b>".$row['SUB_CODE']."</b>
	</td>
	";
	$sub_count++;

}

$htm[] = "
</tr>";

$count = 1;

$page_count = 0;

while($row=mysql_fetch_assoc($rollno_details)) {
	
	
	$student_details_sql = mysql_query("SELECT * FROM student_info WHERE university_roll_no='".$row['ED_RollNo']."'") or die(mysql_error());
	$student_details = mysql_fetch_assoc($student_details_sql);
	
	//$photo = 'http://exam.gndec.ac.in/images/'.$student_details['admission_batch'].'/'.$student_details['course_code'].'/'.$student_details['branch_code'].'/'.$student_details['university_roll_no'];
	
	$photo = 'http://exam.gndec.ac.in/images/2007/1/21/gne.jpg';
	
	$htm[] = "<tr>
	<td style='font-size:12px'>".$count."</td>
	<!--<td><img height='80' width='70' src='".$photo."' /></td>-->
	<td style='font-size:12px'>".$row['ED_RollNo']."</td>
	<td style='font-size:12px'>i)Ans. Booklet No.
	<br/><br/>ii)Signature 
	</td>";
	for($i=1;$i<=$sub_count;$i++) {
		$htm[] = "<td style='font-size:12px'><br/>i)....................
		<br/><br/>ii)....................</td>";
	}
	$htm[] = "</tr>";
	$count++;
	$page_count++;
	
	if($run_status==1) {
		$limit=8;
	}else {
		$limit = 10;
	}
	
	if($page_count==$limit) {
		$page_count=0;
		$run_status = 2;
		$htm[] = "
		
		<tr>
		<td colspan='3'>Total Present<br/></td>";
		for($i=1;$i<=$sub_count;$i++) {
				$htm[] = "<td><br/></td>";
		}

		$htm[] =  "
		</tr>
		<tr>
		<td colspan='3' height='20'>Signature of Invigilator/s & (Room No.)</td>";
		for($j=1;$j<=$sub_count;$j++) {
				$htm[] = "<td></td>";
		}
		
		$col_count = 3+$sub_count;


		$htm[] = "
		</tr>
		<tr>
		<td height='30' align='center' colspan='$col_count'><b>Signature of Dy. Supdt.................................... &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature of Supdt(".$_SESSION['fullname'].")..................................</b></td>
		</tr>
		</table>";

		
		$htm[]="<div style='page-break-after:always'></div>";
		
		$htm[] =  "<table border='1' cellpadding='2' style='border-collapse:collapse;width:100%'>

		<tr>

		<td width='4%' style='font-size:8px'>Sr. No.</td>
	<!--	<td width='10%' style='font-size:8px'>Photo</td> -->
		<td width='10%' style='font-size:8px'>Roll No.</td>

		<td>

		</td>";
		
		$subject_details= mysql_query("SELECT distinct date_of_exam,Sub_PaperID,SUB_CODE FROM ptu_subjects WHERE 
		FRM_BRID='".$course_branch[1]."'AND 
		course_code='".$course_branch[0]."'AND 
		Sub_Sem='".$_POST['semester']."' AND 
		aicte_rc='".$_POST['aicte_rc']."' AND 
		full_part_time='".$_POST['full_part_time']."' AND 
		Regular_Reappear='".$_POST['regular_reappear']."' AND 
		ucentre='".$_POST['ucentre']."' AND 
		usession='".$_POST['usession']."' AND
		SUB_TP='T'  ORDER BY date_of_exam") or die(mysql_error());
		
		$sub_count=0;

		while($row=mysql_fetch_assoc($subject_details)) {
	
			$htm[] = "
			<td style='font-size:8px'>
			Date = <b>".$row['date_of_exam']."</b>
			<br/>Paper ID = <b>".$row['Sub_PaperID']."</b>
			<br/>Sub Code = <b>".$row['SUB_CODE']."</b>
			</td>
			";
			$sub_count++;

		}
	}
}

$col_count = 3+$sub_count;


$htm[] = "
<tr>
<td colspan='3'>Total Present<br/></td>";
for($i=1;$i<=$sub_count;$i++) {
		$htm[] = "<td><br/></td>";
}

$htm[] =  "
</tr>


<tr>
<td colspan='3' height='20'>Signature of Invigilator/s & (Room No.)<br/></td>";
for($i=1;$i<=$sub_count;$i++) {
		$htm[] = "<td><br/></td>";
}

$htm[] =  "
</tr>
<tr>
<td height='30' align='center' colspan='$col_count'><b>Signature of Dy. Supdt.................................... &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature of Supdt(".$_SESSION['fullname'].")..................................</b></td>
</tr>
</table>";

$html = implode(" ",$htm);
//echo $html;


$dompdf = new DOMPDF();
$dompdf->set_paper("a3","landscape");

$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("Attendance_sheet_".$_POST['ucentre']."_".$course_name['course_name']."_".$branch_name['branch_name']."_".$_POST['semester']."_".$_POST['regular_reappear'].".pdf");

?>

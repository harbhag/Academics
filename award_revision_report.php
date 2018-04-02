<?php

$exam_session = 'November, 2016';

if($_POST['award_revision_report']=='Totaling') {
	
	$report_title = "Record of Totaling issues for End Semester Examination ".$exam_session;
	
	$data = mysql_query("SELECT * FROM award_revision WHERE
	updated_by = '".$_SESSION['username']."' AND
	locked = 'Y' AND revision_type='totaling' ORDER BY paper_id,university_roll_no") or die(mysql_error());
	
	//ONLINE
	/*
	$wording = "It is certified that above mentioned discrepancies with regards to Totaling on answer sheets have been found. Necessary revision of marks which are required to be performed in the examination branch has been mentioned and wherever applicable appropriate remarks have also been given.";
	*/
	
	//OFFLINE
	$wording = "It is certified that above marks award are verified as per the awards on the answer sheets.";
}

if($_POST['award_revision_report']=='Unchecked') {
	
	$report_title = "Record of Unchecked Questions for End Semester Examination ".$exam_session;
	
	$data = mysql_query("SELECT * FROM award_revision WHERE
	updated_by = '".$_SESSION['username']."' AND
	locked = 'Y' AND revision_type='unchecked' ORDER BY paper_id,university_roll_no") or die(mysql_error());
	
	$wording = "It is certified that above mentioned discrepancies with regards to unchecked questions in answer sheets have been found. Necessary remarks in terms of question numbers which were unchecked have also been given.";
}

if($_POST['award_revision_report']=='Revaluation') {
	
	$report_title = "Record of Revaluation for End Semester Examination ".$exam_session;
	
	$data = mysql_query("SELECT * FROM award_revision WHERE
	updated_by = '".$_SESSION['username']."' AND
	locked = 'Y' AND revision_type='revaluation' ORDER BY paper_id,university_roll_no") or die(mysql_error());
	
	$wording = "It is certified that above mentioned students have filled discrepancy redress form (DRF). All such forms and original receipts (DRF Fee) are attached herewith.";
}



$course_admin_sql = mysql_query("SELECT * FROM users WHERE username='".$_SESSION['username']."'") or die(mysql_error());

$course_admin = mysql_fetch_assoc($course_admin_sql);

$teacher_name = fetch_resource_db('users_intranet',array('username'),array($_SESSION['username']),'resource_array_value','name');
$head_examiner = fetch_resource_db('users_intranet',array('username'),array($_POST['assigned_by']),'resource_array_value','name');

$htm = array();

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
			<td width='70%' align='center'><h4> GURU NANAK DEV ENGINEERING COLLEGE, LUDHIANA </h4>			<h4> ( An Autonomous College Under UGC Act [2(f) and 12(B)])
			<br /> Affiliated to IKG Punjab Technical University</h4></td><td width='15%' align='center'><img src='images/ptu_logo.jpg' height='100' /></td>
		</tr>
	  </table></td></tr></table>
	  </span>
	  <table border='1' style='border-collapse:collapse;width:100%'>
	  <tr>
			<!--<td align='left'><b><br/>Ref. No...............................</b></td>-->
			
			<td align='left' colspan='2'><b><br/>Date...............................</b></td>
			</tr> <tr>
			<td colspan='2' align='center'><b><br/><h3>".$report_title."</h3></b></td>
			</tr>
			
			
	  
	  </table>
	   <br/>
	   <table border='1' style='border-collapse:collapse;width:100%'>
	   <tr>
			<th  align='center' cellpadding='2'>Sr. No.</th>
			<th  align='center'>University Roll No.</th>
			<th  align='center'>Subject Code / Paper ID / M-Code</th>
			<th  align='center'>Subject Title</th>
			<th  align='center'>Original Marks Obtained</th>";
			if($_POST['award_revision_report']=='Totaling') {
				$htm[]= "<th  align='center'>Revised Marks</th>";
			}
			
			
				$htm[]= "
				<!--<th  align='center'>Remarks(if Any)</th>-->
				</tr>";
			
$page_no = 1;			
$page_count = 0;
while($row = mysql_fetch_assoc($data)) {
	$num_to_word = convert_number_to_words($row['external_obtained_marks']);
	
	if($_POST['award_revision_report']!='Totaling') {
		
		$row['revised_marks'] = "N/A";
		
	}
	
	$htm[] = "<tr>
	<td align='left'>".$count."</td>
	<td align='left'>".$row['university_roll_no']."</td>
	<td align='left'>".$row['subject_code']." / ".$row['paper_id']." / ".$row['m_code']."</td>
	<td align='left'>".$row['subject_title']."</td>
	<td align='left'>".$row['external_obtained_marks']."</td>";
	if($_POST['award_revision_report']=='Totaling') {
		$htm[]="<td align='left'>".$row['revised_marks']."</td>";
	}
	
	$htm[]="<!--<td align='left'>".$row['remarks']."</td>-->
		</tr>";
	
	$count++;
};
		
	//ONLINE	
	/*
 $htm[] = "</table>
	  	  </table>
	  	 
	  <br>
	  <table border='1' cellpadding='2' style='border-collapse:collapse;width:100%'>
	  
	  <tr>
	  <td colspan='2' align='left'><p align='justify'></p><b>".$wording."</b></p></td>
	  </tr>
		<tr>
			<td align='letf'><b>Exam Co-ordinator :</b><br> ".$course_admin['name']."(".$course_admin['username'].") </td>
			<td align='letf'><b>Head of Department</b></td>
			</tr>
			<tr>
			<td> <br><br> Sign.................................. </td>
			<td> <br><br> Sign..................................</td>
			</tr>
	  </table>
<b>Note:- Signing officials are required to sign on every page with date. </b>
E-Printed on: ".date('d-m-Y H:i:s')."
</body>";
*/		


//OFFLINE

$htm[] = "</table>
	  	  </table>
	  	 
	  <br>
	  <table border='1' cellpadding='2' style='border-collapse:collapse;width:100%'>
	  
	  <tr>
	  <td colspan='2' align='left'><p align='justify'></p><b>".$wording."</b></p></td>
	  </tr>
		<tr>
			<td align='letf'><br><br>Sign..................................<b><br/>Dealing Hand (1)</b></td>
			<td align='letf'><br><br>Sign..................................<b><br/>Dealing Hand (2)</b></td>
			</tr>
			<tr>
			<td> <br><br> Sign.................................. <b><br/>Assistant Controller (Evaluation)</b></td>
			<td> <br><br> Sign..................................<b><br/>Assistant Controller (Decoding)</b></td>
			</tr>
	  </table>
<b>Note:- Signing officials are required to sign on every page with date. </b>
Uploaded By: ".$_SESSION['username']."
</body>";



$html = implode('',$htm);
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream($_POST['award_revision_report']."_report_".$_SESSION['username']."_".date('d-m-Y H:i:s').".pdf");

?>
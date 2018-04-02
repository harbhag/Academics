<?php

//$paper_ids = fetch_resource_db('subject_master',array('usession','regular_reappear','theory_practical'),
	//						array($_SESSION['usession'],'Regular','T'),'resource','');

$paper_ids = mysql_query("SELECT DISTINCT paper_id 
						FROM subject_master WHERE 
						usession='".$_SESSION['usession']."' AND
						theory_practical='T' AND
						paper_id = 'A0612'
						ORDER BY regular_reappear ASC, branch_code ASC, date_of_exam ASC,course_code ASC") or die(mysql_error());
//$branch_name = fetch_resource_db('branch_code',array('branch_code'),array($_POST['branch_code']),'resource_array_value','branch_name');
//$course_name = fetch_resource_db('course_code',array('course_code'),array($_POST['course_code']),'resource_array_value','course_name');

//$internal_examinar = fetch_resource_db('users',array('username'),array($_SESSION['username']),'resource_array','');


//$sql = mysql_query("SELECT branch_name from branch_code WHERE branch_code=".$_POST['branch_code']." AND course_code=".$_POST['course_code']."") or die(mysql_error());

//$department = mysql_fetch_assoc($sql);

/*if(in_array($_POST['course_code'],array(1,3,4))) {
	
	
	$hod = fetch_resource_db('users',array('course','designation','department'),array($_POST['course_code'],'HOD',$department['branch_name']),'resource_array','');
}

if(in_array($_POST['course_code'],array(2))) {
	$hod = fetch_resource_db('users',array('course','usertype','department'),array($_POST['course_code'],'course_admins',$department['branch_name']),'resource_array','');
}
*/
$count = 1;

$html1="<table style='width:100%'>
			<tr>
			<td align='center'> 
			<table width='100%'>
			<tr>
			<td width='15%' align='center'><img src='images/gndec_logo.jpg' height='100' /></td>
			<td width='70%' align='center'><h4> GURU NANAK DEV ENGINEERING COLLEGE, LUDHIANA </h4>			<h4> ( An Autonomous College Under UGC Act -1956 [2(f) and 12(B)])
			<br /> Affiliated to Punjab Technical University</h4></td><td width='15%' align='center'><img src='images/ptu_logo.jpg' height='100' width='100' /></td>
		</tr>
	  </table></td></tr></table>
	  <br>
	  <table border='1' cellpadding='2' style='border-collapse:collapse;width:100%'>
	  <tr>
			<td colspan='4' align='center'><h3>External Practical Awards (".$_POST['regular_reappear'].") for Examination April-May, 2014</h3></td>
			</tr>
			<tr>
			<th align='left'><><b>Program & Branch</b></th>
			<td>".$course_name."(".$branch_name.")</td>
			<th align='left'><b>Semester</b></th>
			<td align='center'>".mysql_num_rows($paper_ids)."</td>
			</tr>
			<tr>
			<th><b>Subject Name & Code</b></th>
			<td colspan='3'>".$_POST['subject_title']."(".$_POST['subject_code'].")</td>
			</tr>
			<tr>
			<th colspan='2' align='left'><b>Shift / Full Time or Part Time / AICTE or RC</b></th>
			<td colspan='2'>".$_POST['shift']." / ".$_POST['full_part_time']." / ".$_POST['aicte_rc']."</td>
			</tr>
			<tr>
			<td><b>Date of Exam </b></td><td align='center'> ".date('d-m-Y')." </td>
			<td><b>Max. Marks (External) </b></td><td align='center'> ".$_POST['external_max_marks']." </td>
			</tr>
	  </table>
	   <br><br>
	   <table border='1' style='border-collapse:collapse;width:100%'>
	   <tr>
			<th  align='center' cellpadding='2'>Sr. No.</th>
			<th  align='center'>University Roll Number</th>
			<th  align='center'>Paper ID</th>
			<th  align='center'>Subject Code</th>
			<th  align='center'>Subject Title</th>
			<th  align='center'>Semester</th>
			<th  align='center'>Course</th>
			<th  align='center'>Branch</th>
			<th  align='center'>Regular/Reappear</th>
			<th  align='center'>Examination Centre</th>
			</tr>";
while($row = mysql_fetch_assoc($paper_ids)) {
	$roll_nos = mysql_query("select distinct 
						
						ptu_subjects.ED_RollNo, 
						ptu_subjects.Sub_PaperID, 
						ptu_subjects.SUB_CODE, 
						ptu_subjects.Sub_Sem, 
						ptu_subjects.SUB_TITLE, 
						ptu_subjects.StudentName, 
						ptu_subjects.FRM_BRID  
						
						FROM ptu_subjects,centre_allotment WHERE 
						
						
						ptu_subjects.ED_RollNo=centre_allotment.university_roll_no AND
						ptu_subjects.Sub_PaperID='".$row['paper_id']."' AND
						centre_allotment.regular_reappear = 'Regular' AND
						centre_allotment.ucentre = '".$_SESSION['ucentre']."' AND
						ptu_subjects.Regular_Reappear = 'Regular' AND
						ptu_subjects.Ed_Ext = 1 AND
						ptu_subjects.SUB_TP='T' ") or die(mysql_error());
						
						while($row1 = mysql_fetch_assoc($roll_nos)) {
	
			$html2 .= "<tr>
			<td align='center'>".$count."</td>
			<td align='center'>".$row1['ED_RollNo']."</td>
			<td align='center'>".$row1['Sub_PaperID']."</td>
			<td align='center'>".$row1['SUB_CODE']."</td>
			<td align='center'>".$row1['SUB_TITLE']."</td>
			<td align='center'>".$row1['StudentName']."</td>
			<td align='center'>".$row1['FRM_BRID']."</td>
			<td align='center'>".$row1['SUB_CODE']."</td>
			<td align='center'>".$row1['SUB_CODE']."</td>
			<td align='center'>".$row1['SUB_CODE']."</td>
			</tr>";
			$count++;
		}
	}
			
	  /*$html3 = "</table>
	  <br><br>
	  
	  <table border='1' cellpadding='2' style='border-collapse:collapse;width:80%'><tr>
			<th  align='left'>Total Number of Candidates Present </th><td  align='center'>".mysql_num_rows($data_present)."</td></tr>
			<tr><th  align='left'>Total Number of Candidates Absent </th><td  align='center'>".mysql_num_rows($data_absent)."</td></tr>
			<tr><th align='left'>Total Number of Candidates Detained</th><td align='center'>".mysql_num_rows($data_detained)."</td</tr>
			
	  </table>
	  <br><br>
	  <table border='1' cellpadding='2' style='border-collapse:collapse;width:100%'>
	  <tr>
	  <td colspan='4' align='left'><b>Certified that all the candidates have completed the prescribed course of study and fulfilled all the conditions laid down in the Regulations for the examination and are eligible. The above marks have been matched with original award of each student. In case of any discrepancy in the award list, Internal & External examiners shall be responsible for the consequences. </b></td>
	  </tr>
		<tr><td colspan='4'>Internal Examiner(s):</td></tr>
		<tr><td>Name</td><td> <br> 1....................................</td><td> <br> 2....................................</td><td><br>  3....................................</td></tr>
		<tr><td>Sign</td><td> <br> 1....................................</td><td> <br> 2....................................</td><td><br>  3....................................</td></tr>
		<tr><td colspan='4'>External Examiner:</td></tr>
		<tr><td colspan='2'> <br>Name  </td><td> <br>Sign  </td><td> <br> Moblie No. </td></tr>
	  
			<tr>
			<td align='center'><b>Uploaded by User ID :</b><br> ".$internal_examinar['username']." </td>
			<td align='center'><b>Sign of HOD</b></td>
			<td colspan='2'><b>Name & Sign of Director/Dean Academics</b></td>
			</tr>
			<tr>
			<td> <br><br> Sign..................................<br>(".$internal_examinar['name'].") </td>
			<td> <br><br>Sign..................................<br>(".$hod['name'].")</td>
			<td colspan='2'></td>
			</tr>
	  </table>
<b>Note:- Both Internal and External Examiner(s) are required to sign on every page with date. </b>
";*/

//$html = $html1.$html2.$html3;
$html = $html1.$html2;
$dompdf = new DOMPDF();
//$dompdf->font('times', '', 9);
$dompdf->load_html($html);
$dompdf->render();
//$dompdf->stream($_POST['subject_title']."_".$_POST['subject_code']."_".$_POST['semester'].".pdf");
$dompdf->stream("test.pdf");

?>

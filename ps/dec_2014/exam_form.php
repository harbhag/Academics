<? 
require_once('config/config.php');
require_once('config/includes_before.php');
require_once('dompdf_config.inc.php');
#require_once('tcpdf/config/lang/eng.php');
#require_once('tcpdf/tcpdf.php');
#$university_roll_no= $_POST['director_letter_roll_no'];
$ptu_subject_count_sql = "SELECT distinct ED_RollNo FROM `ptu_subjects_may_2013` order by ED_RollNo ASC limit 60;";
$ptu_subject_count_result = mysql_query($ptu_subject_count_sql) or  die(mysql_error());
/*
$pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetPrintFooter(false);
$pdf->SetPrintHeader(false);
$pdf->SetFont('times', '', 8);
$pdf->setFontSubsetting(false);
* */
$html = array();
$html[] =  "
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
font-size:10px;

}
td {
font-size:10px;

}

#page_no {
        font-size:10px;
}
</style>
</head>
<br/>";
while ($ptu_subject_row = mysql_fetch_array($ptu_subject_count_result))
{
	$sql_info ="Select * from ptu_subjects_may_2013 where ED_RollNo='".$ptu_subject_row['ED_RollNo']."' order by SUB_TP DESC, SUB_CODE  DESC;";
	$result_info = mysql_query($sql_info) or  die(mysql_error());
	$exam__month_year="May - 2013";

	$sql_student_info ="Select * from student_info where university_roll_no='".$ptu_subject_row['ED_RollNo']."' ;";
	$result_student_info = mysql_query($sql_student_info) or  die(mysql_error());
	$student_info = mysql_fetch_array($result_student_info);
	#$branch_name = decode_fieldname('branch_code','branch_name','branch_code',$student_info['branch_code']);
	#$course_name = decode_fieldname('course_code','course_name','course_code',$student_info['course_code']);

	$html[] =' 
<table cellpadding="4"><tr>
				<td width="15%" align="center"><img src="images/gndec_logo.jpg" height="100" /></td>
				<td width="70%" align="center"><h3>GURU NANAK DEV ENGINEERING COLLEGE, GILL ROAD, LUDHIANA(PUNJAB)<br />
				( An Autonomous College Under UGC Act )
				<br /> Affiliated to Punjab Technical University</h3> EXAMINATION FROM FOR EXAMINATION : '.$exam__month_year.'</td>
				<td width="15%" align="center"><img src="images/ptu_logo.jpg" height="100" width="90" /></td>
			</tr>
		  </table> 
	<div align="center"><b>For Regular Semester only</b></div>
	<table border="1" cellpadding="4">
	<tr><td width="20%">Institute </td><td width="60%">Guru Nanak Dev Engineering College, (Punjab Govt. Aided
	Status),Ludhiana.</td><td rowspan="6" width="20%"></td></tr>
	<tr><td>Branch</td><td>'.$course_name.'('.$branch_name.')</td></tr>
	<tr><td>Uni Roll No./ Name</td><td>'.$student_info['university_roll_no'].' / '.$student_info['sfname'].' '.$student_info['smname'].' '.$student_info['ssname'].' </td></tr>
	<tr><td>Father / Mother Name </td><td>'.$student_info['ffname'].''.$student_info['fmname'].''.$student_info['fsname'].' / '.$student_info['mfname'].' '.$student_info['mmname'].' '.$student_info['msname'].'</td></tr>
	<tr><td>Mobile / Email  </td><td> '.$student_info['student_mobile_no'].' / '.$student_info['student_email'].'</td></tr>
	<tr><td>Semeter / Batch  </td><td>'.$student_info['semester'].' / '.$student_info['batch'].'</td></tr>
	</table>
	<br />
	<table border="1" cellpadding="4">
	<tr><td colspan="5" align="center" bgcolor="lightgrey"><b>Subjects in which appearing</b></td></tr>
	<tr>
	<td width="20%"><b> Subject Code / Paper Id </b></td>
	<td width="45%"><b> Subject Title / Remarks</b></td>
	<td width="15%"><b> T/P </b></td>
	<td width="10%"><b> Internal </b> </td>
	<td width="10%"><b> External </b></td>
	</tr>';

		while ($ptu_subject = mysql_fetch_array($result_info))
		{
			if ($ptu_subject['Ed_Int']=='1') 
			{	$Ed_Int ='Yes';	}	else {	$Ed_Int ='No'; }
			if ($ptu_subject['Ed_Ext']=='1') 
			{	$Ed_Ext ='Yes';	}	else {	$Ed_Ext ='No';}
		$html[] = '<tr><td>'.$ptu_subject['SUB_CODE'].' / '.$ptu_subject['Sub_PaperID'].'</td><td>'.$ptu_subject['SUB_TITLE'].' / '.$ptu_subject['Sub_Remarks'].' </td><td> '.$ptu_subject['SUB_TP'].'</td><td>'.$Ed_Int.'</td><td>'.$Ed_Ext.'</td></tr>';
		}

	$html[] = '
	</table>
	<br />
	<table border="1" cellpadding="4">
	<tr><td colspan="2"><b>I have understood all the regulations and its amendments in regard to examinations. I found myself Eligible to appear in Examination. In case University declare me ineligible due to any wrong information submitted in examination form by me, I shall be responsible for the consequences at any stage.</b></td></tr>

	<tr><td><br /><br /><br />  Sign of Candidate </td><td><br /><br /><br />  Date </td></tr>
	<tr><td colspan="2"><b>Certified that the Candidate has completed the prescribed course of study and fulfilled all the conditions laid down in the Regulations for the examination and is eligible to appear in the examination as a regular student of Punjab Technical University. The candidate bears a good moral character and particulars filled by him/her are correct.</b>
	</td></tr>

	<tr><td align="left"><br /><br /><br /> Signature of the Principal / Competent <br />Authority (With Seal and Date)</td><td><br /><br /><br />  (Signature of HOD)</td></tr></table>
	<br />
	<hr />
	<br />
		<div align="center"><h3>Receipt of Regular Examination Form and Examination Fee for Examination '.$exam__month_year.'</h3></div>
	<div>Received Regular Examination Form of Semester '.$student_info['semester'].' and Examination Fee of Rs._________________ and late fee (if any) Rs.
	___________ from Student Name: '.$student_info['sfname'].' '.$student_info['smname'].' '.$student_info['ssname'].' and Student Roll No: '.$student_info['university_roll_no'].'.
	</div>
	<br /><div align="right"><b>Signature of Institute Dealing Head with seal</b></div>';

	$html[] =  '<div id="mypage"></div>';
	#$html[] ='<br pagebreak="true" />';
	#$html[] ='<div style="page-break-inside;"></div>';
}
#echo $html;

#$html[] = 'hello ';

$htm = implode(" ",$html);

$dompdf = new DOMPDF();
$dompdf->set_paper("a4","");

$dompdf->load_html($htm);
$dompdf->render();
$dompdf->stream("form.pdf");
?>

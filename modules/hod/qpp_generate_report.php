<?php

$branch_sql = mysql_query("SELECT department FROM users WHERE username='".$_SESSION['username']."'");
$dept_sql = mysql_fetch_assoc($branch_sql);
$dept = $dept_sql['department'];

mysql_query("UPDATE  question_paper_panel SET print_taken='Y', last_print_taken_on='".date('d-m-Y H:i:s')."' where assigned_by='".$_SESSION['username']."'; ");

$hod = fetch_resource_db('users',array('department','designation'),array($dept,'HOD'),'resource_array_value','name');

$sql_examiner = "select distinct  qpp.id as id , mete.name as name , mete.id as meteid, sm.subject_title as subject_title, sm.subject_code as subject_code, sm.m_code as mcode, sm.paper_id as paper_id, sm.full_part_time as full_part_time, sm.aicte_rc as aicte_rc, sm.branch_code as branch_code, sm.course_code as course_code, sm.numerical_percentage as numerical_percentage  from mtech_external_thesis_examiner mete, question_paper_panel qpp, scheme_master sm where mete.id=qpp.mete_id  and qpp.mcode =sm.m_code and qpp.sm_id =sm.scheme_master_id and qpp.assigned_by='".$_SESSION['username']."' order by branch_code, mcode ;  ";

$dean='Controller of Examination';
$count=1;
$scount=1;
$ht = array();
/*$total_entries = mysql_num_rows(mysql_query($sql_examiner));
$entries_per_page =40;


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
*/
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
			<td width='15%' align='center'><img src='images/gndec_logo.jpg' height='100' /></td>
			<td width='70%' align='center'><span style='font-size:15px'><br /> GURU NANAK DEV ENGINEERING COLLEGE, LUDHIANA </span>
			<br/><span style='font-size:14px;'>DEPARTMENT OF ".strtoupper($dept)." <br /> CONFIDENTAL (under sealed cover)</span>
			<td width='15%' align='center'><img src='images/ptu_logo.jpg' height='100' width='90' /></td>
		</tr
	  </table>";

$ht[]="<table><tr>
<td align='left' style='font-size:15px'>No. _________________</td>
<td align='right' style='font-size:15px'>Dated: ________________</td>
</tr>
</table>";

$ht[] ="<br/><h3><u>".$dean."</u></h3> 

Following is the panel of External Examiners for End Semester Theory Examinations, ".$exam_session." <br/>";

$ht[] = "<table border='1px'>
		<tr>
		<th>Sr. No.</th>
		<th>Course(Branch)</th>
		<th>FT-PT / AICTE-RC</th>
		<th>Subject Code / Mcode</th>
		<th>Paper ID</th>
		<th>Subject Title</th>
		<!--<th>Problem Solving Weightage</th>-->
		<th>Examiner Name (ID)</th>
		</tr>";


$examiner = mysql_query($sql_examiner);
while ($result_examiner = mysql_fetch_array($examiner)) {
	$course = fetch_resource_db('course_code',array('course_code'),array($result_examiner['course_code']),'resource_array_value','course_name');
	$branch = fetch_resource_db('branch_code',array('branch_code'),array($result_examiner['branch_code']),'resource_array_value','branch_name');

		$ht[]= "<tr>
		<td>".$scount."</td>
		<td>".$course."(".$branch.")</td>
		<td>".$result_examiner['full_part_time']." / ".$result_examiner['aicte_rc']."</td>
		<td>".$result_examiner['subject_code']." / ".$result_examiner['mcode']."</td>
		<td>".$result_examiner['paper_id']."</td>
		<td>".$result_examiner['subject_title']."</td>
		<!--<td>".$result_examiner['numerical_percentage']."</td>-->
		<td>".$result_examiner['name']."(".$result_examiner['meteid'].")</td>
		</tr>";
	/*	if($count==$entries_per_page) {
			
			$ht[] = "</table>
			<br/>
			<table>
			<tr>
			<td align='right' style='font-size:12px'>
			<br/>HOD
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
		<th>Subject Code / Mcode</th>
		<th>Paper ID</th>
		<th>Subject Title</th>
		<th>Examiner Name (ID)</th>
		</tr>";
			}

			$count=0;
			$page_no++;
			$footer_displayed++;
		}*/
		$count++;
		$scount++;
}

//if($page_no==$total_pages) {
	$ht[] = "<br/></table><table><tr><td align='left' style='font-size:12px'>Faculty In-Charge(s) <br/>Printed On: ".date('d-m-Y H:i:s')." </td>
	<td align='right' style='font-size:12px'>
	<br/>HOD Sign
	</td></tr>
	</table>";
	
	

	/*$ht[] = "
	  <br/>
	  <table><tr>
	  <td align='left'><span id='page_no'>Printed On: ".date('d-m-Y H:i:s')." </span></td>
	  <td align='right'><span id='page_no'>Page: ".$page_no." of ".$total_pages."</span></td>
	  </tr></table>";
	  $footer_displayed=0;*/
//}

$htm = implode(" ",$ht);

#echo $htm;

$html = $htm;
$dompdf = new DOMPDF();
$dompdf->set_paper("a4");

$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("Question_Paper_Examiner_List_".$_POST['theory_practical'].".pdf");

?>


<?
$course_branch = explode(',',$_POST['branch_code']);

$data = fetch_resource_db('student_external_marks', 
		array('branch_code','course_code','paper_id','regular_reappear','theory_practical',
		'ucentre','usession','date_of_exam'), 
		
		array($course_branch[1],$course_branch[0],$_POST['paper_id'],$_POST['regular_reappear'],'T',
		$_SESSION['ucentre'],$_SESSION['usession'],date("Y-m-d")),
		'resource','');

$data_absent = fetch_resource_db('student_external_marks', 
		array('branch_code','course_code','external_attendance_status','paper_id','regular_reappear','theory_practical',
		'ucentre','usession','date_of_exam'), 
		
		array($course_branch[1],$course_branch[0],'Absent',$_POST['paper_id'],$_POST['regular_reappear'],'T',
		$_SESSION['ucentre'],$_SESSION['usession'],date("Y-m-d")),
		'resource','');
		
$data_detained = fetch_resource_db('student_external_marks', 
		array('branch_code','course_code','external_attendance_status','paper_id','regular_reappear','theory_practical',
		'ucentre','usession','date_of_exam'), 
		
		array($course_branch[1],$course_branch[0],'Detained',$_POST['paper_id'],$_POST['regular_reappear'],'T',
		$_SESSION['ucentre'],$_SESSION['usession'],date("Y-m-d")),
		'resource','');
		
$data_present = fetch_resource_db('student_external_marks', 
		array('branch_code','course_code','external_attendance_status','paper_id','regular_reappear','theory_practical',
		'ucentre','usession','date_of_exam'), 
		
		array($course_branch[1],$course_branch[0],'Present',$_POST['paper_id'],$_POST['regular_reappear'],'T',
		$_SESSION['ucentre'],$_SESSION['usession'],date("Y-m-d")),
		'resource','');



//$roll_present = "";
//$roll_absent = "";
//$roll_detained = "";

while($row = mysql_fetch_assoc($data_present)) {
	$roll_present[] = $row['university_roll_no'];
}

while($row = mysql_fetch_assoc($data_absent)) {
	$roll_absent[] = $row['university_roll_no'];
}

while($row = mysql_fetch_assoc($data_detained)) {
	$roll_detained[] = $row['university_roll_no'];
}

$centre = exam_centre_name($_SESSION['ucentre']);
$session = exam_session($_SESSION['usession']);

$location = fetch_resource_db('centre_location',array('ucentre'),array($_SESSION['ucentre']),'resource_array_value','location');

$superitendent = fetch_resource_db('users',array('username'),array($_SESSION['username']),'resource_array_value','name');

$course_name = fetch_resource_db('course_code',array('course_code'),array($course_branch[0]),'resource_array_value','course_name');

$branch_name = fetch_resource_db('branch_code',array('branch_code'),array($course_branch[1]),'resource_array_value','branch_name');

$subject_code = fetch_resource_db('subject_master',array('paper_id','usession','date_of_exam','branch_code','course_code','regular_reappear','theory_practical'),array($_POST['paper_id'],$_SESSION['usession'],date("Y-m-d"),$course_branch[1],$course_branch[0],$_POST['regular_reappear'],'T'),'resource_array_value','subject_code');

$m_code = fetch_resource_db('subject_master',array('paper_id','usession','date_of_exam','branch_code','course_code','regular_reappear','theory_practical'),array($_POST['paper_id'],$_SESSION['usession'],date("Y-m-d"),$course_branch[1],$course_branch[0],$_POST['regular_reappear'],'T'),'resource_array_value','m_code');

$subject_title = fetch_resource_db('subject_master',array('paper_id','usession','date_of_exam','branch_code','course_code','regular_reappear','theory_practical'),array($_POST['paper_id'],$_SESSION['usession'],date("Y-m-d"),$course_branch[1],$course_branch[0],$_POST['regular_reappear'],'T'),'resource_array_value','subject_title');



$html1="<table style='width:100%'>
                        <tr>
                        <td align='center'> 
                        <table width='100%'>
                        <tr>
                        <td width='15%' align='center'><img src='images/gndec_logo.jpg' height='100' /></td>
                        <td width='70%' align='center'><h4> GURU NANAK DEV ENGINEERING COLLEGE, LUDHIANA </h4> <h4> ( An Autonomous College Under UGC Act - 1956 [2(f) and 12(B)])
                        <br /> Affiliated to IKG Punjab Technical University</h4></td>
                        <td width='15%' align='center'><img src='images/ptu_logo.jpg' height='100' width='100' /></td>
                </tr>
          </table></td></tr></table>
          <br>
          <table border='1' cellpadding='2' style='border-collapse:collapse;width:100%'>
          <tr><td colspan='3' align='center'><b>FORWARDING  MEMO Awards (".$_POST['regular_reappear'].")  for End Semester Examination ".$exam_session."</b></td></tr>
          <tr><td align='left' colspan='3' ><b>Exam Centre : </b>".$centre."(".$location.")  </td>
          <tr><td colspan='3'><b>Centre Supdt. : </b> ".$superitendent."  </td>
          </tr>
          <tr><td align='left' ><b>Course : </b>".$course_name."  </td>
          <td colspan='2'><b>Branch : </b> ".$branch_name."  </td>
          </tr>
          
                        
                        <tr>
                        <td align='left'><b>Paper ID/M-Code : </b>".$_POST['paper_id']."/".$m_code."  </td>
                        <td align='left'><b>Subject Code :</b>".$subject_code." </td>
                        <td align='left'><b>Subject Title :</b>".$subject_title." </td>
                        </tr>
                        <tr>
                        <td  align='left'><b>Date(YYYY-MM-DD): </b> ".date("Y-m-d")."</td>
                    
                        <td colspan='2'><b>Session : </b>".$session." </td>
                        </tr>
                        </table>
           <br>
           <table border='1' style='border-collapse:collapse;width:100%' cellpadding='2'>
           <tr><td  align='left'  ><b>Present Roll Numbers :</b></td></tr>
           <tr><td style='font-size:10px'>".implode(", ",$roll_present)."</td></tr>
           <tr><td style='font-size:10px'><b>Total No. of Answer Books  : </b> ".mysql_num_rows($data_present)."</td></tr>
           <tr><td style='font-size:10px'><b>Absent Roll Numbers : </td></tr>
           <tr><td style='font-size:10px'>".implode(", ",$roll_absent)."</td></tr>
           <tr><td style='font-size:10px'><b>Total No. of Absentees : </b> ".mysql_num_rows($data_absent)."</td></tr>
           <tr><td style='font-size:10px'><b>Detained Roll Numbers: </b></td></tr>
            <tr><td style='font-size:10px'>".implode(", ",$roll_detained)."</td></tr>
            <tr><td style='font-size:10px'><b>Total No. of Detainees: </b> ".mysql_num_rows($data_detained)."</td></tr></table>
<br>

<table width='100%'> <tr><td align='left'><br><b>Signature of the Dy. Supdt.</b></td><td align='right'><b>Signature of the Supdt.</b></td></tr>
<br>
<tr><td colspan='2'>
<b>Note:</b><br>
1. Absentee, Detainee Roll Numbers will be shown only after marking attendance.<br>
2. Both Supdt. and Dy. Supdt. must sign with date on every page of forwarding memo.</td></tr></table>
<br/><<h5>Printed On: ".date("d-m-Y H:i:s")."</h5>";

$html = $html1;
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream($_POST['regular_reappear']."_".$course_name."_".$branch_name."_".$subject_title."_".$_POST['paper_id']."_".$_POST['semester'].".pdf");

?>

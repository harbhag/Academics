<?php
include('function.php');
 
if(isset($_POST['student_exam_form_status_show']) && isset($_POST['Regular_Reappear']) && isset($_POST['roll_no']))
{
	$sql_student_info="select * from student_info where university_roll_no='".$_POST['roll_no']."' ;";
	$sql_student_info_result = mysql_query($sql_student_info) or  die(mysql_error());

$row_student_info = mysql_fetch_array($sql_student_info_result);
echo "<center><h4>Student Form Status (".$_POST['Regular_Reappear'].")</h4></center>";
echo "<table class='table table-bordered striped table-condensed container'><tr style='background-color:lightgrey'><th>Uni. Roll No.</th><th>Course</th><th>Branch</th><th>Student Name</td><th>Father / Mother Name</th><th>Admission Year</th><th>Fee Received Status </th><th>Student Status</th><th>LEET Status</th></tr>";	

	$branch_name = decode_fieldname('branch_code','branch_name','branch_code',$row_student_info['branch_code']);
	$course_name = decode_fieldname('course_code','course_name','course_code',$row_student_info['course_code']);
	echo "<tr><td>".$row_student_info['university_roll_no']."</td><td>".$course_name." (".$row_student_info['aicte_rc']." - ".$row_student_info['full_part_time'].") </td><td>".$branch_name."</td><td>".$row_student_info['ptu_student_name']."</td><td>".$row_student_info['ptu_father_name']." / ".$row_student_info['ptu_mother_name']."</td><td>".$row_student_info['admission_year']."</td> <td>".$row_student_info['fee_paid_status']." </td><td>".$row_student_info['student_status']."</td><td>".$row_student_info['leet_non_leet']."</td> </tr>";

$sql="SELECT `ED_RollNo`,`SUB_CODE`,`SUB_TITLE`,`Sub_PaperID`,`Sub_Sem`,`SUB_TP`,`Ed_Int`,`Ed_Ext`,received_status, prov_nonprov, detention_status, m_code, scheme_code, Sub_Remarks FROM `ptu_subjects` WHERE `Regular_Reappear`='".$_POST['Regular_Reappear']."' and `ED_RollNo`='".$_POST['roll_no']."' AND eligibility='Y' order by `SUB_CODE`,`SUB_TP`";
#echo $sql;
$result = mysql_query($sql) or  die(mysql_error());

echo "<table    class='table table-bordered striped table-condensed container' >

<tr style='background-color:lightgrey'><th>Sr No.</th><th >Uni Roll No.</th><th>Subject Title</th><th>Subject Code</th><th>Elective Status</th><th>Paper ID/ M code</th><th>Semester</th><th>T/P</th><th>Is Internal Appear?</th><th>Is External  Appear?</th><th>Form Received Status</th><th>Detention Status</th><th>Provisonal Status</th><th>Scheme Code</th></tr>";
$x=1;
while ($row_result = mysql_fetch_array($result))
{
	if ($row_result['Ed_Int']=='1')
	{$ed_status='Yes';}
	else
	{$ed_status='No';}
	if ($row_result['Ed_Ext']=='1')
	{$id_status='Yes';}
	else
	{$id_status='No';}
	echo "<tr><td>$x</td><td>".$row_result['ED_RollNo']."</td><td>".$row_result['SUB_TITLE']."</td><td>".$row_result['SUB_CODE']."</td><td>".$row_result['Sub_Remarks']."</td><td>".$row_result['Sub_PaperID']." / ".$row_result['m_code']."</td><td>".$row_result['Sub_Sem']."</td><td>".$row_result['SUB_TP']."</td><td>".$ed_status."</td><td>".$id_status."</td><td>".$row_result['received_status']."</td><td>".$row_result['detention_status']."</td><td>".$row_result['prov_nonprov']."</td><td>".$row_result['scheme_code']."</td></tr>";
	$x++;
}
}

else
{
$student_type = mysql_query("SELECT distinct Regular_Reappear FROM ptu_subjects ") or die(mysql_error());

echo "<center>

					<table>
					<form method='post' action=''>
					<tr><td colspan='2' align='center'><h4>Student Form Status Check</h4></td></tr>
					<tr><td>
					<span style='font-weight:bold'>Student Type</span>
					</td><td>
          <select name='Regular_Reappear' id='Regular_Reappear' class='input-xlarge'>";
          while($row2 = mysql_fetch_assoc($student_type)) {
						if($row2['Regular_Reappear']=='' or is_null($row2['Regular_Reappear'])) {
							continue;
						}
						echo "<option value='".$row2['Regular_Reappear']."'>".$row2['Regular_Reappear']."</option>";
					}
					echo "
					</select>
					</tr></td>
					<tr><td>
					<span style='font-weight:bold'>Roll No. </span>
					</td><td>
         <input type='text' class='input-xlarge' name='roll_no' id='roll_no' />
					</tr></td>
					<tr><td>
					<input type='hidden' name='student_exam_form_status_show' value='student_exam_form_status_show' />
					<button type='submit' name='submit' class='btn btn-large btn-danger'>Proceed</button>
					</tr></td>
         
				</form>
				</table>
		</center>";
  
}
?>

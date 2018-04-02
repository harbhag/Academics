<?php
if(isset($_POST['unlock_exam_form_unlock']))
{	
	$student_data_si_sql = mysql_query("SELECT * FROM student_info WHERE 
	university_roll_no='".$_POST['roll_no']."'
	") or die("1 = ".mysql_error());
	$student_data_si = mysql_fetch_assoc($student_data_si_sql);
	
	$course = fetch_resource_db('course_code',array('course_code'),array($student_data_si['course_code']),'resource_array_value','course_name');
	$branch = fetch_resource_db('branch_code',array('branch_code'),array($student_data_si['branch_code']),'resource_array_value','branch_name');

	if($student_data_si['course_code']=='2') {
		$course_name = $course."(".$student_data_si['full_part_time']."-".$student_data_si['aicte_rc'].")";
	}
	else {
		$course_name = $course;
	}

	$sql="SELECT `ED_RollNo`,`SUB_CODE`,`SUB_TITLE`,`Sub_PaperID`,`Sub_Sem`,`SUB_TP`,`Ed_Int`,`Ed_Ext`,detention_status,prov_nonprov FROM `ptu_subjects` WHERE `Regular_Reappear`='".$_POST['Regular_Reappear']."' and `ED_RollNo`='".$_POST['roll_no']."' order by `SUB_CODE`,`SUB_TP`";
	#echo $sql;
	$result = mysql_query($sql) or  die("1.".mysql_error());
	
	if(mysql_num_rows($result)==0) {
		show_label('important','No Record Found');
		exit();
	}
?>
	<center>
	<table class='unlock_rp_form'>
		
		<tr>
		<td class='unlock_rp_form'>Name</td>
		<td class='td-text'><?php echo $student_data_si['ptu_student_name']; ?></td>
		</tr>
		
		<tr>
		<td class='unlock_rp_form'>Father's Name</td>
		<td class='td-text'><?php echo $student_data_si['ptu_father_name']; ?></td>
		</tr>
		
		<tr>
		<td class='unlock_rp_form'>Course</td>
		<td class='td-text'><?php echo $course_name; ?></td>
		</tr>
		
		<tr>
		<td class='unlock_rp_form'>Branch</td>
		<td class='td-text'><?php echo $branch; ?></td>
		</tr>
		
		<tr>
		<td class='unlock_rp_form'>University Roll No.</td>
		<td class='td-text'><?php echo $_POST['roll_no']; ?></td>
		</tr>
		
	</table>
</center>

<?
echo "<div id='exam_form_status'>";
echo "<table    class='table table-bordered striped table-condensed container' >

<tr>
<td align='center' colspan='8'><h4>Record of (".$_POST['Regular_Reappear'].") Form</h4></td></tr>
<tr style='background-color:lightgrey'>
<th >Uni Roll No.</th>
<th>Subject Title</th>
<th>Subject Code</th>
<th>Paper ID</th>
<th>Semester</th>
<th>Detention Status</th>
<th>P/NP</th>
<th>T/P</th>
<th>Internal</th>
<th>External</th>
</tr>";

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
	echo "<tr>
	<td>".$row_result['ED_RollNo']."</td>
	<td>".$row_result['SUB_TITLE']."</td>
	<td>".$row_result['SUB_CODE']."</td>
	<td>".$row_result['Sub_PaperID']."</td>
	<td>".$row_result['Sub_Sem']."</td>
	<td>".$row_result['detention_status']."</td>
	<td>".$row_result['prov_nonprov']."</td>
	<td>".$row_result['SUB_TP']."</td>
	<td>".$ed_status."</td>
	<td>".$id_status."</td>
	</tr>";
}
echo "</table>";

$sql="SELECT DISTINCT received_status FROM `ptu_subjects` WHERE `Regular_Reappear`='".$_POST['Regular_Reappear']."' and `ED_RollNo`='".$_POST['roll_no']."'";
	#echo $sql;
$result = mysql_query($sql) or  die("1.".mysql_error());

$row_result = mysql_fetch_assoc($result);

if($row_result['received_status']=='Y') {
	show_label('important','Form Already Received in Academics Section. Ask the student to Contact Academic Section immediately.');
	exit();
}

if($_POST['Regular_Reappear']=='Reappear') {
	echo "<br/><center>
	<form action='' method='post'>
	<input type='hidden' name='university_roll_no' value='".$_POST['roll_no']."' />
	<input type='hidden' name='unlock_reappear_exam_form' value='' />
	<input type='submit' class='btn btn-big btn-info' value='Unlock Reappear Exam Form' onclick='return confirm_action(\"Do you want to continue\")'/>
	</form>
	</center>";
}
echo "</div>";

}

else
{
$student_type = mysql_query("SELECT distinct Regular_Reappear FROM ptu_subjects WHERE SUB_TP='T' and `Ed_Ext`='1' and `eligibility`='Y' ") or die(mysql_error());

echo "<center>

					<table>
					<form method='post' action=''>
					<tr><td>
					<span style='font-weight:bold'>Form Type</span>
					</td><td>
					<select name='Regular_Reappear' id='Regular_Reappear' class='input-xlarge'>
					<!--<option value='Regular'>Regular</option>-->
					<option value='Reappear'>Reappear</option>
					</select>
					</tr></td>
					<tr><td>
					<span style='font-weight:bold'>Roll No. </span>
					</td><td>
         <input type='text' class='input-xlarge' name='roll_no' id='roll_no' />
					</tr></td>
					<tr><td>
					<input type='hidden' name='unlock_exam_form_unlock' value='student_exam_form_status_show' />
					<input type='hidden' name='unlock_exam_form' value='student_exam_form_status_show' />
					<button type='submit' name='submit' class='btn btn-large btn-danger'>Proceed</button>
					</tr></td>
         
				</form>
				</table>
		</center>";
  
}
?>

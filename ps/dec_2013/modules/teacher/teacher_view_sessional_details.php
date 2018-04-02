<table class='table table-bordered table-condensed container'>
	<? echo "<tr><td><b>Subject Title: </b> ".$_POST['subject_title']."</td><td><b>Subject Code:</b> ".$_POST['subject_code']."  </td><td><b>Semester:</b> ".$_POST['semester']."</td></tr></table>";
$result_iqs=mysql_query("select * from  internal_question_structure where course_code='".$_POST['course_code']."' and ass_tool='S';");

$num_iqs= mysql_num_rows($result_iqs);

?>
<form action='' method='post'/>
<table class='table table-bordered table-condensed container sortable'>
	<tr>
		<th>Sr. No.</th>
		<th>University Roll No.</th>
		<th>College Roll No.</th>
		<th>Student Name</th>
		<? for($x=1;$x<=$num_iqs;$x++) 
		{
		$result_iqs_qn=mysql_query("select * from  internal_question_structure where course_code='".$_POST['course_code']."' and  question_no='".$x."' and ass_tool='S' ;");
		$row_iqs_qn = mysql_fetch_assoc($result_iqs_qn);
		echo "<th>Q:".$x." (".$row_iqs_qn['max_marks'].")</th>";
		}
		?>
		<th>S-1 (Total)</th>
		<? for($x=1;$x<=$num_iqs;$x++) 
		{
		$result_iqs_qn=mysql_query("select * from  internal_question_structure where course_code='".$_POST['course_code']."' and  question_no='".$x."' and ass_tool='S' ");
		$row_iqs_qn = mysql_fetch_assoc($result_iqs_qn);
		echo "<th>Q:".$x." (".$row_iqs_qn['max_marks'].")</th>";
		}
		?>
		<th>S-2 (Total)</th>
		<? for($x=1;$x<=$num_iqs;$x++) 
		{
		$result_iqs_qn=mysql_query("select * from  internal_question_structure where course_code='".$_POST['course_code']."' and  question_no='".$x."'  and ass_tool='S'");
		$row_iqs_qn = mysql_fetch_assoc($result_iqs_qn);
		echo "<th>Q:".$x." (".$row_iqs_qn['max_marks'].")</th>";
		}
		?>
		<th>S-3 (Total)</th>
		<!--<th>T-Avg.</th>
		<th>Attendance Marks</th>-->
		<!--<th>A-1</th>
		<th>A-2</th>
		<th>A-3</th>-->
		<!--<th>Assignment Marks</th>
		<th>Internal Obt. Marks</th>-->
	</tr>
<?php


$details_sql  = mysql_query("SELECT * FROM time_table  WHERE
		course_code='".$_POST['course_code']."' AND
		branch_code='".$_POST['branch_code']."' AND
		shift='".$_POST['shift']."' AND
		ssection='".$_POST['ssection']."' AND
		semester='".$_POST['semester']."' AND
		teacher_username='".$_SESSION['username']."' AND
		subject_code='".$_POST['subject_code']."' AND
		exam_month='".$_POST['exam_month']."' AND
		exam_year='".$_POST['exam_year']."' AND
		
		aicte_rc='".$_POST['aicte_rc']."' AND
		full_part_time='".$_POST['full_part_time']."'") or die(mysql_error());
		
$details = mysql_fetch_assoc($details_sql);
//$roll_nos = mysql_query("SELECT DISTINCT university_roll_no FROM student_sessionals_record WHERE id='".$_POST['autoid']."' AND backup='0' ORDER BY university_roll_no ASC") or die(mysql_error());


$roll_nos = mysql_query("SELECT DISTINCT university_roll_no FROM student_sessionals_record WHERE
		course_code='".$_POST['course_code']."' AND
		branch_code='".$_POST['branch_code']."' AND
		shift='".$_POST['shift']."' AND
		ssection='".$_POST['ssection']."' AND
		semester='".$_POST['semester']."' AND
		teacher_username='".$_SESSION['username']."' AND
		subject_code='".$_POST['subject_code']."' AND
		exam_month='".$_POST['exam_month']."' AND
		exam_year='".$_POST['exam_year']."' AND
		aicte_rc='".$_POST['aicte_rc']."' AND
		full_part_time='".$_POST['full_part_time']."' AND
		backup='0' 
		ORDER BY university_roll_no ASC") or die(mysql_error());


if(mysql_num_rows($roll_nos)==0) {
	show_label('info','No Record Found !');
	exit();
}

$count = 1;
while($row = mysql_fetch_assoc($roll_nos)) {
	
	$student_details = fetch_resource_db('student_info',array('university_roll_no'),array($row['university_roll_no']),'resource_array','');
	
	$details1 = fetch_resource_db('student_sessionals_record',array('university_roll_no','sessional_no','backup','subject_code'),array($row['university_roll_no'],'1','0',$_POST['subject_code']),'resource_array','');
	
	$details2 = fetch_resource_db('student_sessionals_record',array('university_roll_no','sessional_no','backup','subject_code'),array($row['university_roll_no'],'2','0',$_POST['subject_code']),'resource_array','');
	
	$details3 = fetch_resource_db('student_sessionals_record',array('university_roll_no','sessional_no','backup','subject_code'),array($row['university_roll_no'],'3','0',$_POST['subject_code']),'resource_array','');
	
	
	$adetails1 = fetch_resource_db('student_assignment_record',array('university_roll_no','assignment_no','backup','subject_code'),array($row['university_roll_no'],'1','0',$_POST['subject_code']),'resource_array','');
	
	$adetails2 = fetch_resource_db('student_assignment_record',array('university_roll_no','assignment_no','backup','subject_code'),array($row['university_roll_no'],'2','0',$_POST['subject_code']),'resource_array','');
	
	$adetails3 = fetch_resource_db('student_assignment_record',array('university_roll_no','assignment_no','backup','subject_code'),array($row['university_roll_no'],'3','0',$_POST['subject_code']),'resource_array','');
	
	
	$aaverage = round((($adetails1['assignment_obtained_marks'])+($adetails2['assignment_obtained_marks'])+($adetails3['assignment_obtained_marks']))/1);
	
	$details_agg_att = fetch_resource_db('aggregate_attendance_student',array('university_roll_no','backup','subject_code'),array($row['university_roll_no'],'0',$_POST['subject_code']),'resource_array','');
	
	if($details1['attendance_status']=='Absent') {
		$details1['obtained_marks']='A';
	}
	else {
		$number_array[] = $details1['obtained_marks'];
	}
	
	if($details2['attendance_status']=='Absent') {
		$details2['obtained_marks']='A';
	}
	else {
		$number_array[] = $details2['obtained_marks'];
	}
	
	if($details3['attendance_status']=='Absent') {
		$details3['obtained_marks']='A';
	}
	else {
		$number_array[] = $details3['obtained_marks'];
	}
	
	$total_att = $details_agg_att['total_lectures'];
	$attd_att = $details_agg_att['attended_lectures'];
	
	//$final_att = ((($attd_att)/($total_att))*6);
	$final_att = $details_agg_att['attendance_marks'];
	
	
	
	rsort($number_array);
	
	$max1 = $number_array[0];
	$max2 = $number_array[1];
	
	$average = round((($max1)+($max2))/(2));
		
	echo "<tr class='warning'>
	<td>".$count."</td>
	<td>".$row['university_roll_no']."</td>
	<td>".$student_details['college_roll_no']."</td>
	<input type='hidden' name='university_roll_no$count' value='".$row['university_roll_no']."' />
	<input type='hidden' name='sessional_id$count' value='".$row['autoid']."' />
	<td>".$student_details['ptu_student_name']."</td>";
	for($x=1;$x<=$num_iqs;$x++) 
	{
		$result_iqs_qn=mysql_query("select * from  internal_question_structure where course_code='".$_POST['course_code']."' and  question_no='".$x."' and ass_tool='S' ");
		$row_iqs_qn = mysql_fetch_assoc($result_iqs_qn);
		if($details1['attendance_status']=='Absent') 
		{
			echo "<td>--</td>";
		}
		else
		{
		echo "<td>".$details1['q'.$x]."</td>";
		}
	}
	echo "<th>".$details1['obtained_marks']."</th>";
	for($x=1;$x<=$num_iqs;$x++) 
	{
		$result_iqs_qn=mysql_query("select * from  internal_question_structure where course_code='".$_POST['course_code']."' and  question_no='".$x."' and ass_tool='S';");
		$row_iqs_qn = mysql_fetch_assoc($result_iqs_qn);
		if($details2['attendance_status']=='Absent') 
		{
			echo "<td>--</td>";
		}
		else
		{
		echo "<td>".$details2['q'.$x]."</td>";
		}
	}
	echo "<th>".$details2['obtained_marks']."</th>";
	for($x=1;$x<=$num_iqs;$x++) 
	{
		$result_iqs_qn=mysql_query("select * from  internal_question_structure where course_code='".$_POST['course_code']."' and  question_no='".$x."' and ass_tool='S';");
		$row_iqs_qn = mysql_fetch_assoc($result_iqs_qn);
		if($details3['attendance_status']=='Absent') 
		{
			echo "<td>--</td>";
		}
		else
		{
		echo "<td>".$details3['q'.$x]."</td>";
		}
	}
	echo "<th>".$details3['obtained_marks']."</th>";
	
	echo "<!--<td>".$average."</td>
	<td>".round($final_att)."</td>-->
	<!--<td>".$adetails1['assignment_obtained_marks']."</td>
	<td>".$adetails2['assignment_obtained_marks']."</td>
	<td>".$adetails3['assignment_obtained_marks']."</td>-->
	<!--<td>".$aaverage."</td>
	<td>".(($average)+(round($final_att))+($aaverage))."</td>-->";
	$count++;
	unset($number_array);		
}

// Print Button for All Sesssional detail
//START
?>
</table>
<input type='hidden' name='teacher_print_internal_marks_record' value='<?php echo $count; ?>' />
<input type='hidden' name='total_count' value='<?php echo $count; ?>' />
<input type='hidden' name='autoid' value='<?php echo $_POST['autoid']; ?>' />
<input type='hidden' name='sessional_no' value='<?php echo $_POST['sessional_no']; ?>' />
<input type='hidden' name='teacher_update_sessional_marks' value='<?php echo $count; ?>' />
<input type='hidden' name='total_count' value='<?php echo $count; ?>' />
<input type='hidden' name='autoid' value='<?php echo $_POST['autoid']; ?>' />
<input type='hidden' name='sessional_no' value='<?php echo $_POST['sessional_no']; ?>' />
<input type='hidden' name='exam_month' value='<?php echo $_POST['exam_month']; ?>' />
<input type='hidden' name='exam_year' value='<?php echo $_POST['exam_year']; ?>' />
<input type='hidden' name='overall_remarks' value='<?php echo $_POST['overall_remarks']; ?>' />
<input type='hidden' name='paper_id' value='<?php echo $_POST['paper_id']; ?>' />
<input type='hidden' name='subject_title' value='<?php echo $_POST['subject_title']; ?>' />
<input type='hidden' name='ssection' value='<?php echo $_POST['ssection']; ?>' />
<input type='hidden' name='sgroup' value='<?php echo $_POST['sgroup']; ?>' />
<input type='hidden' name='subject_code' value='<?php echo $_POST['subject_code']; ?>' />
<input type='hidden' name='branch_code' value='<?php echo $_POST['branch_code']; ?>' />
<input type='hidden' name='course_code' value='<?php echo $_POST['course_code']; ?>' />
<input type='hidden' name='semester' value='<?php echo $_POST['semester']; ?>' />
<input type='hidden' name='aicte_rc' value='<?php echo $_POST['aicte_rc']; ?>' />
<input type='hidden' name='full_part_time' value='<?php echo $_POST['full_part_time']; ?>' />
<input type='hidden' name='shift' value='<?php echo $_POST['shift']; ?>' />

<?php 

//if($details['internal_lock_status']==1) {
	//echo "<input type='submit' class='btn btn-block btn-danger' value='Click Here To Print Record'/>";
//}
//END  
?>
</form>



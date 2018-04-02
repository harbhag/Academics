<form action='' method='post'/>

<?
$details = fetch_resource_db('time_table',array('autoid'),array($_POST['autoid']),'resource_array','');

$result_iqs=mysql_query("select * from  internal_question_structure where course_code='".$_POST['course_code']."' and ass_tool='S';");

$num_iqs= mysql_num_rows($result_iqs);
#echo $num_iqs;
?>
<table class='table table-bordered table-condensed container'>
	<? echo "<tr><td><b>Subject Title: </b> ".$_POST['subject_title']."(".$_POST['elective_details'].")</td><td><b>Subject Code:</b> ".$_POST['subject_code']."  </td><td><b>Semester:</b> ".$_POST['semester']."</td></tr></table>"; ?>


<table class='table table-bordered table-condensed container'>
	<tr>
		<th>Sr. No.</th>
		<th>University Roll No.</th>
		<th>College Roll No.</th>
		<th>Student Name</th>
		
		<? for($x=1;$x<=$num_iqs;$x++) 
		{
		$result_iqs_qn=mysql_query("select * from  internal_question_structure where course_code='".$_POST['course_code']."' and  question_no='".$x."' and ass_tool='S';");
		$row_iqs_qn = mysql_fetch_assoc($result_iqs_qn);
		echo "<th>Question".$x." (MM:".$row_iqs_qn['max_marks'].")</th>";
		}
		?>
		<!--<th>Date/Period</th>-->
		<th>Obtained Marks</th>
		<th>Absent</th>
		<!--<th>Remarks</th>-->
	</tr>
<?php


$details = fetch_resource_db('time_table',array('autoid'),array($_POST['autoid']),'resource_array','');
	
$roll_nos = mysql_query("SELECT * FROM student_sessionals_record WHERE
		course_code='".$_POST['course_code']."' AND
		branch_code='".$_POST['branch_code']."' AND
		shift='".$_POST['shift']."' AND
		ssection='".$_POST['ssection']."' AND
		sessional_no='".$_POST['sessional_no']."' AND
		semester='".$_POST['semester']."' AND
		teacher_username='".$_SESSION['username']."' AND
		subject_code='".$_POST['subject_code']."' AND
		
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
		
		echo "<tr class='warning'>
			<td>".$count."</td>
			<td>".$row['university_roll_no']."</td>
			<td>".$student_details['college_roll_no']."</td>
			<input type='hidden' name='university_roll_no$count' value='".$row['university_roll_no']."' />
			<input type='hidden' name='sessional_id$count' value='".$row['autoid']."' />
			<td>".$student_details['ptu_student_name']."</td>";
			for($x=1;$x<=$num_iqs;$x++) 
			{
				$result_iqs_mm=mysql_query("select * from  internal_question_structure where course_code='".$_POST['course_code']."' and  question_no='".$x."' and ass_tool='S'; ");
				$row_iqs_mm = mysql_fetch_assoc($result_iqs_mm);
				#echo"<td>24</td>";
				$question_id =$count."".$x;
				
				if($row['attendance_status']=='Absent')
				{
					echo "<td><input class='input-mini'  type='text' id='q$question_id' disabled name='q$question_id' onChange='question_marks_sum()'>";
				}
				else
				{
					echo "<td><input class='input-mini'  type='text' id='q$question_id' name='q$question_id' onChange='question_marks_sum()' value='".$row['q'.$x]."'>";
				}
					echo "<script>
									var q$question_id = new LiveValidation('q$question_id',{ validMessage: 'ok', wait: 500});
									q$question_id.add(Validate.Presence,{failureMessage:'X'});
									q$question_id.add(Validate.Numericality,{ minimum:0,maximum:".$row_iqs_mm['max_marks']."});
					</script>
					</td>";
				
			}
			
			if($row['attendance_status']=='Absent')
			{
				echo "<td><input class='input-mini' readonly type='text' id='obtained_marks$count' value='Absent' name='obtained_marks$count' >";
			}
			else
			{
				echo "<td><input class='input-mini' readonly type='text' id='obtained_marks$count' value='".$row['obtained_marks']."' name='obtained_marks$count' >";
			}
			#echo "<input class='input-mini' type='hidden' value='".$row['obtained_marks']."' id='p_obtained_marks$count' name='p_obtained_marks$count'>";
		
			$id1 =$count."1";
			$id2 =$count."2";
			$id3 =$count."3";
			$id4 =$count."4";
			$id5 =$count."5";
			$id6 =$count."6";
			$id7 =$count."7";
			$id8 =$count."8";
			if($row['attendance_status']=='Absent') {
				echo "<td><input type='checkbox' name='attendance_status$count' checked='checked' value='Absent' id='attendance_status$count' onclick='disable_field1(\"q$id1\",\"q$id2\",\"q$id3\",\"q$id4\",\"q$id5\",\"q$id6\",\"q$id7\",\"q$id8\",this.id)'></td>";
			}
			else {
				echo "<td><input type='checkbox' name='attendance_status$count' value='Absent' id='attendance_status$count' onclick='disable_field1(\"q$id1\",\"q$id2\",\"q$id3\",\"q$id4\",\"q$id5\",\"q$id6\",\"q$id7\",\"q$id8\",this.id)'></td>";
			}
			echo "
			<!--<td><input class='input-small' type='text' value='".$row['remarks']."' name='remarks$count'></td>-->
			</tr>";
			$count++;
		
}
?>
</table>
<input type='hidden' name='teacher_update_sessional_marks' value='<?php echo $count; ?>' />
<input type='hidden' name='total_count' id='total_count' value='<?php echo $count; ?>' />
<input type='hidden' name='num_iqs' id='num_iqs' value='<?php echo $num_iqs; ?>' />
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
<input type='submit' class='btn btn-block btn-danger' value='Click Here To Update Sessional Marks' onclick="return confirm_action('Do you want to continue ?')"/>
</form>



<?php

show_label('info','Mark Attendance');
echo "<br/>";

?>


<form action='' method='post' />
<table class='table table-bordered table-condensed container'>
	<tr>
		<th>Sr. No.</th>
		<th>University Roll No.</th>
		<th>Student Name</th>
		
		<th>Subject Code</th>
		<th>Subject Title</th>
		<th>Semester</th>
		<th>Mark Attendance</th>
	</tr>
<?php


if($_POST['internal_external']=='I') {
	
	if($_POST['theory_practical']=='T') {
		$roll_nos = fetch_resource_db_att('ptu_subjects',
		array('FRM_BRID',
		'Sub_Sem',
		'SUB_CODE',
		'Sub_PaperID',
		'SUB_TP',
		'Ed_Int',
		'Regular_Reappear',
		'aicte_rc',
		'eligibility',
		'received_status',
		'Sub_PaperID'),
		array($_POST['branch_code'],
		$_POST['semester'],
		$_POST['subject_code'],
		$_POST['paper_id'],
		$_POST['theory_practical'],
		'1',
		$_POST['regular_reappear'],
		$_POST['aicte_rc'],
		'Y',
		'Y',
		$_POST['paper_id']),'resource','');
		
		
	}
	if($_POST['theory_practical']=='P') {
		$roll_nos = fetch_resource_db_att('ptu_subjects',
		array('FRM_BRID',
		'Sub_Sem',
		'SUB_CODE',
		'SUB_TP',
		'Ed_Int',
		'Regular_Reappear',
		'aicte_rc',
		'received_status',
		'eligibility'),
		array($_POST['branch_code'],
		$_POST['semester'],
		$_POST['subject_code'],
		$_POST['theory_practical'],
		'1',
		$_POST['regular_reappear'],
		$_POST['aicte_rc'],
		'Y',
		'Y'),'resource','');
		}
	
	
}

if($_POST['internal_external']=='E') {
	if($_POST['theory_practical']=='T') {
		$roll_nos = fetch_resource_db_att('ptu_subjects',
		array('FRM_BRID',
		'Sub_Sem',
		'SUB_CODE',
		'SUB_TP',
		'Ed_Ext',
		'Regular_Reappear',
		'aicte_rc',
		'eligibility',
		'received_status',
		'Sub_PaperID'),
		array($_POST['branch_code'],
		$_POST['semester'],
		$_POST['subject_code'],
		$_POST['theory_practical'],
		'1',
		$_POST['regular_reappear'],
		$_POST['aicte_rc'],
		'Y',
		'Y',
		$_POST['paper_id']),'resource','');
		
	}
	if($_POST['theory_practical']=='P') {
		$roll_nos = fetch_resource_db_att('ptu_subjects',
		array('FRM_BRID',
		'Sub_Sem',
		'SUB_CODE',
		'SUB_TP',
		'Ed_Ext',
		'Regular_Reappear',
		'aicte_rc',
		'received_status',
		'eligibility'),
		array($_POST['branch_code'],
		$_POST['semester'],
		$_POST['subject_code'],
		$_POST['theory_practical'],
		'1',
		$_POST['regular_reappear'],
		$_POST['aicte_rc'],
		'Y',
		'Y'),'resource','');
		}
		
}
$count = 1;
//echo mysql_num_rows($roll_nos);
//echo $_POST['regular_reappear'];
/*echo $_POST['branch_code'];
echo $_POST['subject_title'];
echo $_POST['theory_practical'];
echo $_POST['regular_reappear'];
echo mysql_num_rows($roll_nos);*/
while($row = mysql_fetch_assoc($roll_nos)) {
	$shift_ft = fetch_resource_db('student_info',array('university_roll_no'),array($row['ED_RollNo']),'resource_array','');
	
	$detained_status = mysql_query("SELECT * FROM detainee_list WHERE 
	university_roll_no='".$row['ED_RollNo']."' AND
	semester='".$row['Sub_Sem']."' AND
	subject_code='".$row['SUB_CODE']."' AND
	theory_practical='".$_POST['theory_practical']."' AND
	detained_status='Y' AND
	locked='Y'");
	
	$prev_attendance = fetch_resource_db('student_internal_marks',
	array('university_roll_no',
	'theory_practical',
	'subject_code',
	'semester',
	'teacher_username',
	'internal_external'),
	array($row['ED_RollNo'],
	$_POST['theory_practical'],
	$_POST['subject_code'],
	$_POST['semester'],
	$_SESSION['username'],
	$_POST['internal_external']),'resource_array_value','internal_attendance_status');
	
	if($_POST['regular_reappear']=='Reappear') {
		if($shift_ft['shift']==$_POST['shift'] && $shift_ft['full_part_time']==$_POST['full_part_time']) {
		
		echo "<tr class='warning'>
			<td>".$count."</td>
			<td>".$row['ED_RollNo']."</td>
			<td>".strtoupper($row['StudentName'])."</td>
			
			<td>".$row['SUB_CODE']."</td>
			<td>".$row['SUB_TITLE']."</td>
			<td>".$row['Sub_Sem']."</td>
			<td>
			<input type='hidden' name='college_roll_no$count' value='".$shift_ft['college_roll_no']."' />
			<input type='hidden' name='university_roll_no$count' value='".$row['ED_RollNo']."' />
			<input type='hidden' name='student_name$count' value='".$row['StudentName']."' />
			<select name='attendance$count'>";
			
			if(mysql_num_rows($detained_status)==0) {
				if($prev_attendance!='') {
				echo "
				<option value='".$prev_attendance."'>".$prev_attendance."</option>
				<option value='Present'>Present</option>";
				if($_POST['internal_external']=='E') {
					echo "<option value='Absent'>Absent</option>";
				}
			}
			else {
				echo "
				<option value='Present'>Present</option>";
				if($_POST['internal_external']=='E') {
					echo "<option value='Absent'>Absent</option>";
				}
			}
		}
		else {
			echo "<option value='Detained'>Detained</option>";
		}
		echo "
			</select></td>
			</tr>";
			$count++;
		}
		
	}
	else {
	
		if($shift_ft['shift']==$_POST['shift'] && $shift_ft['full_part_time']==$_POST['full_part_time']) {
	
		/*$ptu_subjects = fetch_resource_db('ptu_subjects',array('ED_RollNo','SUB_CODE','Sub_Sem','SUB_TP'),array($row['university_roll_no'],$_POST['subject_code'],$_POST['semester'],$_POST['theory_practical']),'resource_array','');
		*/
			echo "<tr class='warning'>
			<td>".$count."</td>
			<td>".$row['ED_RollNo']."</td>
			<td>".strtoupper($row['StudentName'])."</td>
			<td>".$row['SUB_CODE']."</td>
			<td>".$row['SUB_TITLE']."</td>
			<td>".$row['Sub_Sem']."</td>
			<td>
			<input type='hidden' name='college_roll_no$count' value='".$shift_ft['college_roll_no']."' />
			<input type='hidden' name='university_roll_no$count' value='".$row['ED_RollNo']."' />
			<input type='hidden' name='student_name$count' value='".$row['StudentName']."' />
			<select name='attendance$count'>";
			if(mysql_num_rows($detained_status)==0) {
				if($prev_attendance!='') {
				echo "
				<option value='".$prev_attendance."'>".$prev_attendance."</option>
				<option value='Present'>Present</option>
				";
				if($_POST['internal_external']=='E') {
					echo "<option value='Absent'>Absent</option>";
				}
			
			}
			else {
				echo "
				<option value='Present'>Present</option>
				";
				if($_POST['internal_external']=='E') {
					echo "<option value='Absent'>Absent</option>";
				}
				
			}
		}
		else {
			echo "<option value='Detained'>Detained</option>";
		}
			
			echo "
			</select></td>
			</tr>";
			$count++;
		}
	}
		
}
?>
</table>
<input type='hidden' name='total_count' value='<?php echo $count; ?>' />
<input type='hidden' name='theory_practical' value='<?php echo $_POST['theory_practical']; ?>' />
<input type='hidden' name='paper_id' value='<?php echo $_POST['paper_id']; ?>' />
<input type='hidden' name='subject_master_id' value='<?php echo $_POST['subject_master_id']; ?>' />
<input type='hidden' name='subject_code' value='<?php echo $_POST['subject_code']; ?>' />
<input type='hidden' name='branch_code' value='<?php echo $_POST['branch_code']; ?>' />
<input type='hidden' name='course_code' value='<?php echo $_POST['course_code']; ?>' />
<input type='hidden' name='exam_month' value='<?php echo $_POST['exam_month']; ?>' />
<input type='hidden' name='internal_external' value='<?php echo $_POST['internal_external']; ?>' />
<input type='hidden' name='exam_year' value='<?php echo $_POST['exam_year']; ?>' />
<input type='hidden' name='semester' value='<?php echo $_POST['semester']; ?>' />
<input type='hidden' name='aicte_rc' value='<?php echo $_POST['aicte_rc']; ?>' />
<input type='hidden' name='full_part_time' value='<?php echo $_POST['full_part_time']; ?>' />
<input type='hidden' name='shift' value='<?php echo $_POST['shift']; ?>' />
<input type='hidden' name='internal_max_marks' value='<?php echo $_POST['internal_max_marks']; ?>' />
<input type='hidden' name='external_max_marks' value='<?php echo $_POST['external_max_marks']; ?>' />
<input type='hidden' name='regular_reappear' value='<?php echo $_POST['regular_reappear'] ?>' />
<input type='hidden' name='teacher_mark_attendance' value='' />
<input type='submit' class='btn btn-block btn-danger' value='Click Here To Mark Attendance' onclick="return confirm_action('Do you want to continue ?')"/>
</form>

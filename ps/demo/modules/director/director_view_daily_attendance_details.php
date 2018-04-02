<form action='' method='post'/>

<table class='table table-bordered table-condensed container sortable'>
	<tr>
		<th>Sr. No.</th>
		<th>Class</th>
		<th>Section</th>
		<?php 
		if($_POST['theory_practical']=='P') {
			echo "<th>Group</th>";
		}
		?>
		<th>University Roll No.</th>
		<th>College Roll No.</th>
		<th>Fee Paid</th>
		<th>Student Name</th>
		
		<th>Subject Code/M-Code</th>
		<th>Subject Title</th>
		<th>Semester</th>
		<th>Teacher</th>
		<th>Attandance</th>
	</tr>
<?php



if($_POST['theory_practical']=='T') {

		$roll_nos = mysql_query("SELECT * FROM daily_attendance_student WHERE
		course_code='".$_POST['course_code']."' AND
		branch_code='".$_POST['branch_code']."' AND
		shift='".$_POST['shift']."' AND
		ssection='".$_POST['ssection']."' AND
		sgroup='".$_POST['sgroup']."' AND
		semester='".$_POST['semester']."' AND
		subject_code='".$_POST['subject_code']."' AND
		aicte_rc='".$_POST['aicte_rc']."' AND
		full_part_time='".$_POST['full_part_time']."' AND
		backup='0' ORDER BY university_roll_no ASC") or die("total_lect: ".mysql_error());

		
}

if($_POST['theory_practical']=='P') {
	$roll_nos = mysql_query("SELECT * FROM daily_attendance_student WHERE
		course_code='".$_POST['course_code']."' AND
		branch_code='".$_POST['branch_code']."' AND
		shift='".$_POST['shift']."' AND
		ssection='".$_POST['ssection']."' AND
		sgroup='".$_POST['sgroup']."' AND
		semester='".$_POST['semester']."' AND
		subject_code='".$_POST['subject_code']."' AND
		aicte_rc='".$_POST['aicte_rc']."' AND
		full_part_time='".$_POST['full_part_time']."' AND
		backup='0' ORDER BY university_roll_no ASC") or die("total_lect: ".mysql_error());
		
}

$count = 1;

while($row = mysql_fetch_assoc($roll_nos)) {
	
	$sfname = fetch_resource_db('student_info',array('university_roll_no'),array($row['university_roll_no']),'resource_array_value','ptu_student_name');
	//$smname = fetch_resource_db('student_info',array('university_roll_no'),array($row['university_roll_no']),'resource_array_value','smname');
	//$ssname = fetch_resource_db('student_info',array('university_roll_no'),array($row['university_roll_no']),'resource_array_value','ssname');
	$college_roll_no = fetch_resource_db('student_info',array('university_roll_no'),array($row['university_roll_no']),'resource_array_value','college_roll_no');

	$fee_paid_status_sql = mysql_query("SELECT fee_paid_status FROM student_info WHERE university_roll_no='".$row['university_roll_no']."'") or die(mysql_error());
	$fee_paid_status = mysql_fetch_assoc($fee_paid_status_sql);

		
		echo "<tr class='warning'>
			<td>".$count."</td>
			<td>".$row['class']."</td>
			<td>".$row['section']."</td>";
			
			if($_POST['theory_practical']=='P') {
				echo "<td>".$row['sgroup']."</td>"; 
			}
			
			echo "
			<td>".$row['university_roll_no']."</td>
			<td>".$college_roll_no."</td>
			<td>".$fee_paid_status['fee_paid_status']."</td>
			<input type='hidden' name='university_roll_no$count' value='".$row['university_roll_no']."' />
			<td>".strtoupper($sfname)."</td>
			
			<td>".$_POST['subject_code']."/".$_POST['m_code']."</td>
			<td>".$_POST['subject_title']."</td>
			<td>".$_POST['semester']."</td>
			<td>".$row['teacher_username']."</td>
			<td>".$row['attendance']."</td>
			</tr>";
			$count++;
		
}
?>
</table>
<input type='hidden' name='teacher_view_daily_attendance_details' value='' />
	<input type='hidden' name='total_lectures' value='".$total_lectures."' />
	<input type='hidden' name='ssection' value='".$ssection."' />
	<input type='hidden' name='sgroup' value='".$sgroup."' />
	<input type='hidden' name='branch_code' value='".$branch_code."' />
	<input type='hidden' name='course_code' value='".$course_code."' />
	<input type='hidden' name='subject_code' value='".$subject_code."' />
	<input type='hidden' name='paper_id' value='".$paper_id."' />
	<input type='hidden' name='subject_title' value='".$subject_title."' />
	<input type='hidden' name='shift' value='".$shift."' />
	<input type='hidden' name='full_part_time' value='".$full_part_time."' />
	<input type='hidden' name='semester' value='".$semester."' />
	<input type='hidden' name='theory_practical' value='".$theory_practical."' />
	<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />
<input type='hidden' name='teacher_update_aggregate_attendance' value='<?php echo $count; ?>' />
<input type='hidden' name='total_count' value='<?php echo $count; ?>' />
<!--<input type='button' class='btn btn-block btn-danger' value='Click Here To Print' onclick="return confirm_action('Do you want to continue ?')"/>-->
</form>



<?php

$course_branch = explode(',',$_POST['course_branch']);

if($_POST['theory_practical']=='T') {

	$subject_allotment = mysql_query("SELECT DISTINCT 
	`paper_id`, `subject_code`, `subject_title`, `theory_practical`,  `ssection`, attendance_period,
	`teacher_username`,elective_details,m_code FROM `daily_attendance_student` 
	WHERE 

	attendance_date='".$_POST['attendance_date']."' AND
	course_code='".$course_branch[0]."' AND
	branch_code='".$course_branch[1]."' AND
	semester='".$_POST['semester']."' AND
	aicte_rc='".$_POST['aicte_rc']."' AND
	shift='".$_POST['shift']."' AND
	full_part_time='".$_POST['full_part_time']."' AND
	theory_practical='T'") or die(mysql_error());
	
	
	
}

if($_POST['theory_practical']=='P') {

	$subject_allotment = mysql_query("SELECT DISTINCT 
	`paper_id`, `subject_code`, `subject_title`, `theory_practical`,  `ssection`,sgroup, attendance_period,
	`teacher_username`,elective_details,m_code FROM `daily_attendance_student` 
	
	WHERE 

	attendance_date='".$_POST['attendance_date']."' AND
	course_code='".$course_branch[0]."' AND
	branch_code='".$course_branch[1]."' AND
	semester='".$_POST['semester']."' AND
	aicte_rc='".$_POST['aicte_rc']."' AND
	shift='".$_POST['shift']."' AND
	full_part_time='".$_POST['full_part_time']."' AND
	theory_practical='P'") or die(mysql_error());

}

?>
<table class='table table-bordered table-condensed container sortable'>
	<tr class='warning'>
		<th>Class</th>
		<th>Shift/<br/>FT or PT/</br>AICTE or RC</th>
		<th>Section</th>
		
		<?php 
		if($_POST['theory_practical']=='P') {
			echo "<th>Group</th>";
		}
		?>
		
		<th>Subject Code / M-Code</th>
		<th>Subject Title</th>
		<th>Teacher</th>
		<th>Period</th>
		<th>Semester</th>
		<th>Subject Type</th>
		<th>Total Students</th>
		<th>Present</th>
		<th>Absent</th>
	</tr>
	
	
<?php
$count = 1;
while($row = mysql_fetch_assoc($subject_allotment)) {
	
	$total_students_sql = mysql_query("SELECT COUNT(*) AS total FROM `daily_attendance_student` 
	WHERE 

	attendance_date='".$_POST['attendance_date']."' AND
	course_code='".$course_branch[0]."' AND
	branch_code='".$course_branch[1]."' AND
	semester='".$_POST['semester']."' AND
	subject_code='".$row['subject_code']."' AND
	elective_details='".$row['elective_details']."' AND
	attendance_period='".$row['attendance_period']."' AND
	teacher_username='".$row['teacher_username']."' AND
	aicte_rc='".$_POST['aicte_rc']."' AND
	shift='".$_POST['shift']."' AND
	full_part_time='".$_POST['full_part_time']."' AND
	backup='0' AND

	theory_practical='".$_POST['theory_practical']."'") or die(mysql_error());

	
	
	$total_absent_sql = mysql_query("SELECT COUNT(*) AS total FROM `daily_attendance_student` 
	WHERE 

	attendance_date='".$_POST['attendance_date']."' AND
	course_code='".$course_branch[0]."' AND
	branch_code='".$course_branch[1]."' AND
	semester='".$_POST['semester']."' AND
	subject_code='".$row['subject_code']."' AND
	elective_details='".$row['elective_details']."' AND
	attendance_period='".$row['attendance_period']."' AND
	teacher_username='".$row['teacher_username']."' AND
	aicte_rc='".$_POST['aicte_rc']."' AND
	shift='".$_POST['shift']."' AND
	full_part_time='".$_POST['full_part_time']."' AND
	attendance = 'Absent' AND
	backup='0' AND

	theory_practical='".$_POST['theory_practical']."'") or die(mysql_error());
	
	$total_present_sql = mysql_query("SELECT COUNT(*) AS total FROM `daily_attendance_student` 
	WHERE 

	attendance_date='".$_POST['attendance_date']."' AND
	course_code='".$course_branch[0]."' AND
	branch_code='".$course_branch[1]."' AND
	semester='".$_POST['semester']."' AND
	subject_code='".$row['subject_code']."' AND
	elective_details='".$row['elective_details']."' AND
	attendance_period='".$row['attendance_period']."' AND
	teacher_username='".$row['teacher_username']."' AND
	aicte_rc='".$_POST['aicte_rc']."' AND
	shift='".$_POST['shift']."' AND
	full_part_time='".$_POST['full_part_time']."' AND
	attendance = 'Present' AND
	backup='0' AND

	theory_practical='".$_POST['theory_practical']."'") or die(mysql_error());
	
	$total_students = mysql_fetch_assoc($total_students_sql);
	$total_absent = mysql_fetch_assoc($total_absent_sql);
	$total_present = mysql_fetch_assoc($total_present_sql);
	
	
	
	$teacher_name = fetch_resource_db('users',array('username'),array($row['teacher_username']),'resource_array_value','name');
	$branch_name = fetch_resource_db('branch_code',array('branch_code'),array($course_branch[1]),'resource_array_value','branch_name');
	$course_name = fetch_resource_db('course_code',array('course_code'),array($course_branch[0]),'resource_array_value','course_name');

?>
<tr class='warning'>
	<td><?php echo $course_name."(".$branch_name.")"; ?></td>
	<td><?php echo $_POST['shift']."/<br/>".$_POST['full_part_time']."/</br>".$_POST['aicte_rc']; ?></td>
	<td><?php echo $row['ssection']; ?></td>
	
	<?php if($_POST['theory_practical']=='P') {
		echo "<td>".$row['sgroup']."</td>"; 
	}
	?>
	
	<td><?php echo $row['subject_code']." / ".$row['m_code']; ?></td>
	<td><?php echo $row['subject_title']."(".$row['elective_details'].")"; ?></td>
	<td><?php echo $teacher_name; ?></td>
	<td><?php echo $row['attendance_period']; ?></td>
	<td><?php echo $_POST['semester']; ?></td>
	<td><?php echo $_POST['theory_practical']; ?></td>
	<td><?php echo $total_students['total']; ?></td>
	<td><?php echo $total_present['total']; ?></td>
	<td><?php echo $total_absent['total']; ?></td>


	
</tr>
<?php
$count++;
}
?>
</table>

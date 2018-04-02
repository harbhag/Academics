<?php

show_label('info','Daily Attendance Record');
echo "<br/>";

$subject_allotment = mysql_query("SELECT DISTINCT course_code,branch_code,subject_code,paper_id,aicte_rc,shift,full_part_time,ssection,sgroup,semester,subject_title,theory_practical,attendance_date,attendance_period FROM
daily_attendance_student WHERE attendance_date='".$_POST['attendance_date']."' AND teacher_username='".$_SESSION['username']."' AND backup='0'") or die(mysql_error());

if(mysql_num_rows($subject_allotment)==0) {
	show_label('info','No Record Found for Daily Attendance !');
	exit();
}
?>
<table class='table table-bordered table-condensed container sortable'>
	<tr class='warning'>
		<th>Class</th>
		<th>Shift/<br/>FT or PT/</br>AICTE or RC</th>
		<th>Section / Group</th>
		<th>Subject Code</th>
		<th>Subject Title</th>
		<th>Semester</th>
		<th>Subject Type</th>
		<th>Attendance Date / Attendance Period</th>
		<th>Update Attendance</th>
	</tr>
<?php
$count = 1;
while($row = mysql_fetch_assoc($subject_allotment)) {
	
	$branch_name = fetch_resource_db('branch_code',array('branch_code'),array($row['branch_code']),'resource_array_value','branch_name');
	$course_name = fetch_resource_db('course_code',array('course_code'),array($row['course_code']),'resource_array_value','course_name');

?>
<tr class='warning'>
	<td><?php echo $course_name."(".$branch_name.")"; ?></td>
	<td><?php echo $row['shift']."/<br/>".$row['full_part_time']."/</br>".$row['aicte_rc']; ?></td>
	<td><?php echo $row['ssection']." / ".$row['sgroup']; ?></td>
	<td><?php echo $row['subject_code']; ?></td>
	<td><?php echo $row['subject_title']; ?></td>
	<td><?php echo $row['semester']; ?></td>
	<td><?php echo $row['theory_practical']; ?></td>
	<td><?php echo $row['attendance_date']." / ".$row['attendance_period']; ?></td>
	
	<td><?php update_daily_attendance($row['course_code'],$row['branch_code'],$row['subject_code'],$row['paper_id'],
	$row['subject_title'],$row['theory_practical'],$row['semester'],$row['shift'],
	$row['full_part_time'],$row['aicte_rc'],$row['exam_month'],$row['exam_year'],$row['ssection'],$row['sgroup'],$count,$row['attendance_date'],$row['attendance_period']); ?></td>
</tr>
<?php
$count++;
}
?>
</table>

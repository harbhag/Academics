<?php

show_label('info','Attendance Marks Module');
echo "<br/>";

$subject_allotment = mysql_query("SELECT DISTINCT  `course_code`, `branch_code`, 
`paper_id`, `subject_code`, `subject_title`, `short_subject_title`, `theory_practical`, 
`semester`, `full_part_time`, `sessional_max_marks`, `ssection`, `teacher_username`, 
`aicte_rc`, `regular_reappear`, `shift`, `BR_TITLE`, `exam_month`, `exam_year`, 
`status`,grace_period_allowed,status_daily_attendance,status_aggregate_attendance,elective_details,m_code,scheme_code,teacher_type,contact_hours,elective_details FROM `time_table` 
WHERE 
`status` = '1' AND 
course_code!='3' AND

teacher_username='".$_SESSION['username']."' AND
theory_practical='T'") or die(mysql_error());

?>
<table class='table table-bordered table-condensed sortable'>
	<tr class='warning'>
		<th>Class</th>
		<th>Shift/<br/>FT or PT/</br>AICTE or RC</th>
		<th>Section</th>
		<th>Subject Code / M-Code</th>
		<th>Subject Title</th>
		<th>Semester</th>
		<th>Subject Type</th>
		<th>Contact hours per week</th>
		<th>Teacher Type(Subject/Adjustment)</th>
		<th></th>
		<th></th>
	</tr>
	
	
<?php
$count = 1;
while($row = mysql_fetch_assoc($subject_allotment)) {
	
	$branch_name = fetch_resource_db('branch_code',array('branch_code'),array($row['branch_code']),'resource_array_value','branch_name');
	$course_name = fetch_resource_db('course_code',array('course_code'),array($row['course_code']),'resource_array_value','course_name');
	
	$master_lock_sql = mysql_query("SELECT * FROM  `consolidated_report_lock` where `course_code`='".$row['course_code']."' AND
		branch_code='".$row['branch_code']."' AND
		shift='".$row['shift']."' AND
		paper_id='".$row['paper_id']."' AND
		ssection='".$row['ssection']."' AND
		semester='".$row['semester']."' AND
		teacher_username='".$_SESSION['username']."' AND
		subject_code='".$row['subject_code']."' AND 
		aicte_rc='".$row['aicte_rc']."' AND
		full_part_time='".$row['full_part_time']."' and 
		backup='0' AND
		consolidated_report_lock_status='1'") or die(mysql_error());
		
		
		if(mysql_num_rows($master_lock_sql)==1) {
			continue;
		}

?>
<tr class='warning'>
	<td><?php echo $course_name."(".$branch_name.")"; ?></td>
	<td><?php echo $row['shift']."/<br/>".$row['full_part_time']."/</br>".$row['aicte_rc']; ?></td>
	<td><?php echo $row['ssection']; ?></td>
	<td><?php echo $row['subject_code']." / ".$row['m_code']; ?></td>
	<td><?php echo $row['subject_title']."(".$row['elective_details'].")"; ?></td>
	<td><?php echo $row['semester']; ?></td>
	<td><?php echo $row['theory_practical']; ?></td>
	<td><?php echo $row['contact_hours']; ?></td>
	<td><?php echo $row['teacher_type']; ?></td>
	
	
	<td><?php upload_attendance_marks($row['course_code'],$row['branch_code'],$row['subject_code'],$row['paper_id'],
	$row['subject_title'],$row['theory_practical'],$row['semester'],$row['shift'],
	$row['full_part_time'],$row['aicte_rc'],$row['exam_month'],$row['exam_year'],$row['ssection'],$row['sgroup'],$count,$row['internal_lock_status'],$row['elective_details']); ?></td>
	
	<td><?php update_attendance_marks($row['course_code'],$row['branch_code'],$row['subject_code'],$row['paper_id'],
	$row['subject_title'],$row['theory_practical'],$row['semester'],$row['shift'],
	$row['full_part_time'],$row['aicte_rc'],$row['exam_month'],$row['exam_year'],$row['ssection'],$row['sgroup'],$count,$row['internal_lock_status'],$row['elective_details']); ?></td>
	
	<td><?php details_attendance_marks($row['course_code'],$row['branch_code'],$row['subject_code'],$row['paper_id'],
	$row['subject_title'],$row['theory_practical'],$row['semester'],$row['shift'],
	$row['full_part_time'],$row['aicte_rc'],$row['exam_month'],$row['exam_year'],$row['ssection'],$row['sgroup'],$count,$row['assignment_no'],$row['internal_lock_status'],$row['elective_details']); ?></td>

	

	
</tr>
<?php
$count++;
}
?>
</table>

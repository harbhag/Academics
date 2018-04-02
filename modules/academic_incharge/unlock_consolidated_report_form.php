<?php


$branch_codes_sql = mysql_query("SELECT show_branch_code,show_course_code,show_semester FROM users WHERE username='".$_SESSION['username']."' AND usertype='academic_incharge'") or die(mysql_error());

$branch_codes = mysql_fetch_assoc($branch_codes_sql);

if($branch_codes['show_branch_code']!='ALL') {
	
	$subject_allotment = mysql_query("SELECT DISTINCT  `course_code`, `branch_code`, 
	`paper_id`, `subject_code`, `subject_title`, `short_subject_title`, `theory_practical`, 
	`semester`, `full_part_time`, `sessional_max_marks`, `ssection`, `teacher_username`, 
	`aicte_rc`, `regular_reappear`, `shift`, `BR_TITLE`, `exam_month`, `exam_year`, 
	`status`,grace_period_allowed,status_daily_attendance,status_aggregate_attendance,elective_details,m_code,scheme_code,teacher_type,contact_hours FROM `time_table` 
	WHERE 
	`status` = '1' AND 
	subject_code IN 

	(SELECT DISTINCT  subject_code FROM `consolidated_report_lock`  WHERE  `consolidated_report_lock_status` = '1' AND  teacher_username='".$_POST['username']."') 

	AND

	branch_code IN (".$branch_codes['show_branch_code'].")

	AND

	semester IN (".$branch_codes['show_semester'].")

	AND

	course_code IN (".$branch_codes['show_course_code'].")

	AND

	teacher_username='".$_POST['username']."' AND
	theory_practical='T'") or die(mysql_error());
	
}

if($branch_codes['show_branch_code']=='ALL') {
	
	$subject_allotment = mysql_query("SELECT DISTINCT  `course_code`, `branch_code`, 
	`paper_id`, `subject_code`, `subject_title`, `short_subject_title`, `theory_practical`, 
	`semester`, `full_part_time`, `sessional_max_marks`, `ssection`, `teacher_username`, 
	`aicte_rc`, `regular_reappear`, `shift`, `BR_TITLE`, `exam_month`, `exam_year`, 
	`status`,grace_period_allowed,status_daily_attendance,status_aggregate_attendance,elective_details,m_code,scheme_code,teacher_type,contact_hours FROM `time_table` 
	WHERE 
	`status` = '1' AND 
	subject_code IN 

	(SELECT DISTINCT  subject_code FROM `consolidated_report_lock`  WHERE  `consolidated_report_lock_status` = '1' AND  teacher_username='".$_POST['username']."') 

	AND

	semester IN (".$branch_codes['show_semester'].")

	AND

	course_code IN (".$branch_codes['show_course_code'].")

	AND
	
	
	branch_code IN (SELECT DISTINCT  branch_code FROM `consolidated_report_lock`  WHERE  `consolidated_report_lock_status` = '1' AND  teacher_username='".$_POST['username']."')

	AND

	teacher_username='".$_POST['username']."' AND
	theory_practical='T'") or die(mysql_error());
}


?>
<table class='table table-bordered table-condensed sortable container'>
	<tr class='warning'>
		<th>Class</th>
		<th>Shift/<br/>FT or PT/</br>AICTE or RC</th>
		<th>Section</th>
		<th>Subject Code / M-Code</th>
		<th>Subject Title</th>
		<th>Semester</th>
		<th>Subject Type</th>
		<th></th>
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
	<td><?php echo $row['ssection']; ?></td>
	<td><?php echo $row['subject_code']." / ".$row['m_code']; ?></td>
	<td><?php echo $row['subject_title']."(".$row['elective_details'].")"; ?></td>
	<td><?php echo $row['semester']; ?></td>
	<td><?php echo $row['theory_practical']; ?></td>
	
	
	<td><? unlock_consolidated_report_form($row['autoid'],$row['course_code'],$row['branch_code'],$row['subject_code'],$row['paper_id'],$row['subject_title'],$row['theory_practical'],$row['semester'],$row['shift'],$row['full_part_time'],$row['aicte_rc'],$row['exam_month'],$row['exam_year'],$row['ssection'],$row['sgroup'],$count,$row['m_code'],$_POST['username']); ?></td>
	

	
</tr>
<?php
$count++;
}
?>
</table>



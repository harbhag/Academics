<?php

//$subject_allotment = fetch_resource_db('time_table',array('teacher_username','theory_practical','status'),array($_SESSION['username'],'T','1'),'resource','');

$subject_allotment = fetch_resource_db('time_table',array('teacher_username','theory_practical','status','status_internal_practical'),array($_SESSION['username'],'P','1','1'),'resource','');

?>
<table class='table table-bordered table-condensed container'>
	<tr class='warning'>
		<th>Class</th>
		<th>Shift/<br/>FT or PT/</br>AICTE or RC</th>
		<th>Section/<br/>Group</th>
		<th>Subject Code</th>
		<th>Subject Title</th>
		<th>Semester</th>
		<th>Subject Type</th>
		<th>Upload Marks</th>
		<th>Update Marks</th>
		<th>Details</th>
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
	<td><?php echo $row['ssection']."/<br/>".$row['sgroup']; ?></td>
	<td><?php echo $row['subject_code']; ?></td>
	<td><?php echo $row['subject_title']; ?></td>
	<td><?php echo $row['semester']; ?></td>
	<td><?php echo $row['theory_practical']; ?></td>
	
	<td><?php upload_internal_practical_marks($row['course_code'],$row['branch_code'],$row['subject_code'],$row['paper_id'],
	$row['subject_title'],$row['theory_practical'],$row['semester'],$row['shift'],
	$row['full_part_time'],$row['aicte_rc'],$row['exam_month'],$row['exam_year'],$row['ssection'],$row['sgroup'],$count,$row['internal_lock_status'],$row['elective_details']); ?></td>
	
	<td><?php update_internal_practical_marks($row['course_code'],$row['branch_code'],$row['subject_code'],$row['paper_id'],
	$row['subject_title'],$row['theory_practical'],$row['semester'],$row['shift'],
	$row['full_part_time'],$row['aicte_rc'],$row['exam_month'],$row['exam_year'],$row['ssection'],$row['sgroup'],$count,$row['internal_lock_status'],$row['elective_details']); ?></td>
	
	<td><?php details_internal_practical_marks($row['course_code'],$row['branch_code'],$row['subject_code'],$row['paper_id'],
	$row['subject_title'],$row['theory_practical'],$row['semester'],$row['shift'],
	$row['full_part_time'],$row['aicte_rc'],$row['exam_month'],$row['exam_year'],$row['ssection'],$row['sgroup'],$count,$row['assignment_no'],$row['internal_lock_status'],$row['elective_details']); ?></td>

	
</tr>
<?php
$count++;
}
?>
</table>

<?php

//echo "<center><span style='color:red;font-size:14px;font-weight:bold'>Attendance can be marked only after completion of period. Incase \"Teacher Type\" and \"Contact hours per week\" as per time table is not displayed, contact Academic Incharge of Department.</span></center></br>";

//echo "<center><span style='color:red;font-size:14px;font-weight:bold'>As permitted by the Competent Authority, Attendance of Practicals (if pending) can be marked only on 20-21 February, 2014 (on-line). However, any updation/deletion of attendance will be allowed only with the prior permission of Head of Institution (Director, GNDEC).</span></center></br>";

//echo "<center><span style='color:red;font-size:20px;font-weight:bold'>Attendance module will be under maintenance from 10 pm (Friday i.e.04-01-2014) to 10 am (Monday i.e. 03-02-2014)</span></center></br>";

//$subject_allotment = fetch_resource_db('time_table',array('teacher_username','theory_practical','status'),array($_SESSION['username'],'T','1'),'resource','');

//show_label('info','Competent Authority has allowed marking of 04-02-2014 attendance today (05-02-2014)'); 

//echo "<br/>";

$subject_allotment = mysql_query("SELECT DISTINCT  `course_code`, `branch_code`, 
`paper_id`, `subject_code`, `subject_title`, `short_subject_title`, `theory_practical`, 
`semester`, `full_part_time`, `sessional_max_marks`, `ssection`, `teacher_username`, 
`aicte_rc`, `regular_reappear`, `shift`, `BR_TITLE`, `exam_month`, `exam_year`, 
`status`,grace_period_allowed,status_daily_attendance,status_aggregate_attendance,elective_details,m_code,scheme_code,teacher_type,contact_hours FROM `time_table` 
WHERE 
`status` = '1' AND 
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
		<th></th>
		<th></th>
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
	
	<?php 
		
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
			$master_lock = 1;
		}
		if(mysql_num_rows($master_lock_sql)==0) {
			$master_lock = 0;
		}
		
	?>
	
	
	<td><?php print_consolidated_report($row['course_code'],$row['branch_code'],$row['subject_code'],$row['paper_id'],
	$row['subject_title'],$row['theory_practical'],$row['semester'],$row['shift'],
	$row['full_part_time'],$row['aicte_rc'],$row['exam_month'],$row['exam_year'],$row['ssection'],$row['sgroup'],$master_lock); ?></td>
	
	<td><?php lock_consolidated_report_form($row['autoid'],$row['course_code'],$row['branch_code'],$row['subject_code'],$row['paper_id'],$row['subject_title'],$row['theory_practical'],$row['semester'],$row['shift'],$row['full_part_time'],$row['aicte_rc'],$row['exam_month'],$row['exam_year'],$row['ssection'],$row['sgroup'],$count,$row['m_code'],$master_lock); ?></td>
	
	<td><?php consolidated_report_details($row['course_code'],$row['branch_code'],$row['subject_code'],$row['paper_id'],
	$row['subject_title'],$row['theory_practical'],$row['semester'],$row['shift'],
	$row['full_part_time'],$row['aicte_rc'],$row['exam_month'],$row['exam_year'],$row['ssection'],$row['sgroup']); ?></td>

	
</tr>
<?php
$count++;
}
?>
</table>


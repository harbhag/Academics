
<?php

show_label('info','Topics Covered');
echo "<br/>";

if($_POST['theory_practical']=='T') {
	
			
	$topics_covered = mysql_query("SELECT DISTINCT attendance_date,attendance_period,topics_covered,teacher_username FROM course_delivery
		WHERE course_code='".$_POST['course_code']."' AND
		branch_code='".$_POST['branch_code']."' AND
		shift='".$_POST['shift']."' AND
		ssection='".$_POST['ssection']."' AND
		semester='".$_POST['semester']."' AND
		
		subject_code='".$_POST['subject_code']."' AND
		aicte_rc='".$_POST['aicte_rc']."' AND
		full_part_time='".$_POST['full_part_time']."' AND backup='0' ORDER BY attendance_date ASC") or die("total_lect: ".mysql_error());
	
}

if($_POST['theory_practical']=='P') {
	
			
	$topics_covered = mysql_query("SELECT DISTINCT attendance_date,attendance_period,topics_covered,teacher_username FROM course_delivery
		
		WHERE course_code='".$_POST['course_code']."' AND
		branch_code='".$_POST['branch_code']."' AND
		shift='".$_POST['shift']."' AND
		ssection='".$_POST['ssection']."' AND
		sgroup='".$_POST['sgroup']."' AND
		semester='".$_POST['semester']."' AND
		subject_code='".$_POST['subject_code']."' AND
		aicte_rc='".$_POST['aicte_rc']."' AND
		full_part_time='".$_POST['full_part_time']."'  AND backup='0' ORDER BY attendance_date ASC") or die("total_lect: ".mysql_error());
	
}

?>

<table class='table table-bordered table-condensed container'>
	<tr>
		<th style='background-color:#D9EDF7'>Attendance Date</th>
		<th style='background-color:#D9EDF7'>Attendance Period</th>
		<th style='background-color:#D9EDF7'>Topics/Experiments Covered</th>
		<th style='background-color:#D9EDF7'>Teacher</th>
	</tr>
	
	<?php 
	
	While($row = mysql_fetch_assoc($topics_covered)) {
		
		$teacher_name = mysql_fetch_assoc(mysql_query("SELECT name FROM users WHERE username = '".$row['teacher_username']."'"));
		
		echo "<tr>
		<td>".$row['attendance_date']."</td>
		<td>".$row['attendance_period']."</td>
		<td>".$row['topics_covered']."</td>
		<td>".$teacher_name['name']."</td>
		</tr>";
	
	}
	?>
</table>





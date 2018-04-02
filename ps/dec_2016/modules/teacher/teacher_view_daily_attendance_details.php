<?php

show_label('info','Daily Attendance Details');
echo "<br/>";

//show_label('info','This section is down for maintenance.');
//exit();

if($_POST['theory_practical']=='T') {

		$roll_nos = mysql_query("SELECT DISTINCT university_roll_no FROM daily_attendance_student WHERE
		course_code='".$_POST['course_code']."' AND
		branch_code='".$_POST['branch_code']."' AND
		shift='".$_POST['shift']."' AND
		ssection='".$_POST['ssection']."' AND
		semester='".$_POST['semester']."' AND

		subject_code='".$_POST['subject_code']."' AND
		elective_details='".$_POST['elective_details']."' AND
		aicte_rc='".$_POST['aicte_rc']."' AND
		full_part_time='".$_POST['full_part_time']."' AND
		backup='0' and theory_practical='T' ORDER BY university_roll_no ASC") or die("total_lect: ".mysql_error());


		$total_lect = mysql_query("SELECT DISTINCT attendance_date,attendance_period FROM daily_attendance_student
		WHERE course_code='".$_POST['course_code']."' AND
		branch_code='".$_POST['branch_code']."' AND
		shift='".$_POST['shift']."' AND
		ssection='".$_POST['ssection']."' AND
		semester='".$_POST['semester']."' AND
		
		subject_code='".$_POST['subject_code']."' AND
		elective_details='".$_POST['elective_details']."' AND
		aicte_rc='".$_POST['aicte_rc']."' AND
		full_part_time='".$_POST['full_part_time']."' AND backup='0' and theory_practical='T'") or die("total_lect: ".mysql_error());
		
}

if($_POST['theory_practical']!='T') {
	$roll_nos = mysql_query("SELECT DISTINCT university_roll_no FROM daily_attendance_student WHERE
		course_code='".$_POST['course_code']."' AND
		branch_code='".$_POST['branch_code']."' AND
		shift='".$_POST['shift']."' AND
		ssection='".$_POST['ssection']."' AND
		sgroup='".$_POST['sgroup']."' AND
		semester='".$_POST['semester']."' AND
		subject_code='".$_POST['subject_code']."' AND
		elective_details='".$_POST['elective_details']."' AND
		aicte_rc='".$_POST['aicte_rc']."' AND
		full_part_time='".$_POST['full_part_time']."' AND
		backup='0' and theory_practical!='T' ORDER BY university_roll_no ASC") or die("total_lect: ".mysql_error());


		$total_lect = mysql_query("SELECT DISTINCT attendance_date,attendance_period FROM daily_attendance_student
		WHERE course_code='".$_POST['course_code']."' AND
		branch_code='".$_POST['branch_code']."' AND
		shift='".$_POST['shift']."' AND
		ssection='".$_POST['ssection']."' AND
		sgroup='".$_POST['sgroup']."' AND
		semester='".$_POST['semester']."' AND
		subject_code='".$_POST['subject_code']."' AND
		elective_details='".$_POST['elective_details']."' AND
		aicte_rc='".$_POST['aicte_rc']."' AND
		full_part_time='".$_POST['full_part_time']."'  AND backup='0' and theory_practical!='T' ;") or die("total_lect: ".mysql_error());
		
}

?>



<table class='table table-bordered table-condensed sortable'>
	<tr>
		<th style='background-color:#D9EDF7'>Total Student</th>
		<th style='background-color:#D9EDF7'>Subject Code/M-Code</th>
		<th style='background-color:#D9EDF7'>Subject Title</th>
		<th style='background-color:#D9EDF7'>Semester</th>
		<th style='background-color:#D9EDF7'>Total Lectures</th>
		
	</tr>
	
	<?php 
	echo "<tr>
	<td>".mysql_num_rows($roll_nos)."</td>
	<td>".$_POST['subject_code']."/".$_POST['m_code']."</td>
	<td>".$_POST['subject_title']."</td>
	<td>".$_POST['semester']."</td>
	<td>".mysql_num_rows($total_lect)."</td>
	</tr>";
	?>
</table>

<?php
if($_POST['theory_practical']=='T') {
	
	$att_dates = mysql_query("SELECT DISTINCT attendance_date,attendance_period,teacher_username FROM daily_attendance_student
		WHERE course_code='".$_POST['course_code']."' AND
		branch_code='".$_POST['branch_code']."' AND
		shift='".$_POST['shift']."' AND
		ssection='".$_POST['ssection']."' AND
		semester='".$_POST['semester']."' AND
		
		subject_code='".$_POST['subject_code']."' AND
		elective_details='".$_POST['elective_details']."' AND
		aicte_rc='".$_POST['aicte_rc']."' AND
		full_part_time='".$_POST['full_part_time']."' AND backup='0' and theory_practical='T' ORDER BY attendance_date ASC") or die("total_lect: ".mysql_error());

	
}

if($_POST['theory_practical']!='T') {
	
	$att_dates = mysql_query("SELECT DISTINCT attendance_date,attendance_period,teacher_username FROM daily_attendance_student
		WHERE course_code='".$_POST['course_code']."' AND
		branch_code='".$_POST['branch_code']."' AND
		shift='".$_POST['shift']."' AND
		ssection='".$_POST['ssection']."' AND
		sgroup='".$_POST['sgroup']."' AND
		semester='".$_POST['semester']."' AND
		subject_code='".$_POST['subject_code']."' AND
		elective_details='".$_POST['elective_details']."' AND
		aicte_rc='".$_POST['aicte_rc']."' AND
		full_part_time='".$_POST['full_part_time']."' and theory_practical!='T'  AND backup='0' ORDER BY attendance_date ASC") or die("total_lect: ".mysql_error());
		
	
}

?>





<form action='' method='post'/>
<table class='table table-bordered table-condensed sortable'>
	<tr>
		<th>University Roll No.</th>
		<th>College Roll No.</th>
		<th>Fee Paid</th>
		<th>Student Name</th>

		<?php 
		while($row = mysql_fetch_assoc($att_dates)) {
			
			$short_name = mysql_fetch_assoc(mysql_query("SELECT short_name FROM users WHERE username = '".$row['teacher_username']."'"));
			
			echo "<th style='color:blue;font-size:10px'>".$row['attendance_date']."<br/>".$row['attendance_period']."<br/>(".$short_name['short_name'].")</th>";
		}
		?>
		
		<th>Attended Lectures</th>
		<th>% age (Based on Total Lectures of Class)</th>
		
	</tr>
<?php

$count = 1;

while($row = mysql_fetch_assoc($roll_nos)) {
	
	$sfname = fetch_resource_db('student_info',array('university_roll_no'),array($row['university_roll_no']),'resource_array_value','ptu_student_name');
	//$smname = fetch_resource_db('student_info',array('university_roll_no'),array($row['university_roll_no']),'resource_array_value','smname');
	//$ssname = fetch_resource_db('student_info',array('university_roll_no'),array($row['university_roll_no']),'resource_array_value','ssname');
	$college_roll_no = fetch_resource_db('student_info',array('university_roll_no'),array($row['university_roll_no']),'resource_array_value','college_roll_no');

	if($_POST['theory_practical']!='T') {

		$attended_lecture_sql = mysql_query("SELECT count(autoid) AS attended_lectures FROM daily_attendance_student WHERE
		course_code='".$_POST['course_code']."' AND
		branch_code='".$_POST['branch_code']."' AND
		shift='".$_POST['shift']."' AND
		ssection='".$_POST['ssection']."' AND
		sgroup='".$_POST['sgroup']."' AND
		semester='".$_POST['semester']."' AND
		subject_code='".$_POST['subject_code']."' AND
		elective_details='".$_POST['elective_details']."' AND
		aicte_rc='".$_POST['aicte_rc']."' AND
		full_part_time='".$_POST['full_part_time']."' AND
		university_roll_no='".$row['university_roll_no']."' AND
		attendance='Present' AND
		backup='0' and theory_practical!='T' ") or die(mysql_error());
		
		
		$att_dates = mysql_query("SELECT DISTINCT attendance_date,attendance_period FROM daily_attendance_student
		WHERE course_code='".$_POST['course_code']."' AND
		branch_code='".$_POST['branch_code']."' AND
		shift='".$_POST['shift']."' AND
		ssection='".$_POST['ssection']."' AND
		sgroup='".$_POST['sgroup']."' AND
		semester='".$_POST['semester']."' AND
		subject_code='".$_POST['subject_code']."' AND
		elective_details='".$_POST['elective_details']."' AND
		aicte_rc='".$_POST['aicte_rc']."' AND
		full_part_time='".$_POST['full_part_time']."'  AND backup='0' and theory_practical!='T' ORDER BY attendance_date ASC") or die("total_lect: ".mysql_error());

	}

	if($_POST['theory_practical']=='T') {

		$attended_lecture_sql = mysql_query("SELECT count(autoid) AS attended_lectures FROM daily_attendance_student WHERE
		course_code='".$_POST['course_code']."' AND
		branch_code='".$_POST['branch_code']."' AND
		shift='".$_POST['shift']."' AND
		ssection='".$_POST['ssection']."' AND
		semester='".$_POST['semester']."' AND
		subject_code='".$_POST['subject_code']."' AND
		elective_details='".$_POST['elective_details']."' AND
		aicte_rc='".$_POST['aicte_rc']."' AND
		full_part_time='".$_POST['full_part_time']."' AND
		university_roll_no='".$row['university_roll_no']."' AND
		attendance='Present' AND
		backup='0' and theory_practical='T' ") or die(mysql_error());
		
		$att_dates = mysql_query("SELECT DISTINCT attendance_date,attendance_period FROM daily_attendance_student
		WHERE course_code='".$_POST['course_code']."' AND
		branch_code='".$_POST['branch_code']."' AND
		shift='".$_POST['shift']."' AND
		ssection='".$_POST['ssection']."' AND
		semester='".$_POST['semester']."' AND
		
		subject_code='".$_POST['subject_code']."' AND
		elective_details='".$_POST['elective_details']."' AND
		aicte_rc='".$_POST['aicte_rc']."' AND
		full_part_time='".$_POST['full_part_time']."' AND backup='0' and theory_practical='T' ORDER BY attendance_date ASC") or die("total_lect: ".mysql_error());

	}

	$fee_paid_status_sql = mysql_query("SELECT fee_paid_status FROM student_info WHERE university_roll_no='".$row['university_roll_no']."'") or die(mysql_error());
	$fee_paid_status = mysql_fetch_assoc($fee_paid_status_sql);

	$attended_lecture = mysql_fetch_assoc($attended_lecture_sql);
		
		echo "<tr class='warning'>
			<td>".$row['university_roll_no']."</td>
			<td>".$college_roll_no."</td>
			<td>".$fee_paid_status['fee_paid_status']."</td>
			<input type='hidden' name='university_roll_no$count' value='".$row['university_roll_no']."' />
			<td>".strtoupper($sfname)."</td>";
			
			while($d = mysql_fetch_assoc($att_dates)) {
				$att_sql = mysql_query("SELECT attendance  FROM daily_attendance_student WHERE
				course_code='".$_POST['course_code']."' AND
				branch_code='".$_POST['branch_code']."' AND
				shift='".$_POST['shift']."' AND
				semester='".$_POST['semester']."' AND
				subject_code='".$_POST['subject_code']."' AND
				elective_details='".$_POST['elective_details']."' AND
				aicte_rc='".$_POST['aicte_rc']."' AND
				full_part_time='".$_POST['full_part_time']."' AND
				university_roll_no='".$row['university_roll_no']."' AND
				attendance_date='".$d['attendance_date']."' AND
				attendance_period='".$d['attendance_period']."' AND
				backup='0'") or die(mysql_error());
				
				
				$att = mysql_fetch_assoc($att_sql); 
				
				$att_per = round(attendance_percentage(mysql_num_rows($total_lect),$attended_lecture['attended_lectures'])) ;
				
				
				if($att['attendance']=='Present') {
					$ap = '<span style="color:green;font-weight:bold">P</span>';
				}
				
				if($att['attendance']=='Absent') {
					$ap = '<span style="color:red;font-weight:bold">A</span>';
				}
				
				if($att['attendance']=='') {
					$ap = '<span style="color:red;font-weight:bold"></span>';
				}
					
				echo "<td>".$ap."</td>";
				
			}
			
			echo "
			<td>".$attended_lecture['attended_lectures']."</td>
			<input class='input-small' size='16' value='".$attended_lecture['attended_lectures']."' type='hidden' id='attended_lectures$count' name='attended_lectures$count'>";

			if($att_per>=75) {
				echo "<td><span style='color:green;font-weight:bold'>".$att_per." %</span></td>";
			}
			else {
				echo "<td><span style='color:red;font-weight:bold'>".$att_per." %</span></td>";
			}
			
			echo "
			<input class='input-small' size='16' value='".attendance_percentage(mysql_num_rows($total_lect),$attended_lecture['attended_lectures'])."' type='hidden' id='attendance_percentage$count' name='attendance_percentage$count'>
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


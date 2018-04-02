<?php

show_label('info','Mark Attendance');
echo "<br/>";

//show_label('info','This section is down for maintenance.');
//exit();

$allowd_ip = mysql_query("SELECT ip_address FROM ip_address WHERE ip_address='".$_SERVER['REMOTE_ADDR']."' AND module_name='daily_attendance' AND allowed='Y'") or die(mysql_error());

$current_time = date('H:i:s');

$attendance_allowed_date = mysql_query("SELECT * FROM attendance_allowed_date where attendance_date = '".$_POST['attendance_date']."'
AND allowed_till_date>='".date('Y-m-d')."'") or die(mysql_error());

$attendance_not_allowed_date = mysql_query("SELECT * FROM attendance_not_allowed_date where attendance_date = '".$_POST['attendance_date']."'") or die(mysql_error());

if(mysql_num_rows($attendance_not_allowed_date)==1) {
	show_label('important','Attendance cannot be marked for this date ('.$_POST['attendance_date'].')');
	exit();
}

$prev_period = $_POST['attendance_period']-1;

//if(mysql_num_rows($attendance_allowed_date)!=1 AND $_SESSION['username']!='harbhag') {

/*
if(mysql_num_rows($attendance_allowed_date)!=1) {

	$check_period = mysql_query("SELECT * FROM period_time WHERE period_no='".$_POST['attendance_period']."' 
	AND attendance_time_start<='".$current_time."' 
	AND attendance_time_end>'".$current_time."' 
	AND shift='".$_POST['shift']."'
	AND full_part_time='".$_POST['full_part_time']."'
	") or die(mysql_error());


	//if(mysql_num_rows($check_period)!=1  AND $_SESSION['username']!='harbhag') {
	if(mysql_num_rows($check_period)!=1) {
		show_label('important','Attendance for Period No.'.$_POST['attendance_period'].' cannot be marked at this time.');
		exit();
	}
}
*/

if(mysql_num_rows($allowd_ip)!=1) {
	show_label('important','You are not allowed to upload attendance from this network.');
	exit();
}


if($_POST['attendance_period']=='') {
	show_label('important','Invalid period no. !!!');
	exit();
}

show_label('info','Topics Covered:- '.$_POST['topics_covered']);
echo "<br/>";

if($_POST['theory_practical']=='P') {
	$prev_attendance_sql = fetch_resource_db('daily_attendance_student',
		array('course_code',
		'branch_code',
		'shift',
		'ssection',
		'sgroup',
		'semester',
		'attendance_date',
		'attendance_period',
		'subject_code',
		'elective_details',
		'aicte_rc',
		'teacher_username',
		'full_part_time'),
		array($_POST['course_code'],
		$_POST['branch_code'],
		$_POST['shift'],
		$_POST['ssection'],
		$_POST['sgroup'],
		$_POST['semester'],
		$_POST['attendance_date'],
		$prev_period,
		$_POST['subject_code'],
		$_POST['elective_details'],
		$_POST['aicte_rc'],
		$_SESSION['username'],
		$_POST['full_part_time']),
		'resource','');
}
		
		

if($_POST['theory_practical']=='T') {
	$dup = fetch_resource_db('daily_attendance_student',
		array('course_code',
		'branch_code',
		'shift',
		'ssection',
		'semester',
		'attendance_date',
		'attendance_period',
		'subject_code',
		'elective_details',
		'aicte_rc',
		'teacher_username',
		'full_part_time'),
		array($_POST['course_code'],
		$_POST['branch_code'],
		$_POST['shift'],
		$_POST['ssection'],
		$_POST['semester'],
		$_POST['attendance_date'],
		$_POST['attendance_period'],
		$_POST['subject_code'],
		$_POST['elective_details'],
		$_POST['aicte_rc'],
		$_SESSION['username'],
		$_POST['full_part_time']),
		'resource','');
		
	if($_POST['elective_details']=='Compulsory') {
		
		$redundancy = fetch_resource_db('daily_attendance_student',
		array('course_code',
		'branch_code',
		'shift',
		'ssection',
		'semester',
		'attendance_date',
		'attendance_period',
		'aicte_rc',
		'full_part_time'),
		array($_POST['course_code'],
		$_POST['branch_code'],
		$_POST['shift'],
		$_POST['ssection'],
		$_POST['semester'],
		$_POST['attendance_date'],
		$_POST['attendance_period'],
		$_POST['aicte_rc'],
		$_POST['full_part_time']),
		'resource','');
	}
	
	else {
		
		$redundancy = fetch_resource_db('daily_attendance_student',
		array('course_code',
		'branch_code',
		'shift',
		'ssection',
		'semester',
		'subject_code',
		'attendance_date',
		'attendance_period',
		'aicte_rc',
		'full_part_time'),
		array($_POST['course_code'],
		$_POST['branch_code'],
		$_POST['shift'],
		$_POST['ssection'],
		$_POST['semester'],
		$_POST['elective_details'],
		$_POST['subject_code'],
		$_POST['attendance_date'],
		$_POST['attendance_period'],
		$_POST['aicte_rc'],
		$_POST['full_part_time']),
		'resource','');
	}
	
		
}


if($_POST['theory_practical']=='P') {
	$dup = fetch_resource_db('daily_attendance_student',
		array('course_code',
		'branch_code',
		'shift',
		'ssection',
		'sgroup',
		'semester',
		'attendance_date',
		'attendance_period',
		'subject_code',
		'elective_details',
		'aicte_rc',
		'teacher_username',
		'full_part_time'),
		array($_POST['course_code'],
		$_POST['branch_code'],
		$_POST['shift'],
		$_POST['ssection'],
		$_POST['sgroup'],
		$_POST['semester'],
		$_POST['attendance_date'],
		$_POST['attendance_period'],
		$_POST['subject_code'],
		$_POST['elective_details'],
		$_POST['aicte_rc'],
		$_SESSION['username'],
		$_POST['full_part_time']),
		'resource','');
	
	
		
	if($_POST['elective_details']=='Compulsory') {
		$redundancy = fetch_resource_db('daily_attendance_student',
		array('course_code',
		'branch_code',
		'shift',
		'ssection',
		'sgroup',
		'semester',
		'attendance_date',
		'attendance_period',
		'aicte_rc',
		'full_part_time'),
		array($_POST['course_code'],
		$_POST['branch_code'],
		$_POST['shift'],
		$_POST['ssection'],
		$_POST['sgroup'],
		$_POST['semester'],
		$_POST['attendance_date'],
		$_POST['attendance_period'],
		$_POST['aicte_rc'],
		$_POST['full_part_time']),
		'resource','');
		
	}
	
	else {
		
		$redundancy = fetch_resource_db('daily_attendance_student',
		array('course_code',
		'branch_code',
		'shift',
		'ssection',
		'sgroup',
		'semester',
		'elective_details',
		'subject_code',
		'attendance_date',
		'attendance_period',
		'aicte_rc',
		'full_part_time'),
		array($_POST['course_code'],
		$_POST['branch_code'],
		$_POST['shift'],
		$_POST['ssection'],
		$_POST['sgroup'],
		$_POST['semester'],
		$_POST['elective_details'],
		$_POST['subject_code'],
		$_POST['attendance_date'],
		$_POST['attendance_period'],
		$_POST['aicte_rc'],
		$_POST['full_part_time']),
		'resource','');
	}
	
}

if(mysql_num_rows($dup)!=0) {
	show_label('info','Attendance already marked. Check "Attendance Record" to update the attendance');
	exit();
}

if(mysql_num_rows($prev_attendance_sql)>0) {
	echo "<center><span style='color:red;font-size:14px;font-weight:bold'>You are currently viewing the attendance of previous period. You can edit before submission.</span></center></br>";
}

if(mysql_num_rows($redundancy)!=0) {
	
	$rd = mysql_fetch_assoc($redundancy);
	//echo $rd['teacher_username'];
	
	$tname_sql = mysql_query("SELECT name,department FROM users WHERE username='".$rd['teacher_username']."'") or die(mysql_error());
	$tname = mysql_fetch_assoc($tname_sql);
	show_label('info','Attendance already marked for same Period for this class by <i><u>'.$tname["name"].' ('.$tname["department"].')</u></i>. Please contanct Academic Incharge.');
	exit();
}
?>


<form action='' method='post'/>
<table class='table table-bordered table-condensed container striped sortable table-hover'>
	<tr>
		<th>Sr. No.</th>
		<th>University Roll No.</th>
		<th>College Roll No.</th>
		<th>Fee Paid</th>
		<th>Student Name</th>
		
		<th>Subject Code/M-Code</th>
		<th>Subject Title</th>
		<th>Semester</th>
		<th>Date/Period</th>
		<th>Present (P)</th>
		<th>Absent (A)</th>
		<!--<th>Remarks</th>-->
	</tr>
<?php

if($_POST['course_code']==1 && ($_POST['semester']==1 OR $_POST['semester']==2)) {
			
	$scheme_field = "scheme_code_first_year";
}
else {
	$scheme_field = "scheme_code_branch";
}


if($_POST['theory_practical']=='T') { 
	
	if($_POST['elective_details']=='Compulsory') {
		
	
		$roll_nos = mysql_query("SELECT * FROM student_info WHERE 
		
		course_code = '".$_POST['course_code']."' AND
		branch_code = '".$_POST['branch_code']."' AND
		shift = '".$_POST['shift']."' AND
		ssection = '".$_POST['ssection']."' AND
		semester = '".$_POST['semester']."' AND
		".$scheme_field." = '".$_POST['scheme_code']."' AND
		student_status = 'Onroll' AND
		aicte_rc = '".$_POST['aicte_rc']."' AND
		full_part_time = '".$_POST['full_part_time']."'") or die(mysql_error());
		
	}
	else {
		$roll_nos = mysql_query("SELECT * FROM student_info WHERE 
		
		course_code = '".$_POST['course_code']."' AND
		branch_code = '".$_POST['branch_code']."' AND
		shift = '".$_POST['shift']."' AND
		ssection = '".$_POST['ssection']."' AND
		semester = '".$_POST['semester']."' AND
		".$scheme_field." = '".$_POST['scheme_code']."' AND
		student_status = 'Onroll' AND
		aicte_rc = '".$_POST['aicte_rc']."' AND
		full_part_time = '".$_POST['full_part_time']."' AND
		
		student_info.university_roll_no IN 
		
		(SELECT university_roll_no FROM student_elective_subjects WHERE 
		
		course_code = '".$_POST['course_code']."' AND
		branch_code = '".$_POST['branch_code']."' AND
		semester = '".$_POST['semester']."' AND
		elective_details = '".$_POST['elective_details']."' AND
		subject_code='".$_POST['subject_code']."')
		") or die(mysql_error());
		
		
	}
	
}


if($_POST['theory_practical']=='P') {
	
	if($_POST['elective_details']=='Compulsory') {
		$roll_nos = mysql_query("SELECT * FROM student_info WHERE 
		
		course_code = '".$_POST['course_code']."' AND
		branch_code = '".$_POST['branch_code']."' AND
		shift = '".$_POST['shift']."' AND
		ssection = '".$_POST['ssection']."' AND
		sgroup = '".$_POST['sgroup']."' AND
		".$scheme_field." = '".$_POST['scheme_code']."' AND
		semester = '".$_POST['semester']."' AND
		student_status = 'Onroll' AND
		aicte_rc = '".$_POST['aicte_rc']."' AND
		full_part_time = '".$_POST['full_part_time']."'") or die(mysql_error());
	}
	else {
		$roll_nos = mysql_query("SELECT * FROM student_info WHERE 
		
		course_code = '".$_POST['course_code']."' AND
		branch_code = '".$_POST['branch_code']."' AND
		shift = '".$_POST['shift']."' AND
		ssection = '".$_POST['ssection']."' AND
		sgroup = '".$_POST['sgroup']."' AND
		semester = '".$_POST['semester']."' AND
		".$scheme_field." = '".$_POST['scheme_code']."' AND
		student_status = 'Onroll' AND
		aicte_rc = '".$_POST['aicte_rc']."' AND
		full_part_time = '".$_POST['full_part_time']."' AND
		
		student_info.university_roll_no IN 
		
		(SELECT university_roll_no FROM student_elective_subjects WHERE 
		
		course_code = '".$_POST['course_code']."' AND
		branch_code = '".$_POST['branch_code']."' AND
		semester = '".$_POST['semester']."' AND
		elective_details = '".$_POST['elective_details']."' AND
		subject_code='".$_POST['subject_code']."')
		
		") or die(mysql_error());
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
		
		echo "<tr class='warning'>
			<td>".$count."</td>
			<td>".$row['university_roll_no']."</td>
			<td>".$row['college_roll_no']."</td>
			<td>".$row['fee_paid_status']."</td>
			<input type='hidden' name='university_roll_no$count' value='".$row['university_roll_no']."' />
			<td>".strtoupper($row['ptu_student_name'])."</td>
			
			<td>".$_POST['subject_code']."/".$_POST['m_code']."</td>
			<td>".$_POST['subject_title']."(".$_POST['elective_details'].")</td>
			<td>".$_POST['semester']."</td>
			<td>".$_POST['attendance_date']." / ".$_POST['attendance_period']."</td>
			
			<!--
			<select name='attendance$count' id='attendance$count'>
			
			";
			if($_POST['default_attandance']=='Present') {
				
				echo "<option value='Present' selected='selected'>Present</option>
				<option value='Absent'>Absent</option>";
			}
			if($_POST['default_attandance']=='Absent') {
				
				echo "<option value='Absent' selected='selected'>Absent</option>
				<option value='Present'>Present</option>
				";
			}
			
			
			echo "
			</select></td>
			-->";
			
			if(mysql_num_rows($prev_attendance_sql)==0) {
			
				if($_POST['default_attandance']=='Present') {
					
					echo "<td><span style='color:green;font-weight:bold'>P</span> <input type='radio' value='Present' checked name='attendance$count' id='attendancep$count'></td>";
					echo "<td><span style='color:red;font-weight:bold'>A</span> <input type='radio' value='Absent' name='attendance$count' id='attendancea$count'></td>";
				}
				if($_POST['default_attandance']=='Absent') {
					
					echo "<td><span style='color:green;font-weight:bold'>P</span> <input type='radio' value='Present' name='attendance$count' id='attendancep$count'></td>";
					echo "<td><span style='color:red;font-weight:bold'>A</span> <input type='radio' value='Absent' checked name='attendance$count' id='attendancea$count'></td>";
				}
			}
			
			else {
				
					$prev_attendance = fetch_resource_db('daily_attendance_student',
					array('course_code',
					'branch_code',
					'university_roll_no',
					'shift',
					'ssection',
					'sgroup',
					'semester',
					'attendance_date',
					'attendance_period',
					'subject_code',
					'elective_details',
					'aicte_rc',
					'teacher_username',
					'full_part_time'),
					array($_POST['course_code'],
					$_POST['branch_code'],
					$row['university_roll_no'],
					$_POST['shift'],
					$_POST['ssection'],
					$_POST['sgroup'],
					$_POST['semester'],
					$_POST['attendance_date'],
					$prev_period,
					$_POST['subject_code'],
					$_POST['elective_details'],
					$_POST['aicte_rc'],
					$_SESSION['username'],
					$_POST['full_part_time']),
					'resource_array_value','attendance');
				
				if($prev_attendance=='Present') {
					
					echo "<td><span style='color:green;font-weight:bold'>P</span> <input type='radio' value='Present' checked name='attendance$count' id='attendancep$count'></td>";
					echo "<td><span style='color:red;font-weight:bold'>A</span> <input type='radio' value='Absent' name='attendance$count' id='attendancea$count'></td>";
				}
				if($prev_attendance=='Absent') {
					
					echo "<td><span style='color:green;font-weight:bold'>P</span> <input type='radio' value='Present' name='attendance$count' id='attendancep$count'></td>";
					echo "<td><span style='color:red;font-weight:bold'>A</span> <input type='radio' value='Absent' checked name='attendance$count' id='attendancea$count'></td>";
				}
			}
			
			echo "
			
			<!--<td><input class='input-small' size='16' type='text' name='topics_covered$count'></td>-->
			</tr>";
			$count++;
		
}
?>
</table>
<input type='hidden' name='teacher_mark_daily_attendance' value='<?php echo $count; ?>' />
<input type='hidden' name='total_count' value='<?php echo $count; ?>' />
<input type='hidden' name='theory_practical' value='<?php echo $_POST['theory_practical']; ?>' />
<input type='hidden' name='attendance_date' value='<?php echo $_POST['attendance_date']; ?>' />
<input type='hidden' name='attendance_period' id='attendance_period' value='<?php echo $_POST['attendance_period']; ?>' />
<input type='hidden' name='start_time' value='<?php echo $_POST['start_time']; ?>' />
<input type='hidden' name='end_time' value='<?php echo $_POST['end_time']; ?>' />
<input type='hidden' id='topics_covered' name='topics_covered' value='<?php echo $_POST['topics_covered']; ?>' />
<input type='hidden' name='overall_remarks' value='<?php echo $_POST['overall_remarks']; ?>' />
<input type='hidden' name='paper_id' value='<?php echo $_POST['paper_id']; ?>' />
<input type='hidden' id ='subject_title' name='subject_title' value='<?php echo $_POST['subject_title']; ?>' />
<input type='hidden' name='ssection' value='<?php echo $_POST['ssection']; ?>' />
<input type='hidden' name='sgroup' value='<?php echo $_POST['sgroup']; ?>' />
<input type='hidden' name='subject_code' value='<?php echo $_POST['subject_code']; ?>' />
<input type='hidden' name='branch_code' value='<?php echo $_POST['branch_code']; ?>' />
<input type='hidden' name='course_code' value='<?php echo $_POST['course_code']; ?>' />
<input type='hidden' name='semester' value='<?php echo $_POST['semester']; ?>' />
<input type='hidden' name='aicte_rc' value='<?php echo $_POST['aicte_rc']; ?>' />
<input type='hidden' name='exam_month' value='<?php echo $_POST['exam_month']; ?>' />
<input type='hidden' name='exam_year' value='<?php echo $_POST['exam_year']; ?>' />
<input type='hidden' name='full_part_time' value='<?php echo $_POST['full_part_time']; ?>' />
<input type='hidden' name='elective_details' value='<?php echo $_POST['elective_details']; ?>' />
<input type='hidden' name='shift' value='<?php echo $_POST['shift']; ?>' />
<input type='hidden' name='teacher_type' value='<?php echo $_POST['teacher_type']; ?>' />
<input type='hidden' name='m_code' value='<?php echo $_POST['m_code']; ?>' />
<input type='hidden' name='teacher_mark_attendance' value='' />
<input type='submit' class='btn btn-block btn-danger' value='Click Here To Mark Attendance' onclick="return attendance_details('<?php echo $count; ?>')"/>
</form>


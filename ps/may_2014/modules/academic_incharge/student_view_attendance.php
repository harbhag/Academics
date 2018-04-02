<?php

//show_label('info','This section is down for maintenance.');
//exit();
if(isset($_POST['view_student_attendance_show']))
{	
	$usertype=$_SESSION['usertype'];
	if ($usertype=='academic_incharge')
	{
		$branch_codes_sql = mysql_query("SELECT show_branch_code,show_course_code,show_semester FROM users WHERE username='".$_SESSION['username']."' AND usertype='academic_incharge'") or die(mysql_error());
		$branch_codes = mysql_fetch_assoc($branch_codes_sql);
		$student_info_sql = mysql_query("SELECT * FROM student_info WHERE 
		(university_roll_no='".$_POST['university_roll_no']."' or college_roll_no='".$_POST['university_roll_no']."') AND
		student_status='Onroll' AND branch_code IN (".$branch_codes['show_branch_code'].") ;") or die(mysql_error());
		#echo $student_info_sql;
	}
	else
	{
		$student_info_sql = mysql_query("SELECT * FROM student_info WHERE (university_roll_no='".$_POST['university_roll_no']."' or college_roll_no='".$_POST['university_roll_no']."') AND student_status='Onroll'") or die(mysql_error());
	}
	$student_info = mysql_fetch_assoc($student_info_sql);

	$att_data = mysql_query("SELECT DISTINCT subject_code,subject_title,theory_practical FROM daily_attendance_student WHERE 
	university_roll_no='".$student_info['university_roll_no']."' AND
	course_code ='".$student_info['course_code']."' AND
	branch_code ='".$student_info['branch_code']."' AND
	semester ='".$student_info['semester']."' 
	ORDER BY subject_code, theory_practical DESC") or die(mysql_error());

	$sql_branch = "SELECT * from branch_code where branch_code='".$student_info['branch_code']."';";
	$result_branch = mysql_query($sql_branch);
	$row_branch = mysql_fetch_array($result_branch);
	$branch_name=$row_branch['branch_name'];
			
	$sql_course = "SELECT * from course_code where course_code='".$student_info['course_code']."';";
	$result_course = mysql_query($sql_course);
	$row_course = mysql_fetch_array($result_course);
	$course_name=$row_course['course_name'];

if($student_info['fee_paid_status']=='Y') {
	$fee_paid_status = 'Received';
}
else {
	$fee_paid_status = 'Not Received';
}

	echo "<center><h4>Attendance Record (Till - ".date('d-m-Y, g:i a').")</h4></center>";

	echo "<table  class='table table-bordered striped table-condensed container' align='center' border='0'>
	
	<tr class='warning'><th align='left'> Name </th>
	<td>".$student_info['ptu_student_name']." </tr>
	
	<tr class='warning'><th align='left'>Father's Name </th>
	<td>".strtoupper($student_info['ptu_father_name'])." </tr>
	
	<tr class='warning'><th align='left'>Mother's Name </th>
	<td>".strtoupper($student_info['ptu_mother_name'])." </tr>
	
	<tr class='warning'><th align='left'>University Roll No. </th>
	<td>".$student_info['university_roll_no']."</td>
	
	<tr class='warning'><th align='left'>Course (Branch) / Semester / Shift</td>
	<td>".$course_name." (".$branch_name.") / ".$student_info['semester']." / ".$student_info['shift']."</td></tr>
	
	<tr class='warning'><th align='left'>Institute Fee Received Status</td>
	<td>".$fee_paid_status."</td></tr>
	";
	if ($info_result['course_code']!='2')
	{
	echo "<tr class='warning'><th align='left' >College Roll No. </th><td>".$student_info['college_roll_no']."</td> </tr>";
	}
	echo "</table>";

?>




<form action='' method='post'/>
<table class='table table-bordered table-condensed striped sortable table-hover container'>
	<tr class='warning'>
		<th>Sr. No.</th>
		<th>Subject Title</th>
		<th>Subject Code</th>
		<th>Theory(T)/Practical(P)</th>
		<th>Total Lectures Held</th>
		<th>Total Lectures Attended</th>
		<th>Attendance %</th>
	</tr>
<?php

$count = 1;

while($row = mysql_fetch_assoc($att_data)) {

		$attended_lectures_sql = mysql_query("SELECT count(autoid) AS attended_lectures FROM daily_attendance_student WHERE
		course_code='".$student_info['course_code']."' AND
		branch_code='".$student_info['branch_code']."' AND
		semester='".$student_info['semester']."' AND
		subject_code='".$row['subject_code']."' AND
		university_roll_no='".$student_info['university_roll_no']."' AND
		attendance='Present' AND
		backup='0'") or die(mysql_error());
		
		$total_lectures_sql = mysql_query("SELECT count(autoid) AS total_lectures FROM daily_attendance_student WHERE
		course_code='".$student_info['course_code']."' AND
		branch_code='".$student_info['branch_code']."' AND
		semester='".$student_info['semester']."' AND
		subject_code='".$row['subject_code']."' AND
		university_roll_no='".$student_info['university_roll_no']."' AND
		backup='0'") or die(mysql_error());
		
		
		$attended_lectures = mysql_fetch_assoc($attended_lectures_sql);
		$total_lectures = mysql_fetch_assoc($total_lectures_sql);
		
			
			echo "<tr class='warning'><td>".$count."</td>
						<td>".$row['subject_title']."</td>
						<td>".$row['subject_code']."</td>
						<td>".$row['theory_practical']."</td>
						<td>".$total_lectures['total_lectures']."</td>
			<td>".$attended_lectures['attended_lectures']."</td>
			<td>".attendance_percentage($total_lectures['total_lectures'],$attended_lectures['attended_lectures'])."</td>
			
			</tr>";
		
		$count++;
}
?>
</table>
</form>
<table class='table table-bordered striped table-condensed container'><tr><td>
<b>Note :</b><ul>
	<li>Attendance available on website is for information only.</li>
	<li>Attendance record is updated on daily basis by concerned faculty member.</li>
	<li>In case of discrepancy with regards to attendance in terms of total/attended   lectures, contact immediately the concerned faculty or Head of Department.</li>
	<li>In case of discrepancy (with regards to Roll No.(s), spelling mistakes in name (s)), contact immediately your department office.</li>
	<li>In case of discrepancy with regards to fee received status, contact immediately college cashier in accounts branch.</li>
</ul>
</td></tr></table>
<table class='table table-bordered striped table-condensed container'><tr class='warning'><td><b>Disclaimer :</b> Every effort has been made to verify the contents of this website. However Guru Nanak Dev Engineering College , Ludhiana is not liable for any action based on such information.</td></tr></table>

<?
}

if(isset($_POST['view_student_attendance']))
{
	#echo $_SESSION['coursetype'];
	#echo $_SESSION['fullname'];
	echo "<table class='table table-bordered striped table-condensed container'>
	<form method='post' action='' >
	<tr><td><b>University / College Roll No.</b></td>
	<td><input type='text' name='university_roll_no' class='required'/>
	<input type='hidden' name='view_student_attendance_show' value='view_student_attendance_show' />
	</tr></table>
	<center><button type='submit' name='submit' id='submit' class='btn btn-large btn-danger' >Submit</button></center>
    
</form>";
}
?>

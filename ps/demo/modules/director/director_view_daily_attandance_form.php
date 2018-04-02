<?php 

$date = mysql_query("SELECT DISTINCT attendance_date FROM daily_attendance_student ORDER BY attendance_date DESC");
$shift = mysql_query("SELECT DISTINCT shift FROM daily_attendance_student");
$aicte_rc = mysql_query("SELECT DISTINCT aicte_rc FROM daily_attendance_student");
$full_part_time = mysql_query("SELECT DISTINCT full_part_time FROM daily_attendance_student");
$usertype= $_SESSION['usertype'];
if ($usertype=='academic_incharge')
{
	$branch_codes_sql = mysql_query("SELECT show_branch_code,show_course_code,show_semester FROM users WHERE username='".$_SESSION['username']."' AND usertype='academic_incharge'") or die(mysql_error());
	$branch_codes = mysql_fetch_assoc($branch_codes_sql);
	if($branch_codes['show_branch_code']=='ALL' && $branch_codes['show_course_code']!='ALL') {
	$branch = mysql_query("SELECT distinct branch_code,course_code FROM daily_attendance_student WHERE 
	course_code IN (".$branch_codes['show_course_code'].")
	ORDER BY course_code ASC") or die(mysql_error());
	}
	elseif($branch_codes['show_branch_code']=='ALL' && $branch_codes['show_course_code']=='ALL') {
	$branch = mysql_query("SELECT distinct branch_code,course_code FROM daily_attendance_student ORDER BY course_code ASC") or die(mysql_error());
	}
	else {
	$branch = mysql_query("SELECT distinct branch_code,course_code FROM daily_attendance_student WHERE 
	branch_code IN (".$branch_codes['show_branch_code'].") ORDER BY course_code ASC") or die(mysql_error());
	}

	if($branch_codes['show_semester']=='ALL') {
	$semester = mysql_query("SELECT distinct semester FROM daily_attendance_student ORDER BY semester ASC") or die(mysql_error());
	}
	else 
	{
	$semester = mysql_query("SELECT distinct semester FROM daily_attendance_student WHERE
	semester IN (".$branch_codes['show_semester'].") ORDER BY semester ASC") or die(mysql_error());
	}
}
else
{
	$semester = mysql_query("SELECT DISTINCT semester FROM daily_attendance_student ORDER BY semester ASC");
	$branch = mysql_query("SELECT distinct branch_code,course_code FROM daily_attendance_student ORDER BY course_code,branch_code ASC") or die(mysql_error());
}

show_label('info','Daily Attendance Details');
echo "<br/><br/>";

echo "<center>

					<table>
					<form method='post' action=''>
					
					<!--
					<tr><td>
					<span style='font-weight:bold'>Date (Year-Month-Date)</span>
					</td><td>
          <select name='attendance_date' id='attendance_date' class='input-xlarge'>";
          while($row = mysql_fetch_assoc($date)) {
						if($row['attendance_date']=='' or is_null($row['attendance_date'])) {
							continue;
						}
						echo "<option value='".$row['attendance_date']."'>".$row['attendance_date']."</option>";
					}
					echo "
					</select>
					</tr></td>
					-->
					
					
					
					<tr><td>
					<span style='font-weight:bold'>Date</span>
					</td><td>
          <div class='input-append date' id=dp'".rand()." data-date=".date('Y-m-d')." data-date-format='yyyy-mm-dd'>
				<input class='span2' size='16' type='text' name='attendance_date' value=".date('Y-m-d')." readonly>
				<span class='add-on'><i class='icon-calendar'></i>
			  </div>
					</tr></td>
					
					
					
					<tr><td>
					<span style='font-weight:bold'>Program</span>
					</td><td>
			<select name='course_branch' id='course_branch' class='input-xlarge'>";
			while($row = mysql_fetch_assoc($branch)) {
						if($row['branch_code']=='' or is_null($row['branch_code'])) {
							continue;
						}
						$course_name = fetch_resource_db('course_code',array('course_code'),array($row['course_code']),'resource_array_value','course_name');
						$branch_name = fetch_resource_db('branch_code',array('branch_code'),array($row['branch_code']),'resource_array_value','branch_name');
						echo "<option value='".$row['course_code'].",".$row['branch_code']."'>".$course_name."(".$branch_name.")</option>";
					}
					echo "
					</select>
					</tr></td>
					
					
					<tr><td>
					<span style='font-weight:bold'>Semester</span>
					</td><td>
          <select name='semester' id='semester' class='input-xlarge'>";
          while($row = mysql_fetch_assoc($semester)) {
						if($row['semester']=='' or is_null($row['semester'])) {
							continue;
						}
						echo "<option value='".$row['semester']."'>".$row['semester']."</option>";
					}
					echo "
					</select>
					</tr></td>
					
					
					
					<tr><td>
					<span style='font-weight:bold'>Shift</span>
					</td><td>
          <select name='shift' id='shift' class='input-xlarge'>";
          while($row = mysql_fetch_assoc($shift)) {
						if($row['shift']=='' or is_null($row['shift'])) {
							continue;
						}
						echo "<option value='".$row['shift']."'>".$row['shift']."</option>";
					}
					echo "
					</select>
					</tr></td>
					
					
					
					<tr><td>
					<span style='font-weight:bold'>AICTE/RC</span>
					</td><td>
          <select name='aicte_rc' id='aicte_rc' class='input-xlarge'>";
          while($row = mysql_fetch_assoc($aicte_rc)) {
						if($row['aicte_rc']=='' or is_null($row['aicte_rc'])) {
							continue;
						}
						echo "<option value='".$row['aicte_rc']."'>".$row['aicte_rc']."</option>";
					}
					echo "
					</select>
					</tr></td>
					
					
					
					
					<tr><td>
					<span style='font-weight:bold'>Full Time / Part Time</span>
					</td><td>
					<select name='full_part_time' id='full_part_time' class='input-xlarge'>";
					while($row = mysql_fetch_assoc($full_part_time)) {
						if($row['full_part_time']=='' or is_null($row['full_part_time'])) {
							continue;
						}
						echo "<option value='".$row['full_part_time']."'>".$row['full_part_time']."</option>";
					}
					echo "
					</select>
					</tr></td>
					
					
					<tr><td>
					<span style='font-weight:bold'>Theory/Practical</span>
					</td><td>
					<select name='theory_practical' id='theory_practical' class='input-xlarge'>
					<option value='T'>Theory</option>
					<option value='P'>Practical</option>
					</select>
					</tr></td>
					
					
					
					
					<tr><td>
					<input type='hidden' name='director_view_daily_attandance' value='director_view_daily_attandance' />
					<button type='submit' name='submit' class='btn btn-large btn-danger'>Proceed</button>
					</tr></td>
         
				</form>
				</table>
		</center>";
  
?>

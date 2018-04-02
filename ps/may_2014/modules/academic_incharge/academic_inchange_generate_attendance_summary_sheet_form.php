<?php
//require_once('config/config.php');
//require_once('config/includes.php');
echo "<center><span style='color:red;font-size:14px;font-weight:bold'>Before taking printout, kindly check the 'pdf' file carefully.</span></center></br>";

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
	branch_code IN (".$branch_codes['show_branch_code'].")
	ORDER BY course_code ASC") or die(mysql_error());
}

if($branch_codes['show_semester']=='ALL') {
	$semester = mysql_query("SELECT distinct semester FROM daily_attendance_student ORDER BY semester ASC") or die(mysql_error());
}

else {
	$semester = mysql_query("SELECT distinct semester FROM daily_attendance_student WHERE
	semester IN (".$branch_codes['show_semester'].") ORDER BY semester ASC") or die(mysql_error());
}

$group = mysql_query("SELECT distinct sgroup FROM daily_attendance_student ORDER BY sgroup ASC") or die(mysql_error());

$section = mysql_query("SELECT distinct ssection FROM daily_attendance_student ORDER BY ssection ASC") or die(mysql_error());

$start_date = mysql_query("SELECT distinct MIN(attendance_date) AS start_date FROM daily_attendance_student ORDER BY start_date ASC") or die(mysql_error());

$end_date = mysql_query("SELECT DISTINCT MAX(attendance_date) AS end_date FROM daily_attendance_student ORDER BY end_date ASC") or die(mysql_error());

echo "<script type='text/javascript' src='js/harbhag.js'></script>";
echo "<center>
					<table>
					<form method='post' action='' target='_blank'>
          <input type='hidden' name='academic_inchange_generate_attendance_summary_sheet' value='academic_inchange_generate_attendance_summary_sheet_form' />
          
          <tr><td>
          <span style='font-weight:bold'>Regular/Reappear</span>
          </td><td>
          <select name='regular_reappear' class='input-xlarge'>
					<option value='Regular'>Regular</option>
					</select>
					</tr></td>

					
					<tr><td>
					<span style='font-weight:bold'>Course(Branch)</span>
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
					<span style='font-weight:bold'>T/P</span>
					</td><td>
          <select name='theory_practical' id='theory_practical' class='input-xlarge' onchange='disable_group(this.value)'>
          <option value='P' selected='selected'>Practical</option>
          <option value='T'>Theory</option>
					</select>
					</tr></td>
					
					<tr><td>
					<span style='font-weight:bold'>Shift</span>
					</td><td>
          <select name='shift' id='shift' class='input-xlarge'>
          <option value='First'>First</option>
          <option value='Second'>Second</option>
					</select>
					</tr></td>
					
					<tr><td>
					<span style='font-weight:bold'>AICTE/RC</span>
					</td><td>
          <select name='aicte_rc' id='aicte_rc' class='input-xlarge'>
          <option value='AICTE'>AICTE</option>
          <option value='RC'>RC</option>
					</select>
					</tr></td>
					
					<tr><td>
					<span style='font-weight:bold'>Full/Part Time</span>
					</td><td>
          <select name='full_part_time' id='full_part_time' class='input-xlarge'>
          <option value='Full Time'>Full Time</option>
          <option value='Pat Time'>Part Time</option>
					</select>
					</tr></td>


					<tr><td>
					<span style='font-weight:bold'>Section</span>
					</td><td>
          <select name='ssection' id='ssection' class='input-xlarge'>";
           while($row = mysql_fetch_assoc($section)) {
						
						echo "<option value='".$row['ssection']."'>".$row['ssection']."</option>";
					}
					echo "
					</select>
					</tr></td>
					

					<tr><td>
					<span style='font-weight:bold'>Group</span>
					</td><td>
          <select name='sgroup' id='sgroup' class='input-xlarge'>";
           while($row = mysql_fetch_assoc($group)) {
						
						echo "<option value='".$row['sgroup']."'>".$row['sgroup']."</option>";
					}
					echo "
					</select>
					</tr></td>

					
					<tr><td>
					<span style='font-weight:bold'>Semester</span>
					</td><td>
          <select name='semester' id='semester' class='input-xlarge'>";
           while($row = mysql_fetch_assoc($semester)) {
						
						echo "<option value='".$row['semester']."'>".$row['semester']."</option>";
					}
					echo "
					</select>
					</tr></td>
					
					<!--
					<tr><td>
					<span style='font-weight:bold'>From Date</span>
					</td><td>
          <select name='start_date' id='start_date' class='input-xlarge'>";
           while($row = mysql_fetch_assoc($start_date)) {
						
						echo "<option value='".$row['start_date']."'>".$row['start_date']."</option>";
					}
					echo "
					</select>
					</tr></td>
					-->
					<input type='hidden' name='start_date' value='".$row['start_date']."' />
					
					
					<tr><td>
					<span style='font-weight:bold'>Upto Date</span>
					</td><td>
          <select name='end_date' id='end_date' class='input-xlarge'>";
           while($row = mysql_fetch_assoc($end_date)) {
						
						echo "<option value='2014-04-17'>2014-04-17</option>";
					}
					echo "
					</select>
					</tr></td>
					
					<tr><td>
					<span style='font-weight:bold'>No. of Records per page</span>
					</td><td>
          <input name='records_per_page' id='records_per_page' type='text' value='15' class='input-small'>
					</tr></td>
					
					<tr><td>
					
					<button type='submit' name='submit' class='btn btn-large btn-danger'>Proceed</button>
					</tr></td>
         
				</form>
				</table>
		</center>";
?>

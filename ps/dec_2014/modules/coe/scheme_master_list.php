<?php
$aicte_rc = mysql_query("SELECT DISTINCT aicte_rc FROM student_info");
$full_part_time = mysql_query("SELECT DISTINCT full_part_time FROM student_info");
$scheme_code = mysql_query("SELECT DISTINCT scheme_code FROM scheme_master");

if(isset($_POST['scheme_master_list']))
{
	$branch_codes_sql = mysql_query("SELECT show_branch_code,show_course_code,show_semester FROM users WHERE username='".$_SESSION['username']."' ") or die(mysql_error());
	$branch_codes = mysql_fetch_assoc($branch_codes_sql);
	if($branch_codes['show_branch_code']=='ALL' && $branch_codes['show_course_code']!='ALL') {
	$branch = mysql_query("SELECT distinct branch_code,course_code FROM student_info WHERE 
	course_code IN (".$branch_codes['show_course_code'].")
	ORDER BY course_code ASC") or die(mysql_error());
	}
	elseif($branch_codes['show_branch_code']=='ALL' && $branch_codes['show_course_code']=='ALL') {
	$branch = mysql_query("SELECT distinct branch_code,course_code FROM student_info ORDER BY course_code ASC") or die(mysql_error());
	}
	else {
	$branch = mysql_query("SELECT distinct branch_code,course_code FROM student_info WHERE 
	branch_code IN (".$branch_codes['show_branch_code'].") ORDER BY course_code ASC") or die(mysql_error());
	}

	if($branch_codes['show_semester']=='ALL') {
	$semester = mysql_query("SELECT distinct semester FROM scheme_master ORDER BY semester ASC") or die(mysql_error());
	}
	else 
	{
	$semester = mysql_query("SELECT distinct semester FROM scheme_master WHERE
	semester IN (".$branch_codes['show_semester'].") ORDER BY semester ASC") or die(mysql_error());
	}
	
show_label('info','Select Scheme Master List');
echo "<br/><br/>

<center><table>
					<form method='post' action=''>
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
					</td></tr>
					
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
					<tr><td>
					<span style='font-weight:bold'>Scheme Code</span>
					</td><td>
					<select name='scheme_code' id='scheme_code' class='input-xlarge'>";
					while($row = mysql_fetch_assoc($scheme_code)) {
						if($row['scheme_code']=='' or is_null($row['scheme_code'])) {
							continue;
						}
						echo "<option value='".$row['scheme_code']."'>".$row['scheme_code']."</option>";
					}
					echo "
					</select>
					</tr></td>
					<tr><td>
					<input type='hidden' name='scheme_master_list_show' value='scheme_master_list_show' />
					<button type='submit' name='submit' class='btn btn-large btn-danger'>Proceed</button>
					</tr></td>
					</form>
				</table>
		</center>";
}

if(isset($_POST['scheme_master_list_show'])) 
{
	$course_branch = explode(',',$_POST['course_branch']);
	show_label('info','List of Subjects');
	$sm_list = mysql_query("SELECT * FROM scheme_master where full_part_time='".$_POST['full_part_time']."' and aicte_rc='".$_POST['aicte_rc']."' and  semester='".$_POST['semester']."' and course_code='".$course_branch[0]."' and branch_code='".$course_branch[1]."'  and scheme_code='".$_POST['scheme_code']."'; ");
	
	echo "<table  class='table table-bordered striped table-condensed container sortable' >
	<tr style='background-color:lightgrey'><th>Sr No.</th><th>Course Code</th><th>Branch Code</th><th>Subject Title</th><th>Subject Code</th><th>Paper ID </th><th>M Code</th><th>Sem.</th><th>T/P</th><th>Elective Type</th><th>Int. Marks</th><th>Ext. Marks</th><th>Scheme Code</th><th>Full /Part Time </th><th>AICTE / RC</th><th>Subject Group</th><th> Six Month Trg.</th><th>LEET Subject (Disabled) </th></tr>";

	$x=1;
	while($row_sm = mysql_fetch_assoc($sm_list))
	{	
	echo "<tr><td>$x</td><td>".$row_sm['course_code']."</td><td>".$row_sm['branch_code']."</td><td>".$row_sm['subject_title']."</td><td>".$row_sm['subject_code']."</td><td>".$row_sm['paper_id']."</td><td>".$row_sm['m_code']."</td><td>".$row_sm['semester']."</td><td>".$row_sm['theory_practical']."</td><td>".$row_sm['elective_details']."</td><td>".$row_sm['internal_max_marks']."</td><td>".$row_sm['external_max_marks']."</td><td>".$row_sm['scheme_code']."</td><td>".$row_sm['full_part_time']."</td><td>".$row_sm['aicte_rc']."</td><td>".$row_sm['subject_group']."</td><td>".$row_sm['six_month_training']."</td><td>".$row_sm['leet_subject_status_disable']."</td></tr>";
	$x++;
	}
	
}

?>

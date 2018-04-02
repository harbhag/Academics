<?
if(isset($_POST['unlock_sessional_marks_submit']))
{
	$n=$_POST['num'];
	#echo "N=".$n;
	$x=1;
	for($i=1;$i<=$n;$i++)
	{
		if(isset($_POST['sessional_lock'.$x]))
		{
			$sql= "update sessionals_locks set sessional_lock_status='".$_POST['sessional_lock'.$x]."',unlock_updated_on='".date('Y-m-d H:i:s')."',unlock_updated_by='".$_SESSION['username']."' where autoid='".$_POST['autoid'.$x]."' ;";
			#echo $sql."<br>";
			mysql_query($sql) or die(mysql_error());
		}
		$x++;
	}
	show_label('success','Record Successfully Un-Locked');
}


if(isset($_POST['unlock_sessional_marks_show']))
{
show_label('info','Unlock Sessional Marks');
echo "<br/>";
	$course_branch = explode(',',$_POST['course_branch']);
	$sql_sessional_list = "SELECT * from sessionals_locks where  course_code='".$course_branch[0]."' AND
	branch_code='".$course_branch[1]."' AND semester='".$_POST['semester']."' and shift='".$_POST['shift']."' and full_part_time='".$_POST['full_part_time']."' and  aicte_rc='".$_POST['aicte_rc']."' AND sessional_no='".$_POST['sessional_no']."'  AND sessional_lock_status='1'	;";
	$result_sessional_list = mysql_query($sql_sessional_list);
	echo "<table class='table table-bordered table-condensed container sortable'>
	<tr><th>Branch</th><th>Shift /<br>FT or PT /<br>AICTE or RC</th><th>Subject Title</th><th>Subject  Code</th><th>Semester</th><th>Section</th><th> Sessional No.</th><th>Teacher Username</th><th>Sessional Un-Lock</th></tr>";
	echo "<form id='profile' name='profile' action=''  method='post'>";
	$x=1;
	$num=mysql_num_rows($result_sessional_list);
	while ($row_list = mysql_fetch_array($result_sessional_list))
	{	
		$sql_branch = "SELECT * from branch_code where branch_code='".$row_list['branch_code']."';";
		$result_branch = mysql_query($sql_branch);
		$row_branch = mysql_fetch_array($result_branch);
		$branch_name=$row_branch['branch_name'];
		echo "<tr><td>".$branch_name."</td><td>".$row_list['shift']." / ".$row_list['full_part_time']." / ".$row_list['aicte_rc']."</td><td>".$row_list['subject_title']."</td><td>".$row_list['subject_code']."</td><td>".$row_list['semester']."</td><td>".$row_list['ssection']."</td><td>".$row_list['sessional_no']."</td><td>".$row_list['teacher_username']."</td><td><font color='red'>";
		
		echo "<input type='checkbox' name='sessional_lock$x' value='0'><br>Un-Lock<br></font></td></tr>";
		echo "<input type='hidden' name='autoid$x' value='".$row_list['autoid']."'>";
	$x++;
	}
	echo "<input type='hidden' name='num' value='$num'>";
	echo "<tr><td colspan='10' align='center'>
		<input type='hidden' name='unlock_sessional_marks_submit' value='unlock_sessional_marks_submit' /> 
		<input type='submit' name='submit' class='btn btn-block btn-danger' value='Click Here to Unlock'></form></td></tr></table>";
}



if(isset($_POST['unlock_sessional_marks']))
{
$shift = mysql_query("SELECT DISTINCT shift FROM sessionals_locks");
$aicte_rc = mysql_query("SELECT DISTINCT aicte_rc FROM sessionals_locks");
$full_part_time = mysql_query("SELECT DISTINCT full_part_time FROM sessionals_locks");

	$branch_codes_sql = mysql_query("SELECT show_branch_code,show_course_code,show_semester FROM users WHERE username='".$_SESSION['username']."' AND usertype='academic_incharge'") or die(mysql_error());
	$branch_codes = mysql_fetch_assoc($branch_codes_sql);
	if($branch_codes['show_branch_code']=='ALL' && $branch_codes['show_course_code']!='ALL') {
	$branch = mysql_query("SELECT distinct branch_code,course_code FROM sessionals_locks WHERE 
	course_code IN (".$branch_codes['show_course_code'].")
	ORDER BY course_code ASC") or die(mysql_error());
	}
	elseif($branch_codes['show_branch_code']=='ALL' && $branch_codes['show_course_code']=='ALL') {
	$branch = mysql_query("SELECT distinct branch_code,course_code FROM sessionals_locks ORDER BY course_code ASC") or die(mysql_error());
	}
	else {
	$branch = mysql_query("SELECT distinct branch_code,course_code FROM sessionals_locks WHERE 
	branch_code IN (".$branch_codes['show_branch_code'].") ORDER BY course_code ASC") or die(mysql_error());
	}

	if($branch_codes['show_semester']=='ALL') {
	$semester = mysql_query("SELECT distinct semester FROM sessionals_locks ORDER BY semester ASC") or die(mysql_error());
	}
	else 
	{
	$semester = mysql_query("SELECT distinct semester FROM sessionals_locks WHERE
	semester IN (".$branch_codes['show_semester'].") ORDER BY semester ASC") or die(mysql_error());
	}


show_label('info','Unlock Sessional Marks');
echo "<br/><br/>";
echo "<center>
					<table>
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
					<span style='font-weight:bold'>Sessional No.</span>
					</td><td>
					<select name='sessional_no' id='sessional_no' class='input-xlarge'>
					<option value='1'>1</option>
					<option value='2'>2</option>
					<option value='3'>3</option>
					</select>
					</tr></td>
					<tr><td>
					<input type='hidden' name='unlock_sessional_marks_show' value='unlock_sessional_marks_show' />
					<button type='submit' name='submit' class='btn btn-large btn-danger'>Proceed</button>
					</tr></td>
         
				</form>
				</table>
		</center>";
}


?>

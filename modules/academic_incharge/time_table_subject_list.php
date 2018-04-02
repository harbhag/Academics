<?
if (isset($_POST['time_table_subject_delete']))
{
	$n=$_POST['num'];$x=1;
		for($i=1;$i<=$n;$i++)
		{
			if($_POST['delete_subject'.$x]=='1')
			{
				$sql_time_table = "SELECT * from time_table where `scheme_master_id`='".$_POST['scheme_master_id'.$x]."' and autoid='".$_POST['time_table_id'.$x]."'; ";
				$result_sql_time_table = mysql_query($sql_time_table);
				$row_time_table = mysql_fetch_array($result_sql_time_table);
				
				$sql_time_table_insert= "INSERT INTO `time_table_log`(`autoid`, `scheme_master_id`, `course_code`, `branch_code`, `paper_id`, `m_code`, `subject_code`, `subject_title`, `short_subject_title`, `theory_practical`, `elective_details`, `contact_hours`, `semester`, `full_part_time`, `sessional_max_marks`, `ssection`, `sgroup`, `teacher_username`, `short_name`, `aicte_rc`, `regular_reappear`, `shift`, `BR_TITLE`, `exam_month`, `exam_year`, `internal_lock_status`, `status`, `status_daily_attendance`, `status_aggregate_attendance`, `status_sessionals`, `status_assignments`, `grace_period_allowed`, `scheme_code`, `allotment_timestamp`, `alloted_username`, `teacher_type`, `delete_timestamp`, `delete_username`)
				 VALUES ('".$row_time_table['autoid']."','".$row_time_table['scheme_master_id']."','".$row_time_table['course_code']."','".$row_time_table['branch_code']."','".$row_time_table['paper_id']."','".$row_time_table['m_code']."','".$row_time_table['subject_code']."','".$row_time_table['subject_title']."','".$row_time_table['short_subject_title']."','".$row_time_table['theory_practical']."','".$row_time_table['elective_details']."','".$row_time_table['contact_hours']."','".$row_time_table['semester']."','".$row_time_table['full_part_time']."','".$row_time_table['sessional_max_marks']."','".$row_time_table['ssection']."','".$row_time_table['sgroup']."','".$row_time_table['teacher_username']."','".$row_time_table['short_name']."','".$row_time_table['aicte_rc']."','".$row_time_table['regular_reappear']."','".$row_time_table['shift']."','".$row_time_table['BR_TITLE']."','".$row_time_table['exam_month']."','".$row_time_table['exam_year']."','".$row_time_table['internal_lock_status']."','".$row_time_table['status']."','".$row_time_table['status_daily_attendance']."','".$row_time_table['status_aggregate_attendance']."','".$row_time_table['status_sessionals']."','".$row_time_table['status_assignments']."','".$row_time_table['grace_period_allowed']."','".$row_time_table['scheme_code']."','".$row_time_table['allotment_timestamp']."','".$row_time_table['alloted_username']."','".$row_time_table['teacher_type']."','".date('Y-m-d H:i:s')."','".$_SESSION['username']."'); ";
			
				 mysql_query($sql_time_table_insert) or die(mysql_error());
				
				$sql_time_table_delete= "delete from time_table where `scheme_master_id`='".$_POST['scheme_master_id'.$x]."' and autoid='".$_POST['time_table_id'.$x]."'; ";
			#echo $sql_time_table_delete;
			mysql_query($sql_time_table_delete) or die(mysql_error());
			}
			
		$x++;
		}
		show_label("success","Subject Allotement Successfully Deleted");
}


else if (isset($_POST['time_table_subject_list_show']))
{
	$sql_subject = "SELECT * from time_table where  branch_code='".$_POST['Branch_Name']."' and semester='".$_POST['Semester']."'  and full_part_time='".$_POST['Full_/_Part_Time']."' and  aicte_rc='".$_POST['AICTE_/_RC']."' and theory_practical='".$_POST['theory_practical']."';";
	$result_subject = mysql_query($sql_subject);
	echo "<table class='table table-bordered striped table-condensed'><tr><th>Branch</th><th>FT or PT /<br>AICTE or RC</th><th>Subject Title</th><th>Subject Code/ M Code</th><th>Semester</th><th>T/P</th><th>Section </th>";
	if ($_POST['theory_practical']!='T')
	{
		echo "<th>Group</th>";
	}
	echo "<th>Shift</th><th>Teacher Type (Subject / Adjustment Teacher)</th><th>Contact hours per week</th><th>Student Count <br>(Only for Compulsory Subject)</th> <th> Faculty</th><th> Delete Subject </th></tr>";
	echo "  <form id='profile' name='profile' action=''  method='post'>";
	$x=1;
	$num=mysql_num_rows($result_subject);
	while ($row_subject = mysql_fetch_array($result_subject))
	{
		$sql_branch = "SELECT * from branch_code where branch_code='".$row_subject['branch_code']."';";
		$result_branch = mysql_query($sql_branch);
		$row_branch = mysql_fetch_array($result_branch);
		$branch_name=$row_branch['branch_name'];
		echo "<tr class='warning'><td>".$branch_name."</td><td>".$_POST['Full_/_Part_Time']." /<br>".$_POST['AICTE_/_RC']." </td><td>".$row_subject['subject_title']." (".$row_subject['elective_details'].")</td><td>".$row_subject['subject_code']."/ ".$row_subject['m_code']."</td>
		<td>".$row_subject['semester']."</td><td>".$row_subject['theory_practical']."</td>";
		echo "<input type='hidden' name='time_table_id$x' value=".$row_subject['autoid'].">";
		echo "<input type='hidden' name='scheme_master_id$x' value=".$row_subject['scheme_master_id'].">";
		echo "<td>".$row_subject['ssection']."</td>";
		if ($_POST['theory_practical']!='T')
		{
			echo "<td>".$row_subject['sgroup']."</td>";
		}
		if ($_POST['theory_practical']!='T')
		{
			$sql_student_info = "SELECT * from student_info where branch_code='".$row_subject['branch_code']."' and semester='".$_POST['Semester']."' and ssection='".$row_subject['ssection']."' and sgroup='".$row_subject['sgroup']."' and full_part_time='".$row_subject['full_part_time']."' and aicte_rc='".$row_subject['aicte_rc']."' ;";
		
		}
		else 
		{
			$sql_student_info = "SELECT * from student_info where branch_code='".$row_subject['branch_code']."' and semester='".$_POST['Semester']."' and ssection='".$row_subject['ssection']."' and full_part_time='".$row_subject['full_part_time']."' and aicte_rc='".$row_subject['aicte_rc']."';";
		
		}
		echo "<td>".$row_subject['shift']."</td>";
		echo "<td>".$row_subject['teacher_type']."</td>";
		echo "<td>".$row_subject['contact_hours']."</td>";
		$result_student_info = mysql_query($sql_student_info);
		
		$student_info_count=mysql_num_rows($result_student_info);
		echo "<td>".$student_info_count."</td><td>".$row_subject['teacher_username']."</td>
		<td><input type='checkbox' name='delete_subject$x' value='1'> Delete </td></tr>";
	$x++;
	}
	echo "<input type='hidden' name='time_table_subject_delete' value='time_table_subject_delete'>";
	echo "<input type='hidden' name='num' value='$num'>";
	echo "<tr><td colspan='14' align='center'>
		<input type='submit' name='submit' class='btn btn-block btn-danger' value='Click Here to Delete  Subject(s) Allotment'></form></td></tr></table>";
}
else
{
	show_label("info","List of Time Table Subject Alloted");
	$user=$_SESSION['username'];
	$coursetype=$_SESSION['coursetype'];
	$sql_user = "SELECT * from users where username ='$user';";
	$result_user = mysql_query($sql_user);
	$row_user = mysql_fetch_array($result_user);
	$users_id=$row_user['users_id'];
	echo "  <form id='profile' name='profile' action=''  method='post'><br>";
	echo " <table align='center'><tr><td> Select Branch </td><td>";
		
	if ($coursetype=='chemistry' || $coursetype=='physics')
	{
		echo "<select name='Branch_Name' class='required'>";
		#$sql_branch = "SELECT distinct branch_name,branch_code from branch_code where course_code='1' ;";
	if ($coursetype=='chemistry')
		{
			$sql_branch = "SELECT distinct branch_name,branch_code from branch_code where course_code='1' and branch_code in (14,30,31) ;";
		}
			else if ($coursetype=='physics')
		{
			$sql_branch = "SELECT distinct branch_name,branch_code from branch_code where course_code='1' and branch_code in (15,16,17,21) ;";
		}
		$result_branch = mysql_query($sql_branch);
		while ($row_branch = mysql_fetch_array($result_branch))
		{		
		$branch_code=$row_branch['branch_code'];
		$branch_name=$row_branch['branch_name'];
		echo "<option value='$branch_code'>$branch_name</option>";
		}
		echo "</select></td><tr>
		<tr><td>Semester <td><select name='Semester' >
		<option value='1'>1</option>
		<option value='2'>2</option>
		</select></td>";
	}
	else
	{
		$sql_branch = "SELECT * from branch_code where users_id ='$users_id' order by branch_code DESC;";
		$result_branch = mysql_query($sql_branch);
		echo "<select name='Branch_Name' class='required'>";
		while ($row_branch = mysql_fetch_array($result_branch))
		{		
		$branch_code=$row_branch['branch_code'];
		$course_code=$row_branch['course_code'];
		$branch_name=$row_branch['branch_name'];
		echo "<option value='$branch_code'>$branch_name</option>";
		}	
		echo "</select></td><tr>";
		if ($course_code=='1')
		{
			$sql_semester = "SELECT distinct semester from student_info  where branch_code='".$branch_code."' and student_status='Onroll' AND semester !=1 AND semester !=2 order by semester ASC;";
			
		}
		else
		{
			$sql_semester = "SELECT distinct semester from student_info  where branch_code='".$branch_code."' and student_status='Onroll' order by semester ASC;";
			
		}
		$result_semester= mysql_query($sql_semester);
		#echo $sql_semester;
		echo "<tr><td>Semester <td><select name='Semester' >";
		while ($row_semester = mysql_fetch_array($result_semester))
		{		
		$semester=$row_semester['semester'];
		echo "<option value='$semester'>$semester</option>";
		}
	}
	echo "<tr>";
	form_dropdown_field('dropdown','','Full_/_Part_Time','scheme_master','full_part_time','required');
	echo "<tr>";
	form_dropdown_field('dropdown','','AICTE_/_RC','scheme_master','aicte_rc','required');
	echo "<tr>
	<td>Theory / Practical <td><select name='theory_practical' >
	<option value='T'>Lecture</option>
	<option value='P'>Practical</option>
	<option value='TU'>Tutorial</option>
	</select></td>
	</tr><tr><td>
	<input type='hidden' name='time_table_subject_list_show' value='time_table_subject_list_show' /> 
	<input type='submit' name='submit' class='btn btn-danger' value='Submit'></form></td></tr></table>";
}
?>

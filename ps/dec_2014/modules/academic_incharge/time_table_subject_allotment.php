<?
if (isset($_POST['time_table_subject_add']))
{
	$n=$_POST['num'];$x=1;
		for($i=1;$i<=$n;$i++)
		{
			#echo $_POST['add_subject'.$x];
			if($_POST['add_subject'.$x]=='1')
			{
				$sql_scheme_master= "select * from scheme_master where `scheme_master_id`='".$_POST['scheme_master_id'.$x]."'; ";
				$result_scheme_master = mysql_query($sql_scheme_master);
				$row_scheme_master = mysql_fetch_array($result_scheme_master);
				#echo $sql_scheme_master;
				if ($row_scheme_master['course_code']=='2')
				{$sessional_max_marks='30';}
				else
				{$sessional_max_marks='24';}
				$sql_time_table="INSERT INTO `time_table`(`scheme_master_id`, `course_code`, `branch_code`, `paper_id`, `m_code`, `subject_code`, `subject_title`, `theory_practical`, `elective_details`, `semester`, `full_part_time`, `sessional_max_marks`, `ssection`, `sgroup`, `teacher_username`, `aicte_rc`, `regular_reappear`, `shift`, scheme_code, allotment_timestamp,alloted_username,contact_hours,teacher_type) VALUES ('".$row_scheme_master['scheme_master_id']."', '".$row_scheme_master['course_code']."', '".$row_scheme_master['branch_code']."', '".$row_scheme_master['paper_id']."', '".$row_scheme_master['m_code']."', '".$row_scheme_master['subject_code']."', '".$row_scheme_master['subject_title']."', '".$row_scheme_master['theory_practical']."', '".$row_scheme_master['elective_details']."', '".$row_scheme_master['semester']."', '".$row_scheme_master['full_part_time']."', '".$sessional_max_marks."', '".$_POST['ssection'.$x]."', '".$_POST['sgroup'.$x]."', '".$_POST['teacher_username'.$x]."', '".$row_scheme_master['aicte_rc']."', 'Regular', '".$_POST['shift'.$x]."', '".$_POST['scheme_code'.$x]."','".date('Y-m-d H:i:s')."','".$_SESSION['username']."','".$_POST['contact_hours'.$x]."','".$_POST['teacher_type'.$x]."') ;";
			#echo $sql_time_table;
			mysql_query($sql_time_table) or die(mysql_error());
			}
		$x++;
		}
		show_label("success","Subject Successfully Alloted");
}

else if (isset($_POST['time_table_subject_allotment_show']))
{
	
	echo "<center><span style='color:red;font-size:14px;font-weight:bold'> Theory subject attendance should be marked 'groupwise' (same as Practical Subjects), so you must allot theory subjects for all the groups. </span></center> <br />";

	$sql_subject = "SELECT * from scheme_master where  branch_code='".$_POST['Branch_Name']."' and semester='".$_POST['Semester']."' and scheme_code='".$_POST['Scheme_Code']."' and full_part_time='".$_POST['Full_/_Part_Time']."' and  aicte_rc='".$_POST['AICTE_/_RC']."' and theory_practical='".$_POST['theory_practical']."' order by subject_code ASC ;";
	#echo $sql_subject;
	$result_subject = mysql_query($sql_subject);
	echo "<table class='table table-bordered striped table-condensed'><tr><th>Branch</th><th>FT or PT /<br>AICTE or RC</th><th>Subject Title</th><th>Subject Code/ M Code</th><th>Semester</th><th>Shift</th><th>T/P</th><th>Scheme Code</th><th>Select Faculty</th><th>Section </th><th>Contact hours per week</th><th>Teacher Type (Subject / Adjustment Teacher)</th>";
	#if ($_POST['theory_practical']=='P')
	#{
		echo "<th>Group</th>";
	#}
	echo "<th> Add Subject </th></tr>";
	echo "  <form id='profile' name='profile' action=''  method='post'>
		";
	$x=1;
	$num=mysql_num_rows($result_subject);
	while ($row_subject = mysql_fetch_array($result_subject))
	{
		$sql_branch = "SELECT * from branch_code where branch_code='".$row_subject['branch_code']."';";
		$result_branch = mysql_query($sql_branch);
		$row_branch = mysql_fetch_array($result_branch);
		$branch_name=$row_branch['branch_name'];
		echo "<tr class='warning'><td>".$branch_name."</td><td>".$_POST['Full_/_Part_Time']." /<br>".$_POST['AICTE_/_RC']." </td><td>".$row_subject['subject_title']." (".$row_subject['elective_details'].")</td><td>".$row_subject['subject_code']."/ ".$row_subject['m_code']."</td>
		<td>".$row_subject['semester']."</td><td>".$_POST['shift']."</td><td>".$row_subject['theory_practical']."</td><td>".$row_subject['scheme_code']."</td><td>";
		echo "<input type='hidden' name='scheme_master_id$x' value=".$row_subject['scheme_master_id'].">";
		echo "<input type='hidden' name='scheme_code$x' value=".$row_subject['scheme_code'].">";
		echo "<input type='hidden' name='time_table_subject_add' value='time_table_subject_add'>";
		$sql_user = "SELECT * FROM `users` where usertype='teacher' ORDER BY `name` ASC;";
		$result_user = mysql_query($sql_user);
		echo " <select name='teacher_username$x' >";
		echo "<option value='".$row_subject['teacher_username']."' selected >".$row_subject['teacher_username']."</option>";
		echo "<option value='' >---------</option>";
		while ($row_user = mysql_fetch_array($result_user))
		{
			$usersname=$row_user['username'];
			$name=$row_user['name'];
			$department=$row_user['department'];
			echo "<option value='".$usersname."'>$name-$department ($usersname)</option>";
		}	
		echo "</select></td>";
		$sql_ssection = "SELECT distinct  ssection FROM `student_info` where branch_code='".$row_subject['branch_code']."' and semester='".$row_subject['semester']."' and student_status='Onroll' ORDER BY `ssection`;";
	#	echo $sql_ssection;
		$result_ssection = mysql_query($sql_ssection);
		echo "<td> <select name='ssection$x'  class='input-small'>";
		echo "<option value='' >----</option>";
		while ($row_ssection = mysql_fetch_array($result_ssection))
		{
			$ssection=$row_ssection['ssection'];
			echo "<option value='".$ssection."'>$ssection</option>";
		}	
		echo "</select></td>
		<td><select name='contact_hours$x' class='input-small'>
		<option value='1' >1</option>
		<option value='2' >2</option>
		<option value='3' >3</option>
		<option value='4' >4</option>
		<option value='5' >5</option>
		<option value='6' >6</option>
		<option value='7' >7</option>
		<option value='8' >8</option>
		<option value='9' >9</option>
		<option value='10' >10</option>
		</select></td>
		<td><select name='teacher_type$x' class='input-medium'>
		<option value='Subject Teacher'>Subject Teacher</option>
		<option value='Adjustment Teacher'>Adjustment Teacher</option></select></td>";	
		$sql_sgroup = "SELECT distinct  sgroup FROM `student_info` where branch_code='".$row_subject['branch_code']."' and semester='".$row_subject['semester']."' and student_status='Onroll'  ORDER BY `sgroup`;";
	#	echo $sql_sgroup;
		$result_sgroup = mysql_query($sql_sgroup);
	#	if ($_POST['theory_practical']=='P')
	#	{
			echo "<td> <select name='sgroup$x' class='input-small'>";
			echo "<option value='' >----</option>";
			while ($row_sgroup = mysql_fetch_array($result_sgroup))
			{
				$sgroup=$row_sgroup['sgroup'];
				echo "<option value='".$sgroup."'>$sgroup</option>";
			}	
			echo "</select></td>";
	#	}
		echo "<input type='hidden' name='shift$x' value=".$_POST['shift'].">";
		echo "<td><input type='checkbox' name='add_subject$x' value='1'> ADD</td></tr>";
	$x++;
	}
	echo "<input type='hidden' name='num' value='$num'>";
	echo "<tr><td colspan='14' align='center'>
		<input type='submit' name='submit' class='btn btn-block btn-danger' value='Click Here to Allot Subject(s)'></form></td></tr></table>";
}
else
{
	show_label("info","Time Table Subject Allotement");
	$user=$_SESSION['username'];
	$coursetype=$_SESSION['coursetype'];
	$sql_user = "SELECT * from users where username ='$user';";
	$result_user = mysql_query($sql_user);
	$row_user = mysql_fetch_array($result_user);
	$users_id=$row_user['users_id'];
	echo "  <form id='profile' name='profile' action=''  method='post'><br>";
	if ($coursetype=='All')
	{
		echo " <table align='center'><tr><td> Select Branch </td><td> 
		<select name='Branch_Name' class='required'>";
		$sql_branch = "SELECT distinct branch_name,branch_code from branch_code where course_code='1' ;";
		$result_branch = mysql_query($sql_branch);
		while ($row_branch = mysql_fetch_array($result_branch))
		{		
		$branch_code=$row_branch['branch_code'];
		$branch_name=$row_branch['branch_name'];
		echo "<option value='$branch_code'>$branch_name</option>";
		}
		echo "</select></td><tr>
		<td>Shift <td><select name='shift' >
		<option value='First'>First</option>
		<option value='Second'>Second</option>
		</select></td>
		<tr><td>Semester <td><select name='Semester' >
		<option value='1'>1</option>
		<option value='2'>2</option>
		</select></td>";
		$sql_scheme_code = "SELECT distinct scheme_code_first_year from student_info  where course_code='1' and student_status='Onroll' and (semester='1' or semester='2' )order by  scheme_code_first_year DESC ;";
		$result_scheme_code= mysql_query($sql_scheme_code);
		echo "<tr><td>Scheme Code</td><td><select name='Scheme_Code'>";
		echo "<option value='2004'>2004</option>";
		while ($row_scheme_code = mysql_fetch_array($result_scheme_code))
		{		
		$scheme_code=$row_scheme_code['scheme_code_first_year'];
		echo "<option value='$scheme_code'>$scheme_code</option>";
		}
		echo "</select></td><tr>";
	}
	else
	{
		echo " <table align='center'><tr><td> Select Branch </td><td> 
		<select name='Branch_Name' class='required'>";
		$sql_branch = "SELECT * from branch_code where users_id ='$users_id' order by branch_code DESC;";
		$result_branch = mysql_query($sql_branch);
		while ($row_branch = mysql_fetch_array($result_branch))
		{		
		$branch_code=$row_branch['branch_code'];
		$course_code=$row_branch['course_code'];
		$branch_name=$row_branch['branch_name'];
		echo "<option value='$branch_code'>$branch_name</option>";
		}
		echo "</select></td><tr>";
		$sql_shift = "SELECT distinct shift from student_info  where branch_code='".$branch_code."' and student_status='Onroll' ;";
		$result_shift= mysql_query($sql_shift);
		echo "<td>Shift <td><select name='shift' >";
		while ($row_shift = mysql_fetch_array($result_shift))
		{		
		$shift=$row_shift['shift'];
		echo "<option value='$shift'>$shift</option>";
		}
		if ($course_code=='1')
		{
			$sql_semester = "SELECT distinct semester from student_info  where branch_code='".$branch_code."' and student_status='Onroll' AND semester !=1 AND semester !=2 order by semester ASC;";
			$sql_scheme_code = "SELECT distinct scheme_code_branch from student_info  where branch_code='".$branch_code."' and student_status='Onroll' AND semester !=1 AND semester !=2  order by  scheme_code_branch DESC ;";
		}
		else
		{
			$sql_semester = "SELECT distinct semester from student_info  where branch_code='".$branch_code."' and student_status='Onroll' order by semester ASC;";
			#echo $sql_semester;
			$sql_scheme_code = "SELECT distinct scheme_code_branch from student_info  where branch_code='".$branch_code."' and student_status='Onroll' order by  scheme_code_branch DESC ;";
		}
		$result_semester= mysql_query($sql_semester);
		echo "<tr><td>Semester <td><select name='Semester' >";
		while ($row_semester = mysql_fetch_array($result_semester))
		{		
			$semester=$row_semester['semester'];
			echo "<option value='$semester'>$semester</option>";
		}
		$result_scheme_code= mysql_query($sql_scheme_code);
		#echo $sql_scheme_code;
		echo "<tr><td>Scheme Code</td><td>
		<select name='Scheme_Code'>";
		while ($row_scheme_code = mysql_fetch_array($result_scheme_code))
		{		
		$scheme_code=$row_scheme_code['scheme_code_branch'];
		echo "<option value='$scheme_code'>$scheme_code</option>";
		}
		echo "</select></td><tr>";
	}
	echo "<tr>";
	form_dropdown_field('dropdown','','Full_/_Part_Time','student_info','full_part_time','required');
	echo "<tr>";
	form_dropdown_field('dropdown','','AICTE_/_RC','student_info','aicte_rc','required');
	echo "<tr><td>Theory / Practical <td><select name='theory_practical' >
	<option value='T'>Theory</option>
	<option value='P'>Practical</option>
	</select></td>";
	echo "</tr><tr><td>
	<input type='hidden' name='time_table_subject_allotment_show' value='time_table_subject_allotment_show' /> 
	<input type='submit' name='submit' class='btn btn-danger' value='Submit'></form></td></tr></table>";
}
?>

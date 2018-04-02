<?
$module_subject_allotment = fetch_resource_db('admin_controls',array('control_name'),array('course_admin_subject_allotment'),'resource_array','');
if($module_subject_allotment['value']=='Disabled') {
	show_label('important',$module_subject_allotment['message']);
	exit();
}

if (isset($_POST['security_code']) && isset($_POST['num']))
	{
		$n=$_POST['num'];
		#echo "N=".$n;
		$x=1;
		for($i=1;$i<=$n;$i++)
		{
			if(isset($_POST['internal_unlock'.$x]))
			{
				$sql= "update subject_master set internal_lock_status='".$_POST['internal_unlock'.$x]."' where subject_master_id='".$_POST['subject_master_id'.$x]."' ;";
				#echo $sql."<br>";
				mysql_query($sql) or die(mysql_error());
				$sql_update_lock_internal ="Update student_internal_marks set internal_lock_status='".$_POST['internal_unlock'.$x]."' WHERE
				subject_code = '".$_POST['subject_code'.$x]."' AND
				course_code = '".$_POST['course_code'.$x]."' AND
				branch_code = '".$_POST['branch_code'.$x]."' AND
				aicte_rc = '".$_POST['aicte_rc'.$x]."' AND
				shift = '".$_POST['shift'.$x]."' AND
				m_code = '".$_POST['m_code'.$x]."' AND
				full_part_time = '".$_POST['full_part_time'.$x]."' AND
				theory_practical = '".$_POST['theory_practical'.$x]."' AND
				semester = '".$_POST['semester'.$x]."' AND
				regular_reappear = '".$_POST['regular_reappear'.$x]."' AND
				subject_master_id = '".$_POST['subject_master_id'.$x]."'; ";
				mysql_query($sql_update_lock_internal) or die(mysql_error());
				#echo $sql_update_lock_internal;
				echo "<center><h5>Internal of Subject Successfully Un-Locked</h5>";
			}
			
			if(isset($_POST['external_unlock'.$x]))
			{
				$sql= "update subject_master set external_lock_status='".$_POST['external_unlock'.$x]."' where subject_master_id='".$_POST['subject_master_id'.$x]."' ;";
				#echo $sql."<br>";
				mysql_query($sql) or die(mysql_error());
				$sql_update_lock_external = "Update student_internal_marks set  external_lock_status='".$_POST['external_unlock'.$x]."' WHERE
				subject_code = '".$_POST['subject_code'.$x]."' AND
				course_code = '".$_POST['course_code'.$x]."' AND
				branch_code = '".$_POST['branch_code'.$x]."' AND
				aicte_rc = '".$_POST['aicte_rc'.$x]."' AND
				shift = '".$_POST['shift'.$x]."' AND
				m_code = '".$_POST['m_code'.$x]."' AND
				full_part_time = '".$_POST['full_part_time'.$x]."' AND
				theory_practical = '".$_POST['theory_practical'.$x]."' AND
				semester = '".$_POST['semester'.$x]."' AND
				regular_reappear = '".$_POST['regular_reappear'.$x]."' AND
				subject_master_id = '".$_POST['subject_master_id'.$x]."'; ";
				mysql_query($sql_update_lock_external) or die(mysql_error());
				#echo $sql_update_lock_external;
				echo "<center><h5>External of Subject  Successfully Un-Locked</h5>";
			}
			if(isset($_POST['subject_master_id'.$x]))
			{
				#$sql= "update subject_master set internal_attendance_status='0', external_attendance_status='0', internal_lock_status='0', external_lock_status='0' where subject_master_id='".$_POST['subject_master_id'.$x]."'  ANDsubject_code = '".$_POST['subject_code'.$x]."' AND course_code = '".$_POST['course_code'.$x]."' AND branch_code = '".$_POST['branch_code'.$x]."' AND aicte_rc = '".$_POST['aicte_rc'.$x]."' AND shift = '".$_POST['shift'.$x]."' AND full_part_time = '".$_POST['full_part_time'.$x]."' AND theory_practical = '".$_POST['theory_practical'.$x]."' ANDsemester = '".$_POST['semester'.$x]."' AND regular_reappear = '".$_POST['regular_reappear'.$x]."' AND teacher_username!='".$_POST['username'.$x]."' ;";
				#echo $sql;
				#echo "<br />";
				#mysql_query($sql) or die(mysql_error());
	
				$sql1= "update subject_master set teacher_username='".$_POST['username'.$x]."' where 
				subject_master_id='".$_POST['subject_master_id'.$x]."' ;";
				#echo $sql1;
				mysql_query($sql1) or die(mysql_error());
				
			}
			$x++;
		}
		echo "<center><h5>Subject Alloment Saved Successfully</h5>";
			//echo "<h5><a href=''> Back </a> </h5></center>";
		
	}
	else if(isset($_POST['course_branch']) && isset($_POST['Semester']) && isset($_POST['Shift']) && isset($_POST['Full_Part_Time']))
	{
		$course_branch = explode(',',$_POST['course_branch']);
		
		$sql_subject = "SELECT * from subject_master where  branch_code='".$course_branch[1]."' and semester='".$_POST['Semester']."' and shift='".$_POST['Shift']."' and full_part_time='".$_POST['Full_Part_Time']."' and  aicte_rc='".$_POST['AICTE_/_RC']."' AND (internal_allot='1' OR external_allot='1' );";
		//echo "<h3> Shift : $_POST['Shift']  </h3>echo $_POST['AICTE_/_RC'];
		$result_subject = mysql_query($sql_subject);
		echo "<table class='table table-bordered striped table-condensed'><tr><th>Branch</th><th>Shift /<br>FT or PT /<br>AICTE or RC</th><th>Subject Title</th><th>Subject  Code</th><th>Semester</th><th>Subject Type</th><th>Select Faculty</th>
		 
		 <!-- // For Internal locks 
		 <th>Internal<br /> Un-Lock</th> --> 
		 <!-- // For External Locks  -->
		 <th>External<br /> Un-Lock</th> 
		 		 
		 <th>External<br /> Teacher</th><th>Internal<br /> Teacher</th></tr>";
		echo "  <form id='profile' name='profile' action=''  method='post'>
		";
		$x=1;
		$num=mysql_num_rows($result_subject);
		while ($row_subject = mysql_fetch_array($result_subject))
		{		
			$i_teacher_sql = mysql_query("SELECT DISTINCT teacher_username FROM student_internal_marks WHERE subject_master_id='".$row_subject['subject_master_id']."' AND internal_external='I' AND internal_lock_status='1'") or die(mysql_error());
			$e_teacher_sql = mysql_query("SELECT DISTINCT teacher_username FROM student_internal_marks WHERE subject_master_id='".$row_subject['subject_master_id']."' AND internal_external='E' AND external_lock_status='1'") or die(mysql_error());
			
			$i_teacher = mysql_fetch_assoc($i_teacher_sql);
			$e_teacher = mysql_fetch_assoc($e_teacher_sql);
			
			
			$sql_branch = "SELECT * from branch_code where branch_code='".$row_subject['branch_code']."';";
			$result_branch = mysql_query($sql_branch);
			$row_branch = mysql_fetch_array($result_branch);
			$branch_name=$row_branch['branch_name'];
			echo "<tr class='warning'><td>".$branch_name."</td><td>".$_POST['Shift']." /<br>".$_POST['Full_Part_Time']." /<br>".$_POST['AICTE_/_RC']." </td><td>".$row_subject['subject_title']."</td><td>".$row_subject['subject_code']."</td><td>".$row_subject['semester']."</td><td>".$row_subject['theory_practical']." (".$row_subject['regular_reappear'].")</td><td>";
			#$sql_user = "SELECT * FROM `users` where usertype='teacher' ORDER BY `name` DESC;";
			$sql_user = "SELECT * FROM `users` where usertype='teacher' ORDER BY `name` ASC;";
			$result_user = mysql_query($sql_user);
			echo "<input type='hidden' name='subject_master_id$x' value=".$row_subject['subject_master_id'].">";
			echo "<input type='hidden' name='subject_code$x' value='".$row_subject['subject_code']."'>";
			echo "<input type='hidden' name='m_code$x' value='".$row_subject['m_code']."'>";
			echo "<input type='hidden' name='course_code$x' value='".$row_subject['course_code']."'>";
			echo "<input type='hidden' name='branch_code$x' value='".$row_subject['branch_code']."'>";
			echo "<input type='hidden' name='aicte_rc$x' value='".$row_subject['aicte_rc']."'>";
			echo "<input type='hidden' name='shift$x' value='".$row_subject['shift']."'>";
			echo "<input type='hidden' name='full_part_time$x' value='".$row_subject['full_part_time']."'>";
			echo "<input type='hidden' name='theory_practical$x' value='".$row_subject['theory_practical']."'>";
			echo "<input type='hidden' name='semester$x' value='".$row_subject['semester']."'>";
			echo "<input type='hidden' name='teacher_username$x' value='".$row_subject['teacher_username']."'>";
			echo "<input type='hidden' name='regular_reappear$x' value='".$row_subject['regular_reappear']."'>";
			echo "<input type='hidden' name='security_code' value='security_code'>";
			#echo "<input type='hidden' name='branch_code$x' value=".$row_subject['branch_code'].">";
			echo " <select name='username$x' >";
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
			
			// For Internal Locks
			if ($row_subject['internal_lock_status']=='1' && $row_subject['received_internal']=='N' && $row_subject['internal_allot']=='1')
			{
			#	echo "<td><font color='red'>";
			#	echo "<input type='checkbox' name='internal_unlock$x' value='0'><br>Un-Lock<br></font></td>";
			}
			else
			{
				#echo "<td></td>";
			}
			// For External Locks
			if ($row_subject['external_lock_status']=='1' && $row_subject['received_external']=='N' && $row_subject['external_allot']=='1' )
			{
				echo "<td><font color='red'>";
				echo "<input type='checkbox' name='external_unlock$x' value='0'><br>Un-Lock</font></td>";
			}
			else
			{
				echo "<td></td>";
			}
			echo "<td>".$e_teacher['teacher_username']."</td>";
			echo "<td>".$i_teacher['teacher_username']."</td>";
			$x++;
		}
		echo "<input type='hidden' name='num' value='$num'>";
		echo "<tr><td colspan='10' align='center'>
		<input type='hidden' name='allot_subject_done' value='allot_subject_done' /> 
		<input type='submit' name='submit' class='btn btn-block btn-danger' value='Click Here to Save Subject(s)'></form></td></tr></table>";
		//<input type='submit' name='submit' class='btn btn-danger' value='Save Subject(s)'></form></td></tr></table>";
	}
	else
	{	 
		$user=$_SESSION['username'];
		$sql_user = "SELECT * from users where username ='$user';";
		$result_user = mysql_query($sql_user);
		$row_user = mysql_fetch_array($result_user);
		$users_id=$row_user['users_id'];
		$sql_branch = "SELECT * from branch_code where users_id ='$users_id';";
		$result_branch = mysql_query($sql_branch);
		echo "  <form id='profile' name='profile' action=''  method='post'>";
		$branch_codes_sql = mysql_query("SELECT show_branch_code,show_course_code,show_semester FROM users WHERE username='".$_SESSION['username']."' ; ") or die(mysql_error());

		$branch_codes = mysql_fetch_assoc($branch_codes_sql);



		if($branch_codes['show_branch_code']=='ALL' && $branch_codes['show_course_code']!='ALL') {
			$branch = mysql_query("SELECT distinct branch_code,course_code FROM subject_master WHERE 
			course_code IN (".$branch_codes['show_course_code'].")
			ORDER BY course_code ASC") or die(mysql_error());
		}
		elseif($branch_codes['show_branch_code']=='ALL' && $branch_codes['show_course_code']=='ALL') {

			$branch = mysql_query("SELECT distinct branch_code,course_code FROM subject_master  ORDER BY course_code ASC") or die(mysql_error());
		}
		else {
			$branch = mysql_query("SELECT distinct branch_code,course_code FROM subject_master  WHERE 
			branch_code IN (".$branch_codes['show_branch_code'].")
			ORDER BY course_code ASC") or die(mysql_error());
		}

		if($branch_codes['show_semester']=='ALL') {
			$semester = mysql_query("SELECT distinct semester FROM subject_master  ORDER BY semester ASC") or die(mysql_error());
		}

		else {
			$semester = mysql_query("SELECT distinct semester FROM subject_master  WHERE
			semester IN (".$branch_codes['show_semester'].") ORDER BY semester ASC") or die(mysql_error());
		}


		echo " <table align='center'>
		<tr><td>
					<span style='font-weight:bold'>Program </span>
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
          <select name='Semester' id='Semester' class='input-xlarge'>";
           while($row = mysql_fetch_assoc($semester)) {
						
						echo "<option value='".$row['semester']."'>".$row['semester']."</option>";
					}
					echo "
					</select>
					</tr></td>";
					
		/* <tr><td> Select Branch </td><td> 
		<select name='Branch_Name' class='required'>";
		while ($row_branch = mysql_fetch_array($result_branch))
		{		
		$branch_code=$row_branch['branch_code'];
		$branch_name=$row_branch['branch_name'];
		echo "<option value='$branch_code'>$branch_name</option>";
		}	
		echo "</select></td><tr>";
		form_dropdown_field('dropdown','','Semester','subject_master','semester','required');*/
		echo "<tr>";
		form_dropdown_field('dropdown','','Shift','subject_master','shift','required');
		echo "<tr>";
		form_dropdown_field('dropdown','','Full_Part_Time','subject_master','full_part_time','required');
		echo "<tr>";
		form_dropdown_field('dropdown','','AICTE_/_RC','subject_master','aicte_rc','required');
		echo "</tr><tr><td>
		<input type='hidden' name='allot_subject_show' value='allot_subject_show' /> 
		<input type='submit' name='submit' class='btn btn-danger' value='Submit'></form></td></tr></table>";
	}
?>

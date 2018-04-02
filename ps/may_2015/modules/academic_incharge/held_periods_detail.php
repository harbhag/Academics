<?
if(isset($_POST['held_periods_detail_submit'] ))
{
	$usertype=$_SESSION['usertype'];
	if($usertype=='director')
	{
		$course_branch = explode(',',$_POST['course_branch']);
		$branch_sql = "SELECT branch_name FROM branch_code WHERE branch_code='".$course_branch[1]."'  and course_code='".$course_branch[0]."';";
		$course_sql = "SELECT course_name FROM course_code WHERE  course_code='".$course_branch[0]."';";
		$branch_code= $course_branch[1];
	}
	else
	{
	$branch_sql = "SELECT branch_name FROM branch_code WHERE branch_code='".$_POST['branch_code']."'  and course_code='".$_POST['course_code']."';";
	$course_sql = "SELECT course_name FROM course_code WHERE  course_code='".$_POST['course_code']."';";
	$branch_code= $_POST['branch_code'];
	}
	$branch_result = mysql_query($branch_sql);
	$branch_row = mysql_fetch_array($branch_result);
	$branch_name = $branch_row['branch_name'];
	
	$course_result = mysql_query($course_sql);
	$course_row = mysql_fetch_array($course_result);
	$course_name = $course_row['course_name'];
	
	$sql ="select count(*) as total_number, subject_code,`subject_title`,`theory_practical` ,`semester`,course_code,branch_code, ssection, sgroup, elective_details,shift,full_part_time,aicte_rc from ( select distinct attendance_period,attendance_date,subject_code,`subject_title`,`theory_practical` ,`semester`,course_code,branch_code, ssection, sgroup,elective_details,shift,full_part_time,aicte_rc from `daily_attendance_student` s WHERE backup='0' and branch_code='".$branch_code."' and full_part_time='".$_POST['Full_/_Part_Time']."' and aicte_rc='".$_POST['AICTE_/_RC']."' and semester='".$_POST['Semester']."' and shift='".$_POST['Shift']."' and ssection='".$_POST['Section']."') d group by subject_code,`subject_title`,`theory_practical` ,`semester`,branch_code,course_code,ssection, sgroup,elective_details,shift,full_part_time,aicte_rc order by subject_code, theory_practical, shift, ssection,sgroup";
	#echo $sql;
	$result1 = mysql_query($sql) or die(mysql_error());
	echo "<h4><center>Held Periods Detail (".$course_name." - ".$branch_name.")</center></h4>";
	echo "<b>Date : </b>".date('d-m-Y h:i:s');
	echo "<br /><br /><table class='table table-bordered striped table-condensed container sortable'>
	<tr><th>Sr. No.</th>
	<th>Subject Code</th>
	<th>Subject Title</th>
	<th>Theory / Practical</th>
	<th>Shift</th>
	<th>Semester</th>
	<th>Section</th>
	<th>Group</th>
	<th>Full / Part Time 
	<th>AICTE / RC</th>
	<th>Total Number</th>
	<th>Number of Bunks</th>
		</tr>";
	$x=1;
	while($row = mysql_fetch_array($result1))
	{
		$bunk_sql="SELECT distinct course_code,branch_code,semester,ssection,sgroup, shift,full_part_time,theory_practical,aicte_rc,attendance_date, attendance_period ,subject_code,subject_title FROM `daily_attendance_student` WHERE   backup='0' and subject_code='".$row['subject_code']."'  and theory_practical='".$row['theory_practical']."' and shift='".$row['shift']."' and semester='".$row['semester']."' and ssection='".$row['ssection']."' and sgroup='".$row['sgroup']."' and full_part_time='".$row['full_part_time']."' and aicte_rc='".$row['aicte_rc']."' and branch_code='".$branch_code."' group by course_code,branch_code,semester,ssection,sgroup, shift,full_part_time,theory_practical,aicte_rc,attendance_date, attendance_period ,subject_code  having COUNT( 
		CASE WHEN attendance =  'Present'	THEN 1 	END) =0 ";
		#echo $bunk_sql;
		$bunk_result = mysql_query($bunk_sql) or die(mysql_error());
		$total_bunk=mysql_num_rows($bunk_result);
		echo "<tr><td>".$x."</td><td>".$row['subject_code']."<td>".$row['subject_title']."</td><td>".$row['theory_practical']."  </td><td>".$row['shift']."<td>".$row['semester']."</td><td>".$row['ssection']."</td><td>".$row['sgroup']."</td><td>".$row['full_part_time']."</td><td>".$row['aicte_rc']."</td><td>".$row['total_number']."</td><td>".$total_bunk."</td></tr>";
	$x++;
	}
	break;	

}


if(isset($_POST['held_periods_detail']))
{	
	show_label("info","Held Periods Detail");
	$usertype=$_SESSION['usertype'];
	$user=$_SESSION['username'];
	$coursetype=$_SESSION['coursetype'];
	$sql_user = "SELECT * from users where username ='$user';";
	$result_user = mysql_query($sql_user);
	$row_user = mysql_fetch_array($result_user);
	$users_id=$row_user['users_id'];
	echo "  <form id='profile' name='profile' action=''  method='post'><br><table align='center'>";
	if ($usertype=='director')
	{
		$branch = mysql_query("SELECT distinct branch_code,course_code FROM daily_attendance_student ORDER BY course_code,branch_code ASC") or die(mysql_error());
		echo "<tr><td>Course(Branch)</td><td>
          <select name='course_branch' id='course_branch' class='input-xlarge'>";
          while($row = mysql_fetch_array($branch)) {
						if($row['branch_code']=='' or is_null($row['branch_code'])) {
							continue;
						}
						$course_name = fetch_resource_db('course_code',array('course_code'),array($row['course_code']),'resource_array_value','course_name');
						$branch_name = fetch_resource_db('branch_code',array('branch_code'),array($row['branch_code']),'resource_array_value','branch_name');
						
						echo "<option value='".$row['course_code'].",".$row['branch_code']."'>".$course_name."(".$branch_name.") </option>";
					}
		echo "</select></tr></td>";
		form_dropdown_field('dropdown','','Semester','daily_attendance_student','semester','required');
	}
	else
	{
		if ($coursetype=='All')
		{
			echo " <tr><td> Select Branch </td><td> 
			<select name='branch_code' class='required'>";
			$sql_branch = "SELECT distinct branch_name,branch_code,course_code from branch_code where course_code='1' ;";
			$result_branch = mysql_query($sql_branch);
			while ($row_branch = mysql_fetch_array($result_branch))
			{		
			$branch_code=$row_branch['branch_code'];
			$course_code=$row_branch['course_code'];
			$branch_name=$row_branch['branch_name'];
			echo "<option value='$branch_code'>$branch_name</option>";
			}
			echo "</select></td>
			<tr><td>Semester <td><select name='semester' >
			<option value='1'>1</option>
			<option value='2'>2</option>
			</select></td>";
		}
		else
		{
			echo " <table align='center'><tr><td> Select Branch </td><td> 
			<select name='branch_code' class='required'>";
			$sql_branch = "SELECT * from branch_code where users_id ='$users_id' order by branch_code ASC;";
			$result_branch = mysql_query($sql_branch);
			while ($row_branch = mysql_fetch_array($result_branch))
			{		
			$branch_code=$row_branch['branch_code'];
			$course_code=$row_branch['course_code'];
			$branch_name=$row_branch['branch_name'];
			echo "<option value='$branch_code'>$branch_name</option>";
			}
			echo "</select></td><tr>";
			echo "<input type='hidden' name='course_code' value='$course_code' /> ";
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
		}

	}
		
	echo "<tr>";
	form_dropdown_field('dropdown','','Full_/_Part_Time','student_info','full_part_time','required');
	echo "<tr>";
	form_dropdown_field('dropdown','','AICTE_/_RC','student_info','aicte_rc','required');
		echo "<tr>";
	form_dropdown_field('dropdown','','Shift','student_info','shift','required');
	echo "<tr>";
	form_dropdown_field('dropdown','','Section','student_info','ssection','required');
	echo "</tr><tr><td>
	<input type='hidden' name='held_periods_detail_submit' value='held_periods_detail_submit' /> 
	
	<input type='submit' name='submit' class='btn btn-danger' value='Submit'></form></td></tr></table>";
}
?>

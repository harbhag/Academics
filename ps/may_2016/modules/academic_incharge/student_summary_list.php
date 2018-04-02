<?
if(isset($_POST['student_summary_list_submit'] ))
{
	$branch_sql = "SELECT branch_name FROM branch_code WHERE branch_code='".$_POST['branch_code']."'  and course_code='".$_POST['course_code']."';";
	$branch_result = mysql_query($branch_sql);
	$branch_row = mysql_fetch_array($branch_result);
	$branch_name = $branch_row['branch_name'];
	
	$course_sql = "SELECT course_name FROM course_code WHERE  course_code='".$_POST['course_code']."';";
	$course_result = mysql_query($course_sql);
	$course_row = mysql_fetch_array($course_result);
	$course_name = $course_row['course_name'];
	
	$sql = "SELECT *  FROM `student_info` WHERE `branch_code` = '".$_POST['branch_code']."'  AND `full_part_time` = '".$_POST['Full_/_Part_Time']."' AND  aicte_rc='".$_POST['AICTE_/_RC']."' and semester= '".$_POST['semester']."' and shift= '".$_POST['shift']."' order by university_roll_no ASC; ";
	#echo $sql;
	$result1 = mysql_query($sql) or die(mysql_error());
	echo "<h4> <center> Student Summary List (".$course_name." - ".$branch_name.") </center></h4>";
	echo "<b>Date : </b>".date('d-m-Y h:i:s');
	echo "<br /><br />
	<table class='table table-bordered striped table-condensed container sortable'>
	<tr><th>Sr. No.</th>
	<th>College Roll No.</th>
	<th>University Roll No.</th>
	<th> Student Name</th>
	<th> Father Name</th>
	<th> Mother Name</th>
	<th>Gender</th>
	<th>Shift / Sem.</th>
	<th>Full / Part Time 
	<th>AICTE / RC</th>
	<th>Section / Group </th>
	<th>Email </th>
	<th>Mobile No.</th>
		</tr>";
	$x=1;
	#echo "hello";
	while($row = mysql_fetch_array($result1))
	{
		echo "<tr><td>".$x."</td><td>".$row['college_roll_no']."<td>".$row['university_roll_no']."</td>
		<td>".$row['ptu_student_name']."  </td>
		<td>".$row['ptu_father_name']."  </td><td>".$row['ptu_mother_name']."  </td>
		<td>".$row['gender']."<td>".$row['shift']." / ".$row['semester']."</td>
		<td>".$row['full_part_time']."</td>
		<td>".$row['aicte_rc']."</td>
		<td>".$row['ssection']." / ".$row['sgroup']."</td>
		<td>".$row['student_email']."<td>".$row['student_mobile_no']."</td></tr>";
	$x++;
	}
	break;	
}

if(isset($_POST['student_summary_list_form']))
{	
	show_label("info","Student Summary List");
	$user=$_SESSION['username'];
	$coursetype=$_SESSION['coursetype'];
	$sql_user = "SELECT * from users where username ='$user';";
	$result_user = mysql_query($sql_user);
	$row_user = mysql_fetch_array($result_user);
	$users_id=$row_user['users_id'];
	echo "  <form id='profile' name='profile' action=''  method='post'><br>";
	if ($coursetype=='chemistry' || $coursetype=='physics')
	{
		echo " <table align='center'><tr><td> Select Branch </td><td> 
		<select name='branch_code' class='required'>";
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
		echo "<tr><td>Semester <td><select name='semester' >";
		while ($row_semester = mysql_fetch_array($result_semester))
		{		
			$semester=$row_semester['semester'];
			echo "<option value='$semester'>$semester</option>";
		}
	}
	echo "<tr>";
	form_dropdown_field('dropdown','','Full_/_Part_Time','student_info','full_part_time','required');
	echo "<tr>";
	form_dropdown_field('dropdown','','AICTE_/_RC','student_info','aicte_rc','required');
	echo "<tr>";
	form_dropdown_field('dropdown','','shift','student_info','shift','required');
	echo "</tr><tr><td>
	<input type='hidden' name='student_summary_list_submit' value='student_summary_list_submit' /> 
	<input type='hidden' name='course_code' value='$course_code' /> 
	<input type='submit' name='submit' class='btn btn-danger' value='Submit'></form></td></tr></table>";
}


?>

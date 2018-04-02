<?php 
if(isset($_POST['student_elective_subject_insert']))
{
	$n=$_POST['num'];$x=1;
	for($i=1;$i<=$n;$i++)
	{
	if($_POST['elective_subject'.$x]!='')
	{
		$sql_ses = "SELECT * from student_elective_subjects where university_roll_no='".$_POST['university_roll_no'.$x]."' and semester='".$_POST['semester']."' and elective_details='".$_POST['elective_type']."';";
		#echo $sql_ses;
		$result_ses= mysql_query($sql_ses);
		$row_ses = mysql_fetch_array($result_ses);
		$row_num = mysql_num_rows($result_ses);
		#echo $row_num;
		if($row_num!='')
		{	
			$sql_delete_log="INSERT INTO `student_elective_delete_logs`(`scheme_master_id`, `univeristy_roll_no`, `username`, `timestamp`) VALUES ('".$row_ses['scheme_master_id']."','".$_POST['university_roll_no'.$x]."','".$_SESSION['username']."','".date('Y-m-d H:i:s')."')";
		#	echo $sql_delete_log;
			mysql_query($sql_delete_log) or die('Error, Insert Log query failed');
			
			$sql_delete="DELETE FROM `student_elective_subjects` WHERE university_roll_no='".$_POST['university_roll_no'.$x]."' and semester='".$_POST['semester']."' and elective_details='".$_POST['elective_type']."'; ";
			mysql_query($sql_delete) or die('Error, Delete query failed');
			
		}

		$result_elective_subject = mysql_query("SELECT  * from scheme_master where scheme_master_id= '".$_POST['elective_subject'.$x]."';"); 
		$row_els = mysql_fetch_array($result_elective_subject);
		$sql_ses_insert="INSERT INTO `student_elective_subjects`(`course_code`, `branch_code`, `semester`, `university_roll_no`, `paper_id`, `subject_title`, `subject_code`, `elective_details`, `m_code`, `scheme_master_id`) VALUES ('".$_POST['course_code']."', '".$_POST['branch_code']."', '".$_POST['semester']."', '".$_POST['university_roll_no'.$x]."', '".$row_els['paper_id']."', '".$row_els['subject_title']."','".$row_els['subject_code']."','".$row_els['elective_details']."', '".$row_els['m_code']."', '".$_POST['elective_subject'.$x]."')";
		#echo $sql_ses_insert;
		mysql_query($sql_ses_insert) or die('Error, Insert query failed');
	}
	$x++;	
	}
	show_label("success","Allotment Successfully Updated");
}
 
if(isset($_POST['student_elective_subject_submit']))
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
	echo "<h4> <center>  Elective Subject Allotment </center></h4>";
	echo "<br /><br />
	<form action=''  method='post'>
	<table class='table table-bordered striped table-condensed container sortable'>
	<tr><th>Sr. No.</th>
	<th>College Roll No.</th>
	<th>University Roll No.</th>
	<th> Student Name</th>
	<th>Shift </th><th> Sem.</th>
	<th>Elective Subjects</th>
	</tr>";
	$x=1;
	#echo "hello";
	$num=mysql_num_rows($result1);
	while($row = mysql_fetch_array($result1))
	{
		echo "<tr><td>".$x."</td><td>".$row['college_roll_no']."<td>".$row['university_roll_no']."</td>
		<td>".$row['ptu_student_name']."  </td>
		<td>".$row['shift']." <td> ".$row['semester']."</td>";
		$result_elective_subject = mysql_query("SELECT  * from scheme_master where scheme_code= '".$_POST['scheme_code']."' and branch_code='".$_POST['branch_code']."' and elective_details='".$_POST['elective_type']."' and semester='".$_POST['semester']."';" );
		
		
		$sql_ses = "SELECT * from student_elective_subjects where university_roll_no='".$row['university_roll_no']."' and semester='".$row['semester']."' and elective_details='".$_POST['elective_type']."';";
		#echo $sql_ses;
		$result_ses= mysql_query($sql_ses);
		$row_ses = mysql_fetch_array($result_ses);
		echo "<td><select name='elective_subject$x'>";
		
		echo "<option value=''>".$row_ses['subject_title']."</option>";
		
		while ($row_els = mysql_fetch_array($result_elective_subject))
		{		
			$subject_id=$row_els['scheme_master_id'];
			echo "<option value='$subject_id'>".$row_els['subject_title']."(".$row_els['subject_code'].")</option>";
		}
				"</td>
		</tr>";
	echo "<input type='hidden' name='university_roll_no$x' value='".$row['university_roll_no']."' /> ";
	$x++;
	}
	echo "<input type='hidden' name='num' value='$num'>";
	echo "<input type='hidden' name='branch_code' value='".$_POST['branch_code']."'>";
	echo "<input type='hidden' name='course_code' value='".$_POST['course_code']."'>";
	echo "<input type='hidden' name='semester' value='".$_POST['semester']."'>";
	echo "<input type='hidden' name='elective_type' value='".$_POST['elective_type']."'>";
	echo "<input type='hidden' name='student_elective_subject_insert' value='student_elective_subject_insert' /> 
	</table>
	<center><input type='submit' name='submit' class='btn btn-danger' value='Submit'></form></center>
	";
}
	



if(isset($_POST['student_elective_subject_allotment']))
{	
	show_label("info","Student Elective Subject Allotment");
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
	
	$result_scheme_code= mysql_query($sql_scheme_code);
		echo "<tr><td> Scheme Code <td><select name='scheme_code' >";
		echo "<option value='2004'>2004</option>";
	while ($row_scheme_code = mysql_fetch_array($result_scheme_code))
		{		
			$scheme_code=$row_scheme_code['scheme_code_branch'];
			echo "<option value='$scheme_code'>$scheme_code</option>";
		}
		
	echo "<tr>";
	form_dropdown_field('dropdown','','Full_/_Part_Time','student_info','full_part_time','required');
	echo "<tr>";
	form_dropdown_field('dropdown','','AICTE_/_RC','student_info','aicte_rc','required');
	echo "<tr>";
	form_dropdown_field('dropdown','','shift','student_info','shift','required');
		echo "<tr><td>Elective Type <td><select name='elective_type' >";
		echo "<option value='Elective'>Elective</option>
		<option value='Elective-I'>Elective-I</option>
		<option value='Elective-II'>Elective-II</option>
		<option value='Elective-III'>Elective-III</option>
		<option value='Elective-IV'>Elective-IV</option>
		<option value='Open Elective'>Open Elective</option>";
	
	echo "</tr><tr><td>
	<input type='hidden' name='student_elective_subject_submit' value='student_elective_subject_submit' /> 
	<input type='hidden' name='course_code' value='".$course_code."' /> 
	<input type='submit' name='submit' class='btn btn-danger' value='Submit'></form></td></tr></table>";
}




?>

<?php
if(isset($_POST['student_section_group_update'] ))
{
	$n=$_POST['num'];$x=1;
	for($i=1;$i<=$n;$i++)
	{
		$result_student_info = mysql_query("SELECT  ssection, sgroup from student_info where university_roll_no= ".$_POST['university_roll_no'.$x].";" );
		$student_info = mysql_fetch_array($result_student_info);
		#echo "SELECT  ssection, sgroup from student_info where university_roll_no= ".$_POST['university_roll_no'.$x].";";
		if(($student_info['ssection']!=$_POST['ssection'.$x]) || ($student_info['sgroup']!=$_POST['sgroup'.$x]))
		{
			$sg_log_insert="INSERT INTO `section_group_logs`(`university_roll_no`, `old_ssection`, `old_sgroup`, `username`, `timestamp`) VALUES ('".$_POST['university_roll_no'.$x]."','".$student_info['ssection']."','".$student_info['sgroup']."','".$_SESSION['username']."','".date('Y-m-d H:i:s')."');";
			#echo $sg_log_insert;
			mysql_query($sg_log_insert);
			$si_update="update student_info set ssection='".$_POST['ssection'.$x]."', sgroup='".$_POST['sgroup'.$x]."' where university_roll_no= '".$_POST['university_roll_no'.$x]."'; ";
			#echo $si_update;
			mysql_query($si_update);
		}	
	$x++;	
	}
show_label("success","Record Successfully Update");
}


if(isset($_POST['student_section_group_submit'] ))
{
	$branch_sql = "SELECT branch_name FROM branch_code WHERE branch_code='".$_POST['branch_code']."'  and course_code='".$_POST['course_code']."';";
	$branch_result = mysql_query($branch_sql);
	$branch_row = mysql_fetch_array($branch_result);
	$branch_name = $branch_row['branch_name'];
	
	$course_sql = "SELECT course_name FROM course_code WHERE  course_code='".$_POST['course_code']."';";
	$course_result = mysql_query($course_sql);
	$course_row = mysql_fetch_array($course_result);
	$course_name = $course_row['course_name'];
	
	$sql = "SELECT *  FROM `student_info` WHERE `branch_code` = '".$_POST['branch_code']."'  AND `full_part_time` = '".$_POST['Full_/_Part_Time']."' AND  aicte_rc='".$_POST['AICTE_/_RC']."' and semester= '".$_POST['semester']."' and shift= '".$_POST['shift']."' and student_status='Onroll' order by university_roll_no ASC; ";
	#echo $sql;
	$result1 = mysql_query($sql) or die(mysql_error());
	echo "<h4> <center>  Change Section/Group Allotment (".$course_name." - ".$branch_name.") </center></h4>";
	echo "<br /><br />
	<form action=''  method='post'>
	
	<table class='table table-bordered striped table-condensed container sortable'>
	<tr><th>Sr. No.</th>
	<th>College Roll No.</th>
	<th>University Roll No.</th>
	<th> Student Name</th>
	<th>Shift / Sem.</th>
	
	<th>Section 
	<th> Group </th>
	</tr>";
	$x=1;
	#echo "hello";
	$num=mysql_num_rows($result1);
	while($row = mysql_fetch_array($result1))
	{
		echo "<tr><td>".$x."</td><td>".$row['college_roll_no']."<td>".$row['university_roll_no']."</td>
		<td>".$row['ptu_student_name']."  </td>
		<td>".$row['shift']." / ".$row['semester']."</td>";
		$result_student_info = mysql_query("SELECT  ssection, sgroup from student_info where university_roll_no= ".$row['university_roll_no'].";" );
		$student_info = mysql_fetch_array($result_student_info);
		$sql_section = "SELECT distinct ssection from student_info  where student_status='Onroll' order by  ssection ;";
		$result_section= mysql_query($sql_section);
		echo "<td><select name='ssection$x' >";
		echo "<option value=".$student_info['ssection'].">".$student_info['ssection']."</option>";
		while ($row_section = mysql_fetch_array($result_section))
		{		
			$section=$row_section['ssection'];
			echo "<option value='$section'>$section</option>";
		}
		$sql_sgroup = "SELECT distinct sgroup from student_info  where student_status='Onroll' order by  sgroup ;";
		$result_sgroup= mysql_query($sql_sgroup);
		echo "<td><select name='sgroup$x' >";
		echo "<option value=".$student_info['sgroup'].">".$student_info['sgroup']."</option>";
		while ($row_sgroup = mysql_fetch_array($result_sgroup))
		{		
			$sgroup=$row_sgroup['sgroup'];
			echo "<option value='$sgroup'>$sgroup</option>";
		}
		"</td>
		</tr>";
	echo "<input type='hidden' name='university_roll_no$x' value='".$row['university_roll_no']."' /> ";
	$x++;
	}
	echo "<input type='hidden' name='num' value='$num'>";
	echo "<input type='hidden' name='student_section_group_update' value='student_section_group_update' /> 
	</table>
	<center><input type='submit' name='submit' class='btn btn-danger' value='Submit'></form></center>
	";
}


if(isset($_POST['student_section_group_allotment']))
{	
	show_label("info","Student Section/Group Allotment");
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
	<input type='hidden' name='student_section_group_submit' value='student_section_group_submit' /> 
	<input type='hidden' name='course_code' value='$course_code' /> 
	<input type='submit' name='submit' class='btn btn-danger' value='Submit'></form></td></tr></table>";
}


?>

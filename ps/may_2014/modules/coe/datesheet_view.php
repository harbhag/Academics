<?php

show_label('info','Datesheet View');
echo "<br/>";

include('function.php');

if(isset($_POST['datesheet_view']))
{
	echo "<table class='table table-bordered striped table-condensed container'>
		<form method='post' action=''>
		<tr><td><center><h4>Datesheet View (B.Tech. First Year)</h4></center></td></tr>
		<input type='hidden' name='datesheet_view_show' value='datesheet_view_show' />
		<input type='hidden' name='btech_first_year' value='btech_first_year' />
		<tr><td><center><button type='submit' name='submit' class='btn btn-large btn-danger'>B.Tech.(First Year only) </button></center></form></td></tr></table>
		
		<br /> <table class='table table-bordered striped table-condensed container'>
		<form method='post' action=''>
		<tr><td><center><h4>Datesheet View (M.Tech.)</h4></center></td></tr>
		<input type='hidden' name='datesheet_view_show' value='datesheet_view_show' />
		<input type='hidden' name='mtech' value='mtech' />
		<tr><td><center><button type='submit' name='submit' class='btn btn-large btn-danger'>M.Tech.(All Branchs) </button></center></form></td></tr></table>";
		
		echo " <br /> <table class='table table-bordered striped table-condensed container'>
		<form method='post' action=''>
		<tr><td colspan='2'><center><h4>Datesheet View (MBA / MCA /B.Tech.[2 Year Onwards])</h4></center></td></tr>";	
		$sql_course = "SELECT distinct course_name,course_code from course_code where course_code='1' or course_code='3' or course_code='4' ";
		$result_course = mysql_query($sql_course) or  die(mysql_error()) ;
		echo "<tr><td> Course </td><td> <select name='course_code' class='input-xlarge' >";
		while ($row_course = mysql_fetch_array($result_course))
		{		
		echo "<option value='".$row_course['course_code']."'>".$row_course['course_name']."</option>";
		}	
		echo "</select></td><tr>";
		$sql_branch = "SELECT distinct branch_name,branch_code from branch_code where course_code='1' or course_code='3' or course_code='4' ";
		$result_branch = mysql_query($sql_branch) or  die(mysql_error()) ;
		echo "<tr><td> Branch </td><td> <select name='branch_code' class='input-xlarge' >";
		while ($row_branch = mysql_fetch_array($result_branch))
		{		
		echo "<option value='".$row_branch['branch_code']."'>".$row_branch['branch_name']."</option>";
		}	
		echo "</select></td><tr>
		
		<!--<tr><td>Semester</td><td><select name='semester' class='input-small'>
		<option value='3'>3</option><option value='4'>4</option>
		<option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option>
		</select></td></tr>-->
		</tr><input type='hidden' name='datesheet_view_show' value='datesheet_view_show' />
		</tr><input type='hidden' name='btech_2year_onwards' value='btech_2year_onwards' /></table>
		<center><button type='submit' name='submit' class='btn btn-large btn-danger'>View Datesheet</button></center></form>";
}

if(isset($_POST['datesheet_view_show']) && isset($_POST['btech_first_year']))
{
	$sql_ptu_subjects="select distinct date_of_exam,usession,semester,subject_title,subject_code,paper_id,scheme_code,m_code from scheme_master where (semester='1' or semester='2') and course_code='1' and  theory_practical='T' order by semester,scheme_code,date_of_exam ;";
	$ptu_subjects_result = mysql_query($sql_ptu_subjects) or  die(mysql_error());
	#echo $sql_ptu_subjects;
	echo "<center><h4>DATE SHEET (Regular & Reappear)<br /> BACHELOR OF TECHNOLOGY (FIRST YEAR)</h4></center>";
	echo "<table class='table table-bordered striped table-condensed container' >
	<tr style='background-color:lightgrey'>
	<th>Date of Exam (yyyy-dd-mm)<th>Session</th><th>Semester</th><th>Subject Title</th> <th>Subject Code</th><th>Paper ID</th><th>Scheme Code</th></tr>";
	while ($row_ptu_subjects = mysql_fetch_array($ptu_subjects_result))
	{
	echo "<tr><td>".$row_ptu_subjects['date_of_exam']."</td><td>".$row_ptu_subjects['usession']."</td><td>".$row_ptu_subjects['semester']."</td><td>".$row_ptu_subjects['subject_title']."</td><td>".$row_ptu_subjects['subject_code']."</td><td>".$row_ptu_subjects['paper_id']."</td><td>".$row_ptu_subjects['scheme_code']." Onwards</td></tr>";
	}
	?>
<?
}


if(isset($_POST['datesheet_view_show']) && isset($_POST['btech_2year_onwards']))
{
	$course_code =$_POST['course_code'];
	$branch_code =$_POST['branch_code'];
	$branch_name = decode_fieldname('branch_code','branch_name','branch_code',$branch_code);
	$course_name = decode_fieldname('course_code','course_name','course_code',$course_code);
	if($course_code=='1')
	{
	$sql_ptu_subjects="select distinct date_of_exam,usession,semester,subject_title,subject_code,paper_id,scheme_code,m_code from scheme_master where (semester='3' or semester='4' or semester='5' or semester='6' or semester='7' or semester='8') and course_code='1' and  theory_practical='T' and  branch_code='$branch_code' order by semester,scheme_code,date_of_exam ;";
	}
	else if($course_code=='3' || $course_code=='4')
	{
		$sql_ptu_subjects="select distinct date_of_exam,usession,semester,subject_title,subject_code,paper_id,scheme_code,m_code from scheme_master where course_code='$course_code' and  theory_practical='T' and  branch_code='$branch_code' order by semester,scheme_code,date_of_exam ;";
	}
	$ptu_subjects_result = mysql_query($sql_ptu_subjects) or  die(mysql_error());
	#echo $sql_ptu_subjects;
	echo "<center><h4>DATE SHEET (Regular & Reappear)<br /> $course_name ($branch_name)</h4></center>";
	echo "<table class='table table-bordered striped table-condensed container' >
	<tr style='background-color:lightgrey'>
	<th>Date of Exam  (yyyy-dd-mm)<th>Session</th><th>Semester</th><th>Subject Title</th> <th>Subject Code</th><th>Paper ID</th><th>M Code</th><th>Scheme Code</th></tr>";
	while ($row_ptu_subjects = mysql_fetch_array($ptu_subjects_result))
	{
	echo "<tr><td>".$row_ptu_subjects['date_of_exam']."</td><td>".$row_ptu_subjects['usession']."</td><td>".$row_ptu_subjects['semester']."</td><td>".$row_ptu_subjects['subject_title']."</td><td>".$row_ptu_subjects['subject_code']."</td><td>".$row_ptu_subjects['paper_id']."</td><td>".$row_ptu_subjects['m_code']." </td><td>".$row_ptu_subjects['scheme_code']." Onwards</td></tr>";
	}
}


if(isset($_POST['datesheet_view_show']) && isset($_POST['mtech']))
{
	$sql_ptu_subjects="select distinct branch_code,date_of_exam,usession,subject_title,subject_code,paper_id,scheme_code,m_code from scheme_master where course_code='2' and  theory_practical='T' order by branch_code,scheme_code,date_of_exam ;";
	$ptu_subjects_result = mysql_query($sql_ptu_subjects) or  die(mysql_error());
	#echo $sql_ptu_subjects;
	echo "<center><h4>DATE SHEET (Regular & Reappear)<br /> MASTER OF TECHNOLOGY</h4></center>";
	echo "<table class='table table-bordered striped table-condensed container' >
	<tr style='background-color:lightgrey'>
	<th>Branch</th><th>Date of Exam  (yyyy-dd-mm)<th>Session</th><th>Subject Title</th> <th>Subject Code</th><th>Paper ID</th><th>M Code<th>Scheme Code</th></tr>";
	while ($row_ptu_subjects = mysql_fetch_array($ptu_subjects_result))
	{
	$branch_name = decode_fieldname('branch_code','branch_name','branch_code',$row_ptu_subjects['branch_code']);
	echo "<tr><td>$branch_name</td><td>".$row_ptu_subjects['date_of_exam']."</td><td>".$row_ptu_subjects['usession']."</td><td>".$row_ptu_subjects['subject_title']."</td><td>".$row_ptu_subjects['subject_code']."</td><td>".$row_ptu_subjects['paper_id']."</td><td>".$row_ptu_subjects['m_code']."</td><td>".$row_ptu_subjects['scheme_code']." Onwards</td></tr>";
	}
	?>
<?
}

?>

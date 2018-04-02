<?php

include('function.php');
if(isset($_POST['insert_date_of_exam']))
{
	echo "<table class='table table-bordered striped table-condensed container'>
		<form method='post' action=''>
		<tr><td colspan='2'><center><h4>M.Tech. / MBA / MCA / B.Tech.(Semester 1 and 2 only)</h4></center></td></tr>
		<tr><td>Paper ID</td>
		<td> <input type='text' name='paper_id' id='btech_first_year' />
		</tr><input type='hidden' name='insert_date_of_exam_show' value='insert_date_of_exam_show' />
		</tr><input type='hidden' name='btech_first_year' value='btech_first_year' /></table>
		<center><button type='submit' name='submit' class='btn btn-large btn-danger'>Proceed</button></center></form>";
		echo " <br /> <table class='table table-bordered striped table-condensed container'>
		<form method='post' action=''>
		<tr><td colspan='2'><center><h4>B.Tech. ( 2 Year onwards )</h4></center></td></tr>
		<tr><td>";	
		$sql_branch = "SELECT distinct branch_name,branch_code from branch_code where course_code='1' ";
		$result_branch = mysql_query($sql_branch) or  die(mysql_error()) ;
		echo "<tr><td> Branch </td><td> <select name='branch_code' class='input-xlarge' >";
		while ($row_branch = mysql_fetch_array($result_branch))
		{		
		echo "<option value='".$row_branch['branch_code']."'>".$row_branch['branch_name']."</option>";
		}	
		echo "</select></td><tr>
		<tr><td>Semester</td><td><select name='semester' class='input-small'>
		<option value='3'>3</option><option value='4'>4</option>
		<option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option>
		</select></td></tr>
		<tr><td>Paper ID</td>
		<td> <input type='text' name='paper_id' id='paper_id' />
		</tr><input type='hidden' name='insert_date_of_exam_show' value='insert_date_of_exam_show' />
		</tr><input type='hidden' name='btech_2year_onwards' value='btech_2year_onwards' /></table>
		<center><button type='submit' name='submit' class='btn btn-large btn-danger'>Proceed</button></center></form>";
}

if(isset($_POST['insert_date_of_exam_show']) && isset($_POST['btech_first_year']))
{
	$sql_ptu_subjects="select * from scheme_master where (((semester='1' or semester='2') and course_code='1') or ((semester='1' or semester='2' or semester='3' or semester='4' or semester='5') and (course_code='2' or course_code='3' or course_code='4')))  and  paper_id='".$_POST['paper_id']."' and theory_practical='T' ;";
	$ptu_subjects_result = mysql_query($sql_ptu_subjects) or  die(mysql_error());
	$ptu_subjects_result_count = mysql_query($sql_ptu_subjects) or  die(mysql_error());
	$ptu_subject_row_count = mysql_num_rows($ptu_subjects_result_count);
	#echo $sql_ptu_subjects;
	if($ptu_subject_row_count=='0')
	{
		echo "<center><h4>Wrong Paper ID </h4></center>";
		break;
	}
	echo "<table class='table table-bordered striped table-condensed container' >
	<tr style='background-color:lightgrey'>
	<th>Course</th><th>Branch</th><th>Subject Code</th><th>Paper ID</th><th>M Code<th>Subject Title</th><th>Semester</th><th>AICTE/RC</th><th>Full / Part Time</th><th>Subject Group</th><th>Internal Max marks<th>External Max marks<th>Scheme Code</th></tr>";
	while ($row_ptu_subjects = mysql_fetch_array($ptu_subjects_result))
	{
	$branch_name = decode_fieldname('branch_code','branch_name','branch_code',$row_ptu_subjects['branch_code']);
	$course_name = decode_fieldname('course_code','course_name','course_code',$row_ptu_subjects['course_code']);
	echo "<tr><td>$course_name</td><td>$branch_name</td><td>".$row_ptu_subjects['subject_code']."</td><td>".$row_ptu_subjects['paper_id']."</td><td>".$row_ptu_subjects['m_code']."</td><td>".$row_ptu_subjects['subject_title']."</td><td>".$row_ptu_subjects['semester']."</td>
	<td>".$row_ptu_subjects['aicte_rc']."</td><td>".$row_ptu_subjects['full_part_time']."</td><td>".$row_ptu_subjects['subject_group']."</td><td>".$row_ptu_subjects['internal_max_marks']."</td><td>".$row_ptu_subjects['external_max_marks']."</td><td>".$row_ptu_subjects['scheme_code']."</td></tr>";
	}
	?>
	</table><form method='post' action=''>
	<table class='table table-bordered striped table-condensed container'>	
	<tr><td>Date of Exam</td>
		<td>
		<div class='input-append date'  data-date='<?php echo date('Y-m-d'); ?>' data-date-format='yyyy-mm-dd'> 
		<input  class='span2'  type='text' name='date_of_exam' id='date_of_exam'  readonly />
		<span class='add-on'><i class='icon-calendar'></i></span></div>
		<tr><td>Session </td><td>  <select name='session'>
		<option value='M'>Morning</option>
		<option value='E'>Evening</option>
		</select> </td></tr>
		</table>
		<input type='hidden' name='insert_date_of_exam_submit' value='insert_date_of_exam_submit' />
		<input type='hidden' name='paper_id' value='<? echo $_POST['paper_id']; ?>' />
		</tr><input type='hidden' name='btech_first_year' value='btech_first_year' />
		<tr><td>
		<center><button type='submit' name='submit' class='btn btn-large btn-danger'>Proceed</button></tr></td></center>";
<?
}

if(isset($_POST['insert_date_of_exam_show']) && isset($_POST['btech_2year_onwards']))
{
	$sql_ptu_subjects="select * from scheme_master where  branch_code='".$_POST['branch_code']."' and paper_id='".$_POST['paper_id']."' and semester='".$_POST['semester']."' and theory_practical='T' ;";
	$ptu_subjects_result = mysql_query($sql_ptu_subjects) or  die(mysql_error());
	$ptu_subjects_result_count = mysql_query($sql_ptu_subjects) or  die(mysql_error());
	$ptu_subject_row_count = mysql_num_rows($ptu_subjects_result_count);
	#echo $sql_ptu_subjects;
	if($ptu_subject_row_count=='0')
	{
		echo "<center><h4>Wrong Paper ID </h4></center>";
		break;
	}
	echo "<table class='table table-bordered striped table-condensed container' >
	<tr style='background-color:lightgrey'>
	<th>Course</th><th>Branch</th><th>Subject Code</th><th>Paper ID</th><th>M Code<th>Subject Title</th><th>Semester</th><th>AICTE/RC</th><th>Full / Part Time</th><th>Subject Group</th><th>Internal Max marks<th>External Max marks<th>Scheme Code </th></tr>";
	while ($row_ptu_subjects = mysql_fetch_array($ptu_subjects_result))
	{
	$branch_name = decode_fieldname('branch_code','branch_name','branch_code',$row_ptu_subjects['branch_code']);
	$course_name = decode_fieldname('course_code','course_name','course_code',$row_ptu_subjects['course_code']);
	echo "<tr><td>$course_name</td><td>$branch_name</td><td>".$row_ptu_subjects['subject_code']."</td><td>".$row_ptu_subjects['paper_id']."</td><td>".$row_ptu_subjects['m_code']."</td><td>".$row_ptu_subjects['subject_title']."</td><td>".$row_ptu_subjects['semester']."</td>
	<td>".$row_ptu_subjects['aicte_rc']."</td><td>".$row_ptu_subjects['full_part_time']."</td><td>".$row_ptu_subjects['subject_group']."</td><td>".$row_ptu_subjects['internal_max_marks']."</td><td>".$row_ptu_subjects['external_max_marks']."</td><td>".$row_ptu_subjects['scheme_code']."</td></tr>";
	}
	?>
	</table><form method='post' action=''>
	<table class='table table-bordered striped table-condensed container'>	
	<tr><td>Date of Exam</td>
		<td>
		<div class='input-append date'  data-date='<?php echo date('Y-m-d'); ?>' data-date-format='yyyy-mm-dd'> 
		<input  class='span2'  type='text' name='date_of_exam' id='date_of_exam'  readonly />
		<span class='add-on'><i class='icon-calendar'></i></span></div>
		<tr><td>Session </td><td>  <select name='session'>
		<option value='M'>Morning</option>
		<option value='E'>Evening</option>
		</select> </td></tr>
		</table>
		<input type='hidden' name='insert_date_of_exam_submit' value='insert_date_of_exam_submit' />
		<input type='hidden' name='paper_id' value='<? echo $_POST['paper_id']; ?>' />
		<input type='hidden' name='semester' value='<? echo $_POST['semester']; ?>' />
		<input type='hidden' name='branch_code' value='<? echo $_POST['branch_code']; ?>' />
		</tr><input type='hidden' name='btech_2year_onwards' value='btech_2year_onwards' />
		<tr><td>
		<center><button type='submit' name='submit' class='btn btn-large btn-danger'>Proceed</button></tr></td></center>";
<?
}


if(isset($_POST['insert_date_of_exam_submit']) && isset($_POST['btech_first_year']))
{
	$paper_id = $_POST['paper_id'];
	$date_of_exam = $_POST['date_of_exam'];
	$session = $_POST['session'];
	#echo $paper_id." ".$date_of_exam." ".$session;
	$sql_scheme_master_update="update scheme_master set date_of_exam='".$date_of_exam."', usession='".$session."', date_of_exam_updated_by='".$_SESSION['username']."', date_of_exam_updated_time='".date('Y-m-d h:i:s')."'  where paper_id='".$_POST['paper_id']."' ;";
	#echo $sql_scheme_master_update;
	mysql_query($sql_scheme_master_update) or  die(mysql_error()) ;
	echo "<center><h4>Data Submitted</h4> </center>";
}

if(isset($_POST['insert_date_of_exam_submit']) && isset($_POST['btech_2year_onwards']))
{
	$paper_id = $_POST['paper_id'];
	$date_of_exam = $_POST['date_of_exam'];
	$session = $_POST['session'];
	#echo $paper_id." ".$date_of_exam." ".$session;
	$sql_scheme_master_update="update scheme_master set date_of_exam='".$date_of_exam."', usession='".$session."', date_of_exam_updated_by='".$_SESSION['username']."', date_of_exam_updated_time='".date('Y-m-d h:i:s')."'  where paper_id='".$_POST['paper_id']."' and semester='".$_POST['semester']."'  and branch_code= '".$_POST['branch_code']."'; ";
	#echo $sql_scheme_master_update;
	mysql_query($sql_scheme_master_update) or  die(mysql_error()) ;
	echo "<center><h4>Data Submitted</h4> </center>";
}

?>

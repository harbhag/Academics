<?php
if(isset($_POST['delete_course_outcomes']))
{
	mysql_query("update program_cos set backup='1', revision='0' where  id='".$_POST['program_cos_id']."' ; ");
	show_label('success','Successfully Deleted');
	echo "<br/>";
}

if(isset($_POST['add_course_outcomes_submit']))
{
	
	$dup = mysql_query("SELECT * FROM program_cos WHERE 
	co_number='".$_POST['co_number']."' AND 
	program_outcome_id='".$_POST['program_outcome_id']."' AND
	course_code='".$_POST['course_code']."' AND
	branch_code='".$_POST['branch_code']."' AND
	subject_code='".$_POST['subject_code']."' AND
	scheme_code='".$_POST['scheme_code']."' AND
	backup='0'
	") or die(mysql_error());
	
	if(mysql_num_rows($dup)!=0) {
		show_label('warning','Mapping already exists');
	}
	
	else {
		mysql_query("INSERT INTO `program_cos`( `course_code`, `branch_code`, `scheme_code`, `subject_code`, `m_code`, `co_number`, `co_statement`, `backup`, `revision`, `upload_by`, `timestamp`,correlation_po,program_outcome_id) VALUES ('".$_POST['course_code']."','".$_POST['branch_code']."','".$_POST['scheme_code']."','".$_POST['subject_code']."','".$_POST['m_code']."','".$_POST['co_number']."','".$_POST['co_statement']."','0','0','".$_SESSION['username']."','".date('Y-m-d H:i:s')."','".$_POST['correlation_po']."', '".$_POST['program_outcome_id']."') ;") ; 
		show_label('success','Submit Successfully');
		echo "<br/>";
	}
}


if(isset($_POST['edit_course_outcomes_submit']))
{	$revision= $_POST['revision']+1;
	#echo "update program_cos set backup='1', revision='$revision' where  id='".$_POST['program_cos_id']."' ; ";
	mysql_query("update program_cos set backup='1', revision='$revision' where  id='".$_POST['program_cos_id']."' ; ");
	mysql_query("INSERT INTO `program_cos`( `course_code`, `branch_code`, `scheme_code`, `subject_code`, `m_code`, `co_number`, `co_statement`, `backup`, `revision`, `upload_by`, `timestamp`,correlation_po,program_outcome_id) VALUES ('".$_POST['course_code']."','".$_POST['branch_code']."','".$_POST['scheme_code']."','".$_POST['subject_code']."','".$_POST['m_code']."','".$_POST['co_number']."','".$_POST['co_statement']."','0','0','".$_SESSION['username']."','".date('Y-m-d H:i:s')."','".$_POST['correlation_po']."', '".$_POST['program_outcome_id']."') ;") ; 
	#echo "INSERT INTO `program_cos`( `course_code`, `branch_code`, `scheme_code`, `subject_code`, `m_code`, `co_number`, `co_statement`, `backup`, `revision`, `upload_by`, `timestamp`,correlation_po,program_outcome_id) VALUES ('".$_POST['course_code']."','".$_POST['branch_code']."','".$_POST['scheme_code']."','".$_POST['subject_code']."','".$_POST['m_code']."','".$_POST['co_number']."','".$_POST['co_statement']."','0','0','".$_SESSION['username']."','".date('Y-m-d H:i:s')."','".$_POST['correlation_po']."', '".$_POST['program_outcome_id']."') ;";
	show_label('success','Successfully Updated');
	echo "<br/>";
	
}

$scheme_master = mysql_query("SELECT *  from scheme_master  where scheme_code='".$_POST['scheme_code']."' and branch_code='".$_POST['branch_code']."' and subject_code='".$_POST['subject_code']."' and semester='".$_POST['semester']."'; ");

$row_sm = mysql_fetch_assoc($scheme_master);
show_label('info','Subject Detail ');
echo "<br/>
	<table  class='table table-bordered table-condensed container '>
	<tr class='warning'><th>Subject Code / M Code</th><th>Subject Title</th><th>Semester</th><th>Theory / Practical</th><th>Scheme Code</th><th>Progarm COS</th></tr>
	<tr class='warning'><td>".$row_sm['subject_code']." / ".$row_sm['m_code']."</td><td>".$row_sm['subject_title']."</td><td>".$row_sm['semester']."</td><td>".$row_sm['theory_practical']."</td><td>".$row_sm['scheme_code']."</td>
	<td><form method='POST' action='' accept-charset='UTF-8'>  
				
				<button type='submit' name='submit' class='btn btn-small btn-danger' data-toggle='modal' href='#add_course_outcomes_form'> Add </button>
						</form></td></tr></table>";
include('modules/modals/nba_incharge/add_course_outcomes_form.php');

$program_cos_result_1 = mysql_query("Select * from program_cos where backup='0' and scheme_code='".$_POST['scheme_code']."' and branch_code='".$_POST['branch_code']."' and subject_code='".$_POST['subject_code']."' ; ");

show_label('info','Program Course Outcome(CO) Detail ');
echo "<br/><table  class='table table-bordered   table-condensed container sortable'>
	<tr><th>Sr No. </th><th>Subject Code / M Code</th><th>CO Number </th><th>CO Statement</th><th>Correlation PO</th><th>Program Outcome (a-l)</th><th> Edit </th><th>Delete</th></tr>";
$count=1;
while($row_pcos_2 = mysql_fetch_assoc($program_cos_result_1)) 
{	
	$program_outcomes_result_id = mysql_query("Select * from program_outcomes where  branch_code='".$_POST['branch_code']."' and id='".$row_pcos_2['program_outcome_id']."' ; ");
	
	$row_po_id = mysql_fetch_assoc($program_outcomes_result_id);
	echo "<tr class='warning' ><td>$count</td><td>".$row_pcos_2['subject_code']." / ".$row_pcos_2['m_code']."</td><td>".$row_pcos_2['co_number']."</td><td>".$row_pcos_2['co_statement']."</td><td>".$row_pcos_2['correlation_po']."</td><td>".$row_po_id['po_num']."</td>
	<td><form method='POST' action='' accept-charset='UTF-8'>
	<button type='button' name='submit' class='btn btn-mini btn-danger' data-toggle='modal' href='#edit_course_outcomes_form$count'> Edit </button></form></td>";
	include('modules/modals/nba_incharge/edit_course_outcomes_form.php');
	$count++;
	echo "<td><form method='POST' action='' accept-charset='UTF-8'>
 <input type='hidden' name='course_code' value='".$row_sm['course_code']."' />
				<input type='hidden' name='m_code' value='".$row_sm['m_code']."' />
				<input type='hidden' name='semester' value='".$row_sm['semester']."' />
				<input type='hidden' name='branch_code' value='".$_POST['branch_code']."' />
				<input type='hidden' name='program_cos_id' value='".$row_pcos_2['id']."' />
				<input type='hidden' name='revision' value='".$row_pcos_2['revision']."' />
				<input type='hidden' name='scheme_code' value='".$_POST['scheme_code']."' />
				<input type='hidden' name='subject_code' value='".$_POST['subject_code']."' />
	<input type='hidden' name='delete_course_outcomes' value='delete_course_outcomes' />
	 <button type='submit' class='btn btn-mini btn-danger'>Delete</button></form></td></tr>";
}


echo "</table>";
?>

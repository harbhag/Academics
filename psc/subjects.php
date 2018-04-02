<?php


//echo "SELECT * FROM mtech_external_thesis_examiner WHERE username='".$_SESSION['username']."'";



echo "<br/><br/><center><span style='color:#bd362f;font-weight:bold;font-size:20px'>Please Select Subjects Below</span><br/><br/></center>";

$user = mysql_fetch_assoc(mysql_query("SELECT * FROM mtech_external_thesis_examiner WHERE username='".$_SESSION['username']."'")) or die(mysql_error());

$query = " SELECT DISTINCT course_code ,subject_code,subject_title,paper_id,m_code FROM scheme_master WHERE branch_code IN (".$user['branch_code'].") AND theory_practical='T'  ";


if($user['excluded_mcode']!='') {
	
	$query .= " AND m_code NOT IN (".$user['excluded_mcode'].") ";
	
}

if($user['included_mcode']!='') {
	
	$query .= " AND m_code IN (".$user['included_mcode'].") ";
	
}

if($user['excluded_semester']!='') {
	
	$query .= " AND semester NOT IN (".$user['excluded_semester'].") ";
	
}

$query .= "  ORDER BY course_code,subject_code  ";



//echo $query;

$subject_sql = mysql_query($query) or die(mysql_error());




echo "<center><table class='table table-hover table-striped table-bordered table-condensed'>
<form method='post' action=''>
<tr><td colspan='7'><input class='btn btn-info btn-large btn-block btn-primary' type='submit' name='submit' value='Submit' /></td></tr>
<tr>
<th>Sr. No. </th>
<th>Program</th>
<th>Subject Code</th>
<th>Subject Title</th>
<th>M.Code</th>
<th>Paper ID</th>
<th>Select</th>
</tr>";

$count = 1;


while($subject=mysql_fetch_assoc($subject_sql)) {
	
	$prev_subjects = mysql_query("SELECT * FROM paper_setter_consent WHERE 
	
	teacher_username='".$_SESSION['username']."' AND
	subject_code='".$subject['subject_code']."' AND
	subject_title='".$subject['subject_title']."' AND
	m_code='".$subject['m_code']."' AND
	paper_id='".$subject['paper_id']."' AND backup='0'
	") or die(mysql_error());
	
	
	if(mysql_num_rows($prev_subjects)==1) {
		$checked = "checked";
	}
	else{
		$checked="";
	}
	
	$course_name = mysql_fetch_assoc(mysql_query("SELECT course_name FROM course_code WHERE course_code='".$subject['course_code']."'")) or die(mysql_error());
	
	echo "<tr>
	<td>".$count."</td>
	<td>".$course_name['course_name']."</td>
	<td>".$subject['subject_code']."</td>
	<td>".$subject['subject_title']."</td>
	<td>".$subject['m_code']."</td>
	<td>".$subject['paper_id']."</td>";
	
	echo "<input type='hidden' name='course_code".$count."' value='".$subject['course_code']."'/>";
	echo "<input type='hidden' name='subject_code".$count."' value='".$subject['subject_code']."'/>";
	echo "<input type='hidden' name='subject_title".$count."' value='".$subject['subject_title']."'/>";
	echo "<input type='hidden' name='m_code".$count."' value='".$subject['m_code']."'/>";
	echo "<input type='hidden' name='paper_id".$count."' value='".$subject['paper_id']."'/>";
	
	echo "<td><input type='checkbox' $checked name='consent".$count."' value='yes'/> Yes</td>";
	
	echo "</tr>";
	
	
	
	$count +=1;
	
}

echo "<input type='hidden' name='count' value='".$count."'/>";
echo "<input type='hidden' name='consent_submitted'/>";

echo "<tr><td colspan='7'><input class='btn btn-info btn-large btn-block btn-primary' type='submit' name='submit' value='Submit' /></td></tr>";

echo "</form></table></center>";



/*
//EXPERIMENTAL CODE
echo "<center><table class='table table-hover table-striped table-bordered table-condensed'>
<form method='post' action=''>
<tr>";

$count = 1;

echo "<td><table class='table table-hover table-striped table-bordered table-condensed'>
<tr>
	<th>Sr. No. </th>
	<th>Subject Code</th>
	<th>Subject Title</th>
	<th>M.Code</th>
	<th>Paper ID</th>
	<th>Select</th>
</tr>";

while($subject=mysql_fetch_assoc($subject_sql)) {
	
	
	if($count%85==0) {
		echo "</td></table>";
		echo "<td><table class='table table-hover table-striped table-bordered table-condensed'>
		<tr>
	<th>Sr. No. </th>
	<th>Subject Code</th>
	<th>Subject Title</th>
	<th>M.Code</th>
	<th>Paper ID</th>
	<th>Select</th>
</tr>";
	}
	
	
	echo "<tr>
	<td>".$count."</td>
	<td>".$subject['subject_code']."</td>
	<td>".$subject['subject_title']."</td>
	<td>".$subject['m_code']."</td>
	<td>".$subject['paper_id']."</td>";
	
	echo "<td><input type='checkbox' name='consent'".$count."</td>";
	
	echo "</tr>";
	
	
	
	$count +=1;
	
}

echo "</tr><tr><td colspan='6'><input class='btn btn-danger btn-large btn-block btn-primary' type='submit' name='submit' /></td></tr>";

echo "</form></table></center>";
*/


?>
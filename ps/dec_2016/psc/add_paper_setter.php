<?php


echo "<br/><br/><center><span style='color:#bd362f;font-weight:bold;font-size:20px'>Following Subjects Selected</span><br/><br/></center>";

echo "<center><table class='table table-hover table-striped table-bordered table-condensed'>
<form method='post' action=''>
<tr><td colspan='7'><input class='btn btn-danger btn-large btn-block btn-primary btn-info' type='submit' value='Edit' /></td>
<tr>
<th>Sr. No. </th>
<th>Program</th>
<th>Subject Code</th>
<th>Subject Title</th>
<th>M.Code</th>
<th>Paper ID</th>
</tr>";

$countr = 1;

if(isset($_POST['consent_submitted'])) {
	//mysql_query("DELETE FROM paper_setter_consent WHERE teacher_username='".$_SESSION['username']."'") or die(mysql_error());
	mysql_query("UPDATE paper_setter_consent SET backup='1' WHERE teacher_username='".$_SESSION['username']."'") or die(mysql_error());
}

for($i=1;$i<=$_POST['count'];$i++){
	
	if($_POST['consent'.$i]=='yes'){
		
		mysql_query("INSERT INTO  `paper_setter_consent` 
		(
		`course_code` ,
		`subject_code` ,
		`subject_title` ,
		`paper_id` ,
		`m_code` ,
		`teacher_consent` ,
		`teacher_username`,
		`ip`,
		`internal_external`,
		`backup`
		)
		
		VALUES (
		'".$_POST['course_code'.$i]."','".$_POST['subject_code'.$i]."',  '".$_POST['subject_title'.$i]."',  '".$_POST['paper_id'.$i]."',  '".$_POST['m_code'.$i]."',  '".$_POST['consent'.$i]."',  '".$_SESSION['username']."', '".$_SERVER['REMOTE_ADDR']."', '".$_SESSION['ie']."','0'
		);
		
		") or die(mysql_error());
		
	}
	
}

$added_subjects = mysql_query("SELECT * FROM paper_setter_consent WHERE teacher_username='".$_SESSION['username']."' AND backup='0'") or die(mysql_error());

while($row=mysql_fetch_assoc($added_subjects)) {
	
	$course_name = mysql_fetch_assoc(mysql_query("SELECT course_name FROM course_code WHERE course_code='".$row['course_code']."'")) or die(mysql_error());
	
	echo "<tr class='info'>
		<td>".$countr."</td>
		<td>".$course_name['course_name']."</td>
		<td>".$row['subject_code']."</td>
		<td>".$row['subject_title']."</td>
		<td>".$row['m_code']."</td>
		<td>".$row['paper_id']."</td>
		</tr>";
		$countr +=1;
}

echo "<form method='post' action=''>";

echo "<input type='hidden' name='edit'/>";

echo "<tr><td colspan='7'><input class='btn btn-danger btn-large btn-block btn-primary btn-info' type='submit' value='Edit' /></td></form>";

echo "</table></center>";

?>
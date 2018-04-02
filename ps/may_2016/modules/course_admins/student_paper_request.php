<?
if(isset($_POST['student_paper_request_detail']))
{
	echo "<center><h4>Detail List of Students (Paper See Request)</h4></center>";
echo "<table border='3' class='table table-bordered striped table-condensed container' >
	<tr style='background-color:lightgrey'>
	<th>University Roll No.</th>
	<th>Student Name</th>
	<th>Semester</th>
	<th>Paper ID</th>
	<th>Subject Code</th>
	<th>Subject Title</th>
	<th>Regular/Reappear</th>
	</tr>";
	$sql_user = "SELECT * from coe_external_attendance where paper_id='".$_POST['paper_id']."' and subject_code='".$_POST['subject_code']."' and semester='".$_POST['semester']."' and paper_see_request='Y' order by university_roll_no,regular_reappear ;";
	#echo $sql_user;
	$result_user = mysql_query($sql_user)  or  die(mysql_error());
	while ($row_user = mysql_fetch_array($result_user))
	{
		$sql_name = "SELECT StudentName from ptu_subjects where ED_RollNo='".$row_user['university_roll_no']."' limit 1;";
		$result_name = mysql_query($sql_name);
		$row_name = mysql_fetch_array($result_name);
		$name=$row_name['StudentName'];
		echo "<tr><td>".$row_user['university_roll_no']."</td>
		<td>".$name."</td>
		<td>".$row_user['semester']."</td>
		<td>".$row_user['paper_id']."</td>
		<td>".$row_user['subject_code']."</td>
		<td>".$row_user['subject_title']."</td>
		<td>".$row_user['regular_reappear']."</td>";

	}
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
	$row_branch = mysql_fetch_array($result_branch);
	$branch_code=$row_branch['branch_code'];
	echo "<center><h4>List of Paper Request by Students</h4></center>";
	echo "<table border='3' class='table table-bordered striped table-condensed container' >
	<tr style='background-color:lightgrey'>
	<th>Semester</th>
	<th>Paper ID</th>
	<th>Subject Code</th>
	<th>Subject Title</th>
	<th>Total Sheets</th>
	<th>Total Requests<br> Received</th>
	<th>Student Request Details</th>
	</tr>";
	$sql_user = "SELECT distinct paper_id,subject_code,subject_title,semester from coe_external_attendance where branch_code ='$branch_code'  order by semester,paper_id ASC;";

	$result_user = mysql_query($sql_user)  or  die(mysql_error());
	$count = mysql_num_rows($result_user);
	#echo $count;
	while ($row_user = mysql_fetch_array($result_user))
	{
		echo "<tr><td>".$row_user['semester']."</td>
		<td>".$row_user['paper_id']."</td>
		<td>".$row_user['subject_code']."</td>
		<td>".$row_user['subject_title']."</td>";
		
		$sql_total_sheet = "SELECT count('secerecy_code') as count from coe_external_attendance where paper_id='".$row_user['paper_id']."' and subject_code='".$row_user['subject_code']."' and semester='".$row_user['semester']."';";
		$result_total_sheet = mysql_query($sql_total_sheet)  or  die(mysql_error());
		$row_total_sheet = mysql_fetch_array($result_total_sheet);
		$total_sheets=$row_total_sheet['count'];
		
		$sql_request = "SELECT count('secerecy_code') as count from coe_external_attendance where paper_id='".$row_user['paper_id']."' and subject_code='".$row_user['subject_code']."' and semester='".$row_user['semester']."' and paper_see_request='Y';";
		$result_request = mysql_query($sql_request)  or  die(mysql_error());
		$row_request = mysql_fetch_array($result_request);
		$total_request=$row_request['count'];
		
		echo "<td>".$total_sheets."</td>
		<td>".$total_request."</td>";
		echo "
				<form method='post' action=''>
				<input type='hidden' name='student_paper_request_detail' value='student_paper_request_detail' />
				<input type='hidden' name='paper_id' value='".$row_user['paper_id']."' />
				<input type='hidden' name='subject_code' value='".$row_user['subject_code']."' />
				<input type='hidden' name='subject_title' value='".$row_user['subject_title']."' />
				<input type='hidden' name='semester' value='".$row_user['semester']."' />
				<td><button type='submit' name='submit' class='btn btn-danger'>Click to View Details</button></td></form></tr>";
		
	}
	echo "</table>";
}
?>

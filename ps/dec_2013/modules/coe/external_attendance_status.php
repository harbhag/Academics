<?php

if(isset($_POST['external_attendance_status_show']) && isset($_POST['roll_no']))
{
$sql="SELECT  *  FROM `student_external_marks` WHERE `university_roll_no`='".$_POST['roll_no']."'  order by `date_of_exam`";
#echo $sql;
$result = mysql_query($sql) or  die(mysql_error());

echo "<table    class='table table-bordered striped table-condensed container' >

<tr><td colspan='3'></td><td colspan='3' align='center'><h4>Student External Theory Attendance Status </h4></td><td colspan='2'></td></tr>
<tr style='background-color:lightgrey'><th >Uni Roll No.</th><th>Subject Code</th><th>Paper ID</th><th>Semester</th><th>Regular/Reappear</th><th>Attendance Status<br>(As per Forwarding Memo)</th><th>Detained <br>Status- Data</th><th>Date of Exam<br>(yyyy-mm-dd)</th><th>Centre</th><th>Session</th></tr>";

while ($row_result = mysql_fetch_array($result))
{
	echo  "<tr><td>".$row_result['university_roll_no']."</td><td>".$row_result['subject_code']."</td><td>".$row_result['paper_id']."</td><td>".$row_result['semester']."</td><td>".$row_result['regular_reappear']."</td><td>".$row_result['external_attendance_status']."</td>";
	
	$sql_detainee = "SELECT * from detainee_list where university_roll_no='".$row_result['university_roll_no']."' and paper_id='".$row_result['paper_id']."';";
	$result_detainee = mysql_query($sql_detainee);
	#echo $sql_detainee;
	#$test = mysql_num_rows($sql_detainee)."TEST";
	#echo $test;
	if (mysql_num_rows($result_detainee) == 1)
	{
		echo "<td>Detained</td>";
	}
	else
	{
	echo "<td></td>";	
	}
	echo "<td>".$row_result['date_of_exam']."</td><td>".$row_result['ucentre']."</td><td>".$row_result['usession']."</td></tr>";
}
echo "</table>";
}

else
{
echo "<center>

					<table>
					<form method='post' action=''>
					<tr><td colspan='2' align='center'><h4>Student External Theory Attendance Status</h4></td></tr>
							
					<tr><td>
					<span style='font-weight:bold'>University Roll No. </span>
					</td><td>
         <input type='text' class='input-xlarge' name='roll_no' id='roll_no' />
					</tr></td>
					<tr><td>
					<input type='hidden' name='external_attendance_status_show' value='external_attendance_status_show' />
					<button type='submit' name='submit' class='btn btn-large btn-danger'>Proceed</button>
					</tr></td>
         
				</form>
				</table>
		</center>";
  
}
?>

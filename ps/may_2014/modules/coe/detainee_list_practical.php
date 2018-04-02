<?php

show_label('info','Detainee List Practical');
echo "<br/>";

if(isset($_POST['detainee_list_practical']))
{
	$sql_detainee_list ="SELECT CONCAT( cc.course_name,  '(', bc.branch_name,  ')' ) AS Branch, `ED_RollNo` AS University_Roll_No, UPPER(  `StudentName` ) AS Student_Name,   `SUB_CODE` AS Subject_Code,  `SUB_TITLE` AS Subject_Title,  `Sub_Sem` AS Semester,  `Regular_Reappear` 
		FROM  `ptu_subjects` ps, course_code cc, branch_code bc
		WHERE  `detention_status` =  'Y'
		AND  `SUB_TP` =  'P'
		AND ps.course_code = cc.course_code
		AND bc.branch_code = ps.FRM_BRID
		AND ps.`eligibility` = 'Y'  
		AND ps.received_status='Y'
		ORDER BY  `FRM_BRID` , `Sub_Sem`, `ED_RollNo` ,  `Regular_Reappear`; ";
	}
	
	#echo $sql_detainee_list;
	$result_detainee_list = mysql_query($sql_detainee_list) or  die(mysql_error());
	echo "<center><h3>Detainee List (Practical) - As per Received Exam Form </h3></center>";
	echo "<table  class='table table-bordered striped table-condensed container' ><tr style='background-color:lightgrey'>
	<th>Sr. No.</th>
	<th>Course(Branch)</th> 
	<th>Sem.
	<th>Regular / Reappear
	<th>Subject Code</th>
	<th>Subject Title</th>
	<th>University Roll No.</th>
	<th>Student Name</th></tr>
	";
	$x=1;
	while($row_result = mysql_fetch_array($result_detainee_list))
		{
			echo "<tr><td>$x</td>
		
			<td>".$row_result['Branch']."</td>
			<td>".$row_result['Semester']."</td>
			<td>".$row_result['Regular_Reappear']."</td>
			<td>".$row_result['Subject_Code']."</td>
			<td>".$row_result['Subject_Title']."</td>
			<td>".$row_result['University_Roll_No']."</td>
			<td>".$row_result['Student_Name']."</td>
			</tr>";
			$x++;

		}



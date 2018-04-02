<?php

$sql ="SELECT  cc.course_name as course_name, bc.branch_name as branch_name,  `semester`,`scheme_code`, aicte_rc,full_part_time, 	compulsory_count , elective_count, total_count, six_month_training, leet_subject_status_disable,	subject_group  FROM subject_count as sc, course_code cc, branch_code bc where sc.course_code=cc.course_code and bc.branch_code= sc.branch_code order by sc.course_code, sc.branch_code, semester,`scheme_code`, aicte_rc, full_part_time; ";

$result= mysqli_query($mysqli_conn, $sql);

echo "<table  id='example' class='table table-bordered striped table-condensed container sortable' ><tr style='background-color:lightgrey'>
	<th>Course(Branch)</th> 
	<th>Semester
	<th>Scheme Code</th>
	<th>AICTE/RC</th>
	<th>Full / Part Time</th>
	<th>Compulsory Count</th>
	<th>Elective Count</th>
	<th>Total Count</th>
	<th>Six Month Training</th>
	<th>Leet Status</th>
	<th>Subject Group</th>
	</tr>";

while($row_result = mysqli_fetch_assoc($result))
{
echo "<tr><td>".$row_result['course_name']." ( ".$row_result['branch_name'].")</td><td>".$row_result['semester']."</td><td>".$row_result['scheme_code']."</td><td>".$row_result['aicte_rc']."</td><td>".$row_result['full_part_time']."</td><td>".$row_result['compulsory_count']."</td><td>".$row_result['elective_count']."</td>
<td>".$row_result['total_count']."</td>
<td>".$row_result['six_month_training']."</td>
<td>".$row_result['leet_subject_status_disable']."</td>
<td>".$row_result['subject_group']."</td>

</tr>";
}



?>

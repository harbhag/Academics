<?php
$fee_pending_sql="SELECT DISTINCT course_code.course_name ,  `branch_code`.branch_name ,  `aicte_rc` ,  `full_part_time` , semester , COUNT(  `college_roll_no` ) No_of_Students_Pending
FROM fee_not_paid fnp, course_code, branch_code
WHERE fnp.course_code = course_code.course_code
AND fnp.branch_code = branch_code.branch_code
GROUP BY fnp.`course_code` , fnp.`branch_code` ,  `aicte_rc` ,  `full_part_time` , semester
ORDER BY fnp.course_code, fnp.branch_code, aicte_rc, full_part_time, semester";
$result_fee_pending=mysql_query($fee_pending_sql);
show_label('info','Fee Pending Summary');

$count="SELECT count(*) as total_count FROM `fee_not_paid`";
$result_count=mysql_query($count);
?>
<br />
<table class='table table-bordered table-condensed container sortable'>
	<tr class='warning'>
		<th>Course</th>
		<th>Branch 
		<th>AICTE / RC
		<th>Full / Part Time</th>
		<th>Semester</th>
		<th>No. of students pending</th>
		</tr>
<?
while($row_fee_pending = mysql_fetch_assoc($result_fee_pending)) 
{
	echo "<tr><td>".$row_fee_pending['course_name']."</td>
	<td>".$row_fee_pending['branch_name']."</td>
	<td>".$row_fee_pending['aicte_rc']."</td>
	<td>".$row_fee_pending['full_part_time']."</td>
	<td>".$row_fee_pending['semester']."</td>	
	<td>".$row_fee_pending['No_of_Students_Pending']."</td>
</tr>	";
}		
$row_count = mysql_fetch_assoc($result_count);
echo "<tr><td colspan='5'><b>Total </td><td><b>".$row_count['total_count']."</td></tr></table>"

?>

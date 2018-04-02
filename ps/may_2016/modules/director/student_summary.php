<?php
#$student_summary_sql="Select distinct cc.course_name,bc.branch_name,shift,aicte_rc,full_part_time,semester,count(university_roll_no) as number_of_students from student_info si, course_code cc, branch_code bc where  student_status='Onroll' and bc.branch_code= si.branch_code and si.course_code=cc.course_code group by si.course_code,si.branch_code,shift,aicte_rc,full_part_time,semester";
$student_summary_sql="Select distinct cc.course_name,bc.branch_name,shift,aicte_rc,full_part_time,semester,sum(case when gender = 'Male' then 1 else 0 end) Boys,
  sum(case when gender = 'Female' then 1 else 0 end) Girls,
count(university_roll_no) as number_of_students from student_info si, course_code cc, branch_code bc where  student_status='Onroll' and bc.branch_code= si.branch_code and si.course_code=cc.course_code  group by si.course_code,si.branch_code,shift,aicte_rc,full_part_time,semester";

$result_student_summary=mysql_query($student_summary_sql);
show_label('info','Student Summary');

$count="SELECT count(*) as total_count FROM student_info   where  student_status='Onroll' ";
$result_count=mysql_query($count);

$count_boys="SELECT count(*) as boys_count FROM student_info   where  student_status='Onroll' and gender='Male' ";
$result_count_boys=mysql_query($count_boys);

$count_girls="SELECT count(*) as girls_count FROM student_info   where  student_status='Onroll' and gender='Female' ";
$result_count_girls=mysql_query($count_girls);
?>
<br />
<table class='table table-bordered table-condensed container sortable'>
	<tr class='warning'>
		<th>Course</th>
		<th>Branch 
		<th>Shift
		<th>AICTE / RC
		<th>Full / Part Time</th>
		<th>Semester</th>
		<th>Boys</th>
		<th>Girls</th>
		<th>No. of students</th>
		</tr>
<?
while($row_student_summary = mysql_fetch_assoc($result_student_summary)) 
{
	echo "<tr><td>".$row_student_summary['course_name']."</td>
	<td>".$row_student_summary['branch_name']."</td>
	<td>".$row_student_summary['shift']."</td>
	<td>".$row_student_summary['aicte_rc']."</td>
	<td>".$row_student_summary['full_part_time']."</td>
	<td>".$row_student_summary['semester']."</td>	
	<td>".$row_student_summary['Boys']."</td>	
	<td>".$row_student_summary['Girls']."</td>	
	<td>".$row_student_summary['number_of_students']."</td>
</tr>	";
}		
$row_count = mysql_fetch_assoc($result_count);
$row_count_girls = mysql_fetch_assoc($result_count_girls);
$row_count_boys = mysql_fetch_assoc($result_count_boys);
echo "<tr><td colspan='6'><b>Total </td><td>".$row_count_boys['boys_count']."</td><td>".$row_count_girls['girls_count']."</td><td><b>".$row_count['total_count']."</td></tr></table>"

?>

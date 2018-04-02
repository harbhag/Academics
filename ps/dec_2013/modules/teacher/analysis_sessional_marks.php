<table class='table table-bordered table-condensed container'>
	<? echo "<tr><td><b>Subject Title: </b> ".$_POST['subject_title']."</td><td><b>Subject Code:</b> ".$_POST['subject_code']."  </td><td><b>Semester:</b> ".$_POST['semester']."</td><td> <b>Sessional No.:</b> ".$_POST['sessional_no']." </td><td><b>Section:</b> ".$_POST['ssection']."</td></tr></table>";
$result_iqs=mysql_query("select * from  internal_question_structure where course_code='".$_POST['course_code']."' and ass_tool='S';");

$num_iqs= mysql_num_rows($result_iqs);

$analysis_sql .="select distinct `course_code`,`branch_code`, `subject_code`,`m_code`,`subject_title`,`shift`,sessional_no,`full_part_time`,`aicte_rc`,`exam_month`,`exam_year`,`paper_id`,`semester`,`ssection`,`teacher_username`,count(`m_code`) 
Total_Students,sum(case when `attendance_status`='Present'  then 1 end) Appeared, ";

for($x=1;$x<=$num_iqs;$x++) 
{
$analysis_sql .="sum(case when `q$x` >=0.60* mmq$x and  `attendance_status`='Present'  and `q$x` <0.70* mmq$x  then 1 end) as Number_of_cand_60_70_Q$x,
sum(case when `q$x` >=0.70* mmq$x and  `attendance_status`='Present'  and `q$x` <0.80* mmq$x  then 1 end) as Number_of_cand_70_80_Q$x,
sum(case when `q$x` >=0.80* mmq$x and  `attendance_status`='Present'  and `q$x` <0.90* mmq$x  then 1 end) as Number_of_cand_80_90_Q$x,
sum(case when `q$x` >=0.70* mmq$x and  `attendance_status`='Present'  then 1 end) as Number_of_cand_70_Q$x,
avg(case when `attendance_status`='Present' then `q$x`*100/ mmq$x end) as average_q$x,";
}
$analysis_sql .="sum(case when `obtained_marks` >=0.40* ";

if ($_POST['course_code']=='1')
{
$analysis_sql .="(24)";
}
else
{
$analysis_sql .="(30)";
}

$analysis_sql .= " and  `attendance_status`='Present'  then 1 end) as Number_of_pass,sum(case when `obtained_marks` <0.40* ";


if ($_POST['course_code']=='1')
{
$analysis_sql .="(24)";
}
else
{
$analysis_sql .="(30)";
}

$analysis_sql .= " then 1 end) as Number_of_fail from student_sessionals_record where course_code='".$_POST['course_code']."' AND
		branch_code='".$_POST['branch_code']."' AND
		shift='".$_POST['shift']."' AND
		ssection='".$_POST['ssection']."' AND
		semester='".$_POST['semester']."' AND
		paper_id='".$_POST['paper_id']."' AND
		teacher_username='".$_SESSION['username']."' AND
		subject_code='".$_POST['subject_code']."' AND
		exam_month='".$_POST['exam_month']."' AND
		exam_year='".$_POST['exam_year']."' AND
		aicte_rc='".$_POST['aicte_rc']."' AND
		full_part_time='".$_POST['full_part_time']."' AND backup='0' and sessional_no='".$_POST['sessional_no']."' group by `course_code`,`branch_code`, `subject_code`,`m_code`,`subject_title`,`shift`,sessional_no,`full_part_time`,`aicte_rc`,`exam_month`,`exam_year`,`paper_id`,`semester`,`ssection`,`teacher_username`; ";


#echo $analysis_sql;
$analysis_result = mysql_query($analysis_sql) or die(mysql_error());
#$rows=array();
$info= mysql_fetch_assoc($analysis_result);
echo "<table class='table table-bordered table-condensed container sortable'>";
echo "<tr bgcolor='lightgrey'><th>Detail</th><th>Results Analysis</th></tr>
<tr><th>Total Students</th><td>".$info['Total_Students']."</td></tr>
<tr><th>Appeared Students</th><td>".$info['Appeared']."</td></tr>
<tr><th>Number of Pass</th><td>".$info['Number_of_pass']."</td></tr>
<tr><th>Number of fail</th><td>".$info['Number_of_fail']."</td></tr>";
for($x=1;$x<=$num_iqs;$x++) 
{
	echo  "<tr><th> Average Question $x</th><td>".round($info['average_q'.$x],2)." %</td>";
echo "<tr><th>Number of students (60-70)% Question No.: ".$x."</th><td>".$info['Number_of_cand_60_70_Q'.$x]."</td></tr>";
echo "<tr><th>Number of students (70-80)% Question No.: $x</th><td>".$info['Number_of_cand_70_80_Q'.$x]."</td></tr>";
echo "<tr><th>Number of students (80-90)% Question No.: $x</th><td>".$info['Number_of_cand_80_90_Q'.$x]."</td></tr>";
echo "<tr><th>Number of students above 70% Question No.: $x</th><td>".$info['Number_of_cand_70_Q'.$x]."</td></tr>";
}


/*
$info=mysql_fetch_array($analysis_result);// Changed from MYSQL_NUM to MYSQL_ASSOC, to provide headers
  foreach($info as $key=>$val)
  {
      $rows[$key][]=$val;
  }


foreach($rows as $header=>$row) // Grab the header names from each column
{
 echo "<tr><td>$header</td>";
  foreach($row as $cell)
  {
    echo "<td>$cell</td>";
  }
  echo "</tr>";
}
*/



$roll_nos = mysql_query("SELECT DISTINCT university_roll_no FROM student_sessionals_record WHERE
		course_code='".$_POST['course_code']."' AND
		branch_code='".$_POST['branch_code']."' AND
		shift='".$_POST['shift']."' AND
		ssection='".$_POST['ssection']."' AND
		semester='".$_POST['semester']."' AND
		teacher_username='".$_SESSION['username']."' AND
		subject_code='".$_POST['subject_code']."' AND
		exam_month='".$_POST['exam_month']."' AND
		exam_year='".$_POST['exam_year']."' AND
		aicte_rc='".$_POST['aicte_rc']."' AND
		full_part_time='".$_POST['full_part_time']."' AND
		backup='0' 
		ORDER BY university_roll_no ASC") or die(mysql_error());


if(mysql_num_rows($roll_nos)==0) {
	show_label('info','No Record Found !');
	exit();
}

$count = 1;
while($row = mysql_fetch_assoc($roll_nos)) {
	
	$student_details = fetch_resource_db('student_info',array('university_roll_no'),array($row['university_roll_no']),'resource_array','');
	
	$details1 = fetch_resource_db('student_sessionals_record',array('university_roll_no','sessional_no','backup','subject_code'),array($row['university_roll_no'],'1','0',$_POST['subject_code']),'resource_array','');
	
	$details2 = fetch_resource_db('student_sessionals_record',array('university_roll_no','sessional_no','backup','subject_code'),array($row['university_roll_no'],'2','0',$_POST['subject_code']),'resource_array','');
	
	$details3 = fetch_resource_db('student_sessionals_record',array('university_roll_no','sessional_no','backup','subject_code'),array($row['university_roll_no'],'3','0',$_POST['subject_code']),'resource_array','');
	
	
}

// Print Button for All Sesssional detail
//START
?>
</table>


<?php 

//if($details['internal_lock_status']==1) {
	//echo "<input type='submit' class='btn btn-block btn-danger' value='Click Here To Print Record'/>";
//}
//END  
?>
</form>



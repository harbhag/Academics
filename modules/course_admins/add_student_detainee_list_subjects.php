<?php

$course_branch = explode(',',$_POST['course_branch']);

$subcodes1 = explode(",",$_POST['subjects']);

$subcodes2 = array();

foreach($subcodes1 as $i) {
	$subcodes2 [] = "'$i'";
}

$subcodes = implode(",",$subcodes2);


$student_data_si_sql = mysql_query("SELECT * FROM student_info WHERE 
university_roll_no='".$_POST['university_roll_no']."' AND
course_code = '".$course_branch[0]."' AND
branch_code = '".$course_branch[1]."' AND
aicte_rc = '".$_POST['aicte_rc']."' AND
full_part_time = '".$_POST['ft_pt']."'
") or die(mysql_error());

if(mysql_num_rows($student_data_si_sql)!=1) {
	show_label('important','No Record found for University Roll No. '.$_POST['university_roll_no']);
	exit();
}

$student_data_si = mysql_fetch_assoc($student_data_si_sql);


if($student_data_si['student_status']=='Ex') {
	
	if(($_POST['semester']==1 || $_POST['semester']==2) && ($course_branch[0]==1)) {
		
		$sub_sems = mysql_query("SELECT DISTINCT semester FROM scheme_master WHERE
		course_code = '".$course_branch[0]."' AND
		branch_code = '".$course_branch[1]."' AND
		aicte_rc = '".$_POST['aicte_rc']."' AND
		scheme_code='".$student_data_si['scheme_code_first_year']."' AND
		semester = '".$_POST['semester']."' AND
		theory_practical = '".$_POST['theory_practical']."' AND
		full_part_time = '".$_POST['ft_pt']."' AND
		subject_code IN ($subcodes) ORDER BY semester ASC") or die(mysql_error());
		
	}
	else {
		
		$sub_sems = mysql_query("SELECT DISTINCT semester FROM scheme_master WHERE
		course_code = '".$course_branch[0]."' AND
		branch_code = '".$course_branch[1]."' AND
		aicte_rc = '".$_POST['aicte_rc']."' AND
		scheme_code='".$student_data_si['scheme_code_branch']."' AND
		semester = '".$_POST['semester']."' AND
		theory_practical = '".$_POST['theory_practical']."' AND
		full_part_time = '".$_POST['ft_pt']."' AND
		subject_code IN ($subcodes) ORDER BY semester ASC") or die(mysql_error());
		
	}
		
}
else {
	
	if(($_POST['semester']==1 || $_POST['semester']==2) && ($course_branch[0]==1)) {
		
		$sub_sems = mysql_query("SELECT DISTINCT semester FROM scheme_master WHERE
		course_code = '".$course_branch[0]."' AND
		branch_code = '".$course_branch[1]."' AND
		aicte_rc = '".$_POST['aicte_rc']."' AND
		scheme_code='".$student_data_si['scheme_code_first_year']."' AND
		semester <= '".$student_data_si['semester']."' AND
		semester = '".$_POST['semester']."' AND
		theory_practical = '".$_POST['theory_practical']."' AND
		full_part_time = '".$_POST['ft_pt']."' AND
		subject_code IN ($subcodes) ORDER BY semester ASC") or die(mysql_error());
		
	}
	
	else {
		
		$sub_sems = mysql_query("SELECT DISTINCT semester FROM scheme_master WHERE
		course_code = '".$course_branch[0]."' AND
		branch_code = '".$course_branch[1]."' AND
		aicte_rc = '".$_POST['aicte_rc']."' AND
		scheme_code='".$student_data_si['scheme_code_branch']."' AND
		semester <= '".$student_data_si['semester']."' AND
		semester = '".$_POST['semester']."' AND
		theory_practical = '".$_POST['theory_practical']."' AND
		full_part_time = '".$_POST['ft_pt']."' AND
		subject_code IN ($subcodes) ORDER BY semester ASC") or die(mysql_error());

		
	}
	
}



while($row = mysql_fetch_assoc($sub_sems)) {
	$previous_sems1[] = $row['semester'];
}

$course = fetch_resource_db('course_code',array('course_code'),array($course_branch[0]),'resource_array_value','course_name');
$branch = fetch_resource_db('branch_code',array('branch_code'),array($course_branch[1]),'resource_array_value','branch_name');

if($course_branch[0]==2) {
	$course_name = $course."(".$student_data_si['full_part_time']."-".$student_data_si['aicte_rc'].")";
}
else {
	$course_name = $course;
}

$count = 1;

?>

<center>
	<table class='styled'>
		
		<tr>
		<td class='td-colored-back'>Name</td>
		<td class='td-text'><?php echo $student_data_si['ptu_student_name']; ?></td>
		</tr>
		
		<tr>
		<td class='td-colored-back'>Father's Name</td>
		<td class='td-text'><?php echo $student_data_si['ptu_father_name']; ?></td>
		</tr>
		
		<tr>
		<td class='td-colored-back'>Course</td>
		<td class='td-text'><?php echo $course_name; ?></td>
		</tr>
		
		<tr>
		<td class='td-colored-back'>Branch</td>
		<td class='td-text'><?php echo $branch; ?></td>
		</tr>
		
		<tr>
		<td class='td-colored-back'>University Roll No.</td>
		<td class='td-text'><?php echo $_POST['university_roll_no']; ?></td>
		</tr>
		
		<tr>
		<td class='td-colored-back'>Semester</td>
		<td class='td-text'><?php echo $student_data_si['semester']; ?></td>
		</tr>
		
	</table>
</center>

<br/>
<center><div id='rp_exam_form_td'>
	<form action='' method='post' >
	<table width='90%'>
		
		

<?php 

if(mysql_num_rows($sub_sems)!=1) {
	show_label('important','No Subject found.');
	exit();
}

echo "<br/>";

foreach($previous_sems1 as $semester) {
	$scount = 1;
	
	if($student_data_si['student_status']=='Ex') {
		if(($semester==1 || $semester==2) && ($course_branch[0]==1)) {
			
			$previous_subjects_sql = mysql_query("SELECT * FROM scheme_master WHERE
			course_code = '".$course_branch[0]."' AND
			branch_code = '".$course_branch[1]."' AND
			semester = '".$semester."' AND
			scheme_code='".$student_data_si['scheme_code_first_year']."' AND
			aicte_rc = '".$_POST['aicte_rc']."' AND
			full_part_time = '".$_POST['ft_pt']."' AND
			theory_practical = '".$_POST['theory_practical']."' AND
			subject_code IN ($subcodes) ORDER BY semester ASC") or die(mysql_error());
			
		}
		
		else {
			
			$previous_subjects_sql = mysql_query("SELECT * FROM scheme_master WHERE
			course_code = '".$course_branch[0]."' AND
			branch_code = '".$course_branch[1]."' AND
			semester = '".$semester."' AND
			scheme_code='".$student_data_si['scheme_code_branch']."' AND
			aicte_rc = '".$_POST['aicte_rc']."' AND
			full_part_time = '".$_POST['ft_pt']."' AND
			theory_practical = '".$_POST['theory_practical']."' AND
			subject_code IN ($subcodes) ORDER BY semester ASC") or die(mysql_error());
			
		}
		
	}
	else {
		
		if(($semester==1 || $semester==2) && ($course_branch[0]==1)) {
			
			$previous_subjects_sql = mysql_query("SELECT * FROM scheme_master WHERE
			course_code = '".$course_branch[0]."' AND
			branch_code = '".$course_branch[1]."' AND
			scheme_code='".$student_data_si['scheme_code_first_year']."' AND
			semester<='".$student_data_si['semester']."' AND
			semester = '".$_POST['semester']."' AND
			aicte_rc = '".$_POST['aicte_rc']."' AND
			full_part_time = '".$_POST['ft_pt']."' AND
			theory_practical = '".$_POST['theory_practical']."' AND
			subject_code IN ($subcodes) ORDER BY semester ASC") or die(mysql_error());
			
		}
		else {
			
			$previous_subjects_sql = mysql_query("SELECT * FROM scheme_master WHERE
			course_code = '".$course_branch[0]."' AND
			branch_code = '".$course_branch[1]."' AND
			scheme_code='".$student_data_si['scheme_code_branch']."' AND
			semester<='".$student_data_si['semester']."' AND
			semester = '".$_POST['semester']."' AND
			aicte_rc = '".$_POST['aicte_rc']."' AND
			full_part_time = '".$_POST['ft_pt']."' AND
			theory_practical = '".$_POST['theory_practical']."' AND
			subject_code IN ($subcodes) ORDER BY semester ASC") or die(mysql_error());
			
		}
		
	}
	
	
	echo "<tr>
					<th class='th-colored-back'>Sr. No.</th>
					<!--<th class='th-colored-back'>Semester</th>-->
					<th class='th-colored-back'>Subject Code</th>
					<th class='th-colored-back'>Paper ID</th>
					<th class='th-colored-back'>Subject Title</th>
					<th class='th-colored-back'>Subject Type<br/>(Compulsary/Open Elective/Elective)</th>
					<th class='th-colored-back'>Theory/Practical</th>
					<th class='th-colored-back'>Scheme Code</th>
				</tr>";
	echo "<tr><td colspan='7' style='padding:15px;text-align:center;'><span style='font-size:25px;font-weight:bold;color:#BC091A'> SEMESTER - ".$semester."</span></td></tr>";
	
	
	
	while($row = mysql_fetch_assoc($previous_subjects_sql)) {

		echo "<tr>
		<td>".$scount."</td>
		<!--<td>".$row['semester']."</td>-->
		<td>".$row['subject_code']."</td>
		<td>".$row['paper_id']."</td>
		<td>".$row['subject_title']."</td>
		<td>".$row['elective_details']."</td>
		<td>".$row['theory_practical']."</td>
		<td>".$row['scheme_code']."</td>";
		echo "</tr>";
		echo "<input type='hidden' id='sub".$count."' name='sub".$count."' value='".$row['scheme_master_id']."'/>";
		$count++;
		$scount++;
	}
	
}

?>
</table>
<br/>
<br/>
<br/>
<input type='submit' class='btn btn-big btn-info' value='Add student to Detainee List' onclick="return confirm_action('Do you want to continue ?')"/>
<input type='hidden' id='total_count' name='total_count' value='<?php echo $count; ?>' />
<input type='hidden' id='course_code' name='course_code' value='<?php echo $course_branch[0]; ?>' />
<input type='hidden' id='branch_code' name='branch_code' value='<?php echo $course_branch[1]; ?>' />
<input type='hidden' id='university_roll_no' name='university_roll_no' value='<?php echo $_POST['university_roll_no']; ?>' />
<input type='hidden' id='exam_month' name='exam_month' value='<?php echo $_POST['exam_month']; ?>' />
<input type='hidden' id='exam_year' name='exam_year' value='<?php echo $_POST['exam_year']; ?>' />
<input type='hidden' id='add_student_detainee_list' name='add_student_detainee_list' value='' />
</form>
</div>
</center>

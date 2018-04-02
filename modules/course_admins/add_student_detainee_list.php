<?php

$count = 0;

for($i=1;$i<$_POST['total_count'];$i++) {
	
	$data_sql = mysql_query("SELECT * FROM scheme_master WHERE scheme_master_id='".$_POST['sub'.$i]."'") or die(mysql_error());
	$data = mysql_fetch_assoc($data_sql);
	
	$dup = mysql_query("SELECT * FROM detainee_list WHERE 
	university_roll_no='".$_POST['university_roll_no']."' AND 
	subject_code='".$data['subject_code']."' AND
	detained_status='Y'") or die(mysql_error());
	
	if(mysql_num_rows($dup)!=0) {
		continue;
	}
	
	$student_data_si_sql = mysql_query("SELECT * FROM student_info WHERE 
	university_roll_no='".$_POST['university_roll_no']."'
	") or die(mysql_error());
	
	$student_data_si = mysql_fetch_assoc($student_data_si_sql);

	mysql_query("INSERT INTO detainee_list
	(
	`course_code` ,
	`branch_code` ,
	`university_roll_no` ,
	`semester` ,
	`sname` ,
	`fname` ,
	`mname` ,
	`theory_practical` ,
	`subject_code` ,
	`m_code` ,
	`paper_id` ,
	`subject_title` ,
	`scheme_code` ,
	`detained_status` ,
	`d_exam_month` ,
	`d_exam_year` ,
	`detained_by` ,
	`detained_on` 
	)

	VALUES (
	'".$_POST['course_code']."',
	'".$_POST['branch_code']."',
	'".$_POST['university_roll_no']."',
	'".$data['semester']."',
	'".$student_data_si['ptu_student_name']."',
	'".$student_data_si['ptu_father_name']."',
	'".$student_data_si['ptu_mother_name']."',
	'".$data['theory_practical']."',
	'".$data['subject_code']."',
	'".$data['m_code']."',
	'".$data['paper_id']."',
	'".$data['subject_title']."',
	'".$data['scheme_code']."',
	'Y',
	'".$_POST['exam_month']."',
	'".$_POST['exam_year']."',
	'".$_SESSION['username']."',
	'".date('Y-m-d H:i:s')."'
	)") or die(mysql_error());
	$count++;

}

show_label('success','Detainee List Successfully Updated. Total '.$count.' Record(s) changed.');

?>

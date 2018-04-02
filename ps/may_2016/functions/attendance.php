<?php
function teacher_mark_attendance() {
	
	//echo $_POST['cbs_grading_type'];
	
	if($_POST['cbs_total_students']<30)
	{
		$_POST['cbs_grading_type'] ='Absolute';
	}
	else
	{
		$_POST['cbs_grading_type'] ='Relative';
	}
	
	if($_POST['cbs_total_students']==0)
	{
		$_POST['cbs_grading_type'] ='N/A';
	}
		
		//echo $_POST['cbs_total_students'];
		//echo $_POST['cbs_grading_type'];
	$data_sm_sql = mysql_query("SELECT * FROM subject_master WHERE subject_master_id='".$_POST['subject_master_id']."'") or die(mysql_error());
	$data_sm = mysql_fetch_assoc($data_sm_sql);
	
	if($_POST['internal_external']=='I') {
		$total_count = $_POST['total_count'];
		$time = date("Y-m-d H:i:s");
		
		if($_POST['theory_practical']=='T') {
			
			$field_string = "branch_code,course_code,aicte_rc,shift,full_part_time,exam_month,exam_year,student_name,college_roll_no,university_roll_no,theory_practical,subject_code,m_code,paper_id,semester,internal_max_marks,internal_attendance_status,external_attendance_status,regular_reappear,teacher_username,attendance_last_updated_on,internal_external,subject_master_id,grading_type,mean,std_dev,total_students,grade_letter";

					
		}
				
		if($_POST['theory_practical']=='P') {
			
			$field_string = "branch_code,course_code,aicte_rc,shift,full_part_time,exam_month,exam_year,student_name,college_roll_no,university_roll_no,theory_practical,subject_code,m_code,paper_id,semester,internal_max_marks,internal_attendance_status,external_attendance_status,regular_reappear,teacher_username,attendance_last_updated_on,internal_external,subject_master_id,grading_type,mean,std_dev,total_students,grade_letter";

					
		}
	
		
		
		
		
		if($_POST['theory_practical']=='T') {
			$internal_attendance_status = fetch_resource_db('student_internal_marks', 
			array(
			'university_roll_no',
			'course_code',
			'exam_year',
			'exam_month',
			'branch_code',
			'semester',
			'subject_code',
			'theory_practical',
			'regular_reappear',
			'teacher_username',
			'full_part_time',
			'internal_external',
			'paper_id'), 
			array(
			$_POST['university_roll_no1'],
			$_POST['course_code'],
			$_POST['exam_year'],
			$_POST['exam_month'],
			$_POST['branch_code'],
			$_POST['semester'],
			$_POST['subject_code'],
			$_POST['theory_practical'],
			$_POST['regular_reappear'],
			$_SESSION['username'],
			$_POST['full_part_time'],
			$_POST['internal_external'],
			$_POST['paper_id']),'resource_array_value','internal_attendance_status');
		
		}
		if($_POST['theory_practical']=='P') {
			$internal_attendance_status = fetch_resource_db('student_internal_marks', 
			array(
			'university_roll_no',
			'course_code',
			'exam_year',
			'exam_month',
			'branch_code',
			'semester',
			'subject_code',
			'theory_practical',
			'regular_reappear',
			'teacher_username',
			'full_part_time',
			'internal_external'), 
			array(
			$_POST['university_roll_no1'],
			$_POST['course_code'],
			$_POST['exam_year'],
			$_POST['exam_month'],
			$_POST['branch_code'],
			$_POST['semester'],
			$_POST['subject_code'],
			$_POST['theory_practical'],
			$_POST['regular_reappear'],
			$_SESSION['username'],
			$_POST['full_part_time'],
			$_POST['internal_external']),'resource_array_value','internal_attendance_status');
		}
	
		
		
		
		
		
		for($i=1;$i<=$total_count-1;$i++) {
		//$value_string = "'".$_POST['college_roll_no'.$i].",".$_POST['university_roll_no'.$i].",'".$_POST['theory_practical']."',".$_POST['semester'].",".$_POST['subject_code'].",".$_POST['internal_max_marks'].",".$_POST['attendance'.$i].",".$_POST['regular_reappear'].",".$_SESSION['username'];
		
		
		//$sql = "INSERT INTO student_internal_marks ($field_string) VALUES ($value_string)";
		//echo "<br/>".$sql;
			if($internal_attendance_status!='') {
				
				if($_POST['theory_practical']=='T') {
					
					if($_POST['attendance'.$i]=='Detained') {
						$grade_letterr = 'E';
					}
					else {
						$grade_letterr = '';
					}
					
					mysql_query("UPDATE student_internal_marks SET 
					internal_attendance_status='".$_POST['attendance'.$i]."',
					external_attendance_status='".$_POST['attendance'.$i]."',
					grading_type='".$_POST['cbs_grading_type']."',
					grade_letter='".$grade_letterr."',
					mean='".$_POST['cbs_mean']."',
					std_dev='".$_POST['cbs_std_dev']."',
					total_students='".$_POST['cbs_total_students']."',
					attendance_last_updated_on='".date("Y-m-d H:i:s")."' 
					
					WHERE
					branch_code = '".$_POST['branch_code']."' AND
					course_code = '".$_POST['course_code']."' AND
					aicte_rc = '".$_POST['aicte_rc']."' AND
					shift = '".$_POST['shift']."' AND
					university_roll_no = '".$_POST['university_roll_no'.$i]."' AND
					subject_code = '".$_POST['subject_code']."' AND
					exam_month = '".$_POST['exam_month']."' AND
					exam_year = '".$_POST['exam_year']."' AND
					theory_practical = '".$_POST['theory_practical']."' AND
					semester = '".$_POST['semester']."' AND
					internal_max_marks = '".$_POST['internal_max_marks']."' AND
					regular_reappear = '".$_POST['regular_reappear']."' AND
					full_part_time = '".$_POST['full_part_time']."' AND
					internal_external = '".$_POST['internal_external']."' AND
					teacher_username = '".$_SESSION['username']."' AND
					paper_id='".$_POST['paper_id']."'") or die(mysql_error());
					
					$ias = fetch_resource_db('student_internal_marks',array('subject_master_id'),array($_POST['subject_master_id']),'resource_array_value','internal_attendance_status');
					
					if($ias==0) {
						mysql_query("UPDATE subject_master SET internal_attendance_status=1 WHERE subject_master_id='".$_POST['subject_master_id']."'") or die(mysql_error());
					}
					
				}
				
				if($_POST['theory_practical']=='P') {
					
					if($_POST['attendance'.$i]=='Detained') {
						$grade_letterr = 'E';
					}
					else {
						$grade_letterr = '';
					}
					
					mysql_query("UPDATE student_internal_marks SET 
					internal_attendance_status='".$_POST['attendance'.$i]."',
					external_attendance_status='".$_POST['attendance'.$i]."',
					grading_type='".$_POST['cbs_grading_type']."',
					grade_letter='".$grade_letterr."',
					mean='".$_POST['cbs_mean']."',
					std_dev='".$_POST['cbs_std_dev']."',
					total_students='".$_POST['cbs_total_students']."',
					attendance_last_updated_on='".date("Y-m-d H:i:s")."' WHERE
					branch_code = '".$_POST['branch_code']."' AND
					course_code = '".$_POST['course_code']."' AND
					aicte_rc = '".$_POST['aicte_rc']."' AND
					shift = '".$_POST['shift']."' AND
					university_roll_no = '".$_POST['university_roll_no'.$i]."' AND
					subject_code = '".$_POST['subject_code']."' AND
					exam_month = '".$_POST['exam_month']."' AND
					exam_year = '".$_POST['exam_year']."' AND
					theory_practical = '".$_POST['theory_practical']."' AND
					semester = '".$_POST['semester']."' AND
					internal_max_marks = '".$_POST['internal_max_marks']."' AND
					regular_reappear = '".$_POST['regular_reappear']."' AND
					full_part_time = '".$_POST['full_part_time']."' AND
					internal_external = '".$_POST['internal_external']."' AND
					teacher_username = '".$_SESSION['username']."'") or die(mysql_error());
					
					$ias = fetch_resource_db('student_internal_marks',array('subject_master_id'),array($_POST['subject_master_id']),'resource_array_value','internal_attendance_status');
					
					if($ias==0) {
						mysql_query("UPDATE subject_master SET internal_attendance_status=1 WHERE subject_master_id='".$_POST['subject_master_id']."'") or die(mysql_error());
					}
					
				}
				
				
			}
			if($internal_attendance_status=='') {
				
				if($_POST['theory_practical']=='T') {
					
					if($_POST['attendance'.$i]=='Detained') {
						$grade_letterr = 'E';
					}
					else {
						$grade_letterr = '';
					}
					
					mysql_query("INSERT INTO student_internal_marks ($field_string) 
					VALUES ('".$_POST['branch_code']."',
					'".$_POST['course_code']."',
					'".$_POST['aicte_rc']."',
					'".$_POST['shift']."',
					'".$_POST['full_part_time']."',
					'".$_POST['exam_month']."',
					'".$_POST['exam_year']."',
					'".$_POST['student_name'.$i]."',
					'".$_POST['college_roll_no'.$i]."',
					'".$_POST['university_roll_no'.$i]."',
					'".$_POST['theory_practical']."',
					'".$_POST['subject_code']."',
					'".$data_sm['m_code']."',
					'".$_POST['paper_id']."',
					'".$_POST['semester']."',
					'".$_POST['internal_max_marks']."',
					'".$_POST['attendance'.$i]."',
					'".$_POST['attendance'.$i]."',
					'".$_POST['regular_reappear']."',
					'".$_SESSION['username']."',
					'".date("Y-m-d H:i:s")."',
					'".$_POST['internal_external']."',
					'".$_POST['subject_master_id']."',
					'".$_POST['cbs_grading_type']."',
					'".$_POST['cbs_mean']."',
					'".$_POST['cbs_std_dev']."',
					'".$_POST['cbs_total_students']."',
					'".$grade_letterr."'
					)") or die(mysql_error());
					
					mysql_query("UPDATE subject_master SET internal_attendance_status=1 WHERE
					branch_code = '".$_POST['branch_code']."' AND
					course_code = '".$_POST['course_code']."' AND
					aicte_rc = '".$_POST['aicte_rc']."' AND
					shift = '".$_POST['shift']."' AND
					subject_code = '".$_POST['subject_code']."' AND
					exam_month = '".$_POST['exam_month']."' AND
					exam_year = '".$_POST['exam_year']."' AND
					theory_practical = '".$_POST['theory_practical']."' AND
					full_part_time = '".$_POST['full_part_time']."' AND
					semester = '".$_POST['semester']."' AND
					internal_max_marks = '".$_POST['internal_max_marks']."' AND
					regular_reappear = '".$_POST['regular_reappear']."' AND
					teacher_username = '".$_SESSION['username']."' AND
					paper_id='".$_POST['paper_id']."'") or die(mysql_error());
					
				}
				
				if($_POST['theory_practical']=='P') {
					
					if($_POST['attendance'.$i]=='Detained') {
						$grade_letterr = 'E';
					}
					else {
						$grade_letterr = '';
					}
					
					mysql_query("INSERT INTO student_internal_marks ($field_string) 
					VALUES ('".$_POST['branch_code']."',
					'".$_POST['course_code']."',
					'".$_POST['aicte_rc']."',
					'".$_POST['shift']."',
					'".$_POST['full_part_time']."',
					'".$_POST['exam_month']."',
					'".$_POST['exam_year']."',
					'".$_POST['student_name'.$i]."',
					'".$_POST['college_roll_no'.$i]."',
					'".$_POST['university_roll_no'.$i]."',
					'".$_POST['theory_practical']."',
					'".$_POST['subject_code']."',
					'".$data_sm['m_code']."',
					'".$_POST['paper_id']."',
					'".$_POST['semester']."',
					'".$_POST['internal_max_marks']."',
					'".$_POST['attendance'.$i]."',
					'".$_POST['attendance'.$i]."',
					'".$_POST['regular_reappear']."',
					'".$_SESSION['username']."',
					'".date("Y-m-d H:i:s")."',
					'".$_POST['internal_external']."',
					'".$_POST['subject_master_id']."',
					'".$_POST['cbs_grading_type']."',
					'".$_POST['cbs_mean']."',
					'".$_POST['cbs_std_dev']."',
					'".$_POST['cbs_total_students']."',
					'".$grade_letterr."'
					)") or die(mysql_error());
					
					mysql_query("UPDATE subject_master SET 
					internal_attendance_status=1 WHERE
					branch_code = '".$_POST['branch_code']."' AND
					course_code = '".$_POST['course_code']."' AND
					aicte_rc = '".$_POST['aicte_rc']."' AND
					shift = '".$_POST['shift']."' AND
					subject_code = '".$_POST['subject_code']."' AND
					exam_month = '".$_POST['exam_month']."' AND
					exam_year = '".$_POST['exam_year']."' AND
					theory_practical = '".$_POST['theory_practical']."' AND
					full_part_time = '".$_POST['full_part_time']."' AND
					semester = '".$_POST['semester']."' AND
					internal_max_marks = '".$_POST['internal_max_marks']."' AND
					regular_reappear = '".$_POST['regular_reappear']."' AND
					teacher_username = '".$_SESSION['username']."'") or die(mysql_error());
					
				}
				
				
			}
		}
	
		echo "<center><span class='label label-success'>Attendance Successfully Marked. You can upload the Marks Now.</span></center>";
	}
	
	
	
	if($_POST['internal_external']=='E') {
		$total_count = $_POST['total_count'];
		$time = date("Y-m-d H:i:s");
		
		if($_POST['theory_practical']=='T') {
			
			$field_string = "branch_code,course_code,aicte_rc,shift,full_part_time,exam_month,exam_year,student_name,college_roll_no,university_roll_no,theory_practical,subject_code,m_code,paper_id,semester,external_max_marks,internal_attendance_status,external_attendance_status,regular_reappear,teacher_username,attendance_last_updated_on,internal_external,subject_master_id,grading_type,mean,std_dev,total_students,grade_letter";

					
		}
				
		if($_POST['theory_practical']=='P') {
			
			$field_string = "branch_code,course_code,aicte_rc,shift,full_part_time,exam_month,exam_year,student_name,college_roll_no,university_roll_no,theory_practical,subject_code,m_code,paper_id,semester,external_max_marks,internal_attendance_status,external_attendance_status,regular_reappear,teacher_username,attendance_last_updated_on,internal_external,subject_master_id,grading_type,mean,std_dev,total_students,grade_letter";

					
		}
	
		
		
		
		if($_POST['theory_practical']=='T') {
			$internal_attendance_status = fetch_resource_db('student_internal_marks', 
			array(
			'university_roll_no',
			'course_code',
			'exam_year',
			'exam_month',
			'branch_code',
			'semester',
			'subject_code',
			'theory_practical',
			'regular_reappear',
			'teacher_username',
			'full_part_time',
			'internal_external',
			'paper_id'), 
			array(
			$_POST['university_roll_no1'],
			$_POST['course_code'],
			$_POST['exam_year'],
			$_POST['exam_month'],
			$_POST['branch_code'],
			$_POST['semester'],
			$_POST['subject_code'],
			$_POST['theory_practical'],
			$_POST['regular_reappear'],
			$_SESSION['username'],
			$_POST['full_part_time'],
			$_POST['internal_external'],
			$_POST['paper_id']),'resource_array_value','internal_attendance_status');
		
		}
		if($_POST['theory_practical']=='P') {
			$internal_attendance_status = fetch_resource_db('student_internal_marks', 
			array(
			'university_roll_no',
			'course_code',
			'exam_year',
			'exam_month',
			'branch_code',
			'semester',
			'subject_code',
			'theory_practical',
			'regular_reappear',
			'teacher_username',
			'full_part_time',
			'internal_external'), 
			array(
			$_POST['university_roll_no1'],
			$_POST['course_code'],
			$_POST['exam_year'],
			$_POST['exam_month'],
			$_POST['branch_code'],
			$_POST['semester'],
			$_POST['subject_code'],
			$_POST['theory_practical'],
			$_POST['regular_reappear'],
			$_SESSION['username'],
			$_POST['full_part_time'],
			$_POST['internal_external']),'resource_array_value','internal_attendance_status');
		}
		
		
		
		for($i=1;$i<=$total_count-1;$i++) {
		//$value_string = "'".$_POST['college_roll_no'.$i].",".$_POST['university_roll_no'.$i].",'".$_POST['theory_practical']."',".$_POST['semester'].",".$_POST['subject_code'].",".$_POST['internal_max_marks'].",".$_POST['attendance'.$i].",".$_POST['regular_reappear'].",".$_SESSION['username'];
		
		
		//$sql = "INSERT INTO student_internal_marks ($field_string) VALUES ($value_string)";
		//echo "<br/>".$sql;
		
			if($internal_attendance_status!='') {
				
				
				if($_POST['theory_practical']=='T') {
					
					if($_POST['attendance'.$i]=='Detained') {
						$grade_letterr = 'E';
					}
					else {
						$grade_letterr = '';
					}
					
					mysql_query("UPDATE student_internal_marks SET 
					internal_attendance_status='".$_POST['attendance'.$i]."',
					external_attendance_status='".$_POST['attendance'.$i]."',
					grading_type='".$_POST['cbs_grading_type']."',
					grade_letter='".$grade_letterr."',
					mean='".$_POST['cbs_mean']."',
					std_dev='".$_POST['cbs_std_dev']."',
					total_students='".$_POST['cbs_total_students']."',
					attendance_last_updated_on='".date("Y-m-d H:i:s")."' WHERE
					branch_code = '".$_POST['branch_code']."' AND
					course_code = '".$_POST['course_code']."' AND
					aicte_rc = '".$_POST['aicte_rc']."' AND
					shift = '".$_POST['shift']."' AND
					university_roll_no = '".$_POST['university_roll_no'.$i]."' AND
					subject_code = '".$_POST['subject_code']."' AND
				
					exam_month = '".$_POST['exam_month']."' AND
					exam_year = '".$_POST['exam_year']."' AND
					theory_practical = '".$_POST['theory_practical']."' AND
					semester = '".$_POST['semester']."' AND
					external_max_marks = '".$_POST['external_max_marks']."' AND
					regular_reappear = '".$_POST['regular_reappear']."' AND
					internal_external = '".$_POST['internal_external']."' AND
					full_part_time = '".$_POST['full_part_time']."' AND
					teacher_username = '".$_SESSION['username']."' AND
					paper_id='".$_POST['paper_id']."'") or die(mysql_error());
					
					$eas = fetch_resource_db('student_internal_marks',array('subject_master_id'),array($_POST['subject_master_id']),'resource_array_value','external_attendance_status');
					
					if($eas==0) {
						mysql_query("UPDATE subject_master SET external_attendance_status=1 WHERE subject_master_id='".$_POST['subject_master_id']."'") or die(mysql_error());
					}
					
				}
				
				if($_POST['theory_practical']=='P') {
					
					if($_POST['attendance'.$i]=='Detained') {
						$grade_letterr = 'E';
					}
					else {
						$grade_letterr = '';
					}
					
					mysql_query("UPDATE student_internal_marks SET 
					internal_attendance_status='".$_POST['attendance'.$i]."',
					external_attendance_status='".$_POST['attendance'.$i]."',
					grading_type='".$_POST['cbs_grading_type']."',
					grade_letter='".$grade_letterr."',
					mean='".$_POST['cbs_mean']."',
					std_dev='".$_POST['cbs_std_dev']."',
					total_students='".$_POST['cbs_total_students']."',
					attendance_last_updated_on='".date("Y-m-d H:i:s")."' WHERE
					branch_code = '".$_POST['branch_code']."' AND
					course_code = '".$_POST['course_code']."' AND
					aicte_rc = '".$_POST['aicte_rc']."' AND
					shift = '".$_POST['shift']."' AND
					university_roll_no = '".$_POST['university_roll_no'.$i]."' AND
					subject_code = '".$_POST['subject_code']."' AND
				
					exam_month = '".$_POST['exam_month']."' AND
					exam_year = '".$_POST['exam_year']."' AND
					theory_practical = '".$_POST['theory_practical']."' AND
					semester = '".$_POST['semester']."' AND
					external_max_marks = '".$_POST['external_max_marks']."' AND
					regular_reappear = '".$_POST['regular_reappear']."' AND
					internal_external = '".$_POST['internal_external']."' AND
					full_part_time = '".$_POST['full_part_time']."' AND
					teacher_username = '".$_SESSION['username']."'") or die(mysql_error());
					
					$eas = fetch_resource_db('student_internal_marks',array('subject_master_id'),array($_POST['subject_master_id']),'resource_array_value','external_attendance_status');
					
					if($eas==0) {
						mysql_query("UPDATE subject_master SET external_attendance_status=1 WHERE subject_master_id='".$_POST['subject_master_id']."'") or die(mysql_error());
					}
					
				}
				
				
				
			}
			if($internal_attendance_status=='') {
				
				
				
				if($_POST['theory_practical']=='T') {
					
					if($_POST['attendance'.$i]=='Detained') {
						$grade_letterr = 'E';
					}
					else {
						$grade_letterr = '';
					}
					
					mysql_query("INSERT INTO student_internal_marks ($field_string) 
					VALUES ('".$_POST['branch_code']."',
					'".$_POST['course_code']."',
					'".$_POST['aicte_rc']."',
					'".$_POST['shift']."',
					'".$_POST['full_part_time']."',
					'".$_POST['exam_month']."',
					'".$_POST['exam_year']."',
					'".$_POST['student_name'.$i]."',
					'".$_POST['college_roll_no'.$i]."',
					'".$_POST['university_roll_no'.$i]."',
					'".$_POST['theory_practical']."',
					'".$_POST['subject_code']."',
					'".$data_sm['m_code']."',
					'".$_POST['paper_id']."',
					'".$_POST['semester']."',
					'".$_POST['external_max_marks']."',
					'".$_POST['attendance'.$i]."',
					'".$_POST['attendance'.$i]."',
					'".$_POST['regular_reappear']."',
					'".$_SESSION['username']."',
					'".date("Y-m-d H:i:s")."',
					'".$_POST['internal_external']."',
					'".$_POST['subject_master_id']."',
					'".$_POST['cbs_grading_type']."',
					'".$_POST['cbs_mean']."',
					'".$_POST['cbs_std_dev']."',
					'".$_POST['cbs_total_students']."',
					'".$grade_letterr."'
					)") or die(mysql_error());
					
					mysql_query("UPDATE subject_master SET external_attendance_status=1 WHERE
					branch_code = '".$_POST['branch_code']."' AND
					course_code = '".$_POST['course_code']."' AND
					aicte_rc = '".$_POST['aicte_rc']."' AND
					shift = '".$_POST['shift']."' AND
					subject_code = '".$_POST['subject_code']."' AND
				
					exam_month = '".$_POST['exam_month']."' AND
					exam_year = '".$_POST['exam_year']."' AND
					theory_practical = '".$_POST['theory_practical']."' AND
					full_part_time = '".$_POST['full_part_time']."' AND
					semester = '".$_POST['semester']."' AND
					external_max_marks = '".$_POST['external_max_marks']."' AND
					regular_reappear = '".$_POST['regular_reappear']."' AND
					teacher_username = '".$_SESSION['username']."' AND
					paper_id = '".$_POST['paper_id']."'
					") or die(mysql_error());
					
				}
				
				if($_POST['theory_practical']=='P') {
					
					if($_POST['attendance'.$i]=='Detained') {
						$grade_letterr = 'E';
					}
					else {
						$grade_letterr = '';
					}
					
					mysql_query("INSERT INTO student_internal_marks ($field_string) 
					VALUES ('".$_POST['branch_code']."',
					'".$_POST['course_code']."',
					'".$_POST['aicte_rc']."',
					'".$_POST['shift']."',
						'".$_POST['full_part_time']."',
					'".$_POST['exam_month']."',
					'".$_POST['exam_year']."',
					'".$_POST['student_name'.$i]."',
					'".$_POST['college_roll_no'.$i]."',
					'".$_POST['university_roll_no'.$i]."',
					'".$_POST['theory_practical']."',
					'".$_POST['subject_code']."',
					'".$data_sm['m_code']."',
					'".$_POST['paper_id']."',
					'".$_POST['semester']."',
					'".$_POST['external_max_marks']."',
					'".$_POST['attendance'.$i]."',
					'".$_POST['attendance'.$i]."',
					'".$_POST['regular_reappear']."',
					'".$_SESSION['username']."',
					'".date("Y-m-d H:i:s")."',
					'".$_POST['internal_external']."',
					'".$_POST['subject_master_id']."',
					'".$_POST['cbs_grading_type']."',
					'".$_POST['cbs_mean']."',
					'".$_POST['cbs_std_dev']."',
					'".$_POST['cbs_total_students']."',
					'".$grade_letterr."'
					)") or die(mysql_error());
				
					mysql_query("UPDATE subject_master SET external_attendance_status=1 WHERE
					branch_code = '".$_POST['branch_code']."' AND
					course_code = '".$_POST['course_code']."' AND
					aicte_rc = '".$_POST['aicte_rc']."' AND
					shift = '".$_POST['shift']."' AND
					subject_code = '".$_POST['subject_code']."' AND
				
					exam_month = '".$_POST['exam_month']."' AND
					exam_year = '".$_POST['exam_year']."' AND
					theory_practical = '".$_POST['theory_practical']."' AND
					full_part_time = '".$_POST['full_part_time']."' AND
					semester = '".$_POST['semester']."' AND
					external_max_marks = '".$_POST['external_max_marks']."' AND
					regular_reappear = '".$_POST['regular_reappear']."' AND
					teacher_username = '".$_SESSION['username']."'") or die(mysql_error());
					
				}
				
			}
		}
	
		echo "<center><span class='label label-success'>Attendance Successfully Marked. You can upload the Marks Now.</span></center>";
	}

}



function sup_mark_attendance() {
	
	
		$total_count = $_POST['total_count'];
		$time = date("Y-m-d H:i:s");
	
		$field_string = "branch_code,course_code,university_roll_no,theory_practical,subject_code,m_code,subject_title,
		paper_id,semester,external_max_marks,external_attendance_status,
		regular_reappear,attendance_last_updated,date_of_exam,ucentre,usession,attendance_uploaded_by,prov_nonprov";
		
		$external_attendance_status = fetch_resource_db('student_external_marks', 
		array('branch_code','course_code','university_roll_no','subject_code','paper_id','regular_reappear','theory_practical','semester','ucentre','usession','date_of_exam','attendance_uploaded_by'), 
		array($_POST['branch_code'],$_POST['course_code'],$_POST['university_roll_no1'],$_POST['subject_code1'],
		$_POST['paper_id'],$_POST['regular_reappear'],'T',$_POST['semester1'],
		$_SESSION['ucentre'],$_SESSION['usession'],date("Y-m-d"),$_SESSION['username']),'resource_array_value','external_attendance_status');
		
		for($i=1;$i<=$total_count-1;$i++) {
			
			if($external_attendance_status!='') {
				mysql_query("UPDATE student_external_marks SET external_attendance_status='".$_POST['attendance'.$i]."',
				attendance_last_updated='".date("Y-m-d H:i:s")."' WHERE
				branch_code = '".$_POST['branch_code']."' AND
				course_code = '".$_POST['course_code']."' AND
				university_roll_no = '".$_POST['university_roll_no'.$i]."' AND
				subject_code = '".$_POST['subject_code'.$i]."' AND
				paper_id = '".$_POST['paper_id']."' AND
				regular_reappear = '".$_POST['regular_reappear']."' AND
				semester = '".$_POST['semester'.$i]."' AND
				ucentre = '".$_SESSION['ucentre']."' AND
				usession = '".$_SESSION['usession']."' AND
				date_of_exam = '".date("Y-m-d")."' AND
				semester = '".$_POST['semester'.$i]."' AND
				attendance_uploaded_by = '".$_SESSION['username']."' AND
				theory_practical = 'T'") or die(mysql_error());
			}
			
			if($external_attendance_status=='') {
				
				mysql_query("INSERT INTO student_external_marks ($field_string) 
				VALUES (
				'".$_POST['branch_code']."',
				'".$_POST['course_code']."',
				'".$_POST['university_roll_no'.$i]."',
				'T',
				'".$_POST['subject_code'.$i]."',
				'".$_POST['m_code'.$i]."',
				'".$_POST['subject_title'.$i]."',
				'".$_POST['paper_id']."',
				'".$_POST['semester'.$i]."',
				'".$_POST['external_max_marks']."',
				'".$_POST['attendance'.$i]."',
				'".$_POST['regular_reappear']."',
				'".date("Y-m-d H:i:s")."',
				'".date("Y-m-d")."',
				'".$_SESSION['ucentre']."',
				'".$_SESSION['usession']."',
				'".$_SESSION['username']."',
				'".$_POST['prov_nonprov'.$i]."'
				)") or die(mysql_error());
				mysql_query("UPDATE subject_master SET external_attendance_status=1 WHERE
				subject_code = '".$_POST['subject_code'.$i]."' AND
				paper_id = '".$_POST['paper_id']."' AND
				regular_reappear = '".$_POST['regular_reappear']."' AND
				semester = '".$_POST['semester'.$i]."' AND
				theory_practical = 'T'") or die(mysql_error());
			}
		
		}
	
	echo "<center><span class='label label-success'>Attendance Successfully Marked.</span></center>";

}
?>

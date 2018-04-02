<?php
function teacher_mark_daily_attendance() {
	//echo $_POST['exam_month'];
	//echo $_POST['exam_year'];
		$total_count = $_POST['total_count'];
		$time = date("Y-m-d H:i:s");
		
		$field_string = "branch_code,course_code,aicte_rc,shift,m_code,full_part_time,university_roll_no,ssection,sgroup,theory_practical,subject_code,elective_details,paper_id,subject_title,semester,teacher_username,teacher_type,attendance_date,attendance_period,start_time,end_time,overall_remarks,attendance,topics_covered,remarks,attendance_last_updated_on,attendance_last_updated_by,uploaded_from_ip,exam_month,exam_year";
		
		
		$field_string_tc = "branch_code,course_code,aicte_rc,shift,m_code,full_part_time,ssection,sgroup,theory_practical,subject_code,subject_title,semester,teacher_username,attendance_date,attendance_period,topics_covered,attendance_last_updated_on,uploaded_from_ip,exam_month,exam_year";
	
		
		for($i=1;$i<=$total_count-1;$i++) {
		mysql_query("INSERT INTO daily_attendance_student ($field_string) 
				VALUES ('".$_POST['branch_code']."',
				'".$_POST['course_code']."',
				'".$_POST['aicte_rc']."',
				'".$_POST['shift']."',
				'".$_POST['m_code']."',
				'".$_POST['full_part_time']."',
				'".$_POST['university_roll_no'.$i]."',
				'".$_POST['ssection']."',
				'".$_POST['sgroup']."',
				'".$_POST['theory_practical']."',
				'".$_POST['subject_code']."',
				'".$_POST['elective_details']."',
				'".$_POST['paper_id']."',
				'".$_POST['subject_title']."',
				'".$_POST['semester']."',
				'".$_SESSION['username']."',
				'".$_POST['teacher_type']."',
				'".$_POST['attendance_date']."',
				'".$_POST['attendance_period']."',
				'".$_POST['start_time']."',
				'".$_POST['end_time']."',
				'".$_POST['overall_remarks']."',
				'".$_POST['attendance'.$i]."',
				'".mysql_real_escape_string($_POST['topics_covered'])."',
				'".$_POST['remarks'.$i]."',
				'".date("Y-m-d H:i:s")."',
				'".$_SESSION['username']."',
				'".$_SERVER['REMOTE_ADDR']."',
				'".$_POST['exam_month']."',
				'".$_POST['exam_year']."'
				)") or die(mysql_error());
				
			}
			
			mysql_query("INSERT INTO course_delivery ($field_string_tc) 
				VALUES ('".$_POST['branch_code']."',
				'".$_POST['course_code']."',
				'".$_POST['aicte_rc']."',
				'".$_POST['shift']."',
				'".$_POST['m_code']."',
				'".$_POST['full_part_time']."',
				'".$_POST['ssection']."',
				'".$_POST['sgroup']."',
				'".$_POST['theory_practical']."',
				'".$_POST['subject_code']."',
				'".$_POST['subject_title']."',
				'".$_POST['semester']."',
				'".$_SESSION['username']."',
				'".$_POST['attendance_date']."',
				'".$_POST['attendance_period']."',
				'".mysql_real_escape_string($_POST['topics_covered'])."',
				'".date("Y-m-d H:i:s")."',
				'".$_SERVER['REMOTE_ADDR']."',
				'".$_POST['exam_month']."',
				'".$_POST['exam_year']."'
				)") or die(mysql_error());
			
		echo "<center><span class='label label-success'>Attendance Successfully Marked.</span></center>";
}


function teacher_update_daily_attendance() {
	
		$total_count = $_POST['total_count'];
		$time = date("Y-m-d H:i:s");


		$field_string = "branch_code,course_code,aicte_rc,shift,m_code,elective_details,full_part_time,university_roll_no,ssection,sgroup,theory_practical,subject_code,paper_id,subject_title,semester,teacher_username,attendance_date,attendance_period,start_time,end_time,overall_remarks,attendance,remarks,attendance_last_updated_on,attendance_last_updated_by,revision,updated_from_ip,exam_month,exam_year";
	
		
		for($i=1;$i<=$total_count-1;$i++) {
			
			if($_POST['attendance'.$i]!=$_POST['p_attendance'.$i]) {

				$data = mysql_query("SELECT * FROM daily_attendance_student WHERE autoid='".$_POST['autoid'.$i]."'") or die(mysql_error());
				$row = mysql_fetch_assoc($data);
				
				mysql_query("UPDATE daily_attendance_student SET
					backup = '1' WHERE
					autoid='".$_POST['autoid'.$i]."'") or die(mysql_error());
					
				mysql_query("INSERT INTO daily_attendance_student ($field_string) 
					VALUES ('".$row['branch_code']."',
					'".$row['course_code']."',
					'".$row['aicte_rc']."',
					'".$row['shift']."',
					'".$row['m_code']."',
					'".$row['elective_details']."',
					'".$row['full_part_time']."',
					'".$_POST['university_roll_no'.$i]."',
					'".$row['ssection']."',
					'".$row['sgroup']."',
					'".$row['theory_practical']."',
					'".$row['subject_code']."',
					'".$row['paper_id']."',
					'".$row['subject_title']."',
					'".$row['semester']."',
					'".$_SESSION['username']."',
					'".$row['attendance_date']."',
					'".$row['attendance_period']."',
					'".$row['start_time']."',
					'".$row['end_time']."',
					'".$row['overall_remarks']."',
					'".$_POST['attendance'.$i]."',
					'".$_POST['remarks'.$i]."',
					'".date("Y-m-d H:i:s")."',
					'".$_SESSION['username']."',
					'".(($_POST['revision'.$i])+(1))."',
					'".$_SERVER['REMOTE_ADDR']."',
					'".$row['exam_month']."',
					'".$row['exam_year']."'
					)") or die(mysql_error());

					unset($row);
					
				}
			}
			
		echo "<center><span class='label label-success'>Attendance Successfully Updated.</span></center>";
}


function teacher_mark_aggregate_attendance() {
	
		$total_count = $_POST['total_count'];
		$time = date("Y-m-d H:i:s");
		
		$field_string = "branch_code,id,course_code,aicte_rc,shift,full_part_time,university_roll_no,college_roll_no,ssection,sgroup,theory_practical,subject_code,paper_id,subject_title,semester,teacher_username,start_date,end_date,overall_remarks,total_lectures,attended_lectures,attendance_marks,remarks,attendance_last_updated_on,attendance_last_updated_by,exam_month,exam_year";
	
		
		for($i=1;$i<=$total_count-1;$i++) {
		mysql_query("INSERT INTO aggregate_attendance_student ($field_string) 
				VALUES ('".$_POST['branch_code']."',
				'".$_POST['autoid']."',
				'".$_POST['course_code']."',
				'".$_POST['aicte_rc']."',
				'".$_POST['shift']."',
				'".$_POST['full_part_time']."',
				'".$_POST['university_roll_no'.$i]."',
				'".$_POST['college_roll_no'.$i]."',
				'".$_POST['ssection']."',
				'".$_POST['sgroup']."',
				'".$_POST['theory_practical']."',
				'".$_POST['subject_code']."',
				'".$_POST['paper_id']."',
				'".$_POST['subject_title']."',
				'".$_POST['semester']."',
				'".$_SESSION['username']."',
				'".$_POST['start_date']."',
				'".$_POST['end_date']."',
				'".$_POST['overall_remarks']."',
				'".$_POST['total_lectures']."',
				'".$_POST['attended_lectures'.$i]."',
				'".$_POST['attendance_marks'.$i]."',
				'".$_POST['remarks'.$i]."',
				'".date("Y-m-d H:i:s")."',
				'".$_SESSION['username']."',
				'".$_POST['exam_month']."',
				'".$_POST['exam_year']."'
				)") or die("H.".mysql_error());
				
			}
			
		echo "<center><span class='label label-success'>Attendance Successfully Marked.</span></center>";
}




function teacher_update_aggregate_attendance() {
	
		$total_count = $_POST['total_count'];
		$time = date("Y-m-d H:i:s");


		$field_string = "branch_code,id,course_code,aicte_rc,shift,full_part_time,university_roll_no,college_roll_no,ssection,sgroup,theory_practical,subject_code,paper_id,subject_title,semester,teacher_username,start_date,end_date,overall_remarks,total_lectures,attended_lectures,attendance_marks,remarks,attendance_last_updated_on,attendance_last_updated_by,revision,exam_month,exam_year";
	
		
		for($i=1;$i<=$total_count-1;$i++) {
			
			if(($_POST['attended_lectures'.$i]!=$_POST['p_attended_lectures'.$i]) OR ($_POST['attendance_marks'.$i]!=$_POST['p_attendance_marks'.$i])) {

				$data = mysql_query("SELECT * FROM aggregate_attendance_student WHERE autoid='".$_POST['autoid'.$i]."'") or die(mysql_error());
				$row = mysql_fetch_assoc($data);
				
				mysql_query("UPDATE aggregate_attendance_student SET
					backup = '1' WHERE
					autoid='".$_POST['autoid'.$i]."'") or die(mysql_error());
					
					
				mysql_query("INSERT INTO aggregate_attendance_student ($field_string) 
				VALUES ('".$row['branch_code']."',
				'".$_POST['id']."',
				'".$row['course_code']."',
				'".$row['aicte_rc']."',
				'".$row['shift']."',
				'".$row['full_part_time']."',
				'".$_POST['university_roll_no'.$i]."',
				'".$_POST['college_roll_no'.$i]."',
				'".$row['ssection']."',
				'".$row['sgroup']."',
				'".$row['theory_practical']."',
				'".$row['subject_code']."',
				'".$row['paper_id']."',
				'".$row['subject_title']."',
				'".$row['semester']."',
				'".$_SESSION['username']."',
				'".$row['start_date']."',
				'".$row['end_date']."',
				'".$row['overall_remarks']."',
				'".$row['total_lectures']."',
				'".$_POST['attended_lectures'.$i]."',
				'".$_POST['attendance_marks'.$i]."',
				'".$_POST['remarks'.$i]."',
				'".date("Y-m-d H:i:s")."',
				'".$_SESSION['username']."',
				'".(($_POST['revision'.$i])+(1))."',
				'".$_POST['exam_month']."',
				'".$_POST['exam_year']."'
				)") or die("H:".mysql_error());

				unset($row);
				
			}
		}
			
		echo "<center><span class='label label-success'>Attendance Successfully Updated.</span></center>";
}



function teacher_upload_sessional_marks() {
	
		$total_count = $_POST['total_count'];
		
		$result_iqs=mysql_query("select * from  internal_question_structure where course_code='".$_POST['course_code']."' and ass_tool='S' and sessional_no='".$_POST['sessional_no']."'; ");

		$num_iqs= mysql_num_rows($result_iqs);
#echo $num_iqs;

		$field_string = "id,university_roll_no,sessional_no,sessional_date,attendance_status,overall_remarks,obtained_marks,remarks,last_updated_on,last_updated_by,revision,branch_code,course_code,aicte_rc,shift,full_part_time,college_roll_no,ssection,sgroup,theory_practical,subject_code,m_code,paper_id,subject_title,semester,teacher_username,exam_month,exam_year";
		
		for($x=1;$x<=$num_iqs;$x++) 
		{
			$field_string .= ",q".$x.", mmq".$x;
		}
		
		for($i=1;$i<=$total_count-1;$i++) {
			
			if($_POST['attendance_status'.$i]=='Absent') {
				$attendance = "Absent";
			}
			else {
				$attendance = "Present";
			}
			$obtained_marks=0;
			for($x=1;$x<=$num_iqs;$x++) 
			{
				$obtained_marks += $_POST['q'.$i.''.$x];
				#echo round($obtained_marks)."<br>";
			}
			$row = mysql_fetch_assoc($data);
			$sql_insert= "INSERT INTO student_sessionals_record ($field_string) 
				VALUES ('".$_POST['autoid']."',
				'".$_POST['university_roll_no'.$i]."',
				'".$_POST['sessional_no']."',
				'".$_POST['sessional_date']."',
				'".$attendance."',
				'".$_POST['overall_remarks']."',
				'".round($obtained_marks)."',
				'".$_POST['remarks'.$i]."',
				'".date("Y-m-d H:i:s")."',
				'".$_SESSION['username']."',
				'0',
				'".$_POST['branch_code']."',
				'".$_POST['course_code']."',
				'".$_POST['aicte_rc']."',
				'".$_POST['shift']."',
				'".$_POST['full_part_time']."',
				'".$_POST['college_roll_no'.$i]."',
				'".$_POST['ssection']."',
				'".$_POST['sgroup']."',
				'".$_POST['theory_practical']."',
				'".$_POST['subject_code']."',
				'".$_POST['m_code']."',
				'".$_POST['paper_id']."',
				'".$_POST['subject_title']."',
				'".$_POST['semester']."',
				'".$_SESSION['username']."',
				'".$_POST['exam_month']."',
				'".$_POST['exam_year']."' ";
				
				
				
				for($x=1;$x<=$num_iqs;$x++) 
				{
					$question_id=$i."".$x;
					$result_iqs_qn=mysql_query("select * from  internal_question_structure where course_code='".$_POST['course_code']."' and  question_no='".$x."' and ass_tool='S' and sessional_no='".$_POST['sessional_no']."';");
					$row_iqs_qn = mysql_fetch_assoc($result_iqs_qn);
					$sql_insert .= ",'".$_POST['q'.$question_id]."','".$row_iqs_qn['max_marks']."' ";
				}
				
				$sql_insert .= " );";
				#echo $sql_insert;
				mysql_query($sql_insert) or die("H:".mysql_error());
			}
			
			$sessional_marks_uploaded = "sessional".$_POST['sessional_no']."_marks_uploaded";
			
			mysql_query("UPDATE time_table SET ".$sessional_marks_uploaded."='Y' WHERE
			branch_code='".$_POST['branch_code']."' AND
			course_code='".$_POST['course_code']."' AND
			aicte_rc='".$_POST['aicte_rc']."' AND
			shift='".$_POST['shift']."' AND
			full_part_time='".$_POST['full_part_time']."' AND
			ssection='".$_POST['ssection']."' AND
			subject_code='".$_POST['subject_code']."' AND
			teacher_username='".$_SESSION['username']."'") or die(mysql_error());
			
		echo "<center><span class='label label-success'>Marks Successfully Uploaded.</span></center>";
}


function teacher_update_sessional_marks() 
	{
		$total_count = $_POST['total_count'];
		$result_iqs=mysql_query("select * from  internal_question_structure where course_code='".$_POST['course_code']."' and ass_tool='S' and sessional_no='".$_POST['sessional_no']."';");
		$num_iqs= mysql_num_rows($result_iqs);
		
		$field_string = "id,university_roll_no,sessional_no,sessional_date,attendance_status,overall_remarks,obtained_marks,remarks,last_updated_on,last_updated_by,revision,branch_code,course_code,aicte_rc,shift,full_part_time,college_roll_no,ssection,sgroup,theory_practical,subject_code,m_code,paper_id,subject_title,semester,teacher_username,exam_month,exam_year";
	
		for($x=1;$x<=$num_iqs;$x++) 
		{
			$field_string .= ",q".$x.", mmq".$x;
		}
		
		for($i=1;$i<=$total_count-1;$i++) 
		{
			$details = fetch_resource_db('student_sessionals_record',
			array('autoid',
			'sessional_no'),
			array($_POST['sessional_id'.$i],
			$_POST['sessional_no']),
			'resource_array','');
			
			if($_POST['attendance_status'.$i]=='Absent') {
				$attendance = "Absent";
			}
			else {
				$attendance = "Present";
			}
			$obtained_marks=0;
			for($x=1;$x<=$num_iqs;$x++) 
			{
				$obtained_marks += $_POST['q'.$i.''.$x];
				#echo round($obtained_marks)."<br>";
			}
			
			$row = mysql_fetch_assoc($data);
			mysql_query("UPDATE student_sessionals_record SET backup='1' WHERE
			autoid = '".$_POST['sessional_id'.$i]."'") or die(mysql_error());
			
			$sql_insert= "INSERT INTO student_sessionals_record ($field_string) 
			VALUES ('".$_POST['autoid']."',
			'".$_POST['university_roll_no'.$i]."',
			'".$_POST['sessional_no']."',
			'".$details['sessional_date']."',
			'".$attendance."',
			'".$details['overall_remarks']."',
			'".round($obtained_marks)."',
			'".$_POST['remarks'.$i]."',
			'".date("Y-m-d H:i:s")."',
			'".$_SESSION['username']."',
			'".(($details['revision'])+(1))."',
			'".$_POST['branch_code']."',
			'".$_POST['course_code']."',
			'".$_POST['aicte_rc']."',
			'".$_POST['shift']."',
			'".$_POST['full_part_time']."',
			'".$_POST['college_roll_no'.$i]."',
			'".$_POST['ssection']."',
			'".$_POST['sgroup']."',
			'".$_POST['theory_practical']."',
			'".$_POST['subject_code']."',
			'".$details['m_code']."',
			'".$_POST['paper_id']."',
			'".$_POST['subject_title']."',
			'".$_POST['semester']."',
			'".$_SESSION['username']."',
			'".$details['exam_month']."',
			'".$details['exam_year']."' ";

			for($x=1;$x<=$num_iqs;$x++) 
			{
				$question_id=$i."".$x;
				$result_iqs_qn=mysql_query("select * from  internal_question_structure where course_code='".$_POST['course_code']."' and  question_no='".$x."' and ass_tool='S' and sessional_no='".$_POST['sessional_no']."';");
				$row_iqs_qn = mysql_fetch_assoc($result_iqs_qn);
				$sql_insert .= ",'".$_POST['q'.$question_id]."','".$row_iqs_qn['max_marks']."' ";
			}
			
			$sql_insert .= " );";
			#echo $sql_insert;
			mysql_query($sql_insert) or die("H:".mysql_error());
		}
			
		echo "<center><span class='label label-success'>Marks Successfully Updated.</span></center>";
}





function teacher_upload_assignment_marks() {
	
		$total_count = $_POST['total_count'];
		$total_qcount = $_POST['total_qcount'];


		$field_string = "id,university_roll_no,college_roll_no,assignment_no,assignment_date,assignment_topic,assignment_max_marks,assignment_obtained_marks,remarks,marks_last_updated_on,marks_last_updated_by,revision,branch_code,course_code,aicte_rc,shift,full_part_time,ssection,sgroup,theory_practical,subject_code,paper_id,subject_title,semester,teacher_username,exam_month,exam_year";
	
		
		for($i=1;$i<=$total_count-1;$i++) {

			//$row = mysql_fetch_assoc($data);
			
			$student_details = fetch_resource_db('student_info',array('university_roll_no'),array($_POST['university_roll_no'.$i]),'resource_array','');

			
			mysql_query("INSERT INTO student_assignment_record ($field_string) 
				VALUES ('".$_POST['autoid']."',
				'".$_POST['university_roll_no'.$i]."',
				'".$student_details['college_roll_no']."',
				'".$_POST['assignment_no']."',
				'".$_POST['assignment_date']."',
				'".mysql_real_escape_string($_POST['assignment_topic'])."',
				'".$_POST['assignment_max_marks']."',
				'".$_POST['obtained_marks'.$i]."',
				'".$_POST['remarks'.$i]."',
				'".date("Y-m-d H:i:s")."',
				'".$_SESSION['username']."',
				'0',
				'".$_POST['branch_code']."',
				'".$_POST['course_code']."',
				'".$_POST['aicte_rc']."',
				'".$_POST['shift']."',
				'".$_POST['full_part_time']."',
				'".$_POST['ssection']."',
				'".$_POST['sgroup']."',
				'".$_POST['theory_practical']."',
				'".$_POST['subject_code']."',
				'".$_POST['paper_id']."',
				'".$_POST['subject_title']."',
				'".$_POST['semester']."',
				'".$_SESSION['username']."',
				'".$_POST['exam_month']."',
				'".$_POST['exam_year']."'
				)") or die("H:".mysql_error());
				
				
				
				for($j=1;$j<=$total_qcount;$j++) {
				
					$question_id = $i.$j;
					
					$qmm_sql = mysql_query("SELECT * FROM internal_question_structure WHERE ass_tool='A' AND course_code='".$_POST['course_code']."'
					AND question_no='".$j."'") or die(mysql_query());
					$qmm = mysql_fetch_assoc($qmm_sql);
					
					mysql_query("UPDATE student_assignment_record SET q$j='".$_POST['q'.$question_id]."',mmq$j='".$qmm['max_marks']."'
					WHERE university_roll_no='".$_POST['university_roll_no'.$i]."' AND
					assignment_no = '".$_POST['assignment_no']."' AND 
					assignment_date = '".$_POST['assignment_date']."' AND
					subject_code = '".$_POST['subject_code']."' AND 
					teacher_username = '".$_SESSION['username']."' AND
					backup='0'") or die(mysql_error());
				}

			}
			$assignment_marks_uploaded = "assignment".$_POST['assignment_no']."_marks_uploaded";
			
			mysql_query("UPDATE time_table SET ".$assignment_marks_uploaded."='Y' WHERE
			branch_code='".$_POST['branch_code']."' AND
			course_code='".$_POST['course_code']."' AND
			aicte_rc='".$_POST['aicte_rc']."' AND
			shift='".$_POST['shift']."' AND
			full_part_time='".$_POST['full_part_time']."' AND
			ssection='".$_POST['ssection']."' AND
			subject_code='".$_POST['subject_code']."' AND
			teacher_username='".$_SESSION['username']."'") or die(mysql_error());
							
			
		echo "<center><span class='label label-success'>Assignment Marks Successfully Uploaded.</span></center>";
}




function teacher_update_assignment_marks() {
	
		$total_count = $_POST['total_count'];
		$total_qcount = $_POST['total_qcount'];


		$field_string = "id,university_roll_no,college_roll_no,assignment_no,assignment_date,assignment_topic,assignment_max_marks,assignment_obtained_marks,remarks,marks_last_updated_on,marks_last_updated_by,revision,branch_code,course_code,aicte_rc,shift,full_part_time,ssection,sgroup,theory_practical,subject_code,paper_id,subject_title,semester,teacher_username,exam_month,exam_year";
		
	
		
		for($i=1;$i<=$total_count-1;$i++) {
			
			$details = fetch_resource_db('student_assignment_record',
			array('autoid',
			'assignment_no'),
			array($_POST['assignment_id'.$i],
			$_POST['assignment_no']),
			'resource_array','');
			
			
			
			
			
			$row = mysql_fetch_assoc($data);
			
			$update = 0;
			
			for($k=1;$k<=$total_qcount;$k++) {
				
					$qquestion_id = $i.$k;
					
					if($_POST['q'.$qquestion_id]!=$_POST['p_q'.$qquestion_id]) {
						
						$update = 1;
					}
					
					
			}
			
						
					
					if($update == 1) {
						$new_rev = $details['revision']+1;
				
						mysql_query("UPDATE student_assignment_record SET backup='1' WHERE
						autoid = '".$_POST['assignment_id'.$i]."'") or die(mysql_error());
					
					$student_details = fetch_resource_db('student_info',array('university_roll_no'),array($_POST['university_roll_no'.$i]),'resource_array','');
				
						mysql_query("INSERT INTO student_assignment_record ($field_string) 
						VALUES ('".$_POST['autoid']."',
						'".$_POST['university_roll_no'.$i]."',
						'".$student_details['college_roll_no']."',
						'".$details['assignment_no']."',
						'".$details['assignment_date']."',
						'".mysql_real_escape_string($details['assignment_topic'])."',
						'".$details['assignment_max_marks']."',
						'".$_POST['assignment_obtained_marks'.$i]."',
						'".$_POST['remarks'.$i]."',
						'".date("Y-m-d H:i:s")."',
						'".$_SESSION['username']."',
						'".(($details['revision'])+(1))."',
						'".$_POST['branch_code']."',
						'".$_POST['course_code']."',
						'".$_POST['aicte_rc']."',
						'".$_POST['shift']."',
						'".$_POST['full_part_time']."',
						'".$_POST['ssection']."',
						'".$_POST['sgroup']."',
						'".$_POST['theory_practical']."',
						'".$_POST['subject_code']."',
						'".$_POST['paper_id']."',
						'".$_POST['subject_title']."',
						'".$_POST['semester']."',
						'".$_SESSION['username']."',
						'".$_POST['exam_month']."',
						'".$_POST['exam_year']."'
						)") or die("H:".mysql_error());
					
				
					
					for($j=1;$j<=$total_qcount;$j++) {
						

						$question_id = $i.$j;
						
						$qmm_sql = mysql_query("SELECT * FROM internal_question_structure WHERE ass_tool='A' AND course_code='".$_POST['course_code']."'
						AND question_no='".$j."'") or die(mysql_query());
						$qmm = mysql_fetch_assoc($qmm_sql);
						
						mysql_query("UPDATE student_assignment_record SET q$j='".$_POST['q'.$question_id]."',mmq$j='".$qmm['max_marks']."',revision='".$new_rev."' 
						WHERE university_roll_no='".$_POST['university_roll_no'.$i]."' AND
						assignment_no = '".$_POST['assignment_no']."' AND 
						assignment_date = '".$details['assignment_date']."' AND
						subject_code = '".$_POST['subject_code']."' AND 
						teacher_username = '".$_SESSION['username']."' AND
						backup='0'") or die(mysql_error());
						
					}
				}
		}
			
		echo "<center><span class='label label-success'>Assignment Marks Successfully Updated.</span></center>";
}


function teacher_upload_internal_practical_marks() {
	
		$total_count = $_POST['total_count'];
		$total_qcount = $_POST['total_qcount'];


		$field_string = "id,university_roll_no,college_roll_no,remarks,last_updated_on,last_updated_by,revision,branch_code,course_code,aicte_rc,shift,full_part_time,ssection,sgroup,subject_code,theory_practical,paper_id,subject_title,semester,teacher_username,exam_month,exam_year";
	
		
		for($i=1;$i<=$total_count-1;$i++) {

			//$row = mysql_fetch_assoc($data);
			
			$student_details = fetch_resource_db('student_info',array('university_roll_no'),array($_POST['university_roll_no'.$i]),'resource_array','');

			
			mysql_query("INSERT INTO student_internal_practical_record ($field_string) 
				VALUES ('".$_POST['autoid']."',
				'".$_POST['university_roll_no'.$i]."',
				'".$student_details['college_roll_no']."',
				'".$_POST['remarks'.$i]."',
				'".date("Y-m-d H:i:s")."',
				'".$_SESSION['username']."',
				'0',
				'".$_POST['branch_code']."',
				'".$_POST['course_code']."',
				'".$_POST['aicte_rc']."',
				'".$_POST['shift']."',
				'".$_POST['full_part_time']."',
				'".$_POST['ssection']."',
				'".$_POST['sgroup']."',
				'".$_POST['subject_code']."',
				'P',
				'".$_POST['paper_id']."',
				'".$_POST['subject_title']."',
				'".$_POST['semester']."',
				'".$_SESSION['username']."',
				'".$_POST['exam_month']."',
				'".$_POST['exam_year']."'
				)") or die("H:".mysql_error());
				
				for($j=1;$j<=$total_qcount;$j++) {
				
					$question_id = $i.$j;
					
					$qmm_sql = mysql_query("SELECT * FROM internal_question_structure WHERE ass_tool='P' AND course_code='".$_POST['course_code']."'
					AND question_no='".$j."'") or die(mysql_query());
					$qmm = mysql_fetch_assoc($qmm_sql);
					
					mysql_query("UPDATE student_internal_practical_record SET q$j='".$_POST['q'.$question_id]."',mmq$j='".$qmm['max_marks']."'
					WHERE university_roll_no='".$_POST['university_roll_no'.$i]."' AND
					subject_code = '".$_POST['subject_code']."' AND 
					teacher_username = '".$_SESSION['username']."' AND
					backup='0'") or die(mysql_error());
				}

			}
			
			$internal_practical_marks_uploaded = "internal_practical_marks_uploaded";
			
			mysql_query("UPDATE time_table SET internal_practical_marks_uploaded='Y' WHERE
			branch_code='".$_POST['branch_code']."' AND
			course_code='".$_POST['course_code']."' AND
			aicte_rc='".$_POST['aicte_rc']."' AND
			shift='".$_POST['shift']."' AND
			full_part_time='".$_POST['full_part_time']."' AND
			ssection='".$_POST['ssection']."' AND
			sgroup='".$_POST['sgroup']."' AND
			subject_code='".$_POST['subject_code']."' AND
			teacher_username='".$_SESSION['username']."'") or die(mysql_error());
							
			
		echo "<center><span class='label label-success'>Internal Practical Marks Successfully Uploaded.</span></center>";
}




function teacher_update_internal_practical_marks() {
	
		$total_count = $_POST['total_count'];
		$total_qcount = $_POST['total_qcount'];


		$field_string = "id,university_roll_no,college_roll_no,remarks,last_updated_on,last_updated_by,revision,branch_code,course_code,aicte_rc,shift,full_part_time,ssection,sgroup,subject_code,theory_practical,paper_id,subject_title,semester,teacher_username,exam_month,exam_year";
		
	
		
		for($i=1;$i<=$total_count-1;$i++) {
			
			$details = fetch_resource_db('student_internal_practical_record',array('autoid'),array($_POST['assignment_id'.$i]),'resource_array','');
			
			
			
			
			
			$row = mysql_fetch_assoc($data);
			
			$update = 0;
			
			for($k=1;$k<=$total_qcount;$k++) {
				
					$qquestion_id = $i.$k;
					
					if($_POST['q'.$qquestion_id]!=$_POST['p_q'.$qquestion_id]) {
						
						$update = 1;
					}
					
					
			}
			
						
					
					if($update == 1) {
						$new_rev = $details['revision']+1;
				
						mysql_query("UPDATE student_internal_practical_record SET backup='1' WHERE
						autoid = '".$_POST['assignment_id'.$i]."'") or die(mysql_error());
					
					$student_details = fetch_resource_db('student_info',array('university_roll_no'),array($_POST['university_roll_no'.$i]),'resource_array','');
				
						mysql_query("INSERT INTO student_internal_practical_record ($field_string) 
							VALUES ('".$_POST['autoid']."',
							'".$_POST['university_roll_no'.$i]."',
							'".$student_details['college_roll_no']."',
							'".$_POST['remarks'.$i]."',
							'".date("Y-m-d H:i:s")."',
							'".$_SESSION['username']."',
							'0',
							'".$_POST['branch_code']."',
							'".$_POST['course_code']."',
							'".$_POST['aicte_rc']."',
							'".$_POST['shift']."',
							'".$_POST['full_part_time']."',
							'".$_POST['ssection']."',
							'".$_POST['sgroup']."',
							'".$_POST['subject_code']."',
							'P',
							'".$_POST['paper_id']."',
							'".$_POST['subject_title']."',
							'".$_POST['semester']."',
							'".$_SESSION['username']."',
							'".$_POST['exam_month']."',
							'".$_POST['exam_year']."'
							)") or die("H:".mysql_error());
					
				
					
					for($j=1;$j<=$total_qcount;$j++) {
						

						$question_id = $i.$j;
						
						$qmm_sql = mysql_query("SELECT * FROM internal_question_structure WHERE ass_tool='P' AND course_code='".$_POST['course_code']."'
						AND question_no='".$j."'") or die(mysql_query());
						$qmm = mysql_fetch_assoc($qmm_sql);
						
						mysql_query("UPDATE student_internal_practical_record SET q$j='".$_POST['q'.$question_id]."',mmq$j='".$qmm['max_marks']."',revision='".$new_rev."' 
						WHERE university_roll_no='".$_POST['university_roll_no'.$i]."' AND
						subject_code = '".$_POST['subject_code']."' AND 
						teacher_username = '".$_SESSION['username']."' AND
						backup='0'") or die(mysql_error());
						
					}
				}
		}
			
		echo "<center><span class='label label-success'>Internal Practical Marks Successfully Updated.</span></center>";
}



function teacher_upload_attendance_marks() {
	
		$total_count = $_POST['total_count'];
		$total_qcount = $_POST['total_qcount'];


		$field_string = "id,university_roll_no,college_roll_no,remarks,last_updated_on,last_updated_by,revision,branch_code,course_code,aicte_rc,shift,full_part_time,ssection,sgroup,subject_code,theory_practical,paper_id,subject_title,semester,teacher_username,exam_month,exam_year,attendance_marks";
	
		
		for($i=1;$i<=$total_count-1;$i++) {

			//$row = mysql_fetch_assoc($data);
			
			$student_details = fetch_resource_db('student_info',array('university_roll_no'),array($_POST['university_roll_no'.$i]),'resource_array','');
			
			
			
			mysql_query("INSERT INTO student_attendance_marks_record ($field_string) 
				VALUES ('".$_POST['autoid']."',
				'".$_POST['university_roll_no'.$i]."',
				'".$student_details['college_roll_no']."',
				'".$_POST['remarks'.$i]."',
				'".date("Y-m-d H:i:s")."',
				'".$_SESSION['username']."',
				'0',
				'".$_POST['branch_code']."',
				'".$_POST['course_code']."',
				'".$_POST['aicte_rc']."',
				'".$_POST['shift']."',
				'".$_POST['full_part_time']."',
				'".$_POST['ssection']."',
				'".$_POST['sgroup']."',
				'".$_POST['subject_code']."',
				'T',
				'".$_POST['paper_id']."',
				'".$_POST['subject_title']."',
				'".$_POST['semester']."',
				'".$_SESSION['username']."',
				'".$_POST['exam_month']."',
				'".$_POST['exam_year']."',
				'".$_POST['attendance_marks'.$i]."'
				)") or die("H:".mysql_error());
				

			}
			
							
			
		echo "<center><span class='label label-success'>Attendance Successfully Uploaded.</span></center>";
}






function teacher_update_attendance_marks() {
	
		$total_count = $_POST['total_count'];
		//$total_qcount = $_POST['total_qcount'];


		$field_string = "id,university_roll_no,college_roll_no,remarks,last_updated_on,last_updated_by,revision,branch_code,course_code,aicte_rc,shift,full_part_time,ssection,sgroup,subject_code,theory_practical,paper_id,subject_title,semester,teacher_username,exam_month,exam_year,attendance_marks";
		
	
		
		for($i=1;$i<=$total_count-1;$i++) {
			
			$details = fetch_resource_db('student_attendance_marks_record',array('autoid'),array($_POST['assignment_id'.$i]),'resource_array','');
			
			
			
			
			
			$row = mysql_fetch_assoc($data);
			
			$update = 0;
			
			if($_POST['q'.$i]!=$_POST['p_q'.$i]) {
						
				$update = 1;
			}
			
						
					
					if($update == 1) {
						$new_rev = $details['revision']+1;
				
						mysql_query("UPDATE student_attendance_marks_record SET backup='1' WHERE
						autoid = '".$_POST['attendance_id'.$i]."'") or die(mysql_error());
					
						$student_details = fetch_resource_db('student_info',array('university_roll_no'),array($_POST['university_roll_no'.$i]),'resource_array','');
				
						mysql_query("INSERT INTO student_attendance_marks_record ($field_string) 
							VALUES ('".$_POST['autoid']."',
							'".$_POST['university_roll_no'.$i]."',
							'".$student_details['college_roll_no']."',
							'".$_POST['remarks'.$i]."',
							'".date("Y-m-d H:i:s")."',
							'".$_SESSION['username']."',
							'".$new_rev."',
							'".$_POST['branch_code']."',
							'".$_POST['course_code']."',
							'".$_POST['aicte_rc']."',
							'".$_POST['shift']."',
							'".$_POST['full_part_time']."',
							'".$_POST['ssection']."',
							'".$_POST['sgroup']."',
							'".$_POST['subject_code']."',
							'T',
							'".$_POST['paper_id']."',
							'".$_POST['subject_title']."',
							'".$_POST['semester']."',
							'".$_SESSION['username']."',
							'".$_POST['exam_month']."',
							'".$_POST['exam_year']."',
							'".$_POST['q'.$i]."'
							)") or die("H:".mysql_error());
					

				}
		}
			
		echo "<center><span class='label label-success'>Attendance Marks Successfully Updated.</span></center>";
}




function lock_sessionalmarks() {
#echo "hello";
$update_sql="Update `sessionals_locks` set backup='1' where `course_code`='".$_POST['course_code']."' AND
		branch_code='".$_POST['branch_code']."' AND
		shift='".$_POST['shift']."' AND
		paper_id='".$_POST['paper_id']."' AND
		m_code='".$_POST['m_code']."' AND
		ssection='".$_POST['ssection']."' AND
		semester='".$_POST['semester']."' AND
		teacher_username='".$_SESSION['username']."' AND
		subject_code='".$_POST['subject_code']."' AND aicte_rc='".$_POST['aicte_rc']."' AND
		full_part_time='".$_POST['full_part_time']."' and backup='0' and sessional_no='".$_POST['sessional_no']."'; ";
mysql_query($update_sql);

$insert_sql="INSERT INTO `sessionals_locks`( `course_code`, `branch_code`, `subject_code`, `m_code`, `subject_title`, `shift`, `full_part_time`, `aicte_rc`, `paper_id`, `semester`, `ssection`, `sgroup`, `teacher_username`, `sessional_no`, `lock_updated_on`,`backup`, `sessional_lock_status`) VALUES ('".$_POST['course_code']."' ,'".$_POST['branch_code']."','".$_POST['subject_code']."','".$_POST['m_code']."','".$_POST['subject_title']."','".$_POST['shift']."','".$_POST['full_part_time']."','".$_POST['aicte_rc']."','".$_POST['paper_id']."','".$_POST['semester']."','".$_POST['ssection']."' ,'".$_POST['sgroup']."' ,'".$_SESSION['username']."','".$_POST['sessional_no']."','".date('Y-m-d H:i:s')."','0','1')";

mysql_query($insert_sql);

show_label('success','Record Locked for Sessional No.'.$_POST['sessional_no'].'');
}


function lock_consolidated_report() {


$number_array = array();
$sessional_marks_array = array();
$assignment_marks_array = array();
$sess3 = 0;
$internal_marks = array();


$check_entry_crl = mysql_query("SELECT * FROM consolidated_report_lock WHERE
semester='".$_POST['semester']."' AND
branch_code='".$_POST['branch_code']."' AND
course_code='".$_POST['course_code']."' AND
subject_code='".$_POST['subject_code']."' AND
shift='".$_POST['shift']."' AND
ssection='".$_POST['ssection']."' AND
teacher_username='".$_SESSION['username']."' AND
backup='0' AND
consolidated_report_lock_status='1'") or die(mysql_error());

if(mysql_num_rows($check_entry_crl)==0) {
	$insert_sql="INSERT INTO `consolidated_report_lock`( `course_code`, `branch_code`, `subject_code`, `m_code`, `subject_title`, `shift`, `full_part_time`, `aicte_rc`, `paper_id`, `semester`, `ssection`, `sgroup`, `teacher_username`, `lock_updated_on`,`backup`, `consolidated_report_lock_status`) VALUES ('".$_POST['course_code']."' ,'".$_POST['branch_code']."','".$_POST['subject_code']."','".$_POST['m_code']."','".$_POST['subject_title']."','".$_POST['shift']."','".$_POST['full_part_time']."','".$_POST['aicte_rc']."','".$_POST['paper_id']."','".$_POST['semester']."','".$_POST['ssection']."' ,'".$_POST['sgroup']."' ,'".$_SESSION['username']."','".date('Y-m-d H:i:s')."','0','1')";

	mysql_query($insert_sql) or die(mysql_error());
	
}



$roll_nos = mysql_query("SELECT * FROM student_info WHERE
course_code='".$_POST['course_code']."' AND
branch_code='".$_POST['branch_code']."' AND
shift='".$_POST['shift']."' AND
ssection='".$_POST['ssection']."' AND
semester='".$_POST['semester']."' AND
aicte_rc='".$_POST['aicte_rc']."' AND
full_part_time='".$_POST['full_part_time']."' AND
student_status='Onroll'
ORDER BY university_roll_no ASC") or die(mysql_error());



while($row = mysql_fetch_assoc($roll_nos)) {
	
	$check_entry_sitr = mysql_query("SELECT * FROM student_internal_theory_record WHERE
	university_roll_no='".$row['university_roll_no']."' AND
	semester='".$_POST['semester']."' AND
	branch_code='".$_POST['branch_code']."' AND
	course_code='".$_POST['course_code']."' AND
	subject_code='".$_POST['subject_code']."'") or die(mysql_error());
	
	if(mysql_num_rows($check_entry_sitr)==0) {
		
		mysql_query("INSERT INTO student_internal_theory_record (course_code,branch_code,shift,ssection,semester,aicte_rc,full_part_time,student_name,father_name,university_roll_no,college_roll_no,subject_code,m_code,paper_id,subject_title,theory_practical,teacher_username,exam_month,exam_year)
		VALUES (
		'".$_POST['course_code']."',
		'".$_POST['branch_code']."',
		'".$_POST['shift']."',
		'".$_POST['ssection']."',
		'".$_POST['semester']."',
		'".$_POST['aicte_rc']."',
		'".$_POST['full_part_time']."',
		'".$row['ptu_student_name']."',
		'".$row['ptu_father_name']."',
		'".$row['university_roll_no']."',
		'".$row['college_roll_no']."',
		'".$_POST['subject_code']."',
		'".$_POST['m_code']."',
		'".$_POST['paper_id']."',
		'".$_POST['subject_title']."',
		'".$_POST['theory_practical']."',
		'".$_SESSION['username']."',
		'".date('m')."',
		'".date('Y')."'
		)") or die(mysql_error());
		
	}
	
	for($k=1;$k<=3;$k++) {
		$total_questions = mysql_query("SELECT * FROM internal_question_structure WHERE ass_tool='S' AND course_code='".$_POST['course_code']."' AND sessional_no='".$k."'") or die(mysql_query());

		$total_qcount = mysql_num_rows($total_questions);
			
		for($i=1;$i<=mysql_num_rows($total_questions);$i++) {
				
			$question_id = 'q'.$i;
				
			$qmm_sql = mysql_query("SELECT * FROM internal_question_structure WHERE ass_tool='S' AND course_code='".$_POST['course_code']."'
			AND question_no='".$i."' AND sessional_no='".$k."'") or die(mysql_query());
			$qmm = mysql_fetch_assoc($qmm_sql);
			
			$amarks_sql = mysql_query("SELECT $question_id FROM student_sessionals_record WHERE
			university_roll_no='".$row['university_roll_no']."' AND
			subject_code = '".$_POST['subject_code']."' AND
			sessional_no = '".$k."' AND
			backup = '0'") or die(mysql_error());
			
			$amarks = mysql_fetch_assoc($amarks_sql);
			
			$question_id = "q".$i;
				
			$number_array[] = $amarks[$question_id];
				
		}
			
		$sessional_no_id = "sessional".$k."_marks";	
		
		mysql_query("UPDATE student_internal_theory_record SET ".$sessional_no_id."='".array_sum($number_array)."' WHERE 
		university_roll_no='".$row['university_roll_no']."' AND
		semester='".$_POST['semester']."' AND
		branch_code='".$_POST['branch_code']."' AND
		course_code='".$_POST['course_code']."' AND
		subject_code='".$_POST['subject_code']."'") or die(mysql_error());
			
			
		$sessional_marks_array[] = round(array_sum($number_array));

		if($k==3) {
			$sess3= round(array_sum($number_array));
		}
		unset($number_array);
					
	}

	if($_POST['course_code']==1) {
		$tmp = array_pop($sessional_marks_array);
	}
	
	rsort($sessional_marks_array);
	
	$max1 = $sessional_marks_array[0];
	

	if($_POST['course_code']==1) {
		$max2 = $sess3;
	}
	else {
		$max2 = $sessional_marks_array[1];
	}
	
	$average = round((($max1)+($max2))/(2));
	
	$internal_marks[] = $average;
	
	mysql_query("UPDATE student_internal_theory_record SET sessional_obtained_marks='".$average."' WHERE 
	university_roll_no='".$row['university_roll_no']."' AND
	semester='".$_POST['semester']."' AND
	branch_code='".$_POST['branch_code']."' AND
	course_code='".$_POST['course_code']."' AND
	subject_code='".$_POST['subject_code']."'") or die(mysql_error());
	
	unset($sessional_marks_array);
	
	
	
	
	
	
	for($k=1;$k<=3;$k++) {
		$total_questions = mysql_query("SELECT * FROM internal_question_structure WHERE ass_tool='A' AND course_code='".$_POST['course_code']."'") or die(mysql_query());

		$total_qcount = mysql_num_rows($total_questions);
			
			for($i=1;$i<=mysql_num_rows($total_questions);$i++) {
				
				$question_id = 'q'.$i;
				
				$qmm_sql = mysql_query("SELECT * FROM internal_question_structure WHERE ass_tool='A' AND course_code='".$_POST['course_code']."'
				AND question_no='".$i."'") or die(mysql_query());
				$qmm = mysql_fetch_assoc($qmm_sql);
			
				$amarks_sql = mysql_query("SELECT $question_id FROM student_assignment_record WHERE
				university_roll_no='".$row['university_roll_no']."' AND
				subject_code = '".$_POST['subject_code']."' AND
				assignment_no = '".$k."' AND
				backup = '0'") or die(mysql_error());
				
				$amarks = mysql_fetch_assoc($amarks_sql);
				
				$question_id = "q".$i;
				
				$number_array[] = $amarks[$question_id];
				
			}
				
			$assignment_no_id = "assignment".$k."_marks";	
				
			mysql_query("UPDATE student_internal_theory_record SET ".$assignment_no_id."='".array_sum($number_array)."' WHERE 
			university_roll_no='".$row['university_roll_no']."' AND
			semester='".$_POST['semester']."' AND
			branch_code='".$_POST['branch_code']."' AND
			course_code='".$_POST['course_code']."' AND
			subject_code='".$_POST['subject_code']."'") or die(mysql_error());
			
			$assignment_marks_array[] = round(array_sum($number_array));
			unset($number_array);
					
	}
	
	
	$average = round((array_sum($assignment_marks_array))/(3));
	
	$internal_marks[] = $average;
	
	mysql_query("UPDATE student_internal_theory_record SET assignment_obtained_marks='".$average."' WHERE 
	university_roll_no='".$row['university_roll_no']."' AND
	semester='".$_POST['semester']."' AND
	branch_code='".$_POST['branch_code']."' AND
	course_code='".$_POST['course_code']."' AND
	subject_code='".$_POST['subject_code']."'") or die(mysql_error());
	
	unset($assignment_marks_array);
	
	
	
	$amarks_sql = mysql_query("SELECT attendance_marks FROM student_attendance_marks_record WHERE
	university_roll_no='".$row['university_roll_no']."' AND
	subject_code = '".$_POST['subject_code']."' AND
    backup = '0'") or die(mysql_error());
			 
	$amarks = mysql_fetch_assoc($amarks_sql);
	
	mysql_query("UPDATE student_internal_theory_record SET attendance_marks='".$amarks['attendance_marks']."' WHERE 
	university_roll_no='".$row['university_roll_no']."' AND
	semester='".$_POST['semester']."' AND
	branch_code='".$_POST['branch_code']."' AND
	course_code='".$_POST['course_code']."' AND
	subject_code='".$_POST['subject_code']."'") or die(mysql_error());
	
	$internal_marks[] = round($amarks['attendance_marks']);
	
	
	mysql_query("UPDATE student_internal_theory_record SET internal_obtained_marks='".round(array_sum($internal_marks))."' WHERE 
	university_roll_no='".$row['university_roll_no']."' AND
	semester='".$_POST['semester']."' AND
	branch_code='".$_POST['branch_code']."' AND
	course_code='".$_POST['course_code']."' AND
	subject_code='".$_POST['subject_code']."'") or die(mysql_error());
	
	$count++;
	
	unset($internal_marks);
	
}


show_label('success','Record Locked');
}



function unlock_consolidated_report() {

$update_sql="Update `consolidated_report_lock` set 

backup='1',
consolidated_report_lock_status='0',
unlock_updated_on=now(),
unlock_updated_by='".$_SESSION['username']."'
 

where 

`course_code`='".$_POST['course_code']."' AND
		branch_code='".$_POST['branch_code']."' AND
		shift='".$_POST['shift']."' AND
		paper_id='".$_POST['paper_id']."' AND
		m_code='".$_POST['m_code']."' AND
		ssection='".$_POST['ssection']."' AND
		semester='".$_POST['semester']."' AND
		teacher_username='".$_POST['teacher_username']."' AND
		subject_code='".$_POST['subject_code']."' AND aicte_rc='".$_POST['aicte_rc']."' AND
		full_part_time='".$_POST['full_part_time']."' and backup='0'; ";
mysql_query($update_sql) or die(mysql_error());

mysql_query("DELETE FROM student_internal_theory_record WHERE
		branch_code='".$_POST['branch_code']."' AND
		course_code='".$_POST['course_code']."' AND
		shift='".$_POST['shift']."' AND
		paper_id='".$_POST['paper_id']."' AND
		m_code='".$_POST['m_code']."' AND
		ssection='".$_POST['ssection']."' AND
		semester='".$_POST['semester']."' AND
		teacher_username='".$_POST['teacher_username']."' AND
		subject_code='".$_POST['subject_code']."' AND aicte_rc='".$_POST['aicte_rc']."' AND
		full_part_time='".$_POST['full_part_time']."'") or die(mysql_error());


show_label('success','Record Un-locked');
}


function lock_sessional_module() {
	
	
	mysql_query("UPDATE time_table SET internal_lock_status='1' WHERE
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
		full_part_time='".$_POST['full_part_time']."'") or die(mysql_error());
		
	
	$details = fetch_resource_db('time_table',array('autoid'),array($_POST['autoid']),'resource_array','');
	
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
	
	
	//$roll_nos = mysql_query("SELECT DISTINCT university_roll_no FROM student_sessionals_record WHERE id='".$_POST['autoid']."' AND backup='0' ORDER BY university_roll_no ASC") or die(mysql_error());

	$count = 1;
	while($row = mysql_fetch_assoc($roll_nos)) {
	
	$details1 = fetch_resource_db('student_sessionals_record',array('university_roll_no','sessional_no','backup','subject_code'),array($row['university_roll_no'],'1','0',$_POST['subject_code']),'resource_array','');
	
	$details2 = fetch_resource_db('student_sessionals_record',array('university_roll_no','sessional_no','backup','subject_code'),array($row['university_roll_no'],'2','0',$_POST['subject_code']),'resource_array','');
	
	$details3 = fetch_resource_db('student_sessionals_record',array('university_roll_no','sessional_no','backup','subject_code'),array($row['university_roll_no'],'3','0',$_POST['subject_code']),'resource_array','');
	
	$adetails1 = fetch_resource_db('student_assignment_record',array('university_roll_no','assignment_no','backup','subject_code'),array($row['university_roll_no'],'1','0',$_POST['subject_code']),'resource_array','');
	
	$adetails2 = fetch_resource_db('student_assignment_record',array('university_roll_no','assignment_no','backup','subject_code'),array($row['university_roll_no'],'2','0',$_POST['subject_code']),'resource_array','');
	
	$adetails3 = fetch_resource_db('student_assignment_record',array('university_roll_no','assignment_no','backup','subject_code'),array($row['university_roll_no'],'3','0',$_POST['subject_code']),'resource_array','');
	
	
	$aaverage = round((($adetails1['assignment_obtained_marks'])+($adetails2['assignment_obtained_marks'])+($adetails3['assignment_obtained_marks']))/1);
	
	$details_agg_att = fetch_resource_db('aggregate_attendance_student',array('university_roll_no','backup','subject_code'),array($row['university_roll_no'],'0',$_POST['subject_code']),'resource_array','');
	
	
	if($details1['attendance_status']=='Absent') {
		$details1['obtained_marks']='A';
	}
	else {
		$number_array[] = $details1['obtained_marks'];
	}
	
	if($details2['attendance_status']=='Absent') {
		$details2['obtained_marks']='A';
	}
	else {
		$number_array[] = $details2['obtained_marks'];
	}
	
	if($details3['attendance_status']=='Absent') {
		$details3['obtained_marks']='A';
	}
	else {
		$number_array[] = $details3['obtained_marks'];
	}
	
	$total_att = $details_agg_att['total_lectures'];
	$attd_att = $details_agg_att['attended_lectures'];
	
	//$final_att = ((($attd_att)/($total_att))*6);
	$final_att = $details_agg_att['attendance_marks'];
	
	
	rsort($number_array);
	
	$max1 = $number_array[0];
	$max2 = $number_array[1];
	
	$average = round((($max1)+($max2))/(2));
	
	$final_internal_marks = (($average)+(round($final_att))+($aaverage));
	
	mysql_query("UPDATE student_sessionals_record SET final_internal_marks='".$final_internal_marks."' WHERE subject_code='".$_POST['subject_code']."' AND university_roll_no='".$row['university_roll_no']."' AND backup='0'") or die(mysql_error());
	
	unset($number_array);		
}
	
	show_label('success','Record Locked. You can now print the record');
	
}


?>

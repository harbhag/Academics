<?php 



$total_questions = mysql_query("SELECT * FROM internal_question_structure WHERE ass_tool='P' AND course_code='".$course_branch[0]."'") or die(mysql_query());
	
	//$course_codes = mysql_query("SELECT DISTINCT course_code FROM internal_ques_co_relation where ass_tool='S'") or die(mysql_error());
	//$branch_codes = mysql_query("SELECT DISTINCT branch_code FROM internal_ques_co_relation where ass_tool='S'") or die(mysql_error());
	$subject_codes = mysql_query("SELECT DISTINCT subject_code FROM internal_ques_co_relation where 
	ass_tool='P' AND
	branch_code='".$course_branch[1]."' AND
	course_code='".$course_branch[0]."'
	") or die(mysql_error());
	
	while($sc = mysql_fetch_assoc($subject_codes)) {
	
		while($tq = mysql_fetch_assoc($total_questions)) {
		
		
			$program_cos_id_sql = mysql_query("SELECT DISTINCT program_cos_id FROM internal_ques_co_relation WHERE
			branch_code='".$course_branch[1]."' AND
			course_code='".$course_branch[0]."' AND
			subject_code='".$sc['subject_code']."' AND
			backup='0' AND
			ass_tool='P' AND
			question_number = '".$tq['question_no']."'") or die(mysql_error());
			
			$question_id = "q".$tq['question_no'];
			$mquestion_id = "mmq".$tq['question_no'];
			
			$total_marks_obt_sql = mysql_query("SELECT SUM(".$question_id.") as obt FROM student_internal_practical_record WHERE 
			branch_code='".$course_branch[1]."' AND
			course_code='".$course_branch[0]."' AND
			backup='0' AND
			subject_code='".$sc['subject_code']."'") or die(mysql_error());
			
			$total_marks_max_sql = mysql_query("SELECT SUM(".$mquestion_id.") maxm FROM student_internal_practical_record WHERE 
			branch_code='".$course_branch[1]."' AND
			course_code='".$course_branch[0]."' AND
			backup='0' AND
			subject_code='".$sc['subject_code']."'") or die(mysql_error());
			
			$semester_sql = mysql_query("SELECT DISTINCT semester FROM student_internal_practical_record WHERE 
			branch_code='".$course_branch[1]."' AND
			course_code='".$course_branch[0]."' AND
			backup='0' AND
			subject_code='".$sc['subject_code']."'") or die(mysql_error());
			
			$semester = mysql_fetch_assoc($semester_sql);
			
			$total_marks_obt = mysql_fetch_assoc($total_marks_obt_sql);
			$total_marks_max = mysql_fetch_assoc($total_marks_max_sql);
			
			$avg = round(($total_marks_obt['obt']/$total_marks_max['maxm'])*100,2);
			
			while($pci = mysql_fetch_assoc($program_cos_id_sql)) {
				
				$program_cos_details_sql = mysql_query("SELECT * FROM program_cos WHERE id='".$pci['program_cos_id']."'") or die(mysql_error());
				
				$program_cos_details = mysql_fetch_assoc($program_cos_details_sql);
				
				//echo $program_cos_details['co_number']."<br/>";
				//echo "<br/>".$program_cos_details['correlation_po'];
				//echo "<br/>".$program_cos_details['program_outcome_id'];
				
				$check_dup_sql = mysql_query("SELECT autoid FROM co_po_peo_analysis WHERE
				branch_code='".$course_branch[1]."' AND
				course_code='".$course_branch[0]."' AND
				ass_tool='P' AND
				question_number='".$tq['question_no']."' AND
				program_outcome_id='".$program_cos_details['program_outcome_id']."' AND
				co_number='".$program_cos_details['co_number']."' AND
				correlation_po='".$program_cos_details['correlation_po']."' AND
				subject_code='".$sc['subject_code']."'") or die(mysql_error());
				
				
				if(mysql_num_rows($check_dup_sql)!=0) {
					$check_dup = mysql_fetch_assoc($check_dup_sql);
					mysql_query("DELETE FROM co_po_peo_analysis WHERE autoid='".$check_dup['autoid']."'") or die(mysql_error());
				}
				
				
				mysql_query("INSERT INTO `co_po_peo_analysis` (
				`course_code` ,
				`branch_code` ,
				`subject_code` ,
				`ass_tool` ,
				`semester` ,
				`question_number` ,
				`program_outcome_id` ,
				`co_number` ,
				`correlation_po` ,
				`avg_per`
				)
				VALUES (
			'".$course_branch[0]."', 
				'".$course_branch[1]."', 
				'".$sc['subject_code']."', 
				'P', 
				'".$semester['semester']."', 
				'".$tq['question_no']."', 
				'".$program_cos_details['program_outcome_id']."', 
				'".$program_cos_details['co_number']."', 
				'".$program_cos_details['correlation_po']."', 
				'".$avg."'
				)") or die(mysql_error());
				
				
			}
				
			
		}
		
	}

?>

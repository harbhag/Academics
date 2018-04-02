<?php

function add_sessional_co_que_mapping_details() {
	
	for($i=1;$i<=$_POST['total_count'];$i++) {
		
		for($k=1;$k<=$_POST['total_questions'];$k++) {
			
			$question_id = $i.$k;
			
			if($_POST['q'.$question_id]!='') {
				
					mysql_query("UPDATE internal_ques_co_relation set backup='1',last_updated_on=now(),last_updated_by='".$_SESSION['username']."' WHERE branch_code='".$_POST['branch_code']."' AND
					course_code='".$_POST['course_code']."' AND
					scheme_code='".$_POST['scheme_code']."' AND
					subject_code='".$_POST['subject_code']."' AND
					ass_tool='".$_POST['ass_tool']."' AND
					sessional_assign_no='".$_POST['sessional_no']."' AND
					question_number='".$k."' AND
					program_cos_id='".$_POST['program_cos_id'.$i]."' AND
					backup='0'") or die(mysql_error());
					
					$co_relation = mysql_query("SELECT * FROM internal_ques_co_relation WHERE
					branch_code='".$_POST['branch_code']."' AND
					course_code='".$_POST['course_code']."' AND
					scheme_code='".$_POST['scheme_code']."' AND
					subject_code='".$_POST['subject_code']."' AND
					ass_tool='".$_POST['ass_tool']."' AND
					sessional_assign_no='".$_POST['sessional_no']."' AND
					question_number='".$k."' AND
					program_cos_id='".$_POST['program_cos_id'.$i]."' AND
					backup='0'") or die(mysql_error());
					
					if(mysql_num_rows($co_relation)==0) {
					
						mysql_query("INSERT INTO internal_ques_co_relation 
						(branch_code,
						course_code,
						scheme_code,
						subject_code,
						m_code,
						ass_tool,
						sessional_assign_no,
						question_number,
						program_cos_id,
						exam_month,
						exam_year,
						last_updated_on,
						last_updated_by)
						
						VALUES
						(
						'".$_POST['branch_code']."',
						'".$_POST['course_code']."',
						'".$_POST['scheme_code']."',
						'".$_POST['subject_code']."',
						'".$_POST['m_code']."',
						'".$_POST['ass_tool']."',
						'".$_POST['sessional_no']."',
						'".$k."',
						'".$_POST['program_cos_id'.$i]."',
						'".exam_month_finder(date('n'))."',
						'".date('Y')."',
						now(),
						'".$_SESSION['username']."'
						)") or die("dsfsad".mysql_error());
				}
			}
				
			
			if($_POST['q'.$question_id]=='') {
				
				mysql_query("UPDATE internal_ques_co_relation set backup='1',last_updated_on=now(),last_updated_by='".$_SESSION['username']."' WHERE branch_code='".$_POST['branch_code']."' AND
					course_code='".$_POST['course_code']."' AND
					scheme_code='".$_POST['scheme_code']."' AND
					subject_code='".$_POST['subject_code']."' AND
					ass_tool='".$_POST['ass_tool']."' AND
					sessional_assign_no='".$_POST['sessional_no']."' AND
					question_number='".$k."' AND
					program_cos_id='".$_POST['program_cos_id'.$i]."' AND
					backup='0'") or die(mysql_error());
			
			}
			
		}
	}
	
	show_label("success","Ques/CO Mapping Updated");
	
}




function add_assignment_co_que_mapping_details() {
	
	for($i=1;$i<=$_POST['total_count'];$i++) {
		
		for($k=1;$k<=$_POST['total_questions'];$k++) {
			
			$question_id = $i.$k;
			
			if($_POST['q'.$question_id]!='') {
				
					mysql_query("UPDATE internal_ques_co_relation set backup='1',last_updated_on=now(),last_updated_by='".$_SESSION['username']."' WHERE branch_code='".$_POST['branch_code']."' AND
					course_code='".$_POST['course_code']."' AND
					scheme_code='".$_POST['scheme_code']."' AND
					subject_code='".$_POST['subject_code']."' AND
					ass_tool='".$_POST['ass_tool']."' AND
					sessional_assign_no='".$_POST['assignment_no']."' AND
					question_number='".$k."' AND
					program_cos_id='".$_POST['program_cos_id'.$i]."' AND
					backup='0'") or die(mysql_error());
					
					$co_relation = mysql_query("SELECT * FROM internal_ques_co_relation WHERE
					branch_code='".$_POST['branch_code']."' AND
					course_code='".$_POST['course_code']."' AND
					scheme_code='".$_POST['scheme_code']."' AND
					subject_code='".$_POST['subject_code']."' AND
					ass_tool='".$_POST['ass_tool']."' AND
					sessional_assign_no='".$_POST['assignment_no']."' AND
					question_number='".$k."' AND
					program_cos_id='".$_POST['program_cos_id'.$i]."' AND
					backup='0'") or die(mysql_error());
					
					if(mysql_num_rows($co_relation)==0) {
					
						mysql_query("INSERT INTO internal_ques_co_relation 
						(branch_code,
						course_code,
						scheme_code,
						subject_code,
						m_code,
						ass_tool,
						sessional_assign_no,
						question_number,
						program_cos_id,
						exam_month,
						exam_year,
						last_updated_on,
						last_updated_by)
						
						VALUES
						(
						'".$_POST['branch_code']."',
						'".$_POST['course_code']."',
						'".$_POST['scheme_code']."',
						'".$_POST['subject_code']."',
						'".$_POST['m_code']."',
						'".$_POST['ass_tool']."',
						'".$_POST['assignment_no']."',
						'".$k."',
						'".$_POST['program_cos_id'.$i]."',
						'".exam_month_finder(date('n'))."',
						'".date('Y')."',
						now(),
						'".$_SESSION['username']."'
						)") or die("dsfsad".mysql_error());
				}
			}
				
			
			if($_POST['q'.$question_id]=='') {
				
				mysql_query("UPDATE internal_ques_co_relation set backup='1',last_updated_on=now(),last_updated_by='".$_SESSION['username']."' WHERE branch_code='".$_POST['branch_code']."' AND
					course_code='".$_POST['course_code']."' AND
					scheme_code='".$_POST['scheme_code']."' AND
					subject_code='".$_POST['subject_code']."' AND
					ass_tool='".$_POST['ass_tool']."' AND
					sessional_assign_no='".$_POST['assignment_no']."' AND
					question_number='".$k."' AND
					program_cos_id='".$_POST['program_cos_id'.$i]."' AND
					backup='0'") or die(mysql_error());
			
			}
			
		}
	}
	
	show_label("success","Ques/CO Mapping Updated");
	
}



function add_internal_practical_co_que_mapping_details() {

	
	for($i=1;$i<=$_POST['total_count'];$i++) {
		
		for($k=1;$k<=$_POST['total_questions'];$k++) {
			
			$question_id = $i.$k;
			
			if($_POST['q'.$question_id]!='') {
				
					mysql_query("UPDATE internal_ques_co_relation set backup='1',last_updated_on=now(),last_updated_by='".$_SESSION['username']."' WHERE branch_code='".$_POST['branch_code']."' AND
					course_code='".$_POST['course_code']."' AND
					scheme_code='".$_POST['scheme_code']."' AND
					subject_code='".$_POST['subject_code']."' AND
					ass_tool='".$_POST['ass_tool']."' AND
					sessional_assign_no='".$_POST['ip_no']."' AND
					question_number='".$k."' AND
					program_cos_id='".$_POST['program_cos_id'.$i]."' AND
					backup='0'") or die(mysql_error());
					
					$co_relation = mysql_query("SELECT * FROM internal_ques_co_relation WHERE
					branch_code='".$_POST['branch_code']."' AND
					course_code='".$_POST['course_code']."' AND
					scheme_code='".$_POST['scheme_code']."' AND
					subject_code='".$_POST['subject_code']."' AND
					ass_tool='".$_POST['ass_tool']."' AND
					sessional_assign_no='".$_POST['ip_no']."' AND
					question_number='".$k."' AND
					program_cos_id='".$_POST['program_cos_id'.$i]."' AND
					backup='0'") or die(mysql_error());
					
					if(mysql_num_rows($co_relation)==0) {
					
						mysql_query("INSERT INTO internal_ques_co_relation 
						(branch_code,
						course_code,
						scheme_code,
						subject_code,
						m_code,
						ass_tool,
						sessional_assign_no,
						question_number,
						program_cos_id,
						exam_month,
						exam_year,
						last_updated_on,
						last_updated_by)
						
						VALUES
						(
						'".$_POST['branch_code']."',
						'".$_POST['course_code']."',
						'".$_POST['scheme_code']."',
						'".$_POST['subject_code']."',
						'".$_POST['m_code']."',
						'".$_POST['ass_tool']."',
						'".$_POST['ip_no']."',
						'".$k."',
						'".$_POST['program_cos_id'.$i]."',
						'".exam_month_finder(date('n'))."',
						'".date('Y')."',
						now(),
						'".$_SESSION['username']."'
						)") or die("dsfsad".mysql_error());
				}
			}
				
			
			if($_POST['q'.$question_id]=='') {
				
				mysql_query("UPDATE internal_ques_co_relation set backup='1',last_updated_on=now(),last_updated_by='".$_SESSION['username']."' WHERE branch_code='".$_POST['branch_code']."' AND
					course_code='".$_POST['course_code']."' AND
					scheme_code='".$_POST['scheme_code']."' AND
					subject_code='".$_POST['subject_code']."' AND
					ass_tool='".$_POST['ass_tool']."' AND
					sessional_assign_no='".$_POST['ip_no']."' AND
					question_number='".$k."' AND
					program_cos_id='".$_POST['program_cos_id'.$i]."' AND
					backup='0'") or die(mysql_error());
			
			}
			
		}
	}
	
	show_label("success","Ques/CO Mapping Updated");
	
}

?>

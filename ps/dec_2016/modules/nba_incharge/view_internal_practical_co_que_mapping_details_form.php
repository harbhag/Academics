<?php

$scheme_master = mysql_query("SELECT *  from scheme_master  where scheme_code='".$_POST['scheme_code']."' and branch_code='".$_POST['branch_code']."' and subject_code='".$_POST['subject_code']."' and theory_practical='P' and semester='".$_POST['semester']."'; ");

$row_sm = mysql_fetch_assoc($scheme_master);

$total_questions = mysql_query("SELECT * FROM internal_question_structure WHERE ass_tool='P' AND course_code='".$row_sm['course_code']."'") or die(mysql_query());

$total_qcount = mysql_num_rows($total_questions);

show_label('info','Subject Detail ');
echo "<br/>
	<table  class='table table-bordered table-condensed container'>
	<tr class='warning'>
	<th>Subject Code / M Code</th>
	<th>Subject Title</th>
	<th>Semester</th>
	<th>Theory / Practical</th>
	<th>Scheme Code</th>
	<th>Sessional No.</th>
	</tr>
	<tr class='warning'>
	<td>".$row_sm['subject_code']." / ".$row_sm['m_code']."</td>
	<td>".$row_sm['subject_title']."</td>
	<td>".$row_sm['semester']."</td>
	<td>".$row_sm['theory_practical']."</td>
	<td>".$row_sm['scheme_code']."</td>
	<td>".$_POST['sessional_no']."</td>
	</tr></table>";
//include('modules/modals/nba_incharge/add_course_outcomes_form.php');

$program_cos_result_1 = mysql_query("Select * from program_cos where backup='0' and scheme_code='".$_POST['scheme_code']."' and branch_code='".$_POST['branch_code']."' and subject_code='".$_POST['subject_code']."' ; ");

show_label('info','Questions/Course Outcomes Mappings Detail');
echo "<br/><table  class='table table-bordered   table-condensed container'>
	<tr>
	<th>CO Number</th>
	<th>CO Statement</th>";
		for($i=1;$i<=mysql_num_rows($total_questions);$i++) {
			echo "<th>Q".$i."</th>";
		}
		
	echo "
	<th>Program Outcomes</th>";
	
	$cos_sql = mysql_query("SELECT DISTINCT co_number,co_statement FROM program_cos WHERE 
	branch_code='".$_POST['branch_code']."' AND
	course_code='".$row_sm['course_code']."' AND
	scheme_code='".$_POST['scheme_code']."' AND
	subject_code='".$_POST['subject_code']."' AND
	backup='0' ORDER BY co_number ASC") or die(mysql_error());
	
	while($cos = mysql_fetch_assoc($cos_sql)) {
		echo "<tr>";
		echo "<td>".$cos['co_number']."</td>";
		echo "<td>".$cos['co_statement']."</td>";
		
		$program_cos_sql = mysql_query("SELECT id FROM program_cos WHERE 
		branch_code='".$_POST['branch_code']."' AND
		course_code='".$row_sm['course_code']."' AND
		scheme_code='".$_POST['scheme_code']."' AND
		subject_code='".$_POST['subject_code']."' AND
		co_number='".$cos['co_number']."' AND
		backup='0' ORDER BY co_number ASC") or die(mysql_error());
		
		$pcos = array();
		
		while($program_cos = mysql_fetch_assoc($program_cos_sql)) {
			$pcos[] = $program_cos['id'];
		}
		
		$pcos_s = implode(',',$pcos);
		
		for($i=1;$i<=mysql_num_rows($total_questions);$i++) {
			$que_co_sql = mysql_query("SELECT * FROM internal_ques_co_relation WHERE 
			branch_code='".$_POST['branch_code']."' AND
			course_code='".$row_sm['course_code']."' AND
			scheme_code='".$_POST['scheme_code']."' AND
			subject_code='".$_POST['subject_code']."' AND
			ass_tool='P' AND
			program_cos_id IN (".$pcos_s.") AND
			question_number = '".$i."' AND
			backup='0'") or die(mysql_error());
			
			if(mysql_num_rows($que_co_sql) > 0 ) {
				echo "<td><span style='color:#3A87AD;font-size:20px'>&#10004</span></td>";
			}
			else{
				echo "<td></td>";
			}
		}
		
		
			$program_outcome_id_sql = mysql_query("SELECT program_outcome_id  FROM program_cos WHERE 
			branch_code='".$_POST['branch_code']."' AND
			course_code='".$row_sm['course_code']."' AND
			scheme_code='".$_POST['scheme_code']."' AND
			subject_code='".$_POST['subject_code']."' AND
			id IN (".$pcos_s.") AND
			backup='0' ORDER BY co_number ASC") or die(mysql_error());
			
			$pos_id = array();
		
			while($program_outcome_id = mysql_fetch_assoc($program_outcome_id_sql)) {
				$pos_id[] = $program_outcome_id['program_outcome_id'];
			}
		
			$pos_id_s = implode(',',$pos_id);
			
			$program_outcome_sql = mysql_query("SELECT po_num FROM program_outcomes WHERE
			branch_code='".$_POST['branch_code']."' AND
			course_code='".$row_sm['course_code']."' AND
			id IN (".$pos_id_s.") ORDER BY po_num ASC") or die(mysql_error());
			
			$program_out_id = array();
		
			while($program_outcome = mysql_fetch_assoc($program_outcome_sql)) {
				$program_out_id[] = $program_outcome['po_num'];
			}
		
			$program_out_id_s = implode(', ',$program_out_id);
			
			echo "<td><span style='color:#3A87AD;font-weight:bold'>".$program_out_id_s."</span></td>";
		
		
		echo "</tr>";
	}
	
	

echo "</table>";
?>



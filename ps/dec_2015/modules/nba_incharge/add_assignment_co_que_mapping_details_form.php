<?php

$scheme_master = mysql_query("SELECT *  from scheme_master  where scheme_code='".$_POST['scheme_code']."' and branch_code='".$_POST['branch_code']."' and subject_code='".$_POST['subject_code']."' and theory_practical='T' and semester='".$_POST['semester']."'; ");

$row_sm = mysql_fetch_assoc($scheme_master);
show_label('info','Subject Detail ');
echo "<br/>
	<table  class='table table-bordered table-condensed container'>
	<tr class='warning'>
	<th>Subject Code / M Code</th>
	<th>Subject Title</th>
	<th>Semester</th>
	<th>Theory / Practical</th>
	<th>Scheme Code</th>
	<th>Assignment No.</th>
	</tr>
	<tr class='warning'>
	<td>".$row_sm['subject_code']." / ".$row_sm['m_code']."</td>
	<td>".$row_sm['subject_title']."</td>
	<td>".$row_sm['semester']."</td>
	<td>".$row_sm['theory_practical']."</td>
	<td>".$row_sm['scheme_code']."</td>
	<td>".$_POST['assignment_no']."</td>
	</tr></table>";
//include('modules/modals/nba_incharge/add_course_outcomes_form.php');

$program_cos_result_1 = mysql_query("Select * from program_cos where backup='0' and scheme_code='".$_POST['scheme_code']."' and branch_code='".$_POST['branch_code']."' and subject_code='".$_POST['subject_code']."' ; ");

show_label('info','Program Course Outcome(CO) Detail ');
echo "<br/><table  class='table table-bordered   table-condensed container'>
	<tr>
	<th>Sr No. </th>
	<th>Subject Code / M Code</th>
	<th>CO Number </th>
	<th>CO Statement</th>
	<th>Correlation PO</th>
	<th>PO (a-l)</th>
	<th>PO Statement</th>
	<th>Map With Que. No.</th>

	</tr>";
$count=1;
while($row_pcos_2 = mysql_fetch_assoc($program_cos_result_1)) 
{	
	$program_outcomes_result_id = mysql_query("Select * from program_outcomes where  branch_code='".$_POST['branch_code']."' and id='".$row_pcos_2['program_outcome_id']."' ; ");
	
	$row_po_id = mysql_fetch_assoc($program_outcomes_result_id);
	echo "<tr class='warning' >
	<td>$count</td>
	<td>".$row_pcos_2['subject_code']." / ".$row_pcos_2['m_code']."</td>
	<td>".$row_pcos_2['co_number']."</td>
	<td>".$row_pcos_2['co_statement']."</td>
	<td>".$row_pcos_2['correlation_po']."</td>
	<td>".$row_po_id['po_num']."</td>
	<td>".$row_po_id['po_statement']."</td>";

	
	$qmm_sql = mysql_query("SELECT * FROM internal_question_structure WHERE ass_tool='A' AND course_code='".$row_sm['course_code']."'") or die(mysql_query());
	$total_qcount = mysql_num_rows($qmm_sql);
	$qmm = mysql_fetch_assoc($qmm_sql);
	
	echo "<td><form method='POST' action='' accept-charset='UTF-8'>
 <input type='hidden' name='course_code' value='".$row_sm['course_code']."' />
				<input type='hidden' name='m_code' value='".$row_sm['m_code']."' />
				<input type='hidden' name='assignment_no' value='".$_POST['assignment_no']."' />
				<input type='hidden' name='total_questions' value='".$total_qcount."' />
				<input type='hidden' name='ass_tool' value='A' />
				<input type='hidden' name='semester' value='".$row_sm['semester']."' />
				<input type='hidden' name='branch_code' value='".$_POST['branch_code']."' />
				<input type='hidden' name='program_cos_id$count' value='".$row_pcos_2['id']."' />
				<input type='hidden' name='revision' value='".$row_pcos_2['revision']."' />
				<input type='hidden' name='scheme_code' value='".$_POST['scheme_code']."' />
				<input type='hidden' name='subject_code' value='".$_POST['subject_code']."' />
	<input type='hidden' name='add_assignment_co_que_mapping_details' value='add_assignment_co_que_mapping_details' />";
	for($i=1;$i<=$total_qcount;$i++) {
		
		$co_relation = mysql_query("SELECT * FROM internal_ques_co_relation WHERE
		branch_code='".$_POST['branch_code']."' AND
		course_code='".$row_sm['course_code']."' AND
		scheme_code='".$_POST['scheme_code']."' AND
		subject_code='".$_POST['subject_code']."' AND
		ass_tool='A' AND
		sessional_assign_no='".$_POST['assignment_no']."' AND
		question_number='".$i."' AND
		program_cos_id='".$row_pcos_2['id']."' AND
		backup='0'") or die(mysql_error());
		
		$question_id = $count.$i;
		
		if(mysql_num_rows($co_relation)==1) {
			$co_r = mysql_fetch_assoc($co_relation);
			echo "<input type='hidden' name='p_$question_id' value='".$co_r['autoid']."'>";
			echo $i.". <input type='checkbox' name='q$question_id' checked='checked' value='".$row_pcos_2['id']."'><br/>";
		}
		else {
			
			$co_r = mysql_fetch_assoc($co_relation);
			echo "<input type='hidden' name='p_$question_id' value='".$co_r['autoid']."'>";
			echo $i.". <input type='checkbox' name='q$question_id' value='".$row_pcos_2['id']."'><br/>";
		}
		
	}
	echo "</td></tr>";
	$count++;
}

echo "</table>";

echo "	<input type='hidden' name='total_count' value='".$count."' />";

echo "<input type='submit' class='btn-large btn-block btn-info' value='Click Here To Add Mapping' onclick='return confirm_action(\"Do you want to continue ?\")'/>
</form>";
?>



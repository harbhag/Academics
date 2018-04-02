<?php

$course_branch = explode(',',$_POST['course_branch']);

#include_once('modules/nba_incharge/attainment_sessionals.php');
#include_once('modules/nba_incharge/attainment_assignment.php');
#include_once('modules/nba_incharge/attainment_internal_practicals.php');

if(isset($_POST['calculate_attainment_subjectwise'])) {

	$subject_codes = mysql_query("SELECT DISTINCT subject_code FROM internal_ques_co_relation where 
	branch_code='".$course_branch[1]."' AND
	course_code='".$course_branch[0]."'
	") or die(mysql_error());
	
	
	show_label('info','Attainment of Program Outcomes (Subjectwise)');
	echo "<br/>
		<table  class='table table-bordered table-condensed container'>
		<tr class='info'>
		<th>PO ID</th>";
	
	
	while($sc = mysql_fetch_assoc($subject_codes)) {
		
		echo "<th>".$sc['subject_code']." (%)</th>";
		
	}
	
	echo 
		"<th>Attainment (%)</th>
		</tr>";
		
	
	$po_attainment = mysql_query("SELECT program_outcome_id, round(avg(avg_per),2)attainment_per FROM `co_po_peo_analysis` WHERE
	branch_code='".$course_branch[1]."' AND
	course_code='".$course_branch[0]."'
	group by program_outcome_id
	") or die(mysql_error());
	
		
		while($po = mysql_fetch_assoc($po_attainment)) {
			
			$subject_codes = mysql_query("SELECT DISTINCT subject_code FROM internal_ques_co_relation where 
			branch_code='".$course_branch[1]."' AND
			course_code='".$course_branch[0]."'") or die(mysql_error());
			
			$po_statement_sql = mysql_query("SELECT * FROM program_outcomes WHERE
			branch_code='".$course_branch[1]."' AND
			course_code='".$course_branch[0]."' AND
			id = '".$po['program_outcome_id']."'") or die(mysql_error());
			$po_statement = mysql_fetch_assoc($po_statement_sql);
			
			$tooltip_data = $po_statement['po_statement'];
			
			echo "
			<tr class='info'>
			<td><a href='#' data-toggle='tooltip-right' title='".$tooltip_data."'>".$po_statement['po_num']."</a></td>";
			
			while($sc = mysql_fetch_assoc($subject_codes)) {
				$po_attainment_sc_sql = mysql_query("SELECT round(avg(avg_per),2)attainment_per FROM `co_po_peo_analysis` WHERE
				subject_code='".$sc['subject_code']."' AND
				branch_code='".$course_branch[1]."' AND
				course_code='".$course_branch[0]."' AND
				program_outcome_id='".$po['program_outcome_id']."'
				group by program_outcome_id
				") or die(mysql_error());
				
				$po_attainment_sc = mysql_fetch_assoc($po_attainment_sc_sql);
				
				if($po_attainment_sc['attainment_per']=='') {
					$po_attainment_sc['attainment_per']='---';
				}
				
				echo "	
				<td>".$po_attainment_sc['attainment_per']."</td>";
			}
			
			echo"
			<td>".$po['attainment_per']."</td>
			</tr>";
		}
		echo "</table>";
}


elseif(isset($_POST['calculate_attainment_course_outcomes'])) {
	
	$subject_codes = mysql_query("SELECT DISTINCT subject_code FROM internal_ques_co_relation where 
	branch_code='".$course_branch[1]."' AND
	course_code='".$course_branch[0]."'
	") or die(mysql_error());
	
	$cos_sql = mysql_query("SELECT DISTINCT co_number FROM program_cos WHERE
	branch_code='".$course_branch[1]."' AND
	course_code='".$course_branch[0]."' AND
	backup='0'") or die(mysql_error());
	
	
	
	show_label('info','Attainment of Course Outcomes');
	echo "<br/>
		<table  class='table table-bordered table-condensed container'>
		<tr class='info'>
		<th>Subject</th>";
	
	
	while($cos = mysql_fetch_assoc($cos_sql)) {
		
		echo "<th>CO".$cos['co_number']." (%)</th>";
		
	}
	
	echo 
		"</tr>";
		
	
	while($sc = mysql_fetch_assoc($subject_codes)) {
		
		$subject_title_sql = mysql_query("SELECT DISTINCT subject_title FROM scheme_master WHERE subject_code='".$sc['subject_code']."'") or die(mysql_error());
		$subject_title = mysql_fetch_assoc($subject_title_sql);
	
	echo "<tr class='info'>";
	echo "<td>".$subject_title['subject_title']."(".$sc['subject_code'].")</td>";
	
	$cos_sql = mysql_query("SELECT DISTINCT co_number FROM program_cos WHERE
	branch_code='".$course_branch[1]."' AND
	course_code='".$course_branch[0]."'AND
	backup='0'") or die(mysql_error());
	
	while($cos = mysql_fetch_assoc($cos_sql)) {
		$co_attainment_sc_sql = mysql_query("SELECT round(avg(avg_per),2)attainment_per FROM `co_po_peo_analysis` WHERE
		branch_code='".$course_branch[1]."' AND
		course_code='".$course_branch[0]."' AND
		co_number = '".$cos['co_number']."' AND
		subject_code='".$sc['subject_code']."'
		") or die(mysql_error());
		
		$co_attainment_sc = mysql_fetch_assoc($co_attainment_sc_sql);
		
		$co_statement_sql = mysql_query("SELECT distinct co_statement FROM `program_cos` WHERE
		branch_code='".$course_branch[1]."' AND
		course_code='".$course_branch[0]."' AND
		co_number = '".$cos['co_number']."' AND
		subject_code='".$sc['subject_code']."' AND
		backup='0'
		") or die(mysql_error());
		
		$co_statement = mysql_fetch_assoc($co_statement_sql);
		
		$tooltip_data = $co_statement['co_statement'];
		
		if($co_attainment_sc['attainment_per']=='') {
			$co_attainment_sc['attainment_per']='---';
			$tooltip_data='N/A';
		}
		
		
		
		//echo "<td>".$co_attainment_sc['attainment_per']."</td>";
		echo "<td><a href='#' data-toggle='tooltip' title='".$tooltip_data."'>".$co_attainment_sc['attainment_per']."</a></td>";
	}
		
		
	}
	echo "</table>";
	
}

else {

	$po_attainment = mysql_query("SELECT program_outcome_id, round(avg(avg_per),2)attainment_per FROM `co_po_peo_analysis` WHERE
	branch_code='".$course_branch[1]."' AND
	course_code='".$course_branch[0]."'
	group by program_outcome_id
	") or die(mysql_error());

	show_label('info','Attainment of PEO and PO');
	echo "<br/>
		<table  class='table table-bordered table-condensed container'>
		<tr class='info'>
		<th>PO ID</th>
		<th>PO Statement</th>
		<th>Attainment (%)</th>
		</tr>";
		
		while($po = mysql_fetch_assoc($po_attainment)) {
			
			$po_statement_sql = mysql_query("SELECT * FROM program_outcomes WHERE
			branch_code='".$course_branch[1]."' AND
			course_code='".$course_branch[0]."' AND
			id = '".$po['program_outcome_id']."'") or die(mysql_error());
			$po_statement = mysql_fetch_assoc($po_statement_sql);
			
			echo "
			<tr class='info'>
			<td>".$po_statement['po_num']."</td>
			<td>".$po_statement['po_statement']."</td>
			<td>".$po['attainment_per']."</td>
			</tr>";
		}
		echo "</table>";

	$peo_attainment = mysql_query("SELECT program_peos_id,round(avg(avg_per),2)attainment FROM `co_po_peo_analysis` cppa,peo_po_mapping ppm where ppm.program_outcomes_id=cppa.program_outcome_id AND
	cppa.branch_code='".$course_branch[1]."' AND
	cppa.course_code='".$course_branch[0]."'
	group by program_peos_id") or die(mysql_error());
	

	show_label('info','Attainment of Program Educational Objectives');
	echo "<br/>
		<table  class='table table-bordered table-condensed container'>
		<tr class='info'>
		<th>PEO ID</th>
		<th>PEO Statement</th>
		<th>Attainment (%)</th>
		</tr>";
		
		while($peo = mysql_fetch_assoc($peo_attainment)) {
			
			$peo_statement_sql = mysql_query("SELECT * FROM program_peos WHERE
			branch_code='".$course_branch[1]."' AND
			course_code='".$course_branch[0]."' AND
			id = '".$peo['program_peos_id']."'") or die(mysql_error());
			$peo_statement = mysql_fetch_assoc($peo_statement_sql);
			
			echo "
			<tr class='info'>
			<td>".$peo_statement['peo_no']."</td>
			<td>".$peo_statement['peo_statement']."</td>
			<td>".$peo['attainment']."</td>
			</tr>";
		}
		echo "</table>";
}

?>

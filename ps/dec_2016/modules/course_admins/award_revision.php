<?php

//if($_SESSION['username']!='harbhag' OR $_SERVER['REMOTE_ADDR']!='202.164.40.217') {
//	exit();
//}


$allowed = mysql_query("SELECT * FROM users WHERE username='".$_SESSION['username']."' AND allow_award_revision='Y'") or die(mysql_error());

if(mysql_num_rows($allowed)==0){
	exit();
}

if(isset($_POST['award_revision_record'])) {
	
	if(isset($_POST['award_revision_delete'])) {
		
		mysql_query("DELETE FROM award_revision WHERE 
		revision_type='".$_POST['revision_type']."' AND 
		university_roll_no='".$_POST['university_roll_no']."' AND 
		subject_code='".$_POST['subject_code']."' AND 
		branch_code='".$_POST['branch_code']."'") or die(mysql_error());
		
		if($_POST['revision_type']=='totaling') {
			mysql_query("UPDATE coe_external_attendance
			SET
			updated_marks=NULL,
			updated_marks_given_by=NULL,
			updated_marks_given_on=NULL,
			updated_marks_present='0',
			final_marks=external_obtained_marks
			WHERE
			university_roll_no='".$_POST['university_roll_no']."' AND
			subject_code='".$_POST['subject_code']."' AND
			branch_code='".$_POST['branch_code']."'
			") or die(mysql_error());
		}
		
		show_label("success","Record Deleted for ".$_POST['university_roll_no']."(".$_POST['subject_code'].")");
		echo"<br/>";
		echo"<br/>";
		
	}
	
	if(isset($_POST['award_revision_lock'])) {
		mysql_query("UPDATE award_revision SET locked='Y' WHERE updated_by='".$_SESSION['username']."'") or die(mysql_error());
		
		show_label("success","Report successfully Locked !");
		echo "<br/><br/>";
	}
	
	$data = mysql_query("SELECT * FROM award_revision WHERE updated_by='".$_SESSION['username']."' ORDER BY revision_type,paper_id,university_roll_no") or die(mysql_error());
	echo "<center>

	<table class='table table-bordered table-condensed sortable container'>
	<tr>
	<th style='background-color:#D9EDF7'>Sr. No.</th>
	<th style='background-color:#D9EDF7'>University Roll No</th>
	<th style='background-color:#D9EDF7'>Student Name</th>
	<th style='background-color:#D9EDF7'>Subject Code</th>
	<th style='background-color:#D9EDF7'>Paper ID</th>
	<th style='background-color:#D9EDF7'>Subject Title</th>
	<th style='background-color:#D9EDF7'>Original Marks</th>
	<th style='background-color:#D9EDF7'>Updated Marks</th>
	<th style='background-color:#D9EDF7'>Remarks</th>
	<th style='background-color:#D9EDF7'>Revision Type</th>
	<th style='background-color:#D9EDF7'>Delete</th>
	</tr>";
	$countr = 1;
	while($row = mysql_fetch_assoc($data)) {
		
		$locked = mysql_query("SELECT * FROM award_revision WHERE locked='Y' and updated_by='".$_SESSION['username']."'") or die(mysql_error());
		
		if(mysql_num_rows($locked)>0) {
			$disabled1="disabled='disabled'";
			$disabled2="disabled";
		}
			
		echo "<tr>
		<td>".$countr."</td>
		<td>".$row['university_roll_no']."</td>
		<td>".$row['student_name']."</td>
		<td>".$row['subject_code']."</td>
		<td>".$row['paper_id']."</td>
		<td>".$row['subject_title']."</td>
		<td>".$row['external_obtained_marks']."</td>
		<td>".$row['revised_marks']."</td>
		<td>".$row['remarks']."</td>
		<td>".strtoupper($row['revision_type'])."</td>";
		echo "
		<td>
		<form method='post' action=''>
		<input type='hidden' name='award_revision_delete' value='award_revision' />
		<input type='hidden' name='award_revision_record' value='award_revision' />
		<input type='hidden' name='award_revision' value='award_revision' />
		<input type='hidden' name='revision_type' value='".$row['revision_type']."' />
		<input type='hidden' name='branch_code' value='".$row['branch_code']."' />
		<input type='hidden' name='subject_code' value='".$row['subject_code']."' />
		<input type='hidden' name='university_roll_no' value='".$row['university_roll_no']."' />
		<input type='submit' value='Delete' $disabled1 class='btn btn-danger $disabled2'>
		</td>
		</form>";
		
		echo"<tr>";
		
		$countr +=1;
	}
	
	

	if(mysql_num_rows($locked)>0) {
		echo "
		<tr><td colspan='4'>
		<form method='post' action=''>
		<input type='hidden' name='award_revision_report' value='Totaling' />
		<input type='hidden' name='award_revision_record' value='award_revision' />
		<input type='hidden' name='award_revision' value='award_revision_insert' />
		<button type='submit' name='submit' class='btn-large btn-block btn-info'>Print Totaling Report</button>
		</form></td>
		";
		
		echo "
		<td colspan='3'>
		<form method='post' action=''>
		<input type='hidden' name='award_revision_report' value='Unchecked' />
		<input type='hidden' name='award_revision_record' value='award_revision' />
		<input type='hidden' name='award_revision' value='award_revision_insert' />
		<button type='submit' name='submit' class='btn-large btn-block btn-warning'>Print Unchecked Report</button>
		</form></td>
		";
		
		echo "
		<td colspan='4'>
		<form method='post' action=''>
		<input type='hidden' name='award_revision_report' value='Revaluation' />
		<input type='hidden' name='award_revision_record' value='award_revision' />
		<input type='hidden' name='award_revision' value='award_revision_insert' />
		<button type='submit' name='submit' class='btn-large btn-block btn-success'>Print Revaluation Report</button>
		</td></tr>
		</form></table>";
	}
	else {
		
		echo "
		<tr><td colspan='11'>
		<form method='post' action=''>
		<input type='hidden' name='award_revision_lock' value='award_revision' />
		<input type='hidden' name='award_revision_record' value='award_revision' />
		<input type='hidden' name='award_revision' value='award_revision' />
		<button type='submit' name='submit' class='btn-large btn-block btn-danger'>Lock Report</button>
		</tr></td>
		</form></table>";
	}
	
	
}

else {
	
	$locked = mysql_query("SELECT * FROM award_revision WHERE locked='Y' and updated_by='".$_SESSION['username']."'") or die(mysql_error());

	if(mysql_num_rows($locked)>0) {
		
		show_label("important","Record already locked. Further updations not allowed. !");
		exit();
	}

	if(isset($_POST['award_revision_insert'])) {
		
		
		for($i=1;$i<=$_POST['total_count']-1;$i++){
			
			mysql_query("DELETE FROM award_revision WHERE 
			
			university_roll_no='".$_POST['university_roll_no'.$i]."' AND
			subject_code='".$_POST['subject_code'.$i]."' AND
			revision_type='".$_POST['revision_type']."'
			") or die(mysql_error());
			
			$sec_code = mysql_fetch_assoc(mysql_query("SELECT * from coe_external_attendance WHERE university_roll_no='".$_POST['university_roll_no'.$i]."' AND subject_code='".$_POST['subject_code'.$i]."'")) or die(mysql_error());
			
			mysql_query
			
			("INSERT INTO 
			`award_revision` 
			
			(`course_code`, `branch_code`, `university_roll_no`, `student_name`, `subject_title`, `subject_code`,secerecy_code, `paper_id`, `m_code`, `external_obtained_marks`, `revised_marks`, `revision_type`, `remarks`,updated_by,last_ip) 
			
			VALUES ( 
			'".$_POST['course_code'.$i]."', 
			'".$_POST['branch_code'.$i]."', 
			'".$_POST['university_roll_no'.$i]."', 
			'".$_POST['student_name'.$i]."', 
			'".$_POST['subject_title'.$i]."', 
			'".$_POST['subject_code'.$i]."', 
			'".$sec_code['secerecy_code']."', 
			'".$_POST['paper_id'.$i]."', 
			'".$_POST['m_code'.$i]."', 
			'".$_POST['original_marks'.$i]."', 
			'".$_POST['revised_marks'.$i]."', 
			'".$_POST['revision_type']."', 
			'".mysql_real_escape_string($_POST['remarks'.$i])."',
			'".$_SESSION['username']."',
			'".$_SERVER['REMOTE_ADDR']."'
			)
			") or die(mysql_error());
			
			if($_POST['revision_type']=='totaling'){
			
				mysql_query("UPDATE coe_external_attendance
				SET
				updated_marks='".$_POST['revised_marks'.$i]."',
				updated_marks_given_by='".$_SESSION['username']."',
				updated_marks_given_on='".date("Y-m-d H:i:s")."',
				updated_marks_present='1',
				final_marks='".$_POST['revised_marks'.$i]."'
				WHERE
				university_roll_no='".$_POST['university_roll_no'.$i]."' AND
				paper_id='".$_POST['paper_id'.$i]."' AND
				subject_code='".$_POST['subject_code'.$i]."' AND
				branch_code='".$_POST['branch_code'.$i]."'
				") or die(mysql_error());
			
			}
		}
		
		show_label("success","Data successfully Updated !");
		
		exit();
		
	}



	if(isset($_POST['award_revision_form'])) {
		
		/*
		$subcode_paperid1 = array();
		$subcode_paperid2 = array();
		$subcode_paperid = array();
		
		$subcode_paperid1 = explode(",",$_POST['subject']);
		
		foreach($subcode_paperid1 as $sp) {
			$subcode_paperid2 [] = "'$sp'";
		}
		
		$subcode_paperid = implode(",",$subcode_paperid2);
		*/
		$count = 1;
		
		$data = mysql_query("SELECT * FROM ptu_subjects WHERE ED_RollNo IN (".$_POST['university_roll_no'].") AND (SUB_CODE LIKE '".$_POST['subject']."' OR Sub_PaperID LIKE '".$_POST['subject']."') AND received_status='Y' and eligibility='Y' AND 
		FRM_BRID IN (".$_SESSION['show_branch_code'].") AND Sub_Sem IN (".$_SESSION['show_semester'].")
		
		AND ED_RollNo IN 
		
		(SELECT university_roll_no FROM coe_external_attendance WHERE university_roll_no IN (".$_POST['university_roll_no'].") AND (subject_code LIKE '".$_POST['subject']."' OR paper_id LIKE '".$_POST['subject']."') AND sec_code_assigned='1')") or die(mysql_error());
		
		
		
		if(mysql_num_rows($data)==0){
			
			show_label('important','No record found !');
			echo "<br/><br/><center><a href='http://exam.gndec.ac.in'><button type='button' action='exam.gndec.ac.in' name='submit' class='btn-large btn-info'>Go Back</button></a></center>";
			exit();
		}
		
		echo "<center>

						<table class='table table-bordered table-condensed sortable container'>
						<form method='post' action=''>
						<tr>
						<th style='background-color:#D9EDF7'>University Roll No</th>
						<th style='background-color:#D9EDF7'>Student Name</th>
						<th style='background-color:#D9EDF7'>Subject Code</th>
						<th style='background-color:#D9EDF7'>Paper ID</th>
						<th style='background-color:#D9EDF7'>Subject Title</th>
						<th style='background-color:#D9EDF7'>Original Marks</th>";
						
						if($_POST['revision_type']=='totaling'){
							echo "<th style='background-color:#D9EDF7'>Updated Marks</th>";
						}
						
						
						echo "
						<th style='background-color:#D9EDF7'>Remarks</th>
						<th style='background-color:#D9EDF7'>Revision Type</th>
						</tr>";
		while($row = mysql_fetch_assoc($data)) {
			
			$prev_data_sql = mysql_query("SELECT * FROM award_revision WHERE 
			
			university_roll_no='".$row['ED_RollNo']."' AND
			subject_code='".$row['SUB_CODE']."' AND
			revision_type='".$_POST['revision_type']."'
			") or die(mysql_error());
			
			$prev_data = mysql_fetch_assoc($prev_data_sql);
			
			$max_marks_sql = mysql_query("SELECT * FROM scheme_master WHERE
			subject_code='".$row['SUB_CODE']."' AND
			paper_id='".$row['Sub_PaperID']."' AND
			m_code='".$row['m_code']."'
			") or die(mysql_error());
			
			$max_marks = mysql_fetch_assoc($max_marks_sql);
			
			$original_marks = mysql_fetch_assoc(mysql_query("SELECT external_obtained_marks FROM coe_external_attendance WHERE university_roll_no='".$row['ED_RollNo']."' AND subject_code='".$row['SUB_CODE']."'")) or die(mysql_error());
			
			echo "<tr>
			<td>".$row['ED_RollNo']."</td>
			<td>".$row['StudentName']."</td>
			<td>".$row['SUB_CODE']."</td>
			<td>".$row['Sub_PaperID']."</td>
			<td>".$row['SUB_TITLE']."</td>
			<td>".$original_marks['external_obtained_marks']."</td>";
			if($_POST['revision_type']=='totaling'){
				echo "<td>
			<input type='text' class='input-mini' name='revised_marks$count' id='revised_marks$count' placeholder='' value='".$prev_data['revised_marks']."'/>
			
			<script>
			var revised_marks$count = new LiveValidation('revised_marks$count',{ validMessage: 'ok', wait: 500});
			revised_marks$count.add(Validate.Presence,{failureMessage:'X'});
			revised_marks$count.add(Validate.Numericality,{ minimum:0,maximum:".$max_marks['external_max_marks'].",onlyInteger: true});
			</script>
			
			</td>";
			}
			
			
				echo "
				<td>
				<input type='text' class='input-xlarge' name='remarks$count' id='remarks$count' placeholder='Remarks' value='".$prev_data['remarks']."'/>
				</td>";
			
			echo"
			<td>".strtoupper($_POST['revision_type'])."</td>
			</tr>
			<input type='hidden' name='course_code$count' value='".$row['course_code']."' />
			<input type='hidden' name='branch_code$count' value='".$row['FRM_BRID']."' />
			<input type='hidden' name='university_roll_no$count' value='".$row['ED_RollNo']."' />
			<input type='hidden' name='student_name$count' value='".$row['StudentName']."' />
			<input type='hidden' name='subject_code$count' value='".$row['SUB_CODE']."' />
			<input type='hidden' name='paper_id$count' value='".$row['Sub_PaperID']."' />
			<input type='hidden' name='m_code$count' value='".$row['m_code']."' />
			<input type='hidden' name='scheme_code$count' value='".$row['scheme_code']."' />
			<input type='hidden' name='subject_title$count' value='".$row['SUB_TITLE']."' />
			<input type='hidden' name='original_marks$count' value='".$original_marks['external_obtained_marks']."' />
			";
			
			$count += 1;
			
		}
		
		
		
		echo"
		
		<tr><td colspan='9'>
		<input type='hidden' name='revision_type' value='".$_POST['revision_type']."' />
		<input type='hidden' name='total_count' value='".$count."' />
		<input type='hidden' name='award_revision' value='award_revision' />
		<input type='hidden' name='award_revision_insert' value='award_revision_insert' />
		<button type='submit' name='submit' class='btn-large btn-block btn-danger'>Submit</button>
		</tr></td>
		</form></table>";
		
		
	}

	else {
		echo "<center>

						<table>
						<form method='post' action=''>
						
						<tr><td>
						<span style='font-weight:bold'>Revision Type</span>
						</td>
						
						<td>
						<select name='revision_type' id='revision_type' class='input-xlarge'>
						<option value='totaling'>Totaling</option>
						<option value='unchecked'>Unchecked</option>
						<option value='revaluation'>Revaluation</option>
						</select>
						</tr></td>
						
						
						<tr><td>
						<span style='font-weight:bold'>Subject Code/Paper ID</span>
						</td>
						<td>
						<input type='text' class='input-xlarge' name='subject' id='subject' placeholder='Enter Subject Code or Paper-ID'/>
						</tr></td>
						
						
						<tr><td>
						<span style='font-weight:bold'>University Roll No(s). </span>
						</td>
						<td>
						<textarea name='university_roll_no' rows='10' placeholder='Enter multiple Roll Numbers seperated by comma'></textarea>
						</tr></td>
						
						<tr><td>
						<input type='hidden' name='award_revision' value='award_revision' />
						<input type='hidden' name='award_revision_form' value='award_revision_form' />
						<button type='submit' name='submit' class='btn btn-large btn-danger'>Proceed</button>
						</tr></td>
			 
					</form>
					</table>
			</center>";
	}
}

?>
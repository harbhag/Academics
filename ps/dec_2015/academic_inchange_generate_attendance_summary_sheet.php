<?php

$course_branch = explode(',',$_POST['course_branch']);

$course_name = fetch_resource_db('course_code',array('course_code'),array($course_branch[0]),'resource_array_value','course_name');
$branch_name = fetch_resource_db('branch_code',array('branch_code'),array($course_branch[1]),'resource_array_value','branch_name');

if($_POST['theory_practical']=='P') {
	
	$rolls = mysql_query("SELECT DISTINCT university_roll_no
	FROM daily_attendance_student WHERE
	semester='".$_POST['semester']."' AND
	course_code='".$course_branch[0]."' AND
	branch_code='".$course_branch[1]."' AND
	ssection='".$_POST['ssection']."' AND
	sgroup='".$_POST['sgroup']."'
	ORDER BY university_roll_no ASC") or die("1. ".mysql_error());
	
}
else {
	
	$rolls = mysql_query("SELECT DISTINCT university_roll_no
	FROM daily_attendance_student WHERE
	semester='".$_POST['semester']."' AND
	course_code='".$course_branch[0]."' AND
	branch_code='".$course_branch[1]."' AND
	ssection='".$_POST['ssection']."'
	ORDER BY university_roll_no ASC") or die("1. ".mysql_error());
	
	
}


$ht = array();
$count = 1;


$total_entries = mysql_num_rows($rolls);
$entries_per_page = $_POST['records_per_page'];


$overflow = $total_entries%$entries_per_page;


$rem_number = $total_entries-$overflow;

$total_pages = $rem_number/$entries_per_page;

if($total_entries<$entries_per_page) {
	$loop_end = 1;

	$rolls_used = 0;
	$limit = $total_entries;

}

if($total_entries > $entries_per_page) {
	$loop_end = $total_pages+1;

	$rolls_used = 0;
	$limit = $entries_per_page;
}

if($total_entries==$entries_per_page) {
	$loop_end = 1;
	$rolls_used = 0;
	$limit = $entries_per_page;
}



$ht[] =  "
<html>
<head>
<style type='text/css'>
table {
	width:100%;
	border-collapse:collapse;
}

#mypage {
	page-break-after:always
}

th {
font-size:8px;

}
td {
font-size:10px;

}

#page_no {
	font-size:10px;
}
</style>
</head>
<br/>";

$uroll = mysql_fetch_array($rolls);

$head_h2 = '';

$sdate = strtotime($_POST['start_date']);
$edate = strtotime($_POST['end_date']);

$f_sdate = date("d-m-Y",$sdate);
$f_edate = date("d-m-Y",$edate);
for($k=1;$k<=$loop_end;$k++) {
	
	if($_POST['theory_practical']=='T') {
		$sql_paper_id = mysql_query("SELECT DISTINCT subject_code,elective_details
		FROM daily_attendance_student WHERE
		semester='".$_POST['semester']."' AND
		ssection='".$_POST['ssection']."' AND
		branch_code='".$course_branch[1]."' AND
		course_code = '".$course_branch[0]."' AND
		theory_practical='".$_POST['theory_practical']."' AND
		backup='0' AND
		attendance_date <= '".$_POST['end_date']."'
		ORDER BY theory_practical DESC") or die("2. ".mysql_error());
		
	}
	if($_POST['theory_practical']=='P') {
		
		$sql_paper_id = mysql_query("SELECT DISTINCT subject_code,elective_details
		FROM daily_attendance_student WHERE
		semester='".$_POST['semester']."' AND
		ssection='".$_POST['ssection']."' AND
		sgroup='".$_POST['sgroup']."' AND
		branch_code='".$course_branch[1]."' AND
		course_code = '".$course_branch[0]."' AND
		theory_practical='".$_POST['theory_practical']."' AND
		backup='0' AND
		attendance_date <= '".$_POST['end_date']."'
		ORDER BY theory_practical DESC") or die("2. ".mysql_error());
	}


	$ht[] = "<table cellpadding='4'><tr>
			<td width='15%' align='center'><img src='images/gndec_logo.jpg' height='100' /></td>
			<td width='70%' align='center'><h2> <br /> GURU NANAK DEV ENGINEERING COLLEGE, LUDHIANA </h2>
			<h2> ( An Autonomous College Under UGC Act )*
			<br /> Affiliated to Punjab Technical University</h2></td>
			<td width='15%' align='center'><img src='images/gndec_logo.jpg' height='100' /></td>
		</tr>
	  </table>
	  
	  <center><h4>Consolidated Attendance Report ( From Start of Semester to ".$f_edate." )</h4></center>

			<table border='1' style='border-collapse:collapse;width:100%'>
			<tr>
			<th  align='left'><b>Course(Branch) / Shift</b></th>
			<td >".$course_name."(".$branch_name.") / ".$_POST['shift']." (".$_POST['full_part_time'].")</td>
			</tr>";
			if($_POST['theory_practical']=='P') {
				$ht[]="
			<tr>
			<th  align='left'><b>Section(Group)</b></th>
			<td >".$_POST['ssection']."(".$_POST['sgroup'].")</td>
			</tr>";
		}
			else {
				$ht[]="
				<tr>
			<th  align='left'><b>Section</b></th>
			<td >".$_POST['ssection']."</td>
			</tr>";
		}
		$ht[]="
			<tr>
			<th  align='left'><b>Semester</b></th>
			<td >".$_POST['semester']."</td>
			</tr>
		
			<tr>
			<th align='left'><b>Theory(T)/Practical(P)</b></th>
			<td>".$_POST['theory_practical']."</td>
			</tr>
	  
			</table>

	  <br/>

		<table border='1px'>
		<tr>
		<th width='3%'>Sr. No.</th>
		<th>University Roll No.</th>
		<th>Class Roll No</th>
		<th>Name</th>";

	$sub_codes_h = '';
	$body_h = '';

	$subcode = array();
	$paperid = array();
	$thpr = array();

	$intmax = array();
	$extmax = array();

	$rit = array();
	$rip = array();
	$ret = array();
	$rep = array();

	$remarks = array();
	
	while($row = mysql_fetch_assoc($sql_paper_id)) {
		
		if($_POST['theory_practical']=='P') {
			
			

			
			$total_lect = mysql_query("SELECT DISTINCT attendance_date,attendance_period FROM daily_attendance_student
			WHERE course_code='".$course_branch[0]."' AND
			branch_code='".$course_branch[1]."' AND
			shift='".$_POST['shift']."' AND
			ssection='".$_POST['ssection']."' AND
			semester='".$_POST['semester']."' AND
			sgroup='".$_POST['sgroup']."' AND
			subject_code='".$row['subject_code']."' AND
			elective_details='".$row['elective_details']."' AND
			aicte_rc='".$_POST['aicte_rc']."' AND
			full_part_time='".$_POST['full_part_time']."' AND backup='0' AND attendance_date <= '".$_POST['end_date']."'") or die("total_lect: ".mysql_error());
		
		}
		else {
			
			
			$total_lect = mysql_query("SELECT DISTINCT attendance_date,attendance_period FROM daily_attendance_student
			WHERE course_code='".$course_branch[0]."' AND
			branch_code='".$course_branch[1]."' AND
			shift='".$_POST['shift']."' AND
			ssection='".$_POST['ssection']."' AND
			semester='".$_POST['semester']."' AND
			attendance_date <= '".$_POST['end_date']."' AND
			subject_code='".$row['subject_code']."' AND
			elective_details='".$row['elective_details']."' AND
			aicte_rc='".$_POST['aicte_rc']."' AND
			full_part_time='".$_POST['full_part_time']."' AND backup='0'") or die("total_lect: ".mysql_error());
		
		}


		
			


			//$imax = mysql_fetch_assoc($imax_sql);
			$total_lectures = 0;

			while($r = mysql_fetch_assoc($imax_sql)) {
				$total_lectures += $r['total_lectures'];
			}
			
			$total_lectures = mysql_num_rows($total_lect);

			//$intmax[] = $imax['internal_max_marks'];
			$intmax[] = $total_lectures;
		
		$short_tile_sql = mysql_query("SELECT DISTINCT short_subject_title FROM time_table WHERE subject_code='".$row['subject_code']."'") or die(mysql_error());
		$short_title = mysql_fetch_assoc($short_tile_sql);
		
		if($_POST['theory_practical']=='P') {
			
			$teacher_username_sql = mysql_query("SELECT DISTINCT teacher_username FROM time_table WHERE
			course_code='".$course_branch[0]."' AND
			branch_code='".$course_branch[1]."' AND
			ssection='".$_POST['ssection']."' AND
			sgroup='".$_POST['sgroup']."' AND
			theory_practical='".$_POST['theory_practical']."' AND
			subject_code='".$row['subject_code']."' AND
			regular_reappear='Regular'") or die(mysql_error());
			
		}
		else {
			
			$teacher_username_sql = mysql_query("SELECT DISTINCT teacher_username FROM time_table WHERE
			course_code='".$course_branch[0]."' AND
			branch_code='".$course_branch[1]."' AND
			ssection='".$_POST['ssection']."' AND
			theory_practical='".$_POST['theory_practical']."' AND
			subject_code='".$row['subject_code']."' AND
			regular_reappear='Regular'") or die(mysql_error());
			
		}
		
		
		$teacher_username = mysql_fetch_assoc($teacher_username_sql);
		
		$short_name_sql = mysql_query("SELECT DISTINCT short_name FROM users WHERE username='".$teacher_username['teacher_username']."'") or die(mysql_error());
		$short_name = mysql_fetch_assoc($short_name_sql);
		
		
		$ht[] =  "<th width='6%'>".$row['subject_code']."<br/>(".$total_lectures.")</th>";
		$subcode[] = $row['subject_code'];
		$paperid[] = $row['paper_id'];
		$thpr[] = $row['theory_practical'];
		$start_date[] = $row['start_date'];
		$end_date[] = $row['start_date'];
	}
	$ht[] = "
	<th width='20%'>Remarks</th>
	</tr>";


	if($rolls_used!=0) {
		if(($total_entries-$rolls_used)>($entries_per_page)) {
			$limit = $entries_per_page;
		}
		if(($total_entries-$rolls_used)<($entries_per_page)) {
			$limit = $total_entries-$rolls_used;
		}
		if(($total_entries-$rolls_used)==($entries_per_page)) {
			$limit = $entries_per_page;
		}
	}
	
	if($_POST['theory_practical']=='P') {
		
		$data = mysql_query("SELECT DISTINCT university_roll_no
		FROM daily_attendance_student WHERE
		semester='".$_POST['semester']."' AND
		course_code='".$course_branch[0]."' AND
		branch_code='".$course_branch[1]."' AND
		sgroup='".$_POST['sgroup']."' AND
		attendance_date <= '".$_POST['end_date']."' AND
		ssection='".$_POST['ssection']."'
		ORDER BY university_roll_no ASC LIMIT ".$rolls_used.",".$limit) or die("7444. ".mysql_error());
		
	}
	else {
		
		$data = mysql_query("SELECT DISTINCT university_roll_no
		FROM daily_attendance_student WHERE
		semester='".$_POST['semester']."' AND
		course_code='".$course_branch[0]."' AND
		branch_code='".$course_branch[1]."' AND
		attendance_date <= '".$_POST['end_date']."' AND
		ssection='".$_POST['ssection']."'
		ORDER BY university_roll_no ASC LIMIT ".$rolls_used.",".$limit) or die("7444. ".mysql_error());
		
	}
	
	
		
	while($row = mysql_fetch_assoc($data)) {

	$roll_sql = mysql_query("SELECT DISTINCT ptu_student_name,college_roll_no
	FROM student_info WHERE
	semester='".$_POST['semester']."' AND
	course_code='".$course_branch[0]."' AND
	branch_code='".$course_branch[1]."' AND
	university_roll_no='".$row['university_roll_no']."'") or die("89. ".mysql_error());

	$sname = mysql_fetch_assoc($roll_sql);

		$max_marks = array();
		$obtained_marks = array();
	

		$ht[] =  "<tr>
				<td>".$count."</td>
				<td>".$row['university_roll_no']."</td>
				<td>".$sname['college_roll_no']."</td>
				<td>".strtoupper($sname['ptu_student_name'])."</td>
				";
		unset($sname);

		for($i=0;$i<=count($subcode)-1;$i++) {
			if($subcode[$i]=='') {
				continue;
			}

		if($_POST['theory_practical']=='P') {
			
			$itmarks = mysql_query("SELECT COUNT(autoid) AS internal_obtained_marks
			FROM daily_attendance_student WHERE
			semester='".$_POST['semester']."' AND
			course_code='".$course_branch[0]."' AND
			branch_code='".$course_branch[1]."' AND
			ssection='".$_POST['ssection']."' AND
			sgroup='".$_POST['sgroup']."' AND
			backup='0' AND
			attendance_date <= '".$_POST['end_date']."' AND
			attendance='Present' AND
			subject_code='".$subcode[$i]."' AND
			university_roll_no='".$row['university_roll_no']."'") or die("8. ".mysql_error());
			
		}
		else {
			
			$itmarks = mysql_query("SELECT COUNT(autoid) AS internal_obtained_marks
			FROM daily_attendance_student WHERE
			semester='".$_POST['semester']."' AND
			course_code='".$course_branch[0]."' AND
			branch_code='".$course_branch[1]."' AND
			ssection='".$_POST['ssection']."' AND
			backup='0' AND
			attendance_date <= '".$_POST['end_date']."' AND
			attendance='Present' AND
			subject_code='".$subcode[$i]."' AND
			university_roll_no='".$row['university_roll_no']."'") or die("8. ".mysql_error());
			
		}
			

			

			$fitmarks = mysql_fetch_assoc($itmarks);
			
			if($fitmarks['internal_obtained_marks']==0) {
				
				$check_elective = mysql_query("SELECT * FROM student_elective_subjects WHERE 
				university_roll_no='".$row['university_roll_no']."' AND 
				subject_code='".$subcode[$i]."'") or die(mysql_error());
				
				if(mysql_num_rows($check_elective)==0) {
					$fitmarks['internal_obtained_marks']='---';
				}
			}

			$ht[] = "<td align='center'>".$fitmarks['internal_obtained_marks']." </td>";
			//$body_h .="<td>".$fitmarks['internal_obtained_marks']." </td><td> ".$passing_marks."</td>";
		
	}
	$ht[] = "<td></td></tr>";

		


		
		
		$count++;
		$rolls_used++;
	}
	
	
	if($_POST['theory_practical']=='P') {
		
		$batch_sql = mysql_query("SELECT DISTINCT batch FROM student_info WHERE
		semester='".$_POST['semester']."' AND
		course_code='".$course_branch[0]."' AND
		branch_code='".$course_branch[1]."' AND
		ssection='".$_POST['ssection']."' AND
		sgroup='".$_POST['sgroup']."'") or die(mysql_error());
	
	$batch = mysql_fetch_assoc($batch_sql);
		
	}
	else {
		
		$batch_sql = mysql_query("SELECT DISTINCT batch FROM student_info WHERE
		semester='".$_POST['semester']."' AND
		course_code='".$course_branch[0]."' AND
		branch_code='".$course_branch[1]."' AND
		ssection='".$_POST['ssection']."'") or die(mysql_error());
	
	$batch = mysql_fetch_assoc($batch_sql);
		
	}
	
	$academic_incharge_sql = mysql_query("SELECT DISTINCT teacher_username FROM academic_incharge WHERE
	course_code='".$course_branch[0]."' AND
	branch_code='".$course_branch[1]."' AND
	section='".$_POST['ssection']."' AND
	batch='".$batch['batch']."'") or die(mysql_error());
	
	$academic_incharge = mysql_fetch_assoc($academic_incharge_sql);
	
	$academic_incharge_full_sql = mysql_query("SELECT DISTINCT name FROM users WHERE
	username='".$academic_incharge['teacher_username']."'") or die(mysql_error());
	
	$academic_incharge_full = mysql_fetch_assoc($academic_incharge_full_sql);

	$ht[] = "</table>
	<br/>
	<table  border='1'>
<tr>
<th align='left' width='10%'><br/><br/><br/>Academic Incharge</th><th align='left'> <br/><br/><br/><b>Signature of Subject Teachers:-</b></th>
<th width='15%'align='left'><br/><br/><br/>HOD</th>
</tr>
</table>
<span style='font-size:10px'>*Vide UGC Letter No.F.22-1/2012 (AC) dated 17.08.2012</span>

	  <br/>
	  <span id='page_no'>Page: ".$k." of ".$loop_end."</span>
		<div id='mypage'></div>";
}

$htm = implode(" ",$ht);

//echo $htm;


$html = $htm;
$dompdf = new DOMPDF();
$dompdf->set_paper("a4","landscape");

$branch = branch_code_short($branch_name);

$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream($course_name."_".$branch."_".$_POST['semester']."_".$_POST['theory_practical']."_".$_POST['ssection']."_".$_POST['sgroup']."(".$_POST['start_date']."_to_".$_POST['end_date'].").pdf");

?>

<?php
$course_branch = explode(',',$_POST['branch_code']);
$branch_name = fetch_resource_db('branch_code',array('branch_code'),array($course_branch[1]),'resource_array_value','branch_name');
$course_name = fetch_resource_db('course_code',array('course_code'),array($course_branch[0]),'resource_array_value','course_name');


/*$roll_nos = fetch_resource_db('ptu_subjects',array('Sub_PaperID','Regular_Reappear','SUB_TP'),
						array($_POST['paper_id'],$_POST['regular_reappear'],'T'),'resource','');*/
$roll_nos = mysql_query("select distinct 
						
						ED_RollNo, 
						Sub_PaperID, 
						SUB_CODE, 
						Sub_Sem, 
						SUB_TITLE, 
						StudentName,
						m_code,
						prov_nonprov
						
						FROM ptu_subjects WHERE 
						
						
						
						Sub_PaperID='".$_POST['paper_id']."' AND
						FRM_BRID='".$course_branch[1]."' AND
						course_code='".$course_branch[0]."' AND
						Regular_Reappear = '".$_POST['regular_reappear']."' AND
						ucentre = '".$_SESSION['ucentre']."' AND
                        usession = '".$_SESSION['usession']."' AND
                        date_of_exam = '".date("Y-m-d")."' AND
						Ed_Ext = 1 AND
						received_status='Y' AND
						eligibility = 'Y' AND
						SUB_TP='T' order by 
						ED_RollNo ASC") or die(mysql_error());

if(mysql_num_rows($roll_nos)==0) {
		show_label('warning','No Record Found !!');
	}
else { ?>
<form action='' method='post' />
<table class='table table-bordered table-condensed'>
	<tr>
		<th>Sr. No.</th>
		<th>University Roll No.</th>
		<th>Student Name</th>
		
		<th>Subject Code</th>
		<th>Paper ID</th>
		<th>Subject Title</th>
		<th>Semester</th>
		<th>Mark Attendance</th>
	</tr>
<?php 
$external_mm = mysql_query("SELECT distinct external_max_marks 
FROM subject_master WHERE 
paper_id='".$_POST['paper_id']."' AND 
branch_code='".$course_branch[1]."' AND
course_code='".$course_branch[0]."' AND
regular_reappear='".$_POST['regular_reappear']."' AND 
theory_practical='T' ORDER BY paper_id ASC") or die(mysql_error());

$emma = mysql_fetch_assoc($external_mm);

$external_max_marks = $emma['external_max_marks'];

$count = 1;

while($row = mysql_fetch_assoc($roll_nos)) {
	/*$centre_allotment = fetch_resource_db('section_groups',array('university_roll_no','ucentre','regular_reappear'),
	array($row['ED_RollNo'],$_SESSION['ucentre'],$_POST['regular_reappear']),'resource_array','');*/
	
	$prev_attendance = fetch_resource_db('student_external_marks',array('university_roll_no','semester','subject_code','paper_id','theory_practical','regular_reappear'),
	array($row['ED_RollNo'],$row['Sub_Sem'],$row['SUB_CODE'],$_POST['paper_id'],'T',$_POST['regular_reappear']),'resource_array_value','external_attendance_status');
	
	$detained_status = mysql_query("SELECT * FROM detainee_list WHERE 
	university_roll_no='".$row['ED_RollNo']."' AND
	semester='".$row['Sub_Sem']."' AND
	subject_code='".$row['SUB_CODE']."' AND
	paper_id='".$_POST['paper_id']."' AND
	theory_practical='T' AND
	detained_status='Y' AND
	locked='Y'");
	
	echo "<tr class='warning'>
			<td>".$count."</td>
			<td>".$row['ED_RollNo']."</td>
			<td>".strtoupper($row['StudentName'])."</td>
			<td>".$row['SUB_CODE']."</td>
			<td>".$_POST['paper_id']."</td>
			<td>".$row['SUB_TITLE']."</td>
			<td>".$row['Sub_Sem']."</td>
			<td>
			<input type='hidden' name='university_roll_no$count' value='".$row['ED_RollNo']."' />
			<input type='hidden' name='student_name$count' value='".$row['StudentName']."' />
			<input type='hidden' name='subject_code$count' value='".$row['SUB_CODE']."' />
			<input type='hidden' name='m_code$count' value='".$row['m_code']."' />
			<input type='hidden' name='semester$count' value='".$row['Sub_Sem']."' />
			<input type='hidden' name='subject_title$count' value='".$row['SUB_TITLE']."' />
			<input type='hidden' name='prov_nonprov$count' value='".$row['prov_nonprov']."' />
			<select name='attendance$count'>";
			
			if(mysql_num_rows($detained_status)==0) {
			
				if($prev_attendance!='') {
					echo "
					<option value='".$prev_attendance."'>".$prev_attendance."</option>
					<option value='Present'>Present</option>
					<option value='Absent'>Absent</option>
					";
				}
				else {
					echo "
					<option value='Present'>Present</option>
					<option value='Absent'>Absent</option>
					";
				}
			}
			else {
				echo "
					<option value='Detained' selected='selected'>Detained</option>
					";
			}
			
			echo "
			</select></td>
			</tr>";
			$count++;
		
}
?>
</table>
<input type='hidden' name='total_count' value='<?php echo $count; ?>' />
<input type='hidden' name='paper_id' value='<?php echo $_POST['paper_id']; ?>' />
<input type='hidden' name='course_code' value='<?php echo $course_branch[0]; ?>' />
<input type='hidden' name='branch_code' value='<?php echo $course_branch[1]; ?>' />
<input type='hidden' name='external_max_marks' value='<?php echo $external_max_marks; ?>' />
<input type='hidden' name='regular_reappear' value='<?php echo $_POST['regular_reappear'] ?>' />
<input type='hidden' name='sup_mark_attendance' value='sup_mark_attendance' />
<input type='submit' class='btn btn-block btn-danger' value='Click Here To Mark Attendance' />
</form>
<?php
}
?>

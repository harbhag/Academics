<?php

show_label('info','Regular Exam Form');
echo "<br/>";


$aicte_rc = mysql_query("SELECT DISTINCT aicte_rc FROM student_info");
$full_part_time = mysql_query("SELECT DISTINCT full_part_time FROM student_info");

if(isset($_POST['fill_regular_examform']))
{
	$branch_codes_sql = mysql_query("SELECT show_branch_code,show_course_code,show_semester FROM users WHERE username='".$_SESSION['username']."' ") or die(mysql_error());
	$branch_codes = mysql_fetch_assoc($branch_codes_sql);
	if($branch_codes['show_branch_code']=='ALL' && $branch_codes['show_course_code']!='ALL') {
	$branch = mysql_query("SELECT distinct branch_code,course_code FROM student_info WHERE 
	course_code IN (".$branch_codes['show_course_code'].")
	ORDER BY course_code ASC") or die(mysql_error());
	}
	elseif($branch_codes['show_branch_code']=='ALL' && $branch_codes['show_course_code']=='ALL') {
	$branch = mysql_query("SELECT distinct branch_code,course_code FROM student_info ORDER BY course_code ASC") or die(mysql_error());
	}
	else {
	$branch = mysql_query("SELECT distinct branch_code,course_code FROM student_info WHERE 
	branch_code IN (".$branch_codes['show_branch_code'].") ORDER BY course_code ASC") or die(mysql_error());
	}

	if($branch_codes['show_semester']=='ALL') {
	$semester = mysql_query("SELECT distinct semester FROM student_info ORDER BY semester ASC") or die(mysql_error());
	}
	else 
	{
	$semester = mysql_query("SELECT distinct semester FROM student_info WHERE
	semester IN (".$branch_codes['show_semester'].") ORDER BY semester ASC") or die(mysql_error());
	}
	
show_label('info','Fill Regular Exam Form');
echo "<br/><br/>

<center><table>
					<form method='post' action=''>
					<tr><td>
					<span style='font-weight:bold'>Program</span>
					</td><td>
			<select name='course_branch' id='course_branch' class='input-xlarge'>";
			while($row = mysql_fetch_assoc($branch)) {
						if($row['branch_code']=='' or is_null($row['branch_code'])) {
							continue;
						}
						$course_name = fetch_resource_db('course_code',array('course_code'),array($row['course_code']),'resource_array_value','course_name');
						$branch_name = fetch_resource_db('branch_code',array('branch_code'),array($row['branch_code']),'resource_array_value','branch_name');
						echo "<option value='".$row['course_code'].",".$row['branch_code']."'>".$course_name."(".$branch_name.")</option>";
					}
					echo "
					</select>
					</td></tr>
					
					<tr><td>
					<span style='font-weight:bold'>Semester</span>
					</td><td>
          <select name='semester' id='semester' class='input-xlarge'>";
          while($row = mysql_fetch_assoc($semester)) {
						if($row['semester']=='' or is_null($row['semester'])) {
							continue;
						}
						echo "<option value='".$row['semester']."'>".$row['semester']."</option>";
					}
					echo "
					</select>
					</tr></td>
					<tr><td>
					<span style='font-weight:bold'>AICTE/RC</span>
					</td><td>
          <select name='aicte_rc' id='aicte_rc' class='input-xlarge'>";
          while($row = mysql_fetch_assoc($aicte_rc)) {
						if($row['aicte_rc']=='' or is_null($row['aicte_rc'])) {
							continue;
						}
						echo "<option value='".$row['aicte_rc']."'>".$row['aicte_rc']."</option>";
					}
					echo "
					</select>
					</tr></td>	
					<tr><td>
					<span style='font-weight:bold'>Full Time / Part Time</span>
					</td><td>
					<select name='full_part_time' id='full_part_time' class='input-xlarge'>";
					while($row = mysql_fetch_assoc($full_part_time)) {
						if($row['full_part_time']=='' or is_null($row['full_part_time'])) {
							continue;
						}
						echo "<option value='".$row['full_part_time']."'>".$row['full_part_time']."</option>";
					}
					echo "
					</select>
					</tr></td>
					<tr><td>
					<input type='hidden' name='fill_regular_examform_show' value='fill_regular_examform_show' />
					<button type='submit' name='submit' class='btn btn-large btn-danger'>Proceed</button>
					</tr></td>
					</form>
				</table>
		</center>";
}

if(isset($_POST['fill_regular_examform_show'])) 
{
	$course_branch = explode(',', $_POST['course_branch']);
	$student_list = mysql_query("SELECT * FROM student_info where student_status='Onroll' and full_part_time='".$_POST['full_part_time']."' and aicte_rc='".$_POST['aicte_rc']."' and  semester='".$_POST['semester']."' and course_code='".$course_branch[0]."' and branch_code='".$course_branch[1]."'  and eligibility='Y' and stuck_off_status='N'; ");
	$total_students=0;
	
	show_label('info',' Branch : '.$course_branch[1].', Semester: '.$_POST['semester'].', Full / Part Time:'.$_POST['full_part_time'].', AICTE/RC : '.$_POST['aicte_rc'].' ');
	
	while($row_student = mysql_fetch_assoc($student_list))
	{	
		$subject_list = mysql_query("SELECT * FROM scheme_master where full_part_time='".$_POST['full_part_time']."' and aicte_rc='".$_POST['aicte_rc']."' and  semester='".$_POST['semester']."' and course_code='".$course_branch[0]."' and branch_code='".$course_branch[1]."' and scheme_code='".$row_student['scheme_code_branch']."'; ");
		
		if (($_POST['semester']=='1' || $_POST['semester']=='2') &&  $course_branch[0]=='1')
		{
			$subject_list = mysql_query("SELECT * FROM scheme_master where full_part_time='".$_POST['full_part_time']."' and aicte_rc='".$_POST['aicte_rc']."' and  semester='".$_POST['semester']."' and course_code='".$course_branch[0]."' and branch_code='".$course_branch[1]."' and scheme_code='".$row_student['scheme_code_first_year']."'; ");
			#echo "SELECT * FROM scheme_master where full_part_time='".$_POST['full_part_time']."' and aicte_rc='".$_POST['aicte_rc']."' and  semester='".$_POST['semester']."' and course_code='".$course_branch[0]."' and branch_code='".$course_branch[1]."' and scheme_code='".$row_student['scheme_code_first_year']."';";
		}
		
		$check_ps=mysql_query(" Select * from ptu_subjects where full_part_time='".$_POST['full_part_time']."' and aicte_rc='".$_POST['aicte_rc']."' and  `Sub_Sem`='".$_POST['semester']."' and course_code='".$course_branch[0]."' and `FRM_BRID`='".$course_branch[1]."' and ED_RollNo ='".$row_student['university_roll_no']."' and regular_reappear='Regular'; ");
		
		$ps_rows = mysql_num_rows($check_ps);
		if ($ps_rows!='0')
		{
		show_label('warning','Record already updated for Student Roll No.:'.$row_student['university_roll_no'].' ');
		}
		else
		{	
			#echo "Helo";
			if (($_POST['semester']=='1' || $_POST['semester']=='2') &&  $course_branch[0]=='1')
			{
				
				$insert_sql ="INSERT INTO `ptu_subjects` (`SUB_CODE`, `SUB_TITLE`,
				`SUB_TP`, `Sub_PaperID`, `Sub_Sem`, `ED_RollNo`, `FRM_BRID`, `StudentName`,`full_part_time`,`eligibility`,`course_code`,`shift`,`aicte_rc`,`FRM_BATCH`,`Sub_Remarks`,`Regular_Reappear`,`student_status`,father_name,mother_name,m_code,batch,scheme_code,cbs,scheme_code_first_year,scheme_code_branch)
				select sm.subject_code,sm.subject_title, sm.theory_practical,sm.paper_id,si.semester,si.university_roll_no,si.branch_code,UPPER(si.ptu_student_name), si.full_part_time,
				si.eligibility, si.course_code, si.shift, si.aicte_rc, si.admission_year, sm.elective_details,'Regular',si.student_status,UPPER(si.ptu_father_name),UPPER(si.ptu_mother_name),sm.m_code,si.batch,sm.scheme_code, si.cbs,si.scheme_code_first_year, si.scheme_code_branch from
				scheme_master sm,student_info si, student_subject_group ssg  WHERE sm.branch_code=si.branch_code and sm.course_code=si.course_code and si.semester=sm.semester  and si.semester=ssg.semester  and si.scheme_code_first_year=sm.scheme_code  and ssg.subject_group=sm.subject_group and si.university_roll_no='".$row_student['university_roll_no']."' and si.university_roll_no=ssg.university_roll_no and 	sm.subject_status='1' ; ";
				mysql_query($insert_sql) or die (mysql_error());
			}
			else
			{
				while($row_subject = mysql_fetch_assoc($subject_list)) 
				{				
					$insert_sql ="INSERT INTO `ptu_subjects` (`SUB_CODE`, `SUB_TITLE`,
					`SUB_TP`, `Sub_PaperID`, `Sub_Sem`, `ED_RollNo`, `FRM_BRID`, `StudentName`,`full_part_time`,`eligibility`,`course_code`,`shift`,`aicte_rc`,`FRM_BATCH`,`Sub_Remarks`,`Regular_Reappear`,`student_status`,father_name,mother_name,m_code,batch,scheme_code,cbs,scheme_code_first_year,scheme_code_branch)
					select sm.subject_code,sm.subject_title, sm.theory_practical,sm.paper_id,si.semester,si.university_roll_no,si.branch_code,UPPER(si.ptu_student_name),si.full_part_time,si.eligibility, si.course_code, si.shift, si.aicte_rc, si.admission_year,
					sm.elective_details,'Regular',si.student_status,UPPER(si.ptu_father_name),UPPER(si.ptu_mother_name),sm.m_code,si.batch,sm.scheme_code, si.cbs,si.scheme_code_first_year, si.scheme_code_branch 
					from scheme_master sm,student_info si ";
					
					if ($row_subject['elective_details']!='Compulsory' && $row_subject['full_part_time']=='Full Time')
					{	
					$insert_sql .= ", student_elective_subjects ses ";
					}
				
					$insert_sql .= "WHERE sm.scheme_master_id='".$row_subject['scheme_master_id']."' and 
						sm.branch_code=si.branch_code and sm.course_code=si.course_code and sm.scheme_code = '".$row_student['scheme_code_branch']."' and si.semester=sm.semester  and si.scheme_code_branch=sm.scheme_code   and si.university_roll_no='".$row_student['university_roll_no']."' and 	sm.subject_status='1' ";
					
					if($row_student['six_month_training']=='Y')
					{
						$insert_sql .= " and si.six_month_training='Y' and sm.six_month_training='Y' ";
					}
					
					if($row_student['six_month_training']!='Y')
					{
						$insert_sql .= "  and sm.six_month_training!='Y' ";
					}
					
					if ($row_subject['elective_details']!='Compulsory' && $row_subject['full_part_time']=='Full Time')
					{	
					 $insert_sql .=  " and ses.elective_details=sm.elective_details and ses.semester=sm.semester and ses.m_code=sm.m_code and ses.paper_id=sm.paper_id and ses.university_roll_no='".$row_student['university_roll_no']."' " ;
					}
					
					if($row_student['leet_non_leet']=='Y' && $row_student['semester']=='3')
					{
						$insert_sql .= " and sm.leet_subject_status_disable!='Y' ";
					}
					
					if($course_branch[0]=='2' && $_POST['full_part_time']=='Part Time' && $_POST['aicte_rc']=='AICTE')
					{
						$insert_sql .= " and sm.onroll_regular_status='Y'; ";
					}
				mysql_query($insert_sql) or die (mysql_error());
				}
			}
			show_label('info','Successfully updated for Student Roll No.:'.$row_student['university_roll_no'].' ');
			#echo $insert_sql;
		}
		$total_students++;
	}
		show_label('error','Total Students : '.$total_students.' ');
		mysql_query("update ptu_subjects ps, scheme_master sm set Ed_Int='0' where internal_max_marks='0' and ps.m_code=sm.m_code and ps.FRM_BRID=sm.branch_code and ps.Sub_Sem=sm.semester and ps.regular_reappear='Regular' ;") or die (mysql_error());
		
		mysql_query("update ptu_subjects ps, scheme_master sm set Ed_Ext='0' where external_max_marks='0' and ps.m_code=sm.m_code and ps.FRM_BRID=sm.branch_code and ps.Sub_Sem=sm.semester and ps.regular_reappear='Regular' ; ") or die (mysql_error());
}

?>

<?
if(isset($_POST['received_marks_update']) && isset($_POST['internal_external_strength_show']))
{
	$n=$_POST['num'];
	#echo "N=".$n;
	$x=1;
	for($i=1;$i<$n;$i++)
	{
		if ($_POST['marks_type']=='Practical_External' && $_POST['received_marks_external'.$x]=='Y')
		{
		$sql= "update subject_master set received_external='Y', received_external_time='".date('Y-m-d H:i:s')."', received_external_by='".$_SESSION['username']."', external_allot='0' where subject_master_id='".$_POST['subject_master_id'.$x]."' ;";
		#echo $sql."<br>";
		#echo $x."<br>";
		mysql_query($sql) or die(mysql_error());
		}
		else if ($_POST['received_marks_internal'.$x]=='Y' && $_POST['marks_type']=='Internal' )
		{
		$sql= "update subject_master set received_internal='Y', received_internal_time='".date('Y-m-d H:i:s')."', received_internal_by='".$_SESSION['username']."', internal_allot='0' where subject_master_id='".$_POST['subject_master_id'.$x]."' ;";
		#echo $sql."<br>";
		#echo $x."<br>";
		mysql_query($sql) or die(mysql_error());
		}
		$x++;
	}
	echo "<center><h5>Received Successfully</h5>";
	break;
}

if(isset($_POST['strength_type']) && isset($_POST['internal_external_strength_show']))
{
	if ($_SESSION['usertype']=='coe')
	{
		$sql_branch_code="select branch_code from branch_code where branch_name='".$_POST['Branch_Name']."' AND course_code='".$_POST['course_code']."' ; ";
		#echo $sql_branch_code;
		$result_branch_code = mysql_query($sql_branch_code) or  die(mysql_error());
		$branch_code_result = mysql_fetch_array($result_branch_code);
		$branch_code =$branch_code_result['branch_code'];
	#	echo $branch_code;
	}
	else
	{
		$course_branch = explode(',',$_POST['course_branch']);
		$branch_code=$course_branch[1];
	}

	if($_POST['strength_type']=='Theory_Internal_Strength')
	{
		$sql_strength ="SELECT distinct concat(cc.course_name,'(',bc.branch_name,')') as Branch, `Sub_Sem` as Semester,Sub_PaperID as Paper_ID,`SUB_CODE`,`SUB_TITLE` as Subject_Title, `shift`,`aicte_rc`,`full_part_time`, count(Ed_RollNo) as Strength,`Regular_Reappear`,SUB_ID   FROM `ptu_subjects` ps,course_code cc,branch_code bc WHERE `SUB_TP` = 'T' AND `Ed_Int` = '1' and `received_status`='Y' and eligibility ='Y'  and ps.course_code=cc.course_code and bc.branch_code= ps.FRM_BRID AND ps.FRM_BRID='".$branch_code."'  group by ps.`SUB_CODE`,ps.FRM_BRID,`Sub_Sem`,Sub_PaperID,`shift`,`aicte_rc`,`full_part_time`,`Regular_Reappear` order by ps.course_code,ps.FRM_BRID,`Sub_Sem`,`Sub_PaperID`,`Regular_Reappear`,`shift`,`aicte_rc`,`full_part_time` ";
		
		#echo $sql_strength;
		
		$sql_strength_count ="SELECT count(Ed_RollNo) as total_strength   FROM `ptu_subjects` ps WHERE `SUB_TP` = 'T' AND `Ed_Int` = '1' and `received_status`='Y' and eligibility ='Y' AND ps.FRM_BRID='".$branch_code."'  ";
	}
	else if($_POST['strength_type']=='Practical_Internal_Strength')
	{
		$sql_strength ="SELECT distinct concat(cc.course_name,'(',bc.branch_name,')') as Branch, `Sub_Sem` as Semester,`SUB_CODE`,`SUB_TITLE` as Subject_Title, `shift`,`aicte_rc`,`full_part_time`, count(Ed_RollNo) as Strength,`Regular_Reappear`,SUB_ID   FROM `ptu_subjects` ps,course_code cc,branch_code bc WHERE `SUB_TP` = 'P' AND `Ed_Int` = '1' and `received_status`='Y' and eligibility ='Y'  and ps.course_code=cc.course_code and 
		bc.branch_code= ps.FRM_BRID AND ps.FRM_BRID='".$branch_code."'  group by ps.FRM_BRID,`Sub_Sem`,`SUB_CODE`,`shift`,`aicte_rc`,`full_part_time`,`Regular_Reappear` order by ps.course_code,ps.FRM_BRID,`Sub_Sem`,`SUB_CODE`,`Regular_Reappear`,`shift`,`aicte_rc`,`full_part_time` ; ";
		
		$sql_strength_count ="SELECT count(Ed_RollNo) as total_strength   FROM `ptu_subjects` ps WHERE `SUB_TP` = 'P' AND `Ed_Int` = '1' and `received_status`='Y' and eligibility ='Y' AND ps.FRM_BRID='".$branch_code."'  ";
	}
	else if($_POST['strength_type']=='Practical_External_Strength')
	{
		$sql_strength = "SELECT distinct concat(cc.course_name,'(',bc.branch_name,')') as Branch, `Sub_Sem` as Semester,`SUB_CODE`,`SUB_TITLE` as Subject_Title, `shift`,`aicte_rc`,`full_part_time`, count(Ed_RollNo) as Strength,`Regular_Reappear`,SUB_ID    FROM `ptu_subjects` ps,course_code cc,branch_code bc WHERE `SUB_TP` = 'P' AND `Ed_Ext` = '1' and `received_status`='Y' and eligibility ='Y'  and ps.course_code=cc.course_code and bc.branch_code= ps.FRM_BRID  AND ps.FRM_BRID='".$branch_code."' group by ps.FRM_BRID,`Sub_Sem`,`SUB_CODE`,`shift`,`aicte_rc`,`full_part_time`,`Regular_Reappear` order by ps.course_code,ps.FRM_BRID,`Sub_Sem`,`SUB_CODE`,`Regular_Reappear`,`shift`,`aicte_rc`,`full_part_time`";
			
		$sql_strength_count ="SELECT count(Ed_RollNo) as total_strength   FROM `ptu_subjects` ps WHERE `SUB_TP` = 'P' AND `Ed_Ext` = '1' and `received_status`='Y' and eligibility ='Y' AND ps.FRM_BRID='".$branch_code."'  ";

	}
	#echo $sql_detainee_list;
	$result_strength_list = mysql_query($sql_strength) or  die(mysql_error());
	$result_strength_count = mysql_query($sql_strength_count) or  die(mysql_error());
	$row_strength_count = mysql_fetch_array($result_strength_count);
	echo "  <form id='profile' name='profile' action=''  method='post'>";
	echo "<center><h3>".$_POST['strength_type']." Detail </h3></center>";
	echo "<table  class='table table-bordered striped table-condensed container' ><tr style='background-color:lightgrey'>
	<th>Sr. No.</th>
	<th>Course(Branch)</th> 
	<th>Sem.
	<th>Paper ID</th>
	<th>Subject Code</th>
	<th>Subject Title</th>
	<th>Shift</th>
	<th>AICTE</th>
	<th>Full / Part Time</th>
	<th>Strength</th>
	<th>Filled Strength</th>
	<th>Regular / Reappear
	<!--<th>Remarks</th>-->	";
	if ($_SESSION['usertype']=='coe')
	{
		echo "<th>Received</th>";
	}
	$x=1;
	while($row_result = mysql_fetch_array($result_strength_list))
		{
			if ($_POST['strength_type']=='Theory_Internal_Strength')
			{
				$sql_strength_filled = "SELECT count(sim.university_roll_no) as filled_strength  FROM `student_internal_marks` sim, subject_master sm WHERE 
				sim.`theory_practical` ='T' AND 
				sim.internal_external='I' and  
				sim.`internal_lock_status`='1' 
				and sm.`theory_practical` = 'T' and 
				sim.branch_code='".$branch_code."' AND
				sim.subject_master_id = '".$row_result['SUB_ID']."' AND
				sm.subject_master_id = '".$row_result['SUB_ID']."' AND
				sim.paper_id='".$row_result['Paper_ID']."' AND
				sim.subject_code='".$row_result['SUB_CODE']."' AND
				sim.shift='".$row_result['shift']."' AND
				sim.aicte_rc='".$row_result['aicte_rc']."' AND
				sim.full_part_time='".$row_result['full_part_time']."' AND
				sim.regular_reappear ='".$row_result['Regular_Reappear']."' ;
				";
				#echo $sql_strength_filled.  ".$x<br />";
				
				$sql_strength_filled_count = "SELECT count(sim.university_roll_no) as filled_strength_count  FROM `student_internal_marks` sim, subject_master sm WHERE 
				sim.`theory_practical` ='T' AND 
				sim.internal_external='I' and  
				sim.`internal_lock_status`='1' 
				
				and sm.`theory_practical` = 'T' and 
				sm.`theory_practical` = sim.`theory_practical` AND
				sm.course_code=sim.course_code 	and sm.branch_code= sim.branch_code and  sm.`semester`=sim.semester and sm.paper_id = sim.paper_id and sm.subject_code =  sim.subject_code and sm.shift = sim.shift and sm.aicte_rc = sim.aicte_rc and sm.full_part_time= sim.full_part_time and sm.regular_reappear= sim.regular_reappear and 
				sim.branch_code='".$branch_code."' ;";
				
			}
			else if($_POST['strength_type']=='Practical_Internal_Strength')
			{
				$sql_strength_filled = "SELECT  count(sim.university_roll_no) as filled_strength  FROM `student_internal_marks` sim, subject_master sm WHERE sim.`theory_practical` = 'P' AND sim.internal_external='I'  and sim.`internal_lock_status`=1 AND sim.`internal_lock_status`=1 and sm.`theory_practical` = 'P'  and
				sim.branch_code='".$branch_code."' AND
				sim.subject_master_id = '".$row_result['SUB_ID']."' AND
				sm.subject_master_id = '".$row_result['SUB_ID']."' AND
				sim.subject_code='".$row_result['SUB_CODE']."' AND
				sim.shift='".$row_result['shift']."' AND
				sim.aicte_rc='".$row_result['aicte_rc']."' AND
				sim.full_part_time='".$row_result['full_part_time']."' AND
				sim.regular_reappear ='".$row_result['Regular_Reappear']."'   ";
				
				#echo $sql_strength_filled. "$x <br>";
				
				$sql_strength_filled_count = "SELECT  count(sim.university_roll_no) as filled_strength_count  FROM `student_internal_marks` sim, subject_master sm WHERE sim.`theory_practical` = 'P' AND sim.internal_external='I' and  sim.`internal_lock_status`=1 and sim.`internal_attendance_status`=1 and sim.`internal_lock_status`=1  and sm.`theory_practical` = 'P' and 
				sm.course_code=sim.course_code and sm.branch_code= sim.branch_code and  sm.`semester`=sim.semester
				and sm.paper_id = sim.paper_id and sm.subject_code =  sim. subject_code and sm.shift = sim.shift and
				 sm.aicte_rc = sim.aicte_rc and sm.full_part_time= sim.full_part_time and sm.regular_reappear= sim.regular_reappear  and sm.`theory_practical` = sim.`theory_practical` and
				sim.branch_code='".$branch_code."'  ;";
				
	
			}
			else if($_POST['strength_type']=='Practical_External_Strength')
			{
				$sql_strength_filled = " SELECT count(sim.university_roll_no) as filled_strength  FROM `student_internal_marks` sim, subject_master sm WHERE sim.`theory_practical` = 'P' AND sim.internal_external='E' and  sim.`external_lock_status`=1 and sim.`external_lock_status`=1 and sm.`theory_practical` = 'P' and sm.`theory_practical` = sim.`theory_practical` AND
				sm.course_code=sim.course_code and sm.branch_code= sim.branch_code and  sm.`semester`=sim.semester
				and sm.subject_code =  sim. subject_code and sm.shift = sim.shift and
				 sm.aicte_rc = sim.aicte_rc and sm.full_part_time= sim.full_part_time and sm.regular_reappear= sim.regular_reappear AND
				 sim.branch_code='".$branch_code."' AND
				sim.subject_master_id = '".$row_result['SUB_ID']."' AND
				sm.subject_master_id = '".$row_result['SUB_ID']."' AND
				sim.subject_code='".$row_result['SUB_CODE']."' AND
				sim.shift='".$row_result['shift']."' AND
				sim.aicte_rc='".$row_result['aicte_rc']."' AND
				sim.full_part_time='".$row_result['full_part_time']."' AND
				sim.regular_reappear ='".$row_result['Regular_Reappear']."' ; ";
				
				$sql_strength_filled_count = "SELECT count(sim.university_roll_no) as filled_strength_count  FROM `student_internal_marks` sim, subject_master sm WHERE sim.`theory_practical` = 'P' AND sim.internal_external='E' and  sim.`external_lock_status`=1 and sim.`external_attendance_status`=1 and sim.`external_lock_status`=1 and sm.`theory_practical` = 'P' and sm.`theory_practical` = sim.`theory_practical` AND
				sm.course_code=sim.course_code and sm.branch_code= sim.branch_code and  sm.`semester`=sim.semester
				and sm.subject_code =  sim. subject_code and sm.shift = sim.shift and
				 sm.aicte_rc = sim.aicte_rc and sm.full_part_time= sim.full_part_time and sm.regular_reappear= sim.regular_reappear AND
				 sim.branch_code='".$branch_code."' ;";
	
			}
			$result_strength_filled = mysql_query($sql_strength_filled) or  die(mysql_error());
			$row_strength_filled = mysql_fetch_array($result_strength_filled);
			$result_strength_filled_count = mysql_query($sql_strength_filled_count) or  die(mysql_error());
			$row_strength_filled_count = mysql_fetch_array($result_strength_filled_count);
			echo "<tr><td>$x</td>
			<td>".$row_result['Branch']."</td>
			<td>".$row_result['Semester']."</td>
			<td>".$row_result['Paper_ID']."</td>
			<td>".$row_result['SUB_CODE']."</td>
			<td>".$row_result['Subject_Title']."</td>
			<td>".$row_result['shift']."</td>
			<td>".$row_result['aicte_rc']."</td>
			<td>".$row_result['full_part_time']."</td>
			<td>".$row_result['Strength']."</td>
			<td>".$row_strength_filled['filled_strength']."</td>
			<td>".$row_result['Regular_Reappear']."</td>";
			#############################
			#Received ON
			#############################
			if ($_SESSION['usertype']=='coe')
			{ 
				$sql_subject = "SELECT * from subject_master where  subject_master_id='".$row_result['SUB_ID']."' ;";
				$result_subject = mysql_query($sql_subject);
				$row_subject = mysql_fetch_array($result_subject);
				#$sql_sim_I = "SELECT * from student_internal_marks where  subject_master_id='".$row_result['SUB_ID']."' and internal_external='I' and teacher_username='".$row_subject['teacher_username']."';";
				$sql_sim_I = "SELECT * from student_internal_marks where  subject_master_id='".$row_result['SUB_ID']."' and internal_external='I' order by attendance_last_updated_on DESC;";
				$result_sim_I = mysql_query($sql_sim_I);
				$row_sim_I = mysql_fetch_array($result_sim_I);
				#$sql_sim_E = "SELECT * from student_internal_marks where  subject_master_id='".$row_result['SUB_ID']."' and internal_external='E' and teacher_username='".$row_subject['teacher_username']."' ;";
				$sql_sim_E = "SELECT * from student_internal_marks where  subject_master_id='".$row_result['SUB_ID']."' and internal_external='E' order by attendance_last_updated_on DESC;";
				$result_sim_E = mysql_query($sql_sim_E);
				$row_sim_E = mysql_fetch_array($result_sim_E);
				#echo "$x ".$sql_sim_E."<br>";
				if($_POST['strength_type']=='Practical_External_Strength')
				{	
						#echo  "<td>".$row_subject['remarks'];
					if ($row_subject['received_external']=='Y')
					{
						echo "<td>Yes</td>";
					}
					else if ($row_sim_E['external_lock_status']=='1')
					{
					echo "<td><font color='red'>";
					echo "<input type='checkbox' name='received_marks_external$x' value='Y'> Received</font></td>
					<input type='hidden' name='marks_type' value='Practical_External'>
					<input type='hidden' name='subject_master_id$x' value='".$row_result['SUB_ID']."'>";
					}
					else
					{ echo "<td></td>";}
				}
				else
				{
					#echo  "<td>".$row_subject['remarks'];
					if ($row_subject['received_internal']=='Y')
					{
						echo "<td>Yes</td>";
					}
					else if ($row_sim_I['internal_lock_status']=='1' )
					{		 
						echo "<td><font color='red'>";
						echo "<input type='checkbox' name='received_marks_internal$x' value='Y'> Received</font></td>
						<input type='hidden' name='marks_type' value='Internal'>
						<input type='hidden' name='subject_master_id$x' value='".$row_result['SUB_ID']."'>";
					}
					else
					{ echo "<td> </td>";}
				}
			}
			echo "</tr>";
			$x++;
		}
			#echo "<tr><td><td><td><td><td><td><td><td><td>Total<td>".$row_strength_count['total_strength']."<td>".$row_strength_filled_count['filled_strength_count']."<td><td></td></tr>
			echo "</table>";
			##########################
			#Received ON
			##########################
			if ($_SESSION['usertype']=='coe')
			{ 
				echo "<center><input type='hidden' name='received_marks_update' value='received_marks_update' /> 
				<input type='hidden' name='num' value='$x'>
				<input type='hidden' name='internal_external_strength_show' value='internal_external_strength_show' /> 
				<input type='submit' name='submit' class='btn btn-danger' value='Submit'></form></center>";
			}
		}

else if($_SESSION['usertype']=='coe')
	{
		$sql_course = "SELECT distinct course_name,course_code from course_code";
		$result_course = mysql_query($sql_course) or  die(mysql_error()) ;
		echo "  <form id='profile' name='profile' action=''  method='post'>";
		echo " <table align='center'><tr><td>Course </td> <td><select name='course_code' >";
		while ($row_course = mysql_fetch_array($result_course))
		{		
		echo "<option value='".$row_course['course_code']."'>".$row_course['course_name']."</option>";
		}	
		echo "</select></td>";
		$sql_branch = "SELECT distinct branch_name from branch_code ;";
		$result_branch = mysql_query($sql_branch);
		echo "<tr><td> Select Branch </td><td> 
		<select name='Branch_Name' class='required'>";
		while ($row_branch = mysql_fetch_array($result_branch))
		{		
			$branch_code=$row_branch['branch_code'];
			$branch_name=$row_branch['branch_name'];
			echo "<option value='$branch_name'>$branch_name</option>";
		}	
		echo "</select></td><tr>";
		echo "<tr><td>Strength Type </td><td> 
		<select name='strength_type' class='required'>";
		echo "<option value='Theory_Internal_Strength'>Theory Internal Strength</option>
		<option value='Practical_Internal_Strength'>Practical Internal Strength</option>
		<option value='Practical_External_Strength'>Practical External Strength</option>";
		echo "</select></td></tr>
		<tr><td></td><td>	
		<input type='hidden' name='internal_external_strength_show' value='internal_external_strength_show' /> 
		<input type='submit' name='submit' class='btn btn-danger' value='Submit'></form></td></tr></table>";
	}
else
	{	
		$user=$_SESSION['username'];
		$sql_user = "SELECT * from users where username ='$user';";
		$result_user = mysql_query($sql_user);
		$row_user = mysql_fetch_array($result_user);
		$users_id=$row_user['users_id'];
		$sql_branch = "SELECT * from branch_code where users_id ='$users_id';";
		#echo $sql_branch;
		$result_branch = mysql_query($sql_branch);
		echo "  <form id='profile' name='profile' action=''  method='post'> <table align='center'>";
		
		
		/*echo " <tr><td> Select Branch </td><td> 
		<select name='Branch_Name' class='required'>";
		while ($row_branch = mysql_fetch_array($result_branch))
		{		
			$branch_code=$row_branch['branch_code'];
			$branch_name=$row_branch['branch_name'];
			echo "<option value='$branch_code'>$branch_name</option>";
		}	
		*/
		$branch_codes_sql = mysql_query("SELECT show_branch_code,show_course_code,show_semester FROM users WHERE username='".$_SESSION['username']."' ; ") or die(mysql_error());
		$branch_codes = mysql_fetch_assoc($branch_codes_sql);
		if($branch_codes['show_branch_code']=='ALL' && $branch_codes['show_course_code']!='ALL') {
			$branch = mysql_query("SELECT distinct branch_code,course_code FROM subject_master WHERE 
			course_code IN (".$branch_codes['show_course_code'].")
			ORDER BY course_code ASC") or die(mysql_error());
		}
		elseif($branch_codes['show_branch_code']=='ALL' && $branch_codes['show_course_code']=='ALL') {
			$branch = mysql_query("SELECT distinct branch_code,course_code FROM subject_master  ORDER BY course_code ASC") or die(mysql_error());
		}
		else {
			$branch = mysql_query("SELECT distinct branch_code,course_code FROM subject_master  WHERE 
			branch_code IN (".$branch_codes['show_branch_code'].")
			ORDER BY course_code ASC") or die(mysql_error()); 
			}
		
		echo "<tr><td>
		<span style='font-weight:bold'>Program </span></td><td>
          <select name='course_branch' id='course_branch' class='input-xlarge'>";
          while($row = mysql_fetch_assoc($branch)) {
						if($row['branch_code']=='' or is_null($row['branch_code'])) {
							continue;
						}
						$course_name = fetch_resource_db('course_code',array('course_code'),array($row['course_code']),'resource_array_value','course_name');
						$branch_name = fetch_resource_db('branch_code',array('branch_code'),array($row['branch_code']),'resource_array_value','branch_name');
						echo "<option value='".$row['course_code'].",".$row['branch_code']."'>".$course_name."(".$branch_name.")</option>";
					}
		echo "/select></tr></td>";
		echo "<tr><td>Strength Type </td><td> 
		<select name='strength_type' class='required'>";
		echo "<option value='Theory_Internal_Strength'>Theory Internal Strength</option>
		<option value='Practical_Internal_Strength'>Practical Internal Strength</option>
		<option value='Practical_External_Strength'>Practical External Strength</option>";
		echo "</select></td></tr>
		<tr><td></td><td>	
		<input type='hidden' name='internal_external_strength_show' value='internal_external_strength_show' /> 
		<input type='submit' name='submit' class='btn btn-danger' value='Submit'></form></td></tr></table>";
	}
?>

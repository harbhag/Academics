<?php

$sub_sems = mysql_query("SELECT DISTINCT semester FROM detainee_list WHERE
detained_by = '".$_SESSION['username']."' AND
theory_practical = '".$_POST['theory_practical']."'") or die(mysql_error());

$locked = mysql_query("SELECT * FROM detainee_list WHERE
detained_by = '".$_SESSION['username']."' AND
locked = 'N' AND
theory_practical = '".$_POST['theory_practical']."'") or die(mysql_error());

$cleared = mysql_query("SELECT * FROM detainee_list WHERE
detained_by = '".$_SESSION['username']."' AND
cleared_status = 'Y' AND
theory_practical = '".$_POST['theory_practical']."'") or die(mysql_error());

if(mysql_num_rows($sub_sems)==0) {
	show_label('important','No Record found.');
	exit();
}

while($row = mysql_fetch_assoc($sub_sems)) {
	$previous_sems1[] = $row['semester'];
}

if(date('n') == 3 || date('n') == 4 || date('n') == 5 || date('n') == 6 || date('n') == 7) {
	$month='May';
}

if( date('n') == 8 || date('n') == 9 || date('n') == 10 || date('n') == 11 || date('n') == 12 || date('n') == 1) {
	$month='Nov';
}

$year = date('Y');



$count = 1;

?>
<br/>
<center><div id='rp_exam_form_td'>
	<table width='95%'>
		
		

<?php 

echo "<br/>";


foreach($previous_sems1 as $semester) {
	$scount = 1;
	$previous_subjects_sql = mysql_query("SELECT DISTINCT * FROM detainee_list WHERE
	detained_by = '".$_SESSION['username']."' AND
	theory_practical = '".$_POST['theory_practical']."' AND
	semester = '".$semester."' ORDER BY semester ASC") or die(mysql_error());
	
	echo "<tr>
					<th class='th-colored-back'>Sr. No.</th>
					<th class='th-colored-back'>University Roll No</th>
					<th class='th-colored-back'>S.Name/F.Name</th>
					<th class='th-colored-back'>Class</th>
					<!--<th class='th-colored-back'>Semester</th>-->
					<th class='th-colored-back'>Subject Code</th>
					<th class='th-colored-back'>Paper ID</th>
					<th class='th-colored-back'>Subject Title</th>
					<th class='th-colored-back'>Scheme Code</th>
					<th class='th-colored-back'>Theory/Practical</th>
					<th class='th-colored-back'>Detained ?</th>
					<th class='th-colored-back'>Cleared ?</th>
					<th class='th-colored-back'>Clear</th>
					<th class='th-colored-back'>Action</th>
				</tr>";
	echo "<tr><td colspan='13' style='padding:15px;text-align:center;'><span style='font-size:25px;font-weight:bold;color:#BC091A'> SEMESTER - ".$semester."</span></td></tr>";
	
	
	
	while($row = mysql_fetch_assoc($previous_subjects_sql)) {
		
		$student_data_si_sql = mysql_query("SELECT * FROM student_info WHERE 
		university_roll_no='".$row['university_roll_no']."'
		") or die(mysql_error());
		$student_data_si = mysql_fetch_assoc($student_data_si_sql);
		
		$course = fetch_resource_db('course_code',array('course_code'),array($student_data_si['course_code']),'resource_array_value','course_name');
		$branch = fetch_resource_db('branch_code',array('branch_code'),array($student_data_si['branch_code']),'resource_array_value','branch_name');

		if($course_branch[0]==2) {
			$course_name = $course."(".$student_data_si['full_part_time']."-".$student_data_si['aicte_rc'].")";
		}
		else {
			$course_name = $course;
		}

		echo "<tr>
		<td>".$scount."</td>
		<td>".$row['university_roll_no']."</td>
		<td>".$row['sname']." / ".$row['fname']."</td>
		<td>".$course_name."(".$branch.")</td>
		<!--<td>".$row['semester']."</td>-->
		<td>".$row['subject_code']."</td>
		<td>".$row['paper_id']."</td>
		<td>".$row['subject_title']."</td>
		<td>".$row['scheme_code']."</td>
		<td>".$row['theory_practical']."</td>
		<td>".$row['detained_status']."</td>
		<td>".$row['cleared_status']."</td>";
		if($row['cleared_status']=='N' && $row['locked']=='N') {
			
			$c_seesion = $row['d_exam_month'].$row['d_exam_year'];
			$p_seesion = $month.$year;
			
			if($c_seesion!=$p_seesion) {
				echo "<td>
				<form action='' method='post'>
			
				<input type='hidden' name='autoid' value='".$row['autoid']."'/>
				<input type='hidden' name='theory_practical' value='".$_POST['theory_practical']."'/>
				<input type='hidden' id='university_roll_no' name='university_roll_no' value='".$row['university_roll_no']."' />
				<input type='button' class='btn btn-mini btn-danger'
				value='Clear' data-toggle='modal' href='#select_exam_month_year".$count."' />";
			
				include('modules/modals/course_admins/select_exam_month_year.php');
			
				echo "</form></td>";
			}
			else {
				echo "
			<td></td>";
			}
		}
		else {
			echo "
			<td></td>";
		}
		
		
		echo "<td>
			<form action='' method='post'>
			
			<input type='hidden' name='autoid' value='".$row['autoid']."'/>
			<input type='hidden' name='delete_detainee' value='".$row['autoid']."'/>
			<input type='hidden' name='theory_practical' value='".$_POST['theory_practical']."'/>
			<input type='hidden' id='university_roll_no' name='university_roll_no' value='".$row['university_roll_no']."' />
			";
			if($row['locked']=='N') {
				if(($row['d_exam_month']==$month) && ($row['d_exam_year']==$year)) {
					echo "
					<input class='btn btn-mini btn-danger'
					value='Delete' type='submit' onclick='return confirm_action(\"Do you Want to Continue ?\")'/>";
				}
			else {
				echo "
				<input type='button' class='btn btn-mini btn-danger disabled' disabled='disabled'
				value='Disabled'/>";
			}
		}
		else {
			echo "
			<input type='button' class='btn btn-mini btn-danger disabled' disabled='disabled'
			value='Locked'/>";
		}
			
			
		echo "</form></td>";
		echo "</tr>";
		$count++;
		$scount++;
	}
	
}

?>
</table>
<br/>
<br/>
<br/>
</div>
</center>

<center>
		<table><tr>
			
			<?php if(mysql_num_rows($locked)!=0) { ?>
			<td>
		<form class="form-horizontal" action='' method='post'>
		<input type='hidden' name='lock_detainee_list'/>
		<input type='hidden' name='theory_practical' value='<?php echo $_POST['theory_practical']; ?>'/>
    <button id="button1id" name="button1id" class="btn btn-danger" type='submit' onclick="return confirm_action('Lock list only after Detaining and Clearing the students. Make sure that you have cleared and detained the students before locking the list. Do you Want to Continue ?')">Lock List</button>
    </form>
    </td>
    <?php } ?>
    
    <?php if(mysql_num_rows($locked)==0) { ?>
    <td>
    <form class="form-horizontal" action='' method='post'>
			<input type='hidden' name='print_detainee_list'/>
			<input type='hidden' name='theory_practical' value='<?php echo $_POST['theory_practical']; ?>'/>
    <button id="button2id"  name="button2id" class="btn btn-danger" type='submit'>Print Detainee List</button>
    </form>
    </td>
    <?php } ?>
    
     <?php if(mysql_num_rows($cleared)!=0 && mysql_num_rows($locked)==0) { ?>
    <td>
    <form class="form-horizontal" action='' method='post'>
			<input type='hidden' name='print_clear_detainee_list'/>
			<input type='hidden' name='theory_practical' value='<?php echo $_POST['theory_practical']; ?>'/>
    <button id="button2id"  name="button2id" class="btn btn-danger" type='submit'>Print Cleared List</button>
    </form>
    </td>
    <?php } ?>
    
    </tr></table>
  

</center>

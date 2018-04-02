<?php

$morning = "16:30:00";
//$morning = "23:30:00";


//$evening = "28:30:00";
$evening = "18:30:00";


$paper_id = mysql_query("SELECT distinct Sub_PaperID as paper_id, SUB_TITLE as subject_title,usession FROM ptu_subjects WHERE 
date_of_exam='".date("Y-m-d")."' AND 
usession='".$_SESSION['usession']."' AND 
`SUB_TP` = 'T' ORDER BY Sub_PaperID ASC") or die(mysql_error());

$branch = mysql_query("SELECT distinct branch_code,branch_name,course_code FROM branch_code ORDER BY course_code ASC") or die(mysql_error());

echo "<center>
					<table>
					<form method='post' action=''>
          <input type='hidden' name='sup_mark_attendance_form_student' value='sup_mark_attendance_form_student' />
          
          <tr><td>
          <span style='font-weight:bold'>Regular/Reappear</span>
          </td><td>
          <select name='regular_reappear' class='input-xlarge'>
					<option value='Regular'>Regular</option>
					<option value='Reappear'>Reappear</option>
					</select>
					</tr></td>
					
					<tr><td>
					<span style='font-weight:bold'>Course(Branch)</span>
					</td><td>
          <select name='branch_code' id='branch_code' class='input-xlarge'>";
          while($row = mysql_fetch_assoc($branch)) {
						if($row['branch_code']=='' or is_null($row['branch_code'])) {
							continue;
						}
						$course_name = fetch_resource_db('course_code',array('course_code'),array($row['course_code']),'resource_array_value','course_name');
						echo "<option value='".$row['course_code'].",".$row['branch_code']."'>".$course_name."(".$row['branch_name'].")</option>";
					}
					echo "
					</select>
					</tr></td>
					
					<tr><td>
					<span style='font-weight:bold'>Paper ID</span>
					</td><td>
          <select name='paper_id' id='paper_id' class='input-xlarge'>";
          while($row = mysql_fetch_assoc($paper_id)) {
						if($row['paper_id']=='' or is_null($row['paper_id'])) {
							continue;
						}
						if($row['usession']=='M') {
							if(time() > strtotime($morning)) {
								continue;
							}
						}
						if($row['usession']=='E') {
							if(time() > strtotime($evening)) {
								continue;
							}
						}
						echo "<option value='".$row['paper_id']."'>".$row['paper_id']."(".$row['subject_title'].")</option>";
					}
					echo "
					</select>
					</tr></td>
					
					<tr><td>
					
					<button type='submit' name='submit' class='btn btn-large btn-danger'>Proceed</button>
					</tr></td>
         
				</form>
				</table>
		</center>";
  

?>

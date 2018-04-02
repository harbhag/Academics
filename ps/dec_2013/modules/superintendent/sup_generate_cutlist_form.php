<?php

$paper_id = mysql_query("SELECT distinct paper_id,subject_title FROM subject_master WHERE 
usession='".$_SESSION['usession']."' AND theory_practical='T' ORDER BY paper_id ASC") or die(mysql_error());

$date_of_exam = mysql_query("SELECT distinct date_of_exam FROM ptu_subjects WHERE 
usession='".$_SESSION['usession']."' AND `SUB_TP` = 'T' ORDER BY date_of_exam ASC") or die(mysql_error());

$branch = mysql_query("SELECT distinct branch_code,branch_name,course_code FROM branch_code ORDER BY course_code ASC") or die(mysql_error());


echo "<center>

					<table>
					<form method='post' action=''>
					
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
         <input type='text' class='input-xlarge' name='paper_id' id='paper_id' />
					</tr></td>
					
					<tr><td>
					<span style='font-weight:bold'>Date of Exam(yyyy-mm-dd)</span>
					</td><td>
          <select name='date_of_exam' id='date_of_exam' class='input-xlarge'>";
          while($row = mysql_fetch_assoc($date_of_exam)) {
						if($row['date_of_exam']=='' or is_null($row['date_of_exam'])) {
							continue;
						}
						echo "<option value='".$row['date_of_exam']."'>".$row['date_of_exam']."</option>";
					}
					echo "
					</select>
					</tr></td>
					
					<tr><td>
					<input type='hidden' name='sup_generate_cutlist' value='sup_generate_cutlist' />
					<button type='submit' name='submit' class='btn btn-large btn-danger'>Proceed</button>
					</tr></td>
         
				</form>
				</table>
		</center>";
  

?>

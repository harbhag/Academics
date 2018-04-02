<?php


$branch = mysql_query("SELECT distinct branch_code,branch_name,course_code FROM branch_code ORDER BY course_code ASC") or die(mysql_error());

echo "<center>
					<table>
					<form method='post' action=''>
          <input type='hidden' name='sup_generate_attendance_sheet' value='sup_generate_attendance_sheet' />
          
           <tr><td>
          <span style='font-weight:bold'>Centre No.</span>
          </td><td>
          <select name='ucentre' class='input-xlarge'>
					<option value='C1'>C1</option>
					<option value='C2'>C2</option>
					<option value='C3'>C3</option>
					</select>
		 </tr></td>
		 
		  <tr><td>
          <span style='font-weight:bold'>Session</span>
          </td><td>
          <select name='usession' class='input-xlarge'>
					<option value='M'>M</option>
					<option value='E'>E</option>
					</select>
		 </tr></td>
		 
		 	
					<tr><td>
          <span style='font-weight:bold'>AICTE/RC</span>
          </td><td>
          <select name='aicte_rc' class='input-xlarge'>
					<option value='AICTE'>AICTE</option>
					<option value='RC'>RC</option>
					</select>
					</tr></td>
					
					<tr><td>
          <span style='font-weight:bold'>FT/PT</span>
          </td><td>
          <select name='full_part_time' class='input-xlarge'>
					<option value='Full Time'>Full Time</option>
					<option value='Part Time'>Part Time</option>
					</select>
					</tr></td>
		 
		  <tr><td>
          <span style='font-weight:bold'>Semester</span>
          </td><td>
          <select name='semester' class='input-xlarge'>
					<option value='1'>1</option>
					<option value='2'>2</option>
					<option value='3'>3</option>
					<option value='4'>4</option>
					<option value='5'>5</option>
					<option value='6'>6</option>
					<option value='7'>7</option>
					<option value='8'>8</option>
					</select>
		 </tr></td>
          
          <tr><td>
          <span style='font-weight:bold'>Regular/Reappear</span>
          </td><td>
          <select name='regular_reappear' class='input-xlarge'>
					<option value='Regular'>Regular</option>
					<!--<option value='Reappear'>Reappear</option>-->
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
					
					<button type='submit' name='submit' class='btn btn-large btn-danger'>Proceed</button>
					</tr></td>
         
				</form>
				</table>
		</center>";
  

?>

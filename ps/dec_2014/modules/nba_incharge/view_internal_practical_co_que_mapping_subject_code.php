<?php

$course_branch = explode(',',$_POST['course_branch']);

$scheme_master = mysql_query("SELECT *  from scheme_master  where semester='".$_POST['semester']."' and scheme_code='".$_POST['scheme_code']."' and theory_practical='P' and branch_code='".$course_branch['1']."'; ");

show_label('info','Select Subject Code ');
echo "<br/><br/>
<center>
	<table>
	<form method='post' action=''>
						<tr><td>
					<span style='font-weight:bold'>Subject Code </span>
					</td><td>
          <select name='subject_code' id='subject_code' class='input-medium'>";
          while($row = mysql_fetch_assoc($scheme_master)) {
						if($row['subject_code']=='' or is_null($row['subject_code'])) {
							continue;
						}
						echo "<option value='".$row['subject_code']."'>".$row['subject_code']."</option>";
					}
					echo "</select></tr></td>		
				<input type='hidden' name='semester' value='".$_POST['semester']."' />
				<input type='hidden' name='branch_code' value='".$course_branch['1']."' />
				<input type='hidden' name='scheme_code' value='".$_POST['scheme_code']."' />
				<input type='hidden' name='ip_no' value='0' />";
				
				
				
				echo "<tr><td>
					<input type='hidden' name='view_internal_practical_co_que_mapping_details_form' value='view_internal_practical_co_que_mapping_details_form' />
					<button type='submit' name='submit' class='btn btn-large btn-danger'>Proceed</button>
					</tr></td></form></table>";
					
					
?>


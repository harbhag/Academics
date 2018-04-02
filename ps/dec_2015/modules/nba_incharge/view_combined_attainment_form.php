<?php
$course_branch = explode(',',$_POST['course_branch']);

$exam_month = mysql_query("SELECT distinct exam_month  from combined_attainment");
$exam_year = mysql_query("SELECT distinct  exam_year  from combined_attainment");

show_label('info','Please select details below.');
echo "<br/><br/>
<center>
	<table>
	<form method='post' action=''>
						
						
						<tr><td>
					<span style='font-weight:bold'>Exam Month </span>
					</td><td>
          <select name='exam_month' id='exam_month' class='input-medium'>";
          while($row = mysql_fetch_assoc($exam_month)) {
					echo "<option value='".$row['exam_month']."'>".$row['exam_month']."</option>";
			}
			echo "</select></tr></td>";
			
			
			
			echo "<tr><td>
					<span style='font-weight:bold'>Exam Year </span>
					</td><td>
          <select name='exam_year' id='exam_year' class='input-medium'>";
          while($row = mysql_fetch_assoc($exam_year)) {
					echo "<option value='".$row['exam_year']."'>".$row['exam_year']."</option>";
			}
			echo "</select></tr></td>";
			
			
			echo "<tr><td>
					<span style='font-weight:bold'>Internal/External </span>
					</td><td>
          <select name='i_e' id='i_e' class='input-medium'>";
         echo "<option value='I'>Internal</option>";
         echo "<option value='E'>External</option>";
         echo "<option value='Both'>Both</option>";
			echo "</select></tr></td>";
				
				
				
				echo "<tr><td>
					<input type='hidden' name='view_combined_attainment' value='view_combined_attainment' />
					<button type='submit' name='submit' class='btn btn-large btn-danger'>Proceed</button>
					</tr></td></form></table>";
					
					
?>

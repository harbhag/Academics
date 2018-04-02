<?php

show_label('info','Subjectwise PO Attainment');

if($_POST['i_e']=='I') {
	$ie = "Internal";
}
else if($_POST['i_e']=='E') {
	$ie = "External";
}
else {
	$ie='Combined';
}

echo "<br/><center><table class='table table-bordered table-condensed container'>
<tr>
<th>Internal/External</th><td>".$ie."</td>
<tr>
<tH>Exam Month/Year</tH><td>".$_POST['exam_month']."/".$_POST['exam_year']."</td>
</tr>
</tr>
</table></center>";
	
	echo "<br/>
		<table  class='table striped table-hover table-bordered table-condensed container'>
		<tr class='info'>
		<th>PO ID</th>";


if($_POST['i_e']!='Both') {

	$subject_codes = mysql_query("SELECT DISTINCT subject_code FROM combined_attainment where 
	exam_month='".$_POST['exam_month']."' AND
	exam_year='".$_POST['exam_year']."' AND
	internal_external='".$_POST['i_e']."' AND
	avg_per!=0 ORDER BY semester,subject_code
	") or die(mysql_error());
	
	while($sc = mysql_fetch_assoc($subject_codes)) {
		
		echo "<th>".$sc['subject_code']." (%)</th>";
		
	}
	
	echo 
		"<th>Attainment (avg.)</th>
		</tr>";
		
	for($i = 'a'; $i<='l'; $i++){
		

	$subject_codes = mysql_query("SELECT DISTINCT subject_code FROM combined_attainment where 
	exam_month='".$_POST['exam_month']."' AND
	exam_year='".$_POST['exam_year']."' AND
	internal_external='".$_POST['i_e']."'AND
	avg_per!=0 ORDER BY semester,subject_code
	") or die(mysql_error());
	
			
			
			echo "
			<tr class='info'>
			<td><b>".$i."</b></td>";
				
				$ff_attain = array();
				
				
				while($sc = mysql_fetch_assoc($subject_codes)) {

					$f_attain = array();
					
					$po_sql = mysql_query("SELECT * FROM combined_attainment WHERE subject_code = '".$sc['subject_code']."' AND internal_external='".$_POST['i_e']."'
					AND exam_month='".$_POST['exam_month']."' AND exam_year='".$_POST['exam_year']."' AND ($i='H' OR $i='M')") or die(mysql_error());
					

					

					$att = "attain_".$i;

					while($po=mysql_fetch_assoc($po_sql)) { 
				
						$attain_sql = mysql_query("SELECT $att from combined_attainment WHERE subject_code = '".$sc['subject_code']."' AND internal_external='".$_POST['i_e']."'
						AND exam_month='".$_POST['exam_month']."' AND exam_year='".$_POST['exam_year']."' AND $i='".$po[$i]."'
						AND $att!=0") or die(mysql_error());
				
						if(mysql_num_rows($attain_sql)==0) {
							continue;
						}
				
						$attain = mysql_fetch_assoc($attain_sql);
			
						$at= $attain[$att];

						$f_attain[] = $at;
					
					
					
					}
					
					$avg_per = (array_sum($f_attain))/(count($f_attain));

					if($avg_per==0) {
						$avg_per='---';
					}

					if($avg_per=='---') {
						echo"
					<td>".$avg_per."</td>";
					}

					else {
						echo"
					<td>".round($avg_per,2)."</td>";

					}
					


					if(is_numeric($avg_per) && $avg_per>0) {

						$ff_attain[] = $avg_per;
					}

					unset($f_attain);
					
									
					
				}

				//echo "<br/>".count($ff_attain);

				$f_avg_per = (array_sum($ff_attain))/(count($ff_attain));
				echo "<td>".round($f_avg_per,2)."</td>";
				unset($ff_attain);
				echo "<tr/>";
			
			
	}
		
		echo "</table>";
}
else {
	$subject_codes = mysql_query("SELECT DISTINCT subject_code FROM combined_attainment where 
	exam_month='".$_POST['exam_month']."' AND
	exam_year='".$_POST['exam_year']."' AND
	avg_per!=0 ORDER BY semester,subject_code
	") or die(mysql_error());
	
	while($sc = mysql_fetch_assoc($subject_codes)) {
		
		echo "<th>".$sc['subject_code']." (%)</th>";
		
	}
	
	echo 
		"<th>Attainment (avg.)</th>
		</tr>";
		
	for($i = 'a'; $i<='l'; $i++){
		

	$subject_codes = mysql_query("SELECT DISTINCT subject_code FROM combined_attainment where 
	exam_month='".$_POST['exam_month']."' AND
	exam_year='".$_POST['exam_year']."' AND
	avg_per!=0 ORDER BY semester,subject_code
	") or die(mysql_error());
	
			
			
			echo "
			<tr class='info'>
			<td><b>".$i."</b></td>";
				
				$ff_attain = array();
				
				
				while($sc = mysql_fetch_assoc($subject_codes)) {

					$f_attain_i = array();
					$f_attain_e = array();
					
					$po_i_sql = mysql_query("SELECT * FROM combined_attainment WHERE subject_code = '".$sc['subject_code']."' AND internal_external='I'
					AND exam_month='".$_POST['exam_month']."' AND exam_year='".$_POST['exam_year']."' AND ($i='H' OR $i='M')") or die(mysql_error());

					$po_e_sql = mysql_query("SELECT * FROM combined_attainment WHERE subject_code = '".$sc['subject_code']."' AND internal_external='E'
					AND exam_month='".$_POST['exam_month']."' AND exam_year='".$_POST['exam_year']."' AND ($i='H' OR $i='M')") or die(mysql_error());
					

					

					$att = "attain_".$i;

					while($po=mysql_fetch_assoc($po_i_sql)) { 
				
						$attain_i_sql = mysql_query("SELECT $att from combined_attainment WHERE subject_code = '".$sc['subject_code']."'
						AND internal_external='I'
						AND exam_month='".$_POST['exam_month']."' AND exam_year='".$_POST['exam_year']."' AND $i='".$po[$i]."'
						AND $att!=0") or die(mysql_error());

						$max_i_sql = mysql_query("SELECT max_marks from combined_attainment WHERE subject_code = '".$sc['subject_code']."'
						AND internal_external='I'
						AND exam_month='".$_POST['exam_month']."' AND exam_year='".$_POST['exam_year']."' AND $i='".$po[$i]."'
						AND $att!=0") or die(mysql_error());
				
						if(mysql_num_rows($attain_i_sql)==0) {
							continue;
						}
				
						$attain_i = mysql_fetch_assoc($attain_i_sql);
						$max_i = mysql_fetch_assoc($max_i_sql);
			
						$at= $attain_i[$att];

						$f_attain_i[] = $at;
					
					
					
					}

					while($po=mysql_fetch_assoc($po_e_sql)) { 
				
						$attain_e_sql = mysql_query("SELECT $att from combined_attainment WHERE subject_code = '".$sc['subject_code']."'
						AND internal_external='E'
						AND exam_month='".$_POST['exam_month']."' AND exam_year='".$_POST['exam_year']."' AND $i='".$po[$i]."'
						AND $att!=0") or die(mysql_error());

						$max_e_sql = mysql_query("SELECT max_marks from combined_attainment WHERE subject_code = '".$sc['subject_code']."'
						AND internal_external='E'
						AND exam_month='".$_POST['exam_month']."' AND exam_year='".$_POST['exam_year']."' AND $i='".$po[$i]."'
						AND $att!=0") or die(mysql_error());
				
						if(mysql_num_rows($attain_e_sql)==0) {
							continue;
						}
				
						$attain_e = mysql_fetch_assoc($attain_e_sql);
						$max_e = mysql_fetch_assoc($max_e_sql);
			
						$at= $attain_e[$att];

						$f_attain_e[] = $at;
					
					
					
					}
					
					$avg_per_i = (array_sum($f_attain_i))/(count($f_attain_i));
					$avg_per_e = (array_sum($f_attain_e))/(count($f_attain_e));

					$avg_per = ((($avg_per_i)*($max_i['max_marks']))+(($avg_per_e)*($max_e['max_marks'])))/(($max_i['max_marks']+$max_e['max_marks']));

					if($avg_per==0) {

						$avg_per='---';
					}

					if($avg_per=='---') {
						echo"
					<td>".$avg_per."</td>";
					}

					else {
						echo"
					<td>".round($avg_per,2)."</td>";

					}


					if(is_numeric($avg_per) && $avg_per>0) {

						$ff_attain[] = $avg_per;
					}

					unset($f_attain_i);
					unset($f_attain_e);
					
									
					
				}

				//echo "<br/>".count($ff_attain);

				$f_avg_per = (array_sum($ff_attain))/(count($ff_attain));
				echo "<td>".round($f_avg_per,2)."</td>";
				unset($ff_attain);
				echo "<tr/>";
			
			
	}
		
		echo "</table>";
	
}
	
		
		
?>

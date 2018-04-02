<?php

show_label('info','Subjectwise PO Attainment');
	
	echo "<br/>
		<table  class='table table-bordered table-condensed container'>
		<tr class='info'>
		<th>PO ID</th>";


if($_POST['i_e']!='Both') {

	$subject_codes = mysql_query("SELECT DISTINCT subject_code FROM combined_attainment where 
	exam_month='".$_POST['exam_month']."' AND
	exam_year='".$_POST['exam_year']."' AND
	internal_external='".$_POST['i_e']."'
	") or die(mysql_error());
	
	while($sc = mysql_fetch_assoc($subject_codes)) {
		
		echo "<th>".$sc['subject_code']." (%)</th>";
		
	}
	
	echo 
		"<th>Attainment (%)</th>
		</tr>";
		
	for($i = 'a'; $i<='l'; $i++){
		

	$subject_codes = mysql_query("SELECT DISTINCT subject_code FROM combined_attainment where 
	exam_month='".$_POST['exam_month']."' AND
	exam_year='".$_POST['exam_year']."' AND
	internal_external='".$_POST['i_e']."'
	") or die(mysql_error());
			
			
			echo "
			<tr class='info'>
			<td><b>".$i."</b></td>";
			
			$po_sql = mysql_query("SELECT $i FROM combined_attainment") or die(mysql_error());
			$po = mysql_fetch_assoc($po_sql);
			
			$f_attain = array();
			
			if($po[$i]=='H' or $po[$i]=='M') {
				
				$att = "attain_".$i;
				
				while($sc = mysql_fetch_assoc($subject_codes)) {
				
					$attain_sql = mysql_query("SELECT $att from combined_attainment WHERE subject_code = '".$sc['subject_code']."' AND internal_external='".$_POST['i_e']."'
					AND exam_month='".$_POST['exam_month']."' AND exam_year='".$_POST['exam_year']."' AND $i='".$po[$i]."'") or die(mysql_error());
				
					
				
					$attain = mysql_fetch_assoc($attain_sql);
			
					$at= $attain[$att];
					
					if($attain[$att]==0) {
						$at = '---';
					}
					echo"
					<td>".$at."</td>";
					
					if($at!='---') {
						
						$f_attain[] = $at;
					}
					
					$avg_per = (array_sum($f_attain))/(count($f_attain));
					
									
					
				}
				echo "<td>".$avg_per."</td>";
				unset($f_attain);
				echo "<tr/>";
			}
			
			
			
			
	}
		
		echo "</table>";
}
else {
	$subject_codes = mysql_query("SELECT DISTINCT subject_code FROM combined_attainment where 
	exam_month='".$_POST['exam_month']."' AND
	exam_year='".$_POST['exam_year']."'
	") or die(mysql_error());
	
	
	while($sc = mysql_fetch_assoc($subject_codes)) {
		
		echo "<th>".$sc['subject_code']." (%)</th>";
		
	}
	
	echo 
		"<th>Attainment (%)</th>
		</tr>";
		
	for($i = 'a'; $i<='l'; $i++){
		
		$subject_codes = mysql_query("SELECT DISTINCT subject_code FROM combined_attainment where 
	exam_month='".$_POST['exam_month']."' AND
	exam_year='".$_POST['exam_year']."'
	") or die(mysql_error());
		
		
	
			echo "
			<tr class='info'>
			<td><b>".$i."</b></td>";
			
			$po_sql = mysql_query("SELECT $i FROM combined_attainment") or die(mysql_error());
			$po = mysql_fetch_assoc($po_sql);
			
			
			$f_attain = array();
			
			if($po[$i]=='H' or $po[$i]=='M') {
				
				
				$att = "attain_".$i;
				
				while($sc = mysql_fetch_assoc($subject_codes)) {
				
					$attain_i_sql = mysql_query("SELECT $att from combined_attainment WHERE subject_code = '".$sc['subject_code']."' AND internal_external='I'
					AND exam_month='".$_POST['exam_month']."' AND exam_year='".$_POST['exam_year']."' AND $i='".$po[$i]."'") or die("1".mysql_error());
					
					$attain_e_sql = mysql_query("SELECT $att from combined_attainment WHERE subject_code = '".$sc['subject_code']."' AND internal_external='E'
					AND exam_month='".$_POST['exam_month']."' AND exam_year='".$_POST['exam_year']."' AND $i='".$po[$i]."'") or die("1".mysql_error());
					
					$max_i_sql = mysql_query("SELECT max_marks from combined_attainment WHERE subject_code = '".$sc['subject_code']."' AND internal_external='I'
					AND exam_month='".$_POST['exam_month']."' AND exam_year='".$_POST['exam_year']."' AND $i='".$po[$i]."'") or die("2".mysql_error());
					
					$max_e_sql = mysql_query("SELECT max_marks from combined_attainment WHERE subject_code = '".$sc['subject_code']."' AND internal_external='E'
					AND exam_month='".$_POST['exam_month']."' AND exam_year='".$_POST['exam_year']."' AND $i='".$po[$i]."'") or die("3".mysql_error());
				
					
				
					$attain_i = mysql_fetch_assoc($attain_i_sql);
					$max_i = mysql_fetch_assoc($max_i_sql);
					
					$attain_e = mysql_fetch_assoc($attain_e_sql);
					$max_e = mysql_fetch_assoc($max_e_sql);
			
					$at_i= ($attain_i[$att])*($max_i['max_marks']);
					$at_e= ($attain_e[$att])*($max_e['max_marks']);
					
					
					
					$max_m = $max_i['max_marks']+$max_e['max_marks'];
					
					$at_f = ($at_i+$at_e)/($max_m);
					
					
					if($at_f==0) {
						$at_f = '---';
					}
					echo"
					<td>".$at_f."</td>";
					
					if($at_f!='---') {
						
						$f_attain[] = $at_f;
					}
					
					$avg_per = (array_sum($f_attain))/(count($f_attain));
					
									
					
				}
				echo "<td>".$avg_per."</td>";
				unset($f_attain);
				echo "<tr/>";
			}
			
			
			
			
	}
		
		echo "</table>";
	
}
	
		
		
?>

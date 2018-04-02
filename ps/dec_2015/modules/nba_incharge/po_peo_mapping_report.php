<?php
$course_branch = explode(',',$_POST['course_branch']);

$peos = mysql_query("SELECT * FROM program_peos WHERE
branch_code='".$course_branch[1]."' AND
course_code='".$course_branch[0]."'") or die(mysql_error());

$pos = mysql_query("SELECT * FROM program_outcomes WHERE
branch_code='".$course_branch[1]."' AND
course_code='".$course_branch[0]."'") or die(mysql_error());


echo "<br/>
	<table  class='table table-bordered table-condensed container'>
	<tr class='warning'>
	<th>PEO ID</th>
	<th>PEO Statement</th>";
	
	while($po = mysql_fetch_assoc($pos)) {
		
		echo "<th><a href='#' data-toggle='tooltip' title='".$po['po_statement']."'>".$po['po_num']."</a></th>";
		
	}
echo "</tr>";	
while($peo = mysql_fetch_assoc($peos)) {
		echo "<tr class='warning'>
		<td>".$peo['peo_no']."</td>
		<td>".$peo['peo_statement']."</td>";
		
		$pos = mysql_query("SELECT * FROM program_outcomes WHERE
		branch_code='".$course_branch[1]."' AND
		course_code='".$course_branch[0]."'") or die(mysql_error());
		
		while($po = mysql_fetch_assoc($pos)) {
			
			$peo_id_sql = mysql_query("SELECT id FROM program_peos WHERE 
			branch_code='".$course_branch[1]."' AND
			course_code='".$course_branch[0]."' AND
			peo_no = '".$peo['peo_no']."'") or die(mysql_error());
			$peo_id = mysql_fetch_assoc($peo_id_sql);
			
			$po_id_sql = mysql_query("SELECT id FROM program_outcomes WHERE 
			branch_code='".$course_branch[1]."' AND
			course_code='".$course_branch[0]."' AND
			po_num = '".$po['po_num']."'") or die(mysql_error());
			$po_id = mysql_fetch_assoc($po_id_sql);
			
			$correlation_sql = mysql_query("SELECT correlation_peo_po FROM peo_po_mapping WHERE 
			branch_code='".$course_branch[1]."' AND
			program_peos_id = '".$peo_id['id']."' AND
			program_outcomes_id = '".$po_id['id']."'") or die(mysql_error());
			
			$correlation = mysql_fetch_assoc($correlation_sql);
			
			if($correlation['correlation_peo_po']=='') {
				$correlation['correlation_peo_po']='--';
			}
			
			echo "<td>".$correlation['correlation_peo_po']."</td>";
		}
		echo "</tr>";
	}



echo "	</table>";
?>




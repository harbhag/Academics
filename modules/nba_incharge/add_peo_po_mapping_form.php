<?php

$course_branch = explode(',',$_POST['course_branch']);

if(isset($_POST['delete_peo_po_mapping'])) {
	
	
	mysql_query("DELETE FROM peo_po_mapping WHERE id='".$_POST['mapping_id']."'") or die(mysql_error());
	
	show_label('important','Mapping Deleted');
}


if(isset($_POST['add_peo_po_mapping'])) {
	
	$peo_id_sql = mysql_query("SELECT * FROM program_peos WHERE peo_no = '".$_POST['peo']."' AND course_code='".$course_branch[0]."' AND branch_code='".$course_branch[1]."'") or die(mysql_error());
	
	$po_id_sql = mysql_query("SELECT * FROM program_outcomes WHERE po_num = '".$_POST['po']."' AND course_code='".$course_branch[0]."' AND branch_code='".$course_branch[1]."'") or die(mysql_error());
	
	$peo_id = mysql_fetch_assoc($peo_id_sql);
	$po_id = mysql_fetch_assoc($po_id_sql);
	
	$dup = mysql_query("SELECT * FROM peo_po_mapping WHERE program_peos_id='".$peo_id['id']."' AND program_outcomes_id='".$po_id['id']."'") or die(mysql_error());
	
	
	if(mysql_num_rows($dup)!=0) {
		show_label('warning','Mapping already exists');
	}
	else {
		
		mysql_query("INSERT INTO peo_po_mapping (course_code,branch_code,program_peos_id,program_outcomes_id,correlation_peo_po)
		
		VALUES('".$_POST['course_code']."','".$_POST['branch_code']."','".$peo_id['id']."','".$po_id['id']."','".$_POST['correlation']."')") or die("asdfasd".mysql_error());
		
		show_label('success','Mapping Added');
		
	}
	
}

echo "<br/><br/><br/>";
show_label('info','ADD PEO/PO Mapping');

$peos = mysql_query("SELECT * FROM program_peos WHERE course_code='".$course_branch[0]."' AND branch_code='".$course_branch[1]."'") or die(mysql_error());
$pos = mysql_query("SELECT * FROM program_outcomes WHERE course_code='".$course_branch[0]."' AND branch_code='".$course_branch[1]."'") or die(mysql_error());


echo "<br/><br/>
<center>
	<table>
	<form method='post' action=''>
						
						
						<tr><td>
					<span style='font-weight:bold'>PEO</span>
					</td><td>
          <select name='peo' id='peo' class='input-xxlarge'>";
          while($row = mysql_fetch_assoc($peos)) {
						
						echo "<option value='".$row['peo_no']."'>(".$row['peo_no'].") ".$row['peo_statement']."</option>";
					}
					echo "</select></tr></td>		
					
					
					<tr><td>
					<span style='font-weight:bold'>PO</span>
					</td><td>
          <select name='po' id='po' class='input-xxlarge'>";
          while($rows = mysql_fetch_assoc($pos)) {
					
						echo "<option value='".$rows['po_num']."'>(".$rows['po_num'].") ".$rows['po_statement']."</option>";
					}
					echo "</select></tr></td>		
					
					
					<tr><td>
					<span style='font-weight:bold'>Correlation</span>
					</td><td>
          <select name='correlation' id='correlation' class='input-small'>";
					echo "
					<option value='H'>H</option>
					<option value='M'>M</option>
					<option value='L'>L</option>
					";
					echo "</select></tr></td>		
				
				
				
				
				<input type='hidden' name='add_peo_po_mapping_form'/>
				<input type='hidden' name='add_peo_po_mapping'/>
				<input type='hidden' name='branch_code' value='".$course_branch[1]."' />
				<input type='hidden' name='course_code' value='".$course_branch[0]."' />
				<input type='hidden' name='course_branch' value='".$_POST['course_branch']."' />";
				
				
				
				echo "<tr><td>
					
					<button type='submit' name='submit' class='btn btn-large btn-danger'>Add Mapping</button>
					</tr></td></form></table>";
					


?>





<?php


$peos_pos_mapping = mysql_query("SELECT * FROM peo_po_mapping WHERE branch_code='".$course_branch[1]."'") or die(mysql_error());

echo "<br/><br/><br/>";
show_label('info','PEO/PO Mapping Details');
echo "<br/><table  class='table table-bordered   table-condensed container'>
	<tr>
	<th>PEO ID</th>
	<th>PEO Statement</th>
	<th>PO ID</th>
	<th>PO Statement</th>
	<th>Correlation</th>
	<th>Delete</th>
	</tr>";
while($ppm = mysql_fetch_assoc($peos_pos_mapping)) {	
	
$peo_detail_sql = mysql_query("SELECT * FROM program_peos WHERE id = '".$ppm['program_peos_id']."'") or die(mysql_error());
$po_detail_sql = mysql_query("SELECT * FROM program_outcomes WHERE id = '".$ppm['program_outcomes_id']."'") or die(mysql_error());

$peo_detail = mysql_fetch_assoc($peo_detail_sql);
$po_detail = mysql_fetch_assoc($po_detail_sql);

	echo "<tr class='warning' >
	<td>".$peo_detail['peo_no']."</td>
	<td>".$peo_detail['peo_statement']."</td>
	<td>".$po_detail['po_num']."</td>
	<td>".$po_detail['po_statement']."</td>
	<td>".$ppm['correlation_peo_po']."</td>
	<td><form action='' method='post' >
	<input type='hidden' name='delete_peo_po_mapping' />
	<input type='hidden' name='add_peo_po_mapping_form' />
	<input type='hidden' name='course_branch' value='".$_POST['course_branch']."' />
	<input type='hidden' name='mapping_id' value='".$ppm['id']."' />
	<input type='submit' value='Delete' onclick='return confirm_action(\"Do you want to continue ?\")'/>
	</form>
	
	</tr>";
	
}

?>



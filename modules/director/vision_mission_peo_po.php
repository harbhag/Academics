<?
$result_branch_code=mysql_query("select distinct * from branch_code where course_code='1';");

while($row_branch_code = mysql_fetch_assoc($result_branch_code)) 
{
	
	$course_name=mysql_query("select * from course_code where course_code='".$row_branch_code['course_code']."' ;");
	$row_course_name = mysql_fetch_assoc($course_name);
	$result_vision = mysql_query("select vision_statement from dept_vision where branch_code='".$row_branch_code['branch_code']."'; ");
	$result_mission = mysql_query("select * from  dept_mission where branch_code='".$row_branch_code['branch_code']."'; ");
	$result_program_peos = mysql_query("select * from  program_peos where branch_code='".$row_branch_code['branch_code']."'; ");
	$result_program_outcomes = mysql_query("select * from program_outcomes where branch_code='".$row_branch_code['branch_code']."';");
	
	echo "<table class='table table-bordered table-condensed container sortable'><tr> <th><center>Department of ".$row_branch_code['branch_name']."</center></th></tr>
	
	<tr><th>Department Vision</th></tr>";
	while($row_vision = mysql_fetch_assoc($result_vision))
	{
		echo "<tr><td>".$row_vision['vision_statement']."</td></tr>";
	}

	echo "<tr><th>Department Mission</th></tr>";
	while($row_mission = mysql_fetch_assoc($result_mission))
	{
		echo "<tr><td>".$row_mission['sr_no'].". ".$row_mission['mission_statements']."</td></tr>";
	}
	
	echo "<tr><th>Program Education Objectives (PEO) ".$row_course_name['course_name']." (".$row_branch_code['branch_name'].")</th></tr>";
	while($row_program_peos  = mysql_fetch_assoc($result_program_peos))
	{
		echo "<tr><td>".$row_program_peos ['peo_no'].". ".$row_program_peos ['peo_statement']."</td></tr>";
	}
	
	echo "<tr><th>Program Outcomes (PO) ".$row_branch_code['branch_name']." </th></tr>";
	while($row_program_outcomes  = mysql_fetch_assoc($result_program_outcomes))
	{
		echo "<tr><td>".$row_program_outcomes['po_num'].". ".$row_program_outcomes['po_statement']."</td></tr>";
	}
	echo "</table>";
}

?>

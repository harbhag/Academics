<?

if(isset($_POST['result_analysis_list_show']))
{
	
	$usertype=$_SESSION['usertype'];
	if ($usertype=='academic_incharge')
	{
		$branch_codes_sql = mysql_query("SELECT show_branch_code,show_course_code,show_semester FROM users WHERE username='".$_SESSION['username']."' AND usertype='academic_incharge'") or die(mysql_error());
		$branch_codes = mysql_fetch_assoc($branch_codes_sql);
		//branch_code IN (".$branch_codes['show_branch_code'].")
		$sql="SELECT concat(cc.course_name,'(',bc.branch_name,')') as Branch ,pr.course_code, pr.aicte_rc, pr.full_part_time, pr.`branch_code` , semester, COUNT( university_roll_no ) AS total_students, COUNT( 
		CASE WHEN rp_count =  '0'
		THEN 1 
		END ) pass, ROUND((COUNT( 
		CASE WHEN rp_count =  '0'
		THEN 1 
		END ) / COUNT( university_roll_no )) *100) pass_per
		FROM  `processed_result` pr, branch_code bc,course_code cc  where  pr.course_code=cc.course_code and 
		bc.branch_code= pr.branch_code and pr.regular_reappear='".$_POST['Regular_/_Reappear']."' and pr.exam_month='".$_POST['exam_month']."' and pr.exam_year='".$_POST['exam_year']."' and pr.branch_code IN (".$branch_codes['show_branch_code'].") group by course_code,  `branch_code` , semester, pr.aicte_rc, pr.full_part_time";
	}	
	else
	{
		$sql="SELECT concat(cc.course_name,'(',bc.branch_name,')') as Branch ,pr.course_code, pr.aicte_rc, pr.full_part_time, pr.`branch_code` , semester, COUNT( university_roll_no ) AS total_students, COUNT( 
		CASE WHEN rp_count =  '0'
		THEN 1 
		END ) pass, ROUND((COUNT( 
		CASE WHEN rp_count =  '0'
		THEN 1 
		END ) / COUNT( university_roll_no )) *100) pass_per
		FROM  `processed_result` pr, branch_code bc,course_code cc  where  pr.course_code=cc.course_code and 
		bc.branch_code= pr.branch_code and pr.regular_reappear='".$_POST['Regular_/_Reappear']."' and pr.exam_month='".$_POST['exam_month']."' and pr.exam_year='".$_POST['exam_year']."' group by course_code,  `branch_code` , semester, pr.aicte_rc, pr.full_part_time";
	}
	$result1 = mysql_query($sql) or die(mysql_error());
	#echo $sql;
	echo "<h4> <center> Result Analysis Regular </center></h4>";
		echo "<br /><br />
		<table class='table table-bordered striped table-condensed container sortable'>
		<tr>
		<th>Program </th>
		<th>Full / Part Time</th>
		<th>AICTE / RC</th>
		<th>Semester</th>
		<th>Total Students</th>
		<th>Student Pass </th>
		<th>Pass Percentage</th></tr>";

	$x=1;
		#echo "hello";
		while($row = mysql_fetch_array($result1))
		{
			echo "<tr><td>".$row['Branch']."<td>".$row['full_part_time']."</td><td>".$row['aicte_rc']."</td><td>".$row['semester']."</td><td>".$row['total_students']."  </td><td>".$row['pass']."<td>".$row['pass_per']."</td></tr>";
		$x++;
		}
		break;	

}
#echo "Regular / Reappear , month , year, ";

if(isset($_POST['result_analysis_list']))
{	
	show_label("info","Result Analysis End Semeter Exam");
	echo "  <form id='profile' name='profile' action=''  method='post'><br>";
	echo "<table align='center'>";
	echo "<tr>";
	form_dropdown_field('dropdown','','Regular_/_Reappear','processed_result','regular_reappear','required');
	echo "	<tr><td>Exam Month</td><td><select name='exam_month'><option value='11'>Nov-Dec</option>
	<tr><td>Exam Year</td><td><select name='exam_year'><option value='2013'>2013</option>
	<tr>";
	#form_dropdown_field('dropdown','','Regular_/_Reappear','processed_result','regular_reappear','required');
	echo "<input type='hidden' name='result_analysis_list_show' value='result_analysis_list_show' /> 
	<td><input type='submit' name='submit' class='btn btn-danger' value='Submit'></form></td></tr></table>";
}
?>

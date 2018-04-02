<?php

$lock_status =  mysql_num_rows ( mysql_query("SELECT *  FROM `question_paper_panel` where assigned_by='".$_SESSION['username']."' and lock_status='N';"));
$lock_status_no_data =  mysql_num_rows ( mysql_query("SELECT *  FROM `question_paper_panel` where assigned_by='".$_SESSION['username']."' ;"));
if($lock_status==0 and $lock_status_no_data!=0)
{
	show_label('important', 'Question Paper Panel Report already locked');
exit();
}	
if (isset($_POST['question_paper_panel_delete']))
{
	$x=$_POST['num'];
	for($i=1;$i<=$x;$i++)
	{
		if ($_POST['delete_subject'.$i]=='1')
		{
			mysql_query("DELETE FROM `question_paper_panel` WHERE id='".$_POST["qpp_id".$i]."' ; ");
		}
	}
	show_label('important','Data Successfully Deleted');
}
elseif (isset($_POST['question_paper_panel_add']))
{
	$x=$_POST['x'];
	for($i=1;$i<=$x;$i++)
	{
	$sb_num = $_POST['sb_num'];
		for($y=1;$y<=$sb_num;$y++)
		{
			if ($_POST['add_subject'.$i.$y]=='1')
			{
			$sql_qpp = "INSERT INTO `question_paper_panel` ( `sm_id`, `mete_id`, `assigned_by`,`mcode`) VALUES ('".$_POST['sm_id'.$i.$y]."','".$_POST['mete_id'.$i.$y]."','".$_SESSION['username']."','".$_POST['mcode'.$i.$y]."'); ";
			#echo $sql_qpp."<br /> ";
			$sql_qpp_check = "select mete.name as name, mete.institute as institute, mete.designation as designation, qpp.mcode as mcode from  `question_paper_panel` qpp, mtech_external_thesis_examiner mete where qpp.mete_id='".$_POST['mete_id'.$i.$y]."' and qpp.mcode='".$_POST['mcode'.$i.$y]."' and mete.id=qpp.mete_id; ";
			$count = mysql_num_rows(mysql_query($sql_qpp_check));
			$result_check = mysql_fetch_array(mysql_query($sql_qpp_check));
		#	show_label('info', 'Data Submitted for Mcode: ');
			$designation=$result_check['designation'];
			$name=$result_check['name'];
			$institute=$result_check['institute'];
			$mcode=$result_check['mcode'];
			if ($count!=0)
			{	
			show_label('important', $name.' - '.$designation .' ('.$institute.')'.' already selected for Mcode :' .$mcode);
			}
			else
			{
				show_label('info', $_POST['mete_id'.$i.$y].' submitted for Mcode :' .$_POST['mcode'.$i.$y]);
			}
			mysql_query($sql_qpp);
			}
		}
	}
}

else
{
$course_branch = explode(',', $_POST['course_branch']);
$sql_subjects = mysql_query("SELECT * from scheme_master where  branch_code='".$course_branch[1]."' and semester='".$_POST['semester']."' and scheme_code='".$_POST['scheme_code']."' and full_part_time='".$_POST['full_part_time']."' and  aicte_rc='".$_POST['aicte_rc']."' and theory_practical= '".$_POST['theory_practical']."' order by subject_code ASC ;") or die(mysql_error());

echo "<h3><center>NOTE: Select 5 external examiner for each subject</center></h3>";
echo "<table class='table table-bordered striped table-condensed'><tr><th>Branch</th><th>FT or PT /<br>AICTE or RC</th><th>Subject Title</th><th>Subject Code/ M Code</th><th>Paper ID</th><th>Problem Solving Weightage</th><th>Semester</th><th>Scheme Code</th><th>Select External Examiner</th><th> Add Subject </th></tr>";

echo "  <form id='profile' name='profile' action=''  method='post'>";
$x=1;
while ($row_subject = mysql_fetch_array($sql_subjects))
	{
		$sql_subjects_count = "SELECT * FROM `question_paper_panel` where assigned_by='".$_SESSION['username']."' and mcode=".$row_subject['m_code']."; ";
		
		$count_subjects = mysql_num_rows(mysql_query($sql_subjects_count));
		$loop_count = 5-$count_subjects;
		
		for ($sb_num = 1; $sb_num <= $loop_count; $sb_num++)
		{
			$course_name = fetch_resource_db('course_code',array('course_code'),array($row_subject['course_code']),'resource_array_value','course_name');
		$branch_name = fetch_resource_db('branch_code',array('branch_code'),array($row_subject['branch_code']),'resource_array_value','branch_name');

			
			echo "<tr class='warning'><td>(".$course_name.")".$branch_name."</td><td>".$_POST['full_part_time']." /<br>".$_POST['aicte_rc']." </td><td>".$row_subject['subject_title']." (".$row_subject['elective_details'].")</td><td>".$row_subject['subject_code']."/ ".$row_subject['m_code']."</td>
			<td>".$row_subject['paper_id']."</td><td>".$row_subject['numerical_percentage']."</td><td>".$row_subject['semester']."</td><td>".$row_subject['scheme_code']."</td><td>";
					
			$sql_user = "SELECT * FROM mtech_external_thesis_examiner where question_paper_setting='Y' and branch_code like '%".$course_branch[1]."%' ORDER BY `name` ASC;";
			$result_user = mysql_query($sql_user);
		
			echo " <select name='mete_id$x$sb_num' >";
			echo "<option value=''>---------</option>";
			while ($row_user = mysql_fetch_array($result_user))
			{
				$designation=$row_user['designation'];
				$name=$row_user['name'];
				$institute=$row_user['institute'];
				$department=$row_user['department'];
				$mete_id=$row_user['id'];
				echo "<option value='".$mete_id."'>$name-$designation,$department ($institute) [Unique ID : $mete_id] </option>";
			}	
			echo "</select></td>";
				echo "<input type='hidden' name='sb_num' value='".$sb_num."'>";
		echo "<input type='hidden' name='xsb_num' value='".$x.$sb_num."'>";
		echo "<input type='hidden' name='x' value='".$x."'>";
		echo "<input type='hidden' name='mcode$x$sb_num' value='".$row_subject['m_code']."'>";
		echo "<input type='hidden' name='sm_id$x$sb_num' value='".$row_subject['scheme_master_id']."'>";
			echo "<td><input type='checkbox' name='add_subject$x$sb_num' value='1'> ADD</td>";
		
		}
	$x++;
	}

	echo "</td></tr></table><input type='hidden' name='question_paper_panel_add' value='question_paper_panel_add'>
	<center><input type='submit' name='submit' class='btn btn-danger' value='Add Examiners'></center></form>";

	echo "<br/> <h3><center>Selected External examiners</center></h3>";
	echo "<table class='table table-bordered striped table-condensed'><tr><th>Branch</th><th>FT or PT /<br>AICTE or RC</th><th>Subject Title</th><th>Subject Code/ M Code</th><th>Paper ID</th><th>Prob. Solv. (%)<th>Semester</th><th>External Examiner [ID]</th><th> Delete </th></tr>";

	$sql_examiner = "select distinct  qpp.id as qpp_id , mete.name as name , mete.id as meteid, sm.subject_title as subject_title, sm.subject_code as subject_code, sm.m_code as mcode, sm.paper_id as paper_id, mete.id as id , sm.numerical_percentage as np from mtech_external_thesis_examiner mete, question_paper_panel qpp, scheme_master sm where mete.id=qpp.mete_id  and qpp.mcode =sm.m_code and sm.branch_code='".$course_branch[1]."' and sm.semester='".$_POST['semester']."' and sm.full_part_time='".$_POST['full_part_time']."' and  sm.aicte_rc='".$_POST['aicte_rc']."' and sm.theory_practical= '".$_POST['theory_practical']."' and qpp.assigned_by='".$_SESSION['username']."' ;  ";
	#echo $sql_examiner;
	$result_examiner = mysql_query($sql_examiner);
	$x=1;
	echo "  <form id='profile' name='profile' action=''  method='post'>";
	while ($row_examiner = mysql_fetch_array($result_examiner))
	{
		$qpp_id = $row_examiner['qpp_id'];
	echo "<tr class='warning'><td>(".$course_name.")".$branch_name."</td><td>".$_POST['full_part_time']." /<br>".$_POST['aicte_rc']." </td><td>".$row_examiner['subject_title']." </td><td>".$row_examiner['subject_code']."/ ".$row_examiner['mcode']."</td>
	<td>".$row_examiner['paper_id']."</td><td>".$row_examiner['np']."</td><td>".$_POST['semester']."</td><td>".$row_examiner['name']." [".$row_examiner['id']."]</td>";

	echo "<td><input type='checkbox' name='delete_subject$x' value='1'> Delete</td></tr>
		<input type='hidden' name='qpp_id$x' value='$qpp_id'>";
	$x++;
	}
	echo "</td></tr></table><input type='hidden' name='question_paper_panel_delete' value='question_paper_panel_delete'>
	<input type='hidden' name='num' value='$x'>
	<center><input type='submit' name='submit' class='btn btn-danger' value='Delete Examiners'></center></form>";
}

?>

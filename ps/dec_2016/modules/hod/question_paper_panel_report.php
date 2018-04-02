<?php

if (isset($_POST['qpp_lock_report']))
{
	$sql_subjects = "SELECT distinct mcode, sm_id, count(mete_id) as count FROM `question_paper_panel` where assigned_by='".$_SESSION['username']."' group by mcode, sm_id";
	$count_subjects = mysql_query($sql_subjects);
	while ($row_count = mysql_fetch_array($count_subjects))
	{
		if($row_count['count']<5)
		{
			$scheme_master = mysql_fetch_array(mysql_query("SELECT *  FROM scheme_master where scheme_master_id = '".$row_count['sm_id']."' ; "));
			show_label('important', 'Examiner Report NOT locked due to Following Reasons:<br>');
			
			echo "<center><h4>You allot less than 5 Examiners against following Subject(s)</h4></center>";
			echo " <br/><table class='table table-bordered striped table-condensed'>
			
			<tr ><th>Subject Title </th><th>Subject Code/ M code</th><th>AICTE/RC | Full/Part Time</th><th>Semester</th><th>Scheme Code</th><th>Count (Required Count 5)</th></tr>
			 <tr class='warning'><td>".$scheme_master['subject_title']."<td> ".$scheme_master['subject_code']."/  ".$row_count['mcode']." <td>".$scheme_master['aicte_rc']." |  ".$scheme_master['full_part_time']." <td> ".$scheme_master['semester']." <td>  ".$scheme_master['scheme_code']."</td><td>".$row_count['count']."</td></tr></table>";
		}
		else
		{
			mysql_query("UPDATE `question_paper_panel` SET `lock_status`='Y' WHERE assigned_by='".$_SESSION['username']."' and mcode='".$row_count['mcode']."' ;");	
		}
	}
	$lock_status =  mysql_num_rows ( mysql_query("SELECT *  FROM `question_paper_panel` where assigned_by='".$_SESSION['username']."' and lock_status='N';"));
	if($lock_status==0)
	{
			show_label('success','Report Succesfully Locked');
			echo " <br> <form id='profile' name='profile' action=''  method='post'>";
			echo "<input type='hidden' name='qpp_generate_report' value='qpp_generate_report'>
			<center><input type='submit' name='submit' class='btn btn-danger' value='Generate Question Paper Panel Report'></center></form>";
	}
}
else
{
echo "  <form id='profile' name='profile' action=''  method='post'>";
echo "<input type='hidden' name='qpp_lock_report' value='qpp_lock_report'>
	<center><input type='submit' name='submit' class='btn btn-danger' value='Lock Examiners Report'></center></form>";	
}

?>

<?php
if(isset($_POST['show_strength']) && isset($_POST['date_of_exam']))
{
$sql="SELECT DISTINCT `Sub_PaperID` , count( `Sub_PaperID` ) as count,SUB_CODE, SUB_TITLE  , date_format(date_of_exam,'%d/%m/%Y') as date_of_exam	, usession,`ucentre` FROM `ptu_subjects`
WHERE `SUB_TP` = 'T' AND `Ed_Ext` =1 AND `eligibility` = 'Y' AND received_status='Y' AND `ucentre`='".$_SESSION['ucentre']."' AND detention_status ='N' AND `usession`='".$_SESSION['usession']."' AND date_of_exam='".$_POST['date_of_exam']."'
GROUP BY `Sub_PaperID` ,SUB_CODE, `ucentre` , `usession`
ORDER BY `date_of_exam` , `ucentre` , usession DESC";
#echo $sql;


$result = mysql_query($sql) or  die(mysql_error());
#echo "<table class='table table-bordered striped table-condensed'><tr><th>Subject ID</th><th>Strength</th></tr>";
echo "<table   border='3' class='table table-bordered striped table-condensed container' ><tr style='background-color:lightgrey'><th >Sr. No.</th><th>Date of Exam</th><th>Paper ID</th><th>Subject Code</th><th>Subject Title</th><th>Strength</th></tr>";

$count ="SELECT  count( `Sub_PaperID` ) as count  FROM `ptu_subjects` WHERE `SUB_TP` = 'T' AND `Ed_Ext` =1 AND `eligibility` = 'Y' AND `ucentre`='".$_SESSION['ucentre']."' AND `usession`='".$_SESSION['usession']."' AND date_of_exam='".$_POST['date_of_exam']."' AND detention_status ='N' AND received_status='Y' ";
$result_count = mysql_query($count) or  die(mysql_error());

$x=1;
while ($row_result = mysql_fetch_array($result))
{
	echo "<tr><td>".$x."</td><td>".$row_result['date_of_exam']."</td><td>".$row_result['Sub_PaperID']."</td><td>".$row_result['SUB_CODE']."</td><td>".$row_result['SUB_TITLE']."</td><td>".$row_result['count']."</td></tr>";
	$x++;
}
echo "<tr style='background-color:lightgrey'><td></td><td></td><td></td><td></td><th>Total Strength</th><td>".mysql_result($result_count,0,0)."</td></tr>";
}


else
{
$date_of_exam = mysql_query("SELECT distinct date_of_exam FROM subject_master WHERE 
usession='".$_SESSION['usession']."' AND 
theory_practical='T' ORDER BY date_of_exam ASC") or die(mysql_error());

echo "<center>

					<table>
					<form method='post' action=''>
					<tr><td colspan='2' align='center'><h4>Datewise Strength (Paper ID)</h4></td></tr>
					<tr><td>
					<span style='font-weight:bold'>Date of Exam(yyyy-mm-dd)</span>
					</td><td>
          <select name='date_of_exam' id='date_of_exam' class='input-xlarge'>";
          while($row = mysql_fetch_assoc($date_of_exam)) {
						if($row['date_of_exam']=='' or is_null($row['date_of_exam'])) {
							continue;
						}
						echo "<option value='".$row['date_of_exam']."'>".$row['date_of_exam']."</option>";
					}
					echo "
					</select>
					</tr></td>
					
					<tr><td>
					<input type='hidden' name='show_strength' value='show_strength' />
					<button type='submit' name='submit' class='btn btn-large btn-danger'>Proceed</button>
					</tr></td>
         
				</form>
				</table>
		</center>";
  
}
?>

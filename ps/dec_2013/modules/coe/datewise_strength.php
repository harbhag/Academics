<?php
if(isset($_POST['coe_show_strength']) && isset($_POST['date_of_exam']) && isset($_POST['centre']))
{
$sql="SELECT DISTINCT `Sub_PaperID` , count( `Sub_PaperID` ) as count,SUB_CODE, SUB_TITLE  , date_format(date_of_exam,'%d/%m/%Y') as date_of_exam	, usession,`ucentre` FROM `ptu_subjects`
WHERE `SUB_TP` = 'T' AND `Ed_Ext` =1 AND `eligibility` = 'Y' AND `detention_status`='N' AND `received_status`='Y' AND `ucentre`='".$_POST['centre']."' AND   `usession`='".$_POST['session']."' AND date_of_exam='".$_POST['date_of_exam']."'
GROUP BY `Sub_PaperID` ,SUB_CODE, `ucentre` , `usession`
ORDER BY `date_of_exam` , `ucentre` , usession DESC";
#echo $sql;
$result = mysql_query($sql) or  die(mysql_error());
#echo "<table class='table table-bordered striped table-condensed'><tr><th>Subject ID</th><th>Strength</th></tr>";
echo "<table   border='3' class='table table-bordered striped container' width='100%'><tr style='background-color:lightgrey'><th >Sr. No.</th><th>Paper ID</th><th>Subject Code</th><th>Subject Title</th><th>Strength</th><th>Centre</th><th>Session<th>Date of Exam</tr>";

$count ="SELECT  count( `Sub_PaperID` ) as count  FROM `ptu_subjects` WHERE `detention_status`='N' AND `received_status`='Y' AND `SUB_TP` = 'T' AND `Ed_Ext` =1 AND `eligibility` = 'Y' AND `ucentre`='".$_POST['centre']."' AND `usession`='".$_POST['session']."' AND date_of_exam='".$_POST['date_of_exam']."' ";

$result_count = mysql_query($count) or  die(mysql_error());
$x=1;
while ($row_result = mysql_fetch_array($result))
{
	echo "<tr><td>".$x."</td><td>".$row_result['Sub_PaperID']."</td><td>".$row_result['SUB_CODE']."</td><td>".$row_result['SUB_TITLE']."</td><td>".$row_result['count']."</td><td>".$_POST['centre']."<td>".$_POST['session']."<td>".$row_result['date_of_exam']."</tr>";
	$x++;
}
echo "<tr style='background-color:lightgrey'><th></th><td></td><td></td><th>Total Strength</th><td>".mysql_result($result_count,0,0)."</td><td></td><td></td><td></tr>";
}
else
{
$date_of_exam = mysql_query("SELECT distinct date_of_exam FROM ptu_subjects WHERE 
SUB_TP='T'  and  Ed_Ext=1 ORDER BY date_of_exam ASC") or die(mysql_error());
$centre = mysql_query("SELECT distinct ucentre FROM ptu_subjects WHERE SUB_TP='T' and `Ed_Ext`='1' and `eligibility`='Y' ORDER BY ucentre ASC") or die(mysql_error());

$session = mysql_query("SELECT distinct usession FROM ptu_subjects WHERE SUB_TP='T' and `Ed_Ext`='1' and `eligibility`='Y' ORDER BY usession ASC") or die(mysql_error());

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
					<span style='font-weight:bold'>Centre</span>
					</td><td>
          <select name='centre' id='centre' class='input-xlarge'>";
          while($row1 = mysql_fetch_assoc($centre)) {
						if($row1['ucentre']=='' or is_null($row1['ucentre'])) {
							continue;
						}
						echo "<option value='".$row1['ucentre']."'>".$row1['ucentre']."</option>";
					}
					echo "
					</select>
					</tr></td>
					<tr><td>
					<span style='font-weight:bold'>Session</span>
					</td><td>
          <select name='session' id='session' class='input-xlarge'>";
          while($row2 = mysql_fetch_assoc($session)) {
						if($row2['usession']=='' or is_null($row2['usession'])) {
							continue;
						}
						echo "<option value='".$row2['usession']."'>".$row2['usession']."</option>";
					}
					echo "
					</select>
					</tr></td>
					<tr><td>
					<input type='hidden' name='coe_show_strength' value='coe_show_strength' />
					<button type='submit' name='submit' class='btn btn-large btn-danger'>Proceed</button>
					</tr></td>       
				</form>
				</table>
		</center>";
}
?>

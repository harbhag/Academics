<?php
$q = intval($_GET['q']);
$subject_code  = $_GET['subject_code'];
$branch_code  = $_GET['branch_code'];

require('config/config.php');
#$sql="SELECT distinct co_statement FROM program_cos WHERE co_number = '".$q."' and backup='0' and subject_code='".$subject_code."' ; ";
$sql="SELECT distinct co_statement FROM program_cos WHERE co_number = '".$q."' and backup='0' and subject_code='".$subject_code."'  and branch_code='".$branch_code."'; ";
$result = mysql_query($sql);

#echo "<table border='1'>
#<tr>
#<th>testing</th>

#</tr>";

while($row = mysql_fetch_array($result))
  {?>
	<label class="control-label">CO Statements (Previous)</label>
			<select name='co_statement_p' id='co_statement_p' class='input-xxlarge' onchange='fillvalue(this.form)'>
			<option value=''>Please Select CO Statement</option>
			<?
		#	while($row_pcos = mysql_fetch_assoc($program_cos_result)) {
				echo " <option value='".$row['co_statement']."'>".$row['co_statement']."</option>";
			#}
			?>
			</select>
			
  <? #echo "<tr>";
 # echo "<td>" . $row['co_statement'] . "</td>";
  #echo "</tr>";
  }
echo "</table>";

?>

<?php
$hostel_count="SELECT count(*) as number,hostel_no FROM `hostel_record` where hostler_day_scholar='Hostler' and backup='0' group by hostel_no ";

$result_hostel_count=mysql_query($hostel_count);

show_label('info','Hostel Summary');
echo "<br />";
$count="SELECT count(*) as total_count FROM `hostel_record` where hostler_day_scholar='Hostler' and backup='0';  ";
$result_count=mysql_query($count);

echo "<table class='table table-bordered table-condensed container sortable'>
	<tr class='warning'>
		<th>Hostel No.</th>
		<th>Number of Students </th>
		</tr>";

while($row_hostel_count = mysql_fetch_assoc($result_hostel_count)) 
{
	if ($row_hostel_count['hostel_no']=='2B')
	{
		$hostel_no='2 Boys';
	}
	else  if ($row_hostel_count['hostel_no']=='1B')
	{
		$hostel_no='1 Boys';
	}
	else  if ($row_hostel_count['hostel_no']=='4G')
	{
		$hostel_no='4 Girls';
	}
	else  if ($row_hostel_count['hostel_no']=='5B')
	{
		$hostel_no='5 Boys';
	}
	else  if ($row_hostel_count['hostel_no']=='6G')
	{
		$hostel_no='6 Girls';
	}
	echo "<tr><td>".$hostel_no."</td>
	<td>".$row_hostel_count['number']."</td>";
}
$row_count = mysql_fetch_assoc($result_count);
echo "<tr><td ><b>Total </td><td><b>".$row_count['total_count']."</td></tr></table>"



?>

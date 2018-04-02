<?php

$notices = mysql_query("SELECT * FROM important_notices WHERE 
viewed_by LIKE '%".$_SESSION['usertype']."%' OR
viewed_by LIKE '%all%'
") or die(mysql_error());

if(mysql_num_rows($notices)===0) {
	show_label('important','Notice not Available');
}
else {
?>
<table class='table table-bordered table-condensed table-stripped container'>
	<tr>
		<th>Sr. No</th>
		<th>Notice</th>
		<th>Date</th>
		<th>Download File</th>
		<th>Remarks</th>
	</tr>
<?php
$count = 1;
while($row = mysql_fetch_assoc($notices)) {
?>

<tr class='warning'>
	<td><?php echo $count; ?></td>
	<td><?php echo $row['notice_text']; ?></td>
	<td><?php echo $row['notice_date']; ?></td>
	<?php if($row['file_link']!='') { 
		if($row['link_type']=='file') {
			echo "<td><a href='files/important_notices/".$row['file_link']."' target='_blank'>Download File</a></td>";
		}
		if($row['link_type']=='link') {
			echo "<td><a href='".$row['file_link']."' target='_blank'>View Link</a></td>";
		}
		
		?>
	
		
	<?php }
	else { ?>
		<td>NA.</td>
	<?php } ?>
	<td><?php echo $row['remarks']; ?></td>
</tr>
<?php
$count++;
}
?>
</table>
<?php } ?>

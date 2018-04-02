<?php

if(isset($_POST['faq_submit'])) 
{	
	mysql_query("INSERT into  faq (  `question`, `answer`, `viewed_by`, `uploaded_by`, `remarks`) VALUES ('".$_POST['question']."','".$_POST['answer']."','".$_POST['viewed_by']."','".$_SESSION['username']."','".$_POST['remarks']."');" ) or die("Error Message");
	
	show_label('success',"Frequently asked questions (FAQ) Successfully Added"); 
	#show_label('warning',"Sorry, there was a problem uploading your file.");
}
if(isset($_POST['faq_upload']))  
{
	echo "<center><h4>Upload Frequently asked questions (FAQ)</h4>";
	
	echo "<br /><table class='table table-bordered striped table-condensed container'>
		<form method='post' method=post enctype='multipart/form-data' action=''>";
		echo "<tr><td> Question:</td><td> <input type='text' name='question' class='input-xxlarge' />";
		echo "<tr><td> Answer:</td><td> <input type='text' name='answer' class='input-xxlarge' />";
		echo "<tr><td> Remarks (if any) </td><td> <input type='text' name='remarks' class='input-xxlarge' />";
		$sql_usertype = "SELECT distinct usertype from users ";
		$result_usertype = mysql_query($sql_usertype) or  die(mysql_error()) ;
		echo "<tr><td> Viewed By </td><td> <select name='viewed_by' class='input-large' >";
		echo "<option value='all'>All</option>";
		while ($row = mysql_fetch_array($result_usertype))
		{		
		echo "<option value='".$row['usertype']."'>".$row['usertype']."</option>";
		}	
		echo "</select></td><tr>
		
		</tr><input type='hidden' name='faq_submit' value='faq_submit' />
		</table>
		<center><button type='submit' name='submit' class='btn btn-large btn-danger'>Submit</button></center></form>";
}





if(isset($_POST['faq_display']))  
{
echo "<center><h4>Frequently asked questions (FAQ)</h4>";
	$notices = mysql_query("SELECT * FROM faq WHERE   viewed_by ='university_project'  ORDER BY id  DESC") or die(mysql_error());
if(mysql_num_rows($notices)===0) {
	show_label('important','FAQ not Available');
}
else {
?>
<table class='table table-bordered table-condensed table-stripped container'>
	<tr>
		<!--<th>Sr. No</th>
		<th>Question</th>
		<th>Answer</th>
	<!--	<th>Date</th>
		<th>Remarks</th>-->
	</tr>
<?php
$count = 1;
while($row = mysql_fetch_assoc($notices)) { ?>
	<tr><th bgcolor='lightgrey'>Question <?php echo $count; ?>: <?php echo $row['question']; ?></th></tr>
	<tr><td>Answer: <?php echo $row['answer']; ?></td></tr>
<!--<tr class='warning'>
	<td><?php //echo $count; ?></td>
	
	<td><?php// echo $row['answer']; ?></td>
	<td><?php //echo $row['datetime']; ?></td>
	<td><?php //echo $row['remarks']; ?></td>
</tr>-->
<?php
$count++;
}
?>
</table>
<?php } 

}
?>

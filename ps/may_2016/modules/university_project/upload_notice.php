<?php
if(isset($_POST['upload_notice_submit'])) 
{	
	$folder = "files/important_notices/";
	move_uploaded_file($_FILES["filep"]["tmp_name"] , "$folder".time().$_FILES["filep"]["name"] );
	
	mysql_query("INSERT into  important_notices ( `notice_text`, `file_link`, `link_type`, `viewed_by`, `uploaded_by`, `remarks`) VALUES ('".$_POST['notice_text']."','".time().$_FILES['filep']['name']."','file','".$_POST['viewed_by']."','".$_SESSION['username']."','".$_POST['remarks']."');" ) or die("Error Message");
	
	show_label('success',"Notice Successfully Updated"); 
	#show_label('warning',"Sorry, there was a problem uploading your file.");
}
if(isset($_POST['upload_notice']))  
{
	echo "<center><h4>Upload Important Notices</h4>";
	
	echo "<br /><table class='table table-bordered striped table-condensed container'>
		<form method='post' method=post enctype='multipart/form-data' action=''>";
		echo "<tr><td> Notice Text</td><td> <input type='text' name='notice_text' class='input-xxlarge' />";
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
		
		<tr> <td>File</td> <td><input type='file' name='filep' ></td></tr>
		
		</tr><input type='hidden' name='upload_notice_submit' value='upload_notice_submit' />
		</table>
		<center><button type='submit' name='submit' class='btn btn-large btn-danger'>Submit</button></center></form>";
}
?>

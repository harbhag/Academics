<?php

if(isset($_POST['upload_document_submit'])) 
{	
	$folder = "files/university_project_docs/";
	move_uploaded_file($_FILES["filep"]["tmp_name"] , "$folder".time().$_FILES["filep"]["name"]);
	
	mysql_query("INSERT into  `up_documents` ( `document_title`, `file`, `uploaded_by`, `remarks`,`uploader_name`) VALUES ('".$_POST['notice_text']."','".time().$_FILES['filep']['name']."','".$_SESSION['username']."','".$_POST['remarks']."','".$_SESSION['fullname']."');" ) or die("Error Message");
	
	#echo "INSERT into  `up_documents` ( `document_title`, `file`, `uploaded_by`, `remarks`) VALUES ('".$_POST['notice_text']."','".$_FILES['filep']['name']."','".$_SESSION['username']."','".$_POST['remarks']."');";
	show_label('success',"Document Successfully Uploaded"); 
}

if(isset($_POST['upload_document']))  
{
	echo "<center><h4>Upload Documents</h4>";
	
	echo "<br /><table class='table table-bordered striped table-condensed container'>
		<form method='post' method=post enctype='multipart/form-data' action=''>";
		echo "<tr><td> Document Title</td><td> <input type='text' name='notice_text' class='input-xxlarge' />";
		echo "<tr><td> Remarks (if any) </td><td> <input type='text' name='remarks' class='input-xxlarge' />";
		echo "		
		<tr> <td>File</td> <td><input type='file' name='filep' ></td></tr>
		
		</tr><input type='hidden' name='upload_document_submit' value='upload_document_submit' />
		</table>
		<center><button type='submit' name='Upload' class='btn btn-large btn-danger'>Upload</button></center></form>";
}

if(isset($_POST['view_documents']))  
{
echo "<center><h4>View List of Documents</h4>";
if ($_SESSION['username']=='up_chairman')
{
$notices = mysql_query("SELECT * FROM up_documents where display_status='Yes' ORDER BY id  DESC ") or die(mysql_error());
}
else
{
	$notices = mysql_query("SELECT * FROM up_documents WHERE  display_status='Yes' and uploaded_by ='".$_SESSION['username']."'  ORDER BY id  DESC") or die(mysql_error());
}
if(mysql_num_rows($notices)===0) {
	show_label('important','Documents not Available');
}
else {
?>
<table class='table table-bordered table-condensed table-stripped container'>
	<tr>
		<th>Sr. No</th>
		<th>Document Title</th>
		<th>Date</th>
		<th>Download File</th>
		<th>Remarks</th>
		<th>Uploaded By</th>
	</tr>
<?php
$count = 1;
while($row = mysql_fetch_assoc($notices)) { ?>
<tr class='warning'>
	<td><?php echo $count; ?></td>
	<td><?php echo $row['document_title']; ?></td>
	<td><?php echo $row['date_time']; ?></td>
	
	<?php if($row['file']!='') {  echo "<td><a href='files/university_project_docs/".$row['file']."' target='_blank'>Download</a></td>";?>
	
	<?php } else { ?><td>NA.</td> <?php } ?>
	<td><?php echo $row['remarks']; ?></td>
	<td><?php echo $row['uploader_name']; ?></td>
</tr>
<?php
$count++;
}
?>
</table>
<?php } 

}
?>

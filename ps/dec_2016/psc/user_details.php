<?php

$user_details = mysql_fetch_assoc(mysql_query("SELECT * FROM mtech_external_thesis_examiner WHERE username='".$_SESSION['username']."'")) or die(mysql_error());

echo "

<center><table class='table table-hover table-striped table-bordered table-condensed'>
<tr>
<th>Name </th>
<th>Designation</th>
</tr>

<tr class='info'>
<td>".$user_details['prefix_name']." ".$user_details['name']."</td>
<td>".$user_details['designation']."</td>
</tr>

<tr>
<th>Department</th>
<th>Institute</th>
</tr>

<tr class='info'>
<td>".$user_details['department']."</td>
<td>".$user_details['institute']."</td>
</tr>

<tr>
<th>Address</th>
<th>Email / Phone</th>
</tr>

<tr class='info'>
<td>".$user_details['address']." ".$user_details['city']." ".$user_details['pin_code']."</td>
<td>".$user_details['email']." / ".$user_details['mobile_no']."</td>
</tr>

<tr>
<td colspan='2' style='color:red;font-weight:bold;font-size:18px'>For updations regarding profile information kindly send email to Dr. Akshay Girdhar at <i style='color:blue'>coegndec@gmail.com</i> with complete details.</td>
</tr>

</table>

";

?>
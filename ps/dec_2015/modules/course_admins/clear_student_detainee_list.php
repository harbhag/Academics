<?php

mysql_query("UPDATE detainee_list SET
cleared_status='Y',
detained_status='N',
cleared_on='".date('Y-m-d H:i:s')."',
cleared_by='".$_SESSION['username']."',
c_exam_month='".$_POST['exam_month']."',
c_exam_year='".$_POST['exam_year']."'
WHERE

university_roll_no='".$_POST['university_roll_no']."' AND
autoid='".$_POST['autoid']."'") or die (mysql_error());

show_label("success","Detainee List successfull Updated");

echo "<br/><br/>";

?>

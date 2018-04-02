<?php

mysql_query("UPDATE exam_centre_duties SET locked='1' WHERE
duty_uploaded_by='".$_SESSION['username']."' AND
date_of_exam = '".date('Y-m-d')."' AND
backup=0") or die(mysql_error());

show_label('success','Attendance Successfully LOCKED for '.date('d-m-Y').' !');

?>

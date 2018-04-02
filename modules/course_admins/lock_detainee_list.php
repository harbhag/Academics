<?php


$sub_sems = mysql_query("UPDATE detainee_list SET locked='Y' WHERE
detained_by = '".$_SESSION['username']."' AND
theory_practical = '".$_POST['theory_practical']."'") or die(mysql_error());

show_label("success","Detainee List successfull Updated");


?>

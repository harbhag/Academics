<?php

mysql_query("DELETE FROM detainee_list WHERE autoid='".$_POST['autoid']."'") or die(mysql_error());

show_label("success","Detainee List successfull Updated");

echo "<br/><br/>";
?>

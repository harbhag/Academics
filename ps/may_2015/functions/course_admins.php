<?php

function unlock_reappear_exam_form() {
	
	mysql_query("DELETE FROM ptu_subjects WHERE ED_RollNo='".$_POST['university_roll_no']."' AND Regular_Reappear='Reappear'") or die(mysql_error());
	mysql_query("UPDATE rp_form_fee set backup='Y' WHERE university_roll_no='".$_POST['university_roll_no']."'") or die(mysql_error());
	mysql_query("UPDATE student_info set rp_form_status='N' WHERE university_roll_no='".$_POST['university_roll_no']."'") or die(mysql_error());
	mysql_query("UPDATE student_info_ex set rp_form_status='N' WHERE university_roll_no='".$_POST['university_roll_no']."'") or die(mysql_error());
	
	show_label('info','Form Successfully Un-Locked.');
}

?>

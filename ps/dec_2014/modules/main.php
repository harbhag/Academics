<?php

$pm_sql = mysql_query("SELECT * FROM popup_notices WHERE usertype LIKE '%".$_SESSION['usertype']."%' AND valid_till>='".date("Y-m-d")."'") or die(mysql_error());

if(mysql_num_rows($pm_sql)>0) {

$pm_status = mysql_query("SELECT * FROM login_session_record WHERE session_id='".$_SESSION['session_id']."' AND pm_status='unread'") or die(mysql_error());

	if(mysql_num_rows($pm_status)==1) {		
		include_once("modules/modals/popup_notice_modal.php");

		echo "<script type='text/javascript'>
		$(document).ready(function () {
			$('#pm_modal').modal('show');
		});
		</script>";
	
		mysql_query("UPDATE login_session_record SET pm_status='read' WHERE session_id='".$_SESSION['session_id']."'") or die(mysql_error());
	}	

}


if($_SESSION['usertype']=='teacher') {
	include_once('navigator/teacher.php');
	//include_once('modules/common/welcome.php');
}

elseif($_SESSION['usertype']=='course_admins') {
	include_once('navigator/course_admins.php');
}

elseif($_SESSION['usertype']=='superintendent') {
	include_once('navigator/superintendent.php');
}

elseif($_SESSION['usertype']=='coe') {
	include_once('navigator/coe.php');
}

elseif($_SESSION['usertype']=='director') {
	include_once('navigator/director.php');
}

elseif($_SESSION['usertype']=='academic_incharge') {
	include_once('navigator/academic_incharge.php');
	
}
elseif($_SESSION['usertype']=='nba_incharge') {
	
	//$allowd_ip = mysql_query("SELECT ip_address FROM ip_address WHERE ip_address='".$_SERVER['REMOTE_ADDR']."' AND module_name='nba_incharge' AND allowed='Y'") or die(mysql_error());
	//if(mysql_num_rows($allowd_ip)!=1) {
		//session_destroy();
		//header("location:http://exam.gndec.ac.in");
	//}
	//else {
		include_once('navigator/nba_incharge.php');
	//}
	
}


else {
	show_label('warning','Invalid User. No roles defined.');
	session_destroy();
}

?>

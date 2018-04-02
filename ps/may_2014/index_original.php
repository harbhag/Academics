<?php
date_default_timezone_set('Asia/Kolkata');
session_start();
include_once('config/includes_before.php');

if(isset($_POST['download_internal_marks_csv'])) {
			require_once('modules/parsecsv/parsecsv.lib.php');
			get_internal_marks_csv();
}

if(isset($_POST['sup_generate_formwardingmemo'])) {
			include_once('forwarding_memo.php');
}

if(isset($_POST['print_detainee_list'])) {
			include_once('print_detainee_list.php');
}

if(isset($_POST['print_marks_record'])) {
	if($_POST['internal_external']=='I') {
		if($_POST['theory_practical']=='T') {
			include_once('internal_theory.php');
		}
		if($_POST['theory_practical']=='P') {
			include_once('internal_practical.php');
		}
	}
	
	if($_POST['internal_external']=='E') {
		if($_POST['theory_practical']=='T') {
			include_once('external_theory.php');
		}
		if($_POST['theory_practical']=='P') {
			include_once('external_practical.php');
		}
	}
}

if(isset($_POST['sup_generate_cutlist'])) {
			get_cutlist_csv();
}

include_once('config/includes_after.php');
?>


<body>
<div class="container">
<div class='header-logo'></div>
<?php

if(isset($_POST['username']) && isset($_POST['password'])) {
	$auth = ldap_auth($_POST['username'],$_POST['password']);
	
	if($auth=='LOGIN_FAIL') {
		show_label('warning','Error: Authentication Failed. Wrong/Username Password.');
		include_once('modules/login.php');
	}
	else {
		$usertype = get_usertype($_POST['username']);
		if($usertype!='USERTYPE_NOT_FOUND') {
			$_SESSION['usertype'] = $usertype;
			if(!isset($_SESSION['secure_auth'])) {
				if($usertype=='student') {
					$_SESSION['secure_auth']='Success';
					include_once('modules/main.php');
				}
				else {
					generate_secure_code();
					include_once('modules/auth/secure_auth.php');
				}
			}
		}
		else {
			show_label('warning','Error: Authentication Failed. Unable to Identify the USER_TYPE.');
			session_destroy();
			include_once('modules/login.php');
		}
	}
}	

elseif(isset($_SESSION['usertype']) && !isset($_SESSION['secure_auth'])) {
	
	$_2_way_auth = _2_way_auth();

	if($_2_way_auth=='Success') { 
		$_SESSION['secure_auth']='Success';
		include_once('modules/main.php');
	}
	if($_2_way_auth=='Failure') { 
		show_label('warning','Error: Wrong Secret Code Entered.');
		include_once('modules/auth/secure_auth.php');
	}
	
}

elseif(isset($_SESSION['usertype']) && isset($_SESSION['secure_auth'])) {
	if(!isset($_POST['logmeout'])) {
		include_once('modules/main.php');
		
		if(isset($_POST['upload_internals'])) {
			
			include_once('modules/teacher/upload_internal_marks.php');
		}
		
		if(isset($_POST['teacher_mark_attendance_form'])) {
			
			include_once('modules/teacher/teacher_mark_attendance.php');
		}
		
		if(isset($_POST['teacher_mark_attendance'])) {
			
			teacher_mark_attendance();
		}
		
		if(isset($_POST['lock_internal_subject'])) {
			
			internal_lock_subject();
		}
		
		if(isset($_POST['select_internal_marks_csv_file'])) {
			
			select_internal_marks_csv_file();
		}
		
		if(isset($_POST['upload_internal_marks_csv'])) {
			
			upload_internal_marks_csv();
		}
		
		if(isset($_POST['allot_subject'])) {
			
			include_once('modules/course_admins/allot_subject.php');
		}
		
		if(isset($_POST['allot_subject_show'])) {
			
			include_once('modules/course_admins/allot_subject.php');
		}
		
		if(isset($_POST['allot_subject_done'])) {
			
			include_once('modules/course_admins/allot_subject.php');
		}
		
		if(isset($_POST['sup_mark_attendance_form'])) {
			
			include_once('modules/superintendent/sup_mark_attendance_form.php');
		}
		
		if(isset($_POST['sup_mark_attendance_form_student'])) {
			
			include_once('modules/superintendent/sup_mark_attendance_form_student.php');
		}
		
		if(isset($_POST['sup_mark_attendance'])) {
			
			sup_mark_attendance();
		}
		
		if(isset($_POST['sup_generate_cutlist_form'])) {
			
			include_once('modules/superintendent/sup_generate_cutlist_form.php');
		}
		
		if(isset($_POST['sup_generate_forwardingmemo_form'])) {
			include_once('modules/superintendent/sup_generate_forwardingmemo_form.php');
		}
		
		if(isset($_POST['important_notices'])) {
			include_once('modules/common/important_notices.php');
		}
		
		if(isset($_POST['datewise_strength'])) {
			include_once('modules/superintendent/datewise_strength.php');
		}
		
		if(isset($_POST['show_strength'])) {
			include_once('modules/superintendent/datewise_strength.php');
		}
		
		if(isset($_POST['detailed_datewise_strength'])) {
			include_once('modules/superintendent/detailed_datewise_strength.php');
		}
		
		if(isset($_POST['detailed_show_strength'])) {
			include_once('modules/superintendent/detailed_datewise_strength.php');
		}
		
		if(isset($_POST['coe_detailed_datewise_strength'])) {
			include_once('modules/coe/detailed_datewise_strength.php');
		}
		
		if(isset($_POST['coe_detailed_show_strength'])) {
			include_once('modules/coe/detailed_datewise_strength.php');
		}
		
		if(isset($_POST['coe_datewise_strength'])) {
			include_once('modules/coe/datewise_strength.php');
		}
		
		if(isset($_POST['coe_show_strength'])) {
			include_once('modules/coe/datewise_strength.php');
		}
		
		if(isset($_POST['student_exam_form_status'])) {
			include_once('modules/coe/student_exam_form_status.php');
		}
		
		if(isset($_POST['student_exam_form_status_show'])) {
			include_once('modules/coe/student_exam_form_status.php');
		}
		if(isset($_POST['external_attendance_status'])) {
			include_once('modules/coe/external_attendance_status.php');
		}
		
		if(isset($_POST['external_attendance_status_show'])) {
			include_once('modules/coe/external_attendance_status.php');
		}
		
		if(isset($_POST['result_theory_external'])) {
			include_once('modules/student/result_theory_external.php');
		}
		
		if(isset($_POST['result_internal_external_practical'])) {
			include_once('modules/student/result_internal_external_practical.php');
		}
		
		if(isset($_POST['teacher_mark_daily_attendance_form'])) {
			include_once('modules/teacher/teacher_mark_daily_attendance_form.php');
		}
		
		if(isset($_POST['teacher_mark_daily_attendance_form_student'])) {
			include_once('modules/teacher/teacher_mark_daily_attendance_form_student.php');
		}
		
		if(isset($_POST['teacher_mark_daily_attendance'])) {
			teacher_mark_daily_attendance();
		}
		
		if(isset($_POST['teacher_view_daily_attendance_record'])) {
			include_once('modules/teacher/teacher_daily_attendance_record.php');
		}
		
		if(isset($_POST['teacher_view_aggregate_attendance_record'])) {
			include_once('modules/teacher/teacher_aggregate_attendance_record.php');
		}
		
		if(isset($_POST['teacher_update_daily_attendance_form_student'])) {
			include_once('modules/teacher/teacher_update_daily_attendance_form_student.php');
		}
		
		if(isset($_POST['teacher_update_aggregate_attendance_form_student'])) {
			include_once('modules/teacher/teacher_update_aggregate_attendance_form_student.php');
		}

		if(isset($_POST['teacher_view_daily_attendance_details'])) {
			include_once('modules/teacher/teacher_view_daily_attendance_details.php');
		}
		
		
		
		if(isset($_POST['teacher_update_daily_attendance'])) {
			teacher_update_daily_attendance();
		}
		
		if(isset($_POST['teacher_update_aggregate_attendance'])) {
			teacher_update_aggregate_attendance();
		}

		if(isset($_POST['teacher_mark_aggregate_attendance_form_student'])) {
			include_once('modules/teacher/teacher_mark_aggregate_attendance_form_student.php');
		}
		
		if(isset($_POST['sessionals_module'])) {
			include_once('modules/teacher/sessionals.php');
		}
		
		if(isset($_POST['upload_sessional_marks_form_students'])) {
			include_once('modules/teacher/upload_sessional_marks_form_students.php');
		}
		
		if(isset($_POST['update_sessional_marks_form_students'])) {
			include_once('modules/teacher/update_sessional_marks_form_students.php');
		}
		
		if(isset($_POST['teacher_view_sessional_details'])) {
			include_once('modules/teacher/teacher_view_sessional_details.php');
		}
		
		if(isset($_POST['teacher_upload_sessional_marks'])) {
			teacher_upload_sessional_marks();
		}
		
		if(isset($_POST['teacher_update_sessional_marks'])) {
			teacher_update_sessional_marks();
		}
		
		if(isset($_POST['teacher_mark_aggregate_attendance'])) {
			teacher_mark_aggregate_attendance();
		}
		
		if(isset($_POST['unlock_exam_form'])) {
			include_once('modules/course_admins/unlock_exam_form.php');
		}
		
		if(isset($_POST['add_student_detainee_list_form'])) {
			include_once('modules/course_admins/add_student_detainee_list_form.php');
		}
		
		if(isset($_POST['add_student_detainee_list_subjects'])) {
			include_once('modules/course_admins/add_student_detainee_list_subjects.php');
		}
		
		if(isset($_POST['add_student_detainee_list'])) {
			include_once('modules/course_admins/add_student_detainee_list.php');
		}
		
		if(isset($_POST['view_detainee_list_form'])) {
			include_once('modules/course_admins/view_detainee_list_form.php');
		}
		
		if(isset($_POST['view_detainee_list'])) {
			include_once('modules/course_admins/view_detainee_list.php');
		}
		
		if(isset($_POST['lock_detainee_list'])) {
			include_once('modules/course_admins/lock_detainee_list.php');
		}
		
		
		
		if(isset($_POST['delete_detainee'])) {
			include_once('modules/course_admins/delete_detainee.php');
			include_once('modules/course_admins/view_detainee_list.php');
		}
		
		if(isset($_POST['clear_student_detainee_list'])) {
			include_once('modules/course_admins/clear_student_detainee_list.php');
			include_once('modules/course_admins/view_detainee_list.php');
		}
		
		if(isset($_POST['unlock_reappear_exam_form'])) {
			unlock_reappear_exam_form();
		}
		
		// COE NEW Options
		
		if(isset($_POST['insert_date_of_exam'])) {
			include_once('modules/coe/insert_date_of_exam.php');
		}
		if(isset($_POST['insert_date_of_exam_show'])) {
			include_once('modules/coe/insert_date_of_exam.php');
		}
		if(isset($_POST['insert_date_of_exam_submit'])) {
			include_once('modules/coe/insert_date_of_exam.php');
		}
		if(isset($_POST['datesheet_view'])) {
			include_once('modules/coe/datesheet_view.php');
		}
		if(isset($_POST['datesheet_view_show'])) {
			include_once('modules/coe/datesheet_view.php');
		}
		
		
	}
	elseif(isset($_POST['logmeout'])) {
		session_destroy();
		include_once('modules/login.php');
	}
	else {
		include_once('modules/main.php');
	}
}

else {
	include_once('modules/login.php');
}

//include_once('modules/analytics/piwik.php');
?>
</div>
</body>
</html>

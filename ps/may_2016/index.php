<?php
date_default_timezone_set('Asia/Kolkata');
session_start();
include_once('config/includes_before.php');

$maintenance_status_sql = mysql_query("SELECT portal_status,message FROM portal_status") or die(mysql_error());

$maintenance_status = mysql_fetch_assoc($maintenance_status_sql);

if($maintenance_status['portal_status']=='under_maintenance') {
	
	echo "<center><span style='color:red;font-size:25px;font-weight:bold'>".$maintenance_status['message']."</span></center></br>";
	exit();
	
}
//echo "Your IP address is: ".$_SERVER['REMOTE_ADDR'];
if(isset($_POST['download_internal_marks_csv'])) {
			require_once('modules/parsecsv/parsecsv.lib.php');
			get_internal_marks_csv();
}

if(isset($_POST['sup_generate_formwardingmemo'])) {
			include_once('forwarding_memo.php');
}

if(isset($_POST['teacher_print_internal_marks_record'])) {
			include_once('teacher_print_internal_marks_record.php');
}

if(isset($_POST['print_consolidated_report'])) {
			include_once('print_consolidated_report.php');
}


if(isset($_POST['print_detainee_list'])) {
			include_once('print_detainee_list.php');
}
if(isset($_POST['print_clear_detainee_list'])) {
			include_once('print_clear_detainee_list.php');
}

if(isset($_POST['download_practical_attendance_sheet'])) {
			include_once('download_practical_attendance_sheet.php');
}

if(isset($_POST['academic_inchange_generate_attendance_summary_sheet'])) {
			include_once('academic_inchange_generate_attendance_summary_sheet.php');
}

if(isset($_POST['sup_generate_attendance_sheet'])) {
			
			include_once('sup_generate_attendance_sheet.php');
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
require('config/noscript.php');

if(isset($_POST['username']) && isset($_POST['password'])) {
	$auth = ldap_auth($_POST['username'],$_POST['password']);
	
	if($auth=='LOGIN_FAIL') {
		show_label('warning','Error: Authentication Failed. Wrong/Username Password.');
		include_once('modules/login.php');
	}
	elseif($_SESSION['bypass_2_way_authentication']=='Y') {
		$usertype = get_usertype($_POST['username']);
		$_SESSION['secure_auth']='Success';
		
		//Implemented popup notices for bypass users also.........from here
		$_SESSION['session_id'] = time();
		$prev_session = mysql_query("SELECT * FROM login_session_record WHERE session_id='".$_SESSION['session_id']."'") or die(mysql_error());
			
		if(mysql_num_rows($prev_session)!=0) {
			$_SESSION['session_id'] = $_SESSION['session_id']+3;
		}
		mysql_query("INSERT INTO login_session_record 
		(username,session_id,login_status,login_ip,usertype,subdomain) 
		VALUES ('".$_SESSION['username']."','".$_SESSION['session_id']."','logged_in','".$_SERVER['REMOTE_ADDR']."','".$_SESSION['usertype']."','".$_SERVER['SERVER_NAME']."')") or die(mysql_error());
		
		//to here......................
		
		
		include_once('modules/main.php');
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
		
		if(isset($_POST['student_elective_subject_allotment'])) {
			
			include_once('modules/academic_incharge/student_elective_subject_allotment.php');
		}
		
		if(isset($_POST['student_elective_subject_submit'])) {
			
			include_once('modules/academic_incharge/student_elective_subject_allotment.php');
		}
		
		if(isset($_POST['student_elective_subject_insert'])) {
			
			include_once('modules/academic_incharge/student_elective_subject_allotment.php');
		}
	
		if(isset($_POST['student_section_group_allotment'])) {
			
			include_once('modules/academic_incharge/student_section_group_allotment.php');
		}
		
		if(isset($_POST['student_section_group_submit'])) {
			
			include_once('modules/academic_incharge/student_section_group_allotment.php');
		}
		
		if(isset($_POST['student_section_group_update'])) {
			
			include_once('modules/academic_incharge/student_section_group_allotment.php');
		}
		
		if(isset($_POST['time_table_subject_allotment'])) {
			
			include_once('modules/academic_incharge/time_table_subject_allotment.php');
		}
		if(isset($_POST['result_analysis_list'])) {
			
			include_once('modules/academic_incharge/result_analysis_list.php');
		}
		if(isset($_POST['result_analysis_list_show'])) {
			
			include_once('modules/academic_incharge/result_analysis_list.php');
		}
		if(isset($_POST['held_periods_detail_submit'])) {
			
			include_once('modules/academic_incharge/held_periods_detail.php');
		}
		
		if(isset($_POST['view_student_attendance'])) {
			
			include_once('modules/academic_incharge/student_view_attendance.php');
		}
		
		if(isset($_POST['view_student_attendance_show'])) {
			
			include_once('modules/academic_incharge/student_view_attendance.php');
		}
		
		if(isset($_POST['held_periods_detail'])) {
			
			include_once('modules/academic_incharge/held_periods_detail.php');
		}
		if(isset($_POST['fee_pending_report_submit'])) {
			
			include_once('modules/academic_incharge/fee_pending_report.php');
		}
		if(isset($_POST['student_summary_list_submit'])) {
			
			include_once('modules/academic_incharge/student_summary_list.php');
		}
		if(isset($_POST['student_summary_list_form'])) {
			
			include_once('modules/academic_incharge/student_summary_list.php');
		}
		if(isset($_POST['fee_pending_report_form'])) {
			
			include_once('modules/academic_incharge/fee_pending_report.php');
		}
		if(isset($_POST['time_table_subject_allotment_show'])) {
			
			include_once('modules/academic_incharge/time_table_subject_allotment.php');
		}
		
		if(isset($_POST['time_table_subject_add'])) {
			
			include_once('modules/academic_incharge/time_table_subject_allotment.php');
		}
		
		if(isset($_POST['time_table_subject_list'])) {
			
			include_once('modules/academic_incharge/time_table_subject_list.php');
		}
		if(isset($_POST['time_table_subject_delete'])) {
			
			include_once('modules/academic_incharge/time_table_subject_list.php');
		}
		if(isset($_POST['time_table_subject_list_show'])) {
			
			include_once('modules/academic_incharge/time_table_subject_list.php');
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
		if(isset($_POST['education_faq'])) {
			
			include_once('modules/director/education_faq.php');
		}
		if(isset($_POST['vision_mission_peo_po'])) {
			
			include_once('modules/director/vision_mission_peo_po.php');
		}
		if(isset($_POST['hostel_record_summary'])) {
			
			include_once('modules/director/hostel_record_summary.php');
		}
		
		if(isset($_POST['sup_generate_cutlist_form'])) {
			
			include_once('modules/superintendent/sup_generate_cutlist_form.php');
		}
		if(isset($_POST['sup_generate_attendance_sheet_form'])) {
			
			include_once('modules/superintendent/sup_generate_attendance_sheet_form.php');
		}
		
		if(isset($_POST['sup_generate_forwardingmemo_form'])) {
			include_once('modules/superintendent/sup_generate_forwardingmemo_form.php');
		}
		
		if(isset($_POST['important_notices'])) {
			include_once('modules/common/important_notices.php');
		}
		if(isset($_POST['upload_notice'])) {
			include_once('modules/university_project/upload_notice.php');
		}
		if(isset($_POST['faq_display'])) {
			include_once('modules/university_project/faq.php');
		}
		if(isset($_POST['faq_submit'])) {
			include_once('modules/university_project/faq.php');
		}
		if(isset($_POST['faq_upload'])) {
			include_once('modules/university_project/faq.php');
		}
		if(isset($_POST['upload_notice_submit'])) {
			include_once('modules/university_project/upload_notice.php');
		}
		if(isset($_POST['upload_document_submit'])) {
			include_once('modules/university_project/upload_view_documents.php');
		}
		
		if(isset($_POST['upload_document'])) {
			include_once('modules/university_project/upload_view_documents.php');
		}
		
		if(isset($_POST['view_documents'])) {
			include_once('modules/university_project/upload_view_documents.php');
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
		
		if(isset($_POST['teacher_mark_daily_attendance_theory_form'])) {
			include_once('modules/teacher/teacher_mark_daily_attendance_theory_form.php');
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
		
		if(isset($_POST['teacher_view_aggregate_attendance_record_theory'])) {
			include_once('modules/teacher/teacher_aggregate_attendance_record_theory.php');
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
		
		if(isset($_POST['assignments_module'])) {
			include_once('modules/teacher/assignments.php');
		}
		
		if(isset($_POST['internal_practical_module'])) {
			include_once('modules/teacher/internal_practical.php');
		}
		
		
		if(isset($_POST['upload_internal_practical_marks_form_student'])) {
			include_once('modules/teacher/upload_internal_practical_marks_form_student.php');
		}
		
		
		if(isset($_POST['upload_sessional_marks_form_students'])) {
			include_once('modules/teacher/upload_sessional_marks_form_students.php');
		}
		
		
		
		if(isset($_POST['upload_assignment_marks_form_students'])) {
			include_once('modules/teacher/upload_assignment_marks_form_students.php');
		}
		
		if(isset($_POST['update_sessional_marks_form_students'])) {
			include_once('modules/teacher/update_sessional_marks_form_students.php');
		}
		
		if(isset($_POST['update_assignment_marks_form_students'])) {
			include_once('modules/teacher/update_assignment_marks_form_students.php');
		}
		
		if(isset($_POST['update_internal_practical_marks_form_students'])) {
			include_once('modules/teacher/update_internal_practical_marks_form_students.php');
		}
		
		if(isset($_POST['teacher_view_sessional_details'])) {
			include_once('modules/teacher/teacher_view_sessional_details.php');
		}
		
		if(isset($_POST['details_topics_covered'])) {
			include_once('modules/teacher/details_topics_covered.php');
		}
		
		if(isset($_POST['teacher_view_assignment_details'])) {
			include_once('modules/teacher/teacher_view_assignment_details.php');
		}
		
		if(isset($_POST['teacher_view_internal_practical_details'])) {
			include_once('modules/teacher/teacher_view_internal_practical_details.php');
		}
		
		
		
		if(isset($_POST['analysis_sessional_marks'])) {
			include_once('modules/teacher/analysis_sessional_marks.php');
		}
		
		if(isset($_POST['director_view_daily_attandance_form'])) {
			include_once('modules/director/director_view_daily_attandance_form.php');
		}
		if(isset($_POST['fee_pending_summary'])) {
			include_once('modules/director/fee_pending_summary.php');
		}
		
		if(isset($_POST['student_summary'])) {
			include_once('modules/director/student_summary.php');
		}
		
		if(isset($_POST['director_view_daily_attandance'])) {
			include_once('modules/director/director_view_daily_attandance.php');
		}
		
		
		if(isset($_POST['director_view_daily_attendance_details'])) {
			include_once('modules/director/director_view_daily_attendance_details.php');
		}
		
		if(isset($_POST['teacher_upload_sessional_marks'])) {
			teacher_upload_sessional_marks();
		}
		
		if(isset($_POST['teacher_upload_internal_practical_marks'])) {
			teacher_upload_internal_practical_marks();
		}
		
		if(isset($_POST['teacher_upload_assignment_marks'])) {
			teacher_upload_assignment_marks();
		}
		
		if(isset($_POST['teacher_upload_attendance_marks'])) {
			teacher_upload_attendance_marks();
		}
		
		if(isset($_POST['teacher_update_sessional_marks'])) {
			teacher_update_sessional_marks();
		}
		
		if(isset($_POST['teacher_update_attendance_marks'])) {
			teacher_update_attendance_marks();
		}
		
		if(isset($_POST['teacher_update_assignment_marks'])) {
			teacher_update_assignment_marks();
		}
		
		if(isset($_POST['teacher_update_internal_practical_marks'])) {
			teacher_update_internal_practical_marks();
		}
		
		
		
		if(isset($_POST['teacher_mark_aggregate_attendance'])) {
			teacher_mark_aggregate_attendance();
		}
		
		if(isset($_POST['add_sessional_co_que_mapping_details'])) {
			add_sessional_co_que_mapping_details();
		}
		if(isset($_POST['add_assignment_co_que_mapping_details'])) {
			add_assignment_co_que_mapping_details();
		}
		
		if(isset($_POST['add_internal_practical_co_que_mapping_details'])) {
			add_internal_practical_co_que_mapping_details();
		}
		
		
		if(isset($_POST['academic_inchange_generate_attendance_summary_sheet_form'])) {
			include_once('modules/academic_incharge/academic_inchange_generate_attendance_summary_sheet_form.php');
		}
		
		if(isset($_POST['consolidated_report_theory_form'])) {
			include_once('modules/teacher/consolidated_report_theory_form.php');
		}
		
		if(isset($_POST['unlock_consolidated_report_form'])) {
			include_once('modules/academic_incharge/unlock_consolidated_report_form.php');
		}
		
		if(isset($_POST['consolidated_report_details'])) {
			include_once('modules/teacher/consolidated_report_details.php');
		}
		
		if(isset($_POST['attendance_marks_module'])) {
			include_once('modules/teacher/attendance_marks_module.php');
		}
		
		if(isset($_POST['upload_attendance_marks_form_students'])) {
			include_once('modules/teacher/upload_attendance_marks_form_students.php');
		}
		
		if(isset($_POST['update_attendance_marks_form_students'])) {
			include_once('modules/teacher/update_attendance_marks_form_students.php');
		}
		
		if(isset($_POST['teacher_view_attendance_marks_details'])) {
			include_once('modules/teacher/teacher_view_attendance_marks_details.php');
		}
		
		if(isset($_POST['lock_sessional_module'])) {
			lock_sessional_module();
		}
		
		if(isset($_POST['lock_conslidated_report'])) {
			
			lock_consolidated_report();
		}
		
		if(isset($_POST['unlock_consolidated_report_now'])) {
			
			unlock_consolidated_report();
		}
		
		if(isset($_POST['unlock_sessional_marks'])) {
			include_once('modules/academic_incharge/unlock_sessional_marks.php');
		}
		
		if(isset($_POST['unlock_sessional_marks_show'])) {
			include_once('modules/academic_incharge/unlock_sessional_marks.php');
		}
		if(isset($_POST['unlock_sessional_marks_submit'])) {
			include_once('modules/academic_incharge/unlock_sessional_marks.php');
		}
		
		if(isset($_POST['lock_sessionalmarks'])) {
			lock_sessionalmarks();
		}
		
		if(isset($_POST['unlock_exam_form'])) {
			include_once('modules/course_admins/unlock_exam_form.php');
		}
		
		if(isset($_POST['add_student_detainee_list_theory_form']) or isset($_POST['add_student_detainee_list_practical_form'])) {
			include_once('modules/course_admins/add_student_detainee_list_theory_form.php');
		}
		
/*		if(isset($_POST['add_student_detainee_list_practical_form'])) {
			include_once('modules/course_admins/add_student_detainee_list_practical_form.php');
		}*/
		
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
		
		if(isset($_POST['add_course_outcomes'])) {
			include_once('modules/nba_incharge/add_course_outcomes.php');
		}
		
		if(isset($_POST['calculate_attainment']) or isset($_POST['calculate_attainment_subjectwise']) or isset($_POST['calculate_attainment_course_outcomes'])) {
			include_once('modules/nba_incharge/calculate_attainment.php');
		}
		if(isset($_POST['nba_calculate_attainment_complete'])) {
			include_once('modules/nba_incharge/nba_calculate_attainment_complete.php');
		}
		
		if(isset($_POST['add_sessional_co_que_mapping_subject_code'])) {
			include_once('modules/nba_incharge/add_sessional_co_que_mapping_subject_code.php');
		}
		if(isset($_POST['view_sessional_co_que_mapping_subject_code'])) {
			include_once('modules/nba_incharge/view_sessional_co_que_mapping_subject_code.php');
		}
		if(isset($_POST['add_assignment_co_que_mapping_subject_code'])) {
			include_once('modules/nba_incharge/add_assignment_co_que_mapping_subject_code.php');
		}
		if(isset($_POST['view_assignment_co_que_mapping_subject_code'])) {
			include_once('modules/nba_incharge/view_assignment_co_que_mapping_subject_code.php');
		}
		if(isset($_POST['add_internal_practical_co_que_mapping_subject_code'])) {
			include_once('modules/nba_incharge/add_internal_practical_co_que_mapping_subject_code.php');
		}
		if(isset($_POST['view_internal_practical_co_que_mapping_subject_code'])) {
			include_once('modules/nba_incharge/view_internal_practical_co_que_mapping_subject_code.php');
		}
		
		if(isset($_POST['add_sessional_co_que_mapping_details_form'])) {
			include_once('modules/nba_incharge/add_sessional_co_que_mapping_details_form.php');
		}
		if(isset($_POST['view_sessional_co_que_mapping_details_form'])) {
			include_once('modules/nba_incharge/view_sessional_co_que_mapping_details_form.php');
		}
		if(isset($_POST['add_assignment_co_que_mapping_details_form'])) {
			include_once('modules/nba_incharge/add_assignment_co_que_mapping_details_form.php');
		}
		if(isset($_POST['view_assignment_co_que_mapping_details_form'])) {
			include_once('modules/nba_incharge/view_assignment_co_que_mapping_details_form.php');
		}
		if(isset($_POST['add_internal_practical_co_que_mapping_details_form'])) {
			include_once('modules/nba_incharge/add_internal_practical_co_que_mapping_details_form.php');
		}
		if(isset($_POST['view_internal_practical_co_que_mapping_details_form'])) {
			include_once('modules/nba_incharge/view_internal_practical_co_que_mapping_details_form.php');
		}
		
		if(isset($_POST['add_peo_po_mapping_form'])) {
			include_once('modules/nba_incharge/add_peo_po_mapping_form.php');
		}
		
		if(isset($_POST['edit_course_outcomes_submit'])) {
			include_once('modules/nba_incharge/add_course_outcomes_detail.php');
		}
		if(isset($_POST['add_course_outcomes_detail'])) {
			include_once('modules/nba_incharge/add_course_outcomes_detail.php');
		}
		
		if(isset($_POST['delete_course_outcomes'])) {
			include_once('modules/nba_incharge/add_course_outcomes_detail.php');
		}
		if(isset($_POST['view_combined_attainment_form'])) {
			include_once('modules/nba_incharge/view_combined_attainment_form.php');
		}
		if(isset($_POST['view_combined_attainment'])) {
			include_once('modules/nba_incharge/view_combined_attainment.php');
		}
		
		if(isset($_POST['add_course_outcomes_submit'])) {
			include_once('modules/nba_incharge/add_course_outcomes_detail.php');
		}
		if(isset($_POST['co_po_mapping_report'])) {
			include_once('modules/nba_incharge/co_po_mapping_report.php');
		}
		if(isset($_POST['po_peo_mapping_report'])) {
			include_once('modules/nba_incharge/po_peo_mapping_report.php');
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
		if(isset($_POST['detainee_list_centre_wise'])) {
			include_once('modules/superintendent/detainee_list_centre_wise.php');
		}
		if(isset($_POST['internal_external_strength'])) {
			include_once('modules/course_admins/internal_external_strength.php');
		}
		if(isset($_POST['internal_external_strength_show'])) {
			include_once('modules/course_admins/internal_external_strength.php');
		}
		if(isset($_POST['detainee_list_practical'])) {
			include_once('modules/coe/detainee_list_practical.php');
		}
		
		if(isset($_POST['fill_regular_examform'])) {
			include_once('modules/coe/fill_regular_examform.php');
		}
		
		if(isset($_POST['fill_regular_examform_show'])) {
			include_once('modules/coe/fill_regular_examform.php');
		}
		
		if(isset($_POST['scheme_master_list'])) {
			include_once('modules/coe/scheme_master_list.php');
		}
		if(isset($_POST['scheme_master_list_show'])) {
			include_once('modules/coe/scheme_master_list.php');
		}
		if(isset($_POST['sup_mark_staff_attendance_form_staff'])) {
			include_once('modules/superintendent/sup_mark_staff_attendance_form_staff.php');
		}
		if(isset($_POST['sup_mark_staff_attendance'])) {
			include_once('modules/superintendent/sup_mark_staff_attendance.php');
		}
		if(isset($_POST['sup_lock_staff_attendance'])) {
			include_once('modules/superintendent/sup_lock_staff_attendance.php');
		}
		if(isset($_POST['sup_view_staff_attendance_details'])) {
			include_once('modules/superintendent/sup_view_staff_attendance_details.php');
		}
		
	}
	elseif(isset($_POST['logmeout'])) {
		
		session_destroy();
		mysql_query("UPDATE login_session_record
		SET login_status='logged_out',
		logout_time='".date("Y-m-d H:i:s")."'
		WHERE
		session_id='".$_SESSION['session_id']."'") or die(mysql_error());
		
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

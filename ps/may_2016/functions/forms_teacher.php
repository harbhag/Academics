<?php

function download_internal_marks_csv_form($course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $regular_reappear,
        $internal_max_marks,
        $external_max_marks,
        $aicte_rc,
        $internal_attendance_status,
        $external_attendance_status,
        $internal_lock_status,
        $external_lock_status,
        $exam_month,
        $exam_year,
        $count) {
	echo "<form action='' method='post'>
	<input type='hidden' name='download_internal_marks_csv' value='' />
	<input type='hidden' name='course_code' value='".$course_code."' />
	<input type='hidden' name='branch_code' value='".$branch_code."' />
	<input type='hidden' name='subject_code' value='".$subject_code."' />
	<input type='hidden' name='paper_id' value='".$paper_id."' />
	
	<input type='hidden' name='subject_title' value='".$subject_title."' />
	<input type='hidden' name='batch' value='".$batch."' />
	<input type='hidden' name='shift' value='".$shift."' />
	<input type='hidden' name='full_part_time' value='".$full_part_time."' />
	<input type='hidden' name='semester' value='".$semester."' />
	<input type='hidden' name='theory_practical' value='".$theory_practical."' />
	<input type='hidden' name='regular_reappear' value='".$regular_reappear."' />
	<input type='hidden' name='internal_max_marks' value='".$internal_max_marks."'/>
	<input type='hidden' name='external_max_marks' value='".$external_max_marks."'/>
	<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />
	<input type='hidden' name='exam_month' value='".$exam_month."' />
	<input type='hidden' name='exam_year' value='".$exam_year."' />";
	if($internal_lock_status==0 or $external_lock_status==0) {
		if($internal_attendance_status==0 && $external_attendance_status==0) {
			echo "<input type='submit' class='btn btn-mini' disabled='disabled' 
			value='Disabled' />";
		}
		if($internal_attendance_status==1 or $external_attendance_status==1) {
			
			if($theory_practical=='P') {
				echo "<input type='submit' class='btn btn-mini btn-danger'  value='Download Sheet' data-toggle='modal' href='#myModaldownload".$count."'/>
			";
				include('modules/modals/internal_external_modal_download.php');
			}
			
			elseif($theory_practical=='T') {
				if($internal_lock_status==1) {
					echo "<input type='submit' class='btn btn-mini' disabled='disabled' 
								value='Locked' />";
				}
				else {
					echo "<input type='hidden' name='internal_external' value='I' />
					<input type='submit' class='btn btn-mini btn-danger'  value='Download Sheet' />";
				}
			}
			else {
				echo "<input type='hidden' name='internal_external' value='I' />
				<input type='submit' class='btn btn-mini btn-danger'  value='Download Sheet' />";
			}
			
		}
	}
	if($internal_lock_status==1 && $external_lock_status==1) {
		echo "<input type='submit' class='btn btn-mini' disabled='disabled' 
			value='Locked' />";
	}
	echo"
	</form>";
}

function lock_internal_marks($course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $regular_reappear,
        $internal_max_marks,
        $external_max_marks,
        $aicte_rc,
        $internal_attendance_status,
        $external_attendance_status,
        $internal_lock_status,
        $external_lock_status,
        $exam_month,
        $exam_year,
        $count) {
	echo "<form action='' method='post'>
	<input type='hidden' name='lock_internal_subject' value='' />
	<input type='hidden' name='branch_code' value='".$branch_code."' />
	<input type='hidden' name='course_code' value='".$course_code."' />
	<input type='hidden' name='subject_code' value='".$subject_code."' />
	<input type='hidden' name='paper_id' value='".$paper_id."' />
	<input type='hidden' name='subject_title' value='".$subject_title."' />
	<input type='hidden' name='batch' value='".$batch."' />
	<input type='hidden' name='shift' value='".$shift."' />
	<input type='hidden' name='full_part_time' value='".$full_part_time."' />
	<input type='hidden' name='semester' value='".$semester."' />
	<input type='hidden' name='theory_practical' value='".$theory_practical."' />
	<input type='hidden' name='regular_reappear' value='".$regular_reappear."' />
	<input type='hidden' name='internal_max_marks' value='".$internal_max_marks."'/>
	<input type='hidden' name='external_max_marks' value='".$external_max_marks."'/>
	<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />
	<input type='hidden' name='exam_month' value='".$exam_month."' />
	<input type='hidden' name='exam_year' value='".$exam_year."' />";
	if($internal_lock_status==0 or $external_lock_status==0) {
		if($internal_attendance_status==0  && $external_attendance_status==0) {
		
			echo "<input type='submit' class='btn btn-mini' disabled='disabled' 
			value='Disabled' />";
		}
		if($internal_attendance_status==1 or $external_attendance_status==1) {
			
			if($theory_practical=='P') {
				echo "<input type='submit' class='btn btn-mini btn-danger' 
				value='Lock Subject' onclick='return confirm_action(\"You are going to Lock the subject !!\")' data-toggle='modal' href='#myModallock".$count."'/>";
				include('modules/modals/internal_external_modal_lock.php');
			}
			elseif($theory_practical=='T') {
				if($internal_lock_status==1) {
					echo "<input type='submit' class='btn btn-mini' disabled='disabled' 
					value='Locked' />";
				}
				else {
					echo "<input type='hidden' name='internal_external' value='I' />
					<input type='submit' class='btn btn-mini btn-danger' 
				value='Lock Subject' onclick='return confirm_action(\"You are going to Lock the subject !!\")'/>";
				}
			}
			else {
				echo "<input type='hidden' name='internal_external' value='I' />
				<input type='submit' class='btn btn-mini btn-danger' 
			value='Lock Subject' onclick='return confirm_action(\"You are going to Lock the subject !!\")'/>";
			}
		}
		
	}
	if($internal_lock_status==1 && $external_lock_status==1) {
		echo "<input type='submit' class='btn btn-mini' disabled='disabled' 
			value='Locked' />";
	}
	echo"
	</form>";
}

function print_internal_marks_record($course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $regular_reappear,
        $internal_max_marks,
        $external_max_marks,
        $aicte_rc,
        $internal_attendance_status,
        $external_attendance_status,
        $internal_lock_status,
        $external_lock_status,
        $exam_month,
        $exam_year,
        $count,
        $internal_allot,
        $external_allot) {
	echo "<form action='' method='post'>
	<input type='hidden' name='print_marks_record' value='' />
	<input type='hidden' name='branch_code' value='".$branch_code."' />
	<input type='hidden' name='course_code' value='".$course_code."' />
	<input type='hidden' name='subject_code' value='".$subject_code."' />
	<input type='hidden' name='paper_id' value='".$paper_id."' />
	<input type='hidden' name='subject_title' value='".$subject_title."' />
	<input type='hidden' name='batch' value='".$batch."' />
	<input type='hidden' name='shift' value='".$shift."' />
	<input type='hidden' name='full_part_time' value='".$full_part_time."' />
	<input type='hidden' name='semester' value='".$semester."' />
	<input type='hidden' name='theory_practical' value='".$theory_practical."' />
	<input type='hidden' name='regular_reappear' value='".$regular_reappear."' />
	<input type='hidden' name='internal_max_marks' value='".$internal_max_marks."'/>
	<input type='hidden' name='external_max_marks' value='".$external_max_marks."'/>
	<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />
	<input type='hidden' name='exam_month' value='".$exam_month."' />
	<input type='hidden' name='exam_year' value='".$exam_year."' />";
	if($internal_lock_status==0 && $external_lock_status==0) {
		
		echo "<input type='submit' class='btn btn-mini disabled' 
			value='Subject Not Locked' disabled='disabled'/>";
		
	}
	if($internal_lock_status==1 or $external_lock_status==1) {
		
		if($theory_practical=='P') {
				echo "<input type='submit' class='btn btn-mini btn-danger' 
			value='Print Marks' data-toggle='modal' href='#myModalprint".$count."'/>";
				include('modules/modals/internal_external_modal_print.php');
			}
			
			else {
				echo "<input type='hidden' name='internal_external' value='I' />
				<input type='submit' class='btn btn-mini btn-danger' 
			value='Print Marks' />";
			}
	}
	echo"
	</form>";
}

function mark_absent_internal($subject_master_id,
		$course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $regular_reappear,
        $internal_max_marks,
        $external_max_marks,
        $aicte_rc,
        $internal_attendance_status,
        $external_attendance_status,
        $internal_lock_status,
        $external_lock_status,
        $exam_month,
        $exam_year,
        $count,
        $internal_allot,
        $external_allot) {
	echo "<form action='' method='post'>
	<input type='hidden' name='teacher_mark_attendance_form' value='' />
	<input type='hidden' name='subject_master_id' value='".$subject_master_id."' />
	<input type='hidden' name='branch_code' value='".$branch_code."' />
	<input type='hidden' name='course_code' value='".$course_code."' />
	<input type='hidden' name='subject_code' value='".$subject_code."' />
	<input type='hidden' name='paper_id' value='".$paper_id."' />
	<input type='hidden' name='subject_title' value='".$subject_title."' />
	<input type='hidden' name='batch' value='".$batch."' />
	<input type='hidden' name='shift' value='".$shift."' />
	<input type='hidden' name='full_part_time' value='".$full_part_time."' />
	<input type='hidden' name='semester' value='".$semester."' />
	<input type='hidden' name='theory_practical' value='".$theory_practical."' />
	<input type='hidden' name='regular_reappear' value='".$regular_reappear."' />
	<input type='hidden' name='internal_max_marks' value='".$internal_max_marks."' />
	<input type='hidden' name='external_max_marks' value='".$external_max_marks."'/>
	<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />
	<input type='hidden' name='exam_month' value='".$exam_month."' />
	<input type='hidden' name='exam_year' value='".$exam_year."' />";
	if($internal_lock_status==0 or $external_lock_status==0) {
		if($theory_practical=='P') {
			echo "<input type='button' class='btn btn-mini btn-danger' 
			value='Mark Attendance' data-toggle='modal' href='#myModalattendance".$count."' />";
			include('modules/modals/internal_external_modal_attendance.php');
		}
		elseif($theory_practical=='T') {
				if($internal_lock_status==1) {
					echo "<input type='submit' class='btn btn-mini' disabled='disabled' 
					value='Locked' />";
				}
				else {
					echo "<input type='hidden' name='internal_external' value='I' />
					<input type='submit' class='btn btn-mini btn-danger' 
					value='Mark Attendance'/>";
				}
			}
		
		else {
			echo "<input type='hidden' name='internal_external' value='I' />
			<input type='submit' class='btn btn-mini btn-danger' 
			value='Mark Attendance'/>";
		}
	}
	if($internal_lock_status==1 && $external_lock_status==1) {
		echo "<input type='submit' class='btn btn-mini' disabled='disabled' 
			value='Locked' />";
	}
	echo"
	</form>";
}

function select_internal_marks_csv_file($course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $regular_reappear,
        $internal_max_marks,
        $external_max_marks,
        $aicte_rc,
        $internal_attendance_status,
        $external_attendance_status,
        $internal_lock_status,
        $external_lock_status,
        $exam_month,
        $exam_year,
        $count) {
	
	echo "
	<form class='form-inline' method='post' action='' enctype='multipart/form-data'>
	<input type='hidden' name='course_code' value='".$course_code."' />
	<input type='hidden' name='branch_code' value='".$branch_code."' />
	<input type='hidden' name='subject_code' value='".$subject_code."' />
	<input type='hidden' name='paper_id' value='".$paper_id."' />
	<input type='hidden' name='subject_title' value='".$subject_title."' />
	<input type='hidden' name='batch' value='".$batch."' />
	<input type='hidden' name='shift' value='".$shift."' />
	<input type='hidden' name='full_part_time' value='".$full_part_time."' />
	<input type='hidden' name='semester' value='".$semester."' />
	<input type='hidden' name='theory_practical' value='".$theory_practical."' />
	<input type='hidden' name='regular_reappear' value='".$regular_reappear."' />
	<input type='hidden' name='internal_max_marks' value='".$internal_max_marks."'/>
	<input type='hidden' name='external_max_marks' value='".$external_max_marks."'/>
	<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />
	<input type='hidden' name='exam_month' value='".$exam_month."' />
	<input type='hidden' name='exam_year' value='".$exam_year."' />
	<input type='hidden' name='upload_internal_marks_csv' value='' />";
	if($internal_lock_status==0 or $external_lock_status==0) {
		if($internal_attendance_status==0  && $external_attendance_status==0) {
		
			echo "<input type='file' name='csvfile' disabled='disabled'>
			<button type='submit' class='btn btn-mini disabled' disabled='disabled'>Disabled</button>";
		}
		if($internal_attendance_status==1 or $external_attendance_status==1) {
			
			if($theory_practical=='P') {
				echo "<input type='file' name='csvfile'>
			<button type='submit' class='btn btn-mini btn-danger'  data-toggle='modal' href='#myModalupload".$count."'>Upload</button>
			";
				include('modules/modals/internal_external_modal_upload.php');
			}
			elseif($theory_practical=='T') {
				if($internal_lock_status==1) {
					echo "<input type='file' name='csvfile' disabled='disabled'>
					<button type='submit' class='btn btn-mini disabled' disabled='disabled'>Disabled</button>";
				}
				else {
					echo "<input type='hidden' name='internal_external' value='I' />
					<input type='file' name='csvfile'>
					<button type='submit' class='btn btn-mini btn-danger'>Upload</button>";
				}
			}
			
			else {
				echo "<input type='hidden' name='internal_external' value='I' />
				<input type='file' name='csvfile'>
			<button type='submit' class='btn btn-mini btn-danger'>Upload</button>";
			}
		}
	}
	if($internal_lock_status==1 && $external_lock_status==1) {
		echo "<input type='file' name='csvfile' disabled='disabled'>
		<button type='submit' class='btn btn-mini disabled' disabled='disabled'>Disabled</button>";
	}
	echo"
	</form>";
	
}


function mark_daily_attendance($course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $aicte_rc,
        $exam_month,
        $exam_year,
        $ssection,
        $sgroup,
        $count,$internal_lock_status,$grace_period_allowed,$elective_details,$m_code,$scheme_code,$teacher_type,$contact_hours,$lecture_type) {
	echo "<form action='' method='post'>
	<input type='hidden' name='teacher_mark_daily_attendance_form_student' value='' />
	<input type='hidden' name='ssection' value='".$ssection."' />
	<input type='hidden' name='sgroup' value='".$sgroup."' />
	<input type='hidden' name='exam_month' value='".$exam_month."' />
	<input type='hidden' name='exam_year' value='".$exam_year."' />
	<input type='hidden' name='branch_code' value='".$branch_code."' />
	<input type='hidden' name='course_code' value='".$course_code."' />
	<input type='hidden' name='subject_code' value='".$subject_code."' />
	<input type='hidden' name='paper_id' value='".$paper_id."' />
	<input type='hidden' name='subject_title' value='".$subject_title."' />
	<input type='hidden' name='shift' value='".$shift."' />
	<input type='hidden' name='teacher_type' value='".$teacher_type."' />
	<input type='hidden' name='m_code' value='".$m_code."' />
	<input type='hidden' name='scheme_code' value='".$scheme_code."' />
	<input type='hidden' name='elective_details' value='".$elective_details."' />
	<input type='hidden' name='full_part_time' value='".$full_part_time."' />
	<input type='hidden' name='semester' value='".$semester."' />
	<input type='hidden' name='theory_practical' value='".$theory_practical."' />
	<input type='hidden' name='lecture_type' value='".$lecture_type."' />
	<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />";
	
	if($internal_lock_status==0) {
		echo "<input type='button' class='btn btn-mini btn-danger' 
			value='Mark Daily Attendance' data-toggle='modal' href='#myModalDailyAttendance".$count."'/>";
		include('modules/modals/teacher_daily_attendance.php');
		echo"
		</form>";
	}
	else {
		echo "<input type='button' class='btn btn-mini btn-danger disabled' 
			value='Mark Daily Attendance' data-toggle='modal' href='#myModalDailyAttendance".$count."' disabled/>";
		include('modules/modals/teacher_daily_attendance.php');
		echo"
		</form>";
	}
}


function mark_aggregate_attendance($course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $aicte_rc,
        $exam_month,
        $exam_year,
        $ssection,
        $sgroup,
        $count,$autoid,$internal_lock_status) {
	echo "<form action='' method='post'>
	<input type='hidden' name='exam_month' value='".$exam_month."' />
	<input type='hidden' name='exam_year' value='".$exam_year."' />
	<input type='hidden' name='ssection' value='".$ssection."' />
	<input type='hidden' name='autoid' value='".$autoid."' />
	<input type='hidden' name='sgroup' value='".$sgroup."' />
	<input type='hidden' name='branch_code' value='".$branch_code."' />
	<input type='hidden' name='course_code' value='".$course_code."' />
	<input type='hidden' name='subject_code' value='".$subject_code."' />
	<input type='hidden' name='paper_id' value='".$paper_id."' />
	<input type='hidden' name='subject_title' value='".$subject_title."' />
	<input type='hidden' name='shift' value='".$shift."' />
	<input type='hidden' name='full_part_time' value='".$full_part_time."' />
	<input type='hidden' name='semester' value='".$semester."' />
	<input type='hidden' name='theory_practical' value='".$theory_practical."' />
	<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />";
	
	if($internal_lock_status==0) {
		echo "<input type='button' class='btn btn-mini btn-danger'
			value='Mark Aggregate Attendance' data-toggle='modal' href='#aggregate_attendance_form".$count."' />";
		include('modules/modals/teacher/teacher_aggregate_attendance.php');
		echo"
		</form>";
	}
	else {
		echo "<input type='button' class='btn btn-mini btn-danger disabled'
			value='Mark Aggregate Attendance' data-toggle='modal' href='#aggregate_attendance_form".$count."' disabled/>";
		include('modules/modals/teacher/teacher_aggregate_attendance.php');
		echo"
		</form>";
	}
}


function update_daily_attendance($course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $aicte_rc,
        $exam_month,
        $exam_year,
        $ssection,
        $sgroup,
        $count,
        $attendance_date,
        $attendance_period,$internal_lock_status) {
	echo "<form action='' method='post'>
	<input type='hidden' name='teacher_update_daily_attendance_form_student' value='' />
	<input type='hidden' name='attendance_date' value='".$attendance_date."' />
	<input type='hidden' name='attendance_period' value='".$attendance_period."' />
	<input type='hidden' name='ssection' value='".$ssection."' />
	<input type='hidden' name='sgroup' value='".$sgroup."' />
	<input type='hidden' name='branch_code' value='".$branch_code."' />
	<input type='hidden' name='course_code' value='".$course_code."' />
	<input type='hidden' name='subject_code' value='".$subject_code."' />
	<input type='hidden' name='exam_month' value='".$exam_month."' />
	<input type='hidden' name='exam_year' value='".$exam_year."' />
	<input type='hidden' name='paper_id' value='".$paper_id."' />
	<input type='hidden' name='subject_title' value='".$subject_title."' />
	<input type='hidden' name='shift' value='".$shift."' />
	<input type='hidden' name='full_part_time' value='".$full_part_time."' />
	<input type='hidden' name='semester' value='".$semester."' />
	<input type='hidden' name='theory_practical' value='".$theory_practical."' />
	<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />";
	
	if($internal_lock_status==0) {
		echo "<input type='submit' class='btn btn-mini btn-danger' 
			value='Update Attendance'/>";
		echo"
		</form>";
	}
	else {
		echo "<input type='submit' class='btn btn-mini btn-danger disabled' 
			value='Update Attendance' disabled/>";
		echo"
		</form>";
	}
}



function update_aggregate_attendance($course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $aicte_rc,
        $exam_month,
        $exam_year,
        $ssection,
        $sgroup,
        $count,
        $start_date,
        $end_date,
        $total_lectures,$autoid,$internal_lock_status) {
	echo "<form action='' method='post'>
	<input type='hidden' name='teacher_update_aggregate_attendance_form_student' value='' />
	<input type='hidden' name='autoid' value='".$autoid."' />
	<input type='hidden' name='exam_month' value='".$exam_month."' />
	<input type='hidden' name='exam_year' value='".$exam_year."' />
	<input type='hidden' name='start_date' value='".$start_date."' />
	<input type='hidden' name='end_date' value='".$end_date."' />
	<input type='hidden' name='total_lectures' value='".$total_lectures."' />
	<input type='hidden' name='ssection' value='".$ssection."' />
	<input type='hidden' name='sgroup' value='".$sgroup."' />
	<input type='hidden' name='branch_code' value='".$branch_code."' />
	<input type='hidden' name='course_code' value='".$course_code."' />
	<input type='hidden' name='subject_code' value='".$subject_code."' />
	<input type='hidden' name='paper_id' value='".$paper_id."' />
	<input type='hidden' name='subject_title' value='".$subject_title."' />
	<input type='hidden' name='shift' value='".$shift."' />
	<input type='hidden' name='full_part_time' value='".$full_part_time."' />
	<input type='hidden' name='semester' value='".$semester."' />
	<input type='hidden' name='theory_practical' value='".$theory_practical."' />
	<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />";
	
	if($internal_lock_status==0) {
		echo "<input type='submit' class='btn btn-mini btn-danger' 
			value='Update Attendance' />";
		echo"
		</form>";
	}
	else {
		echo "<input type='submit' class='btn btn-mini btn-danger disabled' 
			value='Update Attendance' disabled/>";
		echo"
		</form>";
	}
}


function details_daily_attendance_record($course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $aicte_rc,
        $exam_month,
        $exam_year,
        $ssection,
        $sgroup,
        $count,
        $start_date,
        $end_date,
        $total_lectures,$elective_details) {
	echo "<form action='' method='post'>
	<input type='hidden' name='teacher_view_daily_attendance_details' value='' />
	<input type='hidden' name='start_date' value='".$start_date."' />
	<input type='hidden' name='end_date' value='".$end_date."' />
	<input type='hidden' name='total_lectures' value='".$total_lectures."' />
	<input type='hidden' name='ssection' value='".$ssection."' />
	<input type='hidden' name='sgroup' value='".$sgroup."' />
	<input type='hidden' name='branch_code' value='".$branch_code."' />
	<input type='hidden' name='course_code' value='".$course_code."' />
	<input type='hidden' name='subject_code' value='".$subject_code."' />
	<input type='hidden' name='elective_details' value='".$elective_details."' />
	<input type='hidden' name='paper_id' value='".$paper_id."' />
	<input type='hidden' name='subject_title' value='".$subject_title."' />
	<input type='hidden' name='shift' value='".$shift."' />
	<input type='hidden' name='full_part_time' value='".$full_part_time."' />
	<input type='hidden' name='semester' value='".$semester."' />
	<input type='hidden' name='theory_practical' value='".$theory_practical."' />
	<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />";
	echo "<input type='submit' class='btn btn-mini btn-danger ' 
			value='Details' />";
	echo"
	</form>";
}


function details_topics_covered($course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $aicte_rc,
        $exam_month,
        $exam_year,
        $ssection,
        $sgroup,
        $count,
        $start_date,
        $end_date,
        $total_lectures,$elective_details) {
	echo "<form action='' method='post'>
	<input type='hidden' name='details_topics_covered' value='' />
	<input type='hidden' name='start_date' value='".$start_date."' />
	<input type='hidden' name='end_date' value='".$end_date."' />
	<input type='hidden' name='total_lectures' value='".$total_lectures."' />
	<input type='hidden' name='ssection' value='".$ssection."' />
	<input type='hidden' name='sgroup' value='".$sgroup."' />
	<input type='hidden' name='branch_code' value='".$branch_code."' />
	<input type='hidden' name='course_code' value='".$course_code."' />
	<input type='hidden' name='subject_code' value='".$subject_code."' />
	<input type='hidden' name='elective_details' value='".$elective_details."' />
	<input type='hidden' name='paper_id' value='".$paper_id."' />
	<input type='hidden' name='subject_title' value='".$subject_title."' />
	<input type='hidden' name='shift' value='".$shift."' />
	<input type='hidden' name='full_part_time' value='".$full_part_time."' />
	<input type='hidden' name='semester' value='".$semester."' />
	<input type='hidden' name='theory_practical' value='".$theory_practical."' />
	<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />";
	echo "<input type='submit' class='btn btn-mini btn-danger ' 
			value='Course Delivery' />";
	echo"
	</form>";
}



function upload_sessional_marks($autoid,$internal_lock_status,
		$count,$course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $aicte_rc,
        $exam_month,
        $exam_year,
        $ssection,
        $sgroup,$elective_details,$m_code) {
	echo "<form action='' method='post'>
	<input type='hidden' name='exam_month' value='".$exam_month."' />
	<input type='hidden' name='exam_year' value='".$exam_year."' />
	<input type='hidden' name='ssection' value='".$ssection."' />
	<input type='hidden' name='sgroup' value='".$sgroup."' />
	<input type='hidden' name='branch_code' value='".$branch_code."' />
	<input type='hidden' name='course_code' value='".$course_code."' />
	<input type='hidden' name='subject_code' value='".$subject_code."' />
	<input type='hidden' name='paper_id' value='".$paper_id."' />
	<input type='hidden' name='subject_title' value='".$subject_title."' />
	<input type='hidden' name='shift' value='".$shift."' />
	<input type='hidden' name='elective_details' value='".$elective_details."' />
	<input type='hidden' name='m_code' value='".$m_code."' />
	<input type='hidden' name='full_part_time' value='".$full_part_time."' />
	<input type='hidden' name='semester' value='".$semester."' />
	<input type='hidden' name='theory_practical' value='".$theory_practical."' />
	<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />
	<input type='hidden' name='autoid' value='".$autoid."' />";
	
	if($internal_lock_status==0) {
		echo "<input type='button' class='btn btn-mini btn-danger' 
			value='Upload Marks' data-toggle='modal' href='#upload_sessional_marks".$count."' />";
		include('modules/modals/teacher/upload_sessional_marks.php');
		echo"
		</form>";
	}
	else {
		echo "<input type='button' class='btn btn-mini btn-danger disabled' 
			value='Upload Marks' data-toggle='modal' href='#upload_sessional_marks".$count."' disabled/>";
		include('modules/modals/teacher/upload_sessional_marks.php');
		echo"
		</form>";
	}
}



function details_sessional_marks($autoid,$course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $aicte_rc,
        $exam_month,
        $exam_year,
        $ssection,
        $sgroup) {
	echo "<form action='' method='post'>
	<input type='hidden' name='exam_month' value='".$exam_month."' />
	<input type='hidden' name='exam_year' value='".$exam_year."' />
	<input type='hidden' name='ssection' value='".$ssection."' />
	<input type='hidden' name='sgroup' value='".$sgroup."' />
	<input type='hidden' name='branch_code' value='".$branch_code."' />
	<input type='hidden' name='course_code' value='".$course_code."' />
	<input type='hidden' name='subject_code' value='".$subject_code."' />
	<input type='hidden' name='paper_id' value='".$paper_id."' />
	<input type='hidden' name='subject_title' value='".$subject_title."' />
	<input type='hidden' name='shift' value='".$shift."' />
	<input type='hidden' name='full_part_time' value='".$full_part_time."' />
	<input type='hidden' name='semester' value='".$semester."' />
	<input type='hidden' name='theory_practical' value='".$theory_practical."' />
	<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />
	<input type='hidden' name='autoid' value='".$autoid."' />
	<input type='hidden' name='teacher_view_sessional_details' value='".$autoid."' />";
	echo "<input type='submit' class='btn btn-mini btn-danger' 
			value='Details' />";
	echo"
	</form>";
}



function consolidated_report_details($course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $aicte_rc,
        $exam_month,
        $exam_year,
        $ssection,
        $sgroup) {
	echo "<form action='' method='post'>
	<input type='hidden' name='exam_month' value='".$exam_month."' />
	<input type='hidden' name='exam_year' value='".$exam_year."' />
	<input type='hidden' name='ssection' value='".$ssection."' />
	<input type='hidden' name='sgroup' value='".$sgroup."' />
	<input type='hidden' name='branch_code' value='".$branch_code."' />
	<input type='hidden' name='course_code' value='".$course_code."' />
	<input type='hidden' name='subject_code' value='".$subject_code."' />
	<input type='hidden' name='paper_id' value='".$paper_id."' />
	<input type='hidden' name='subject_title' value='".$subject_title."' />
	<input type='hidden' name='shift' value='".$shift."' />
	<input type='hidden' name='full_part_time' value='".$full_part_time."' />
	<input type='hidden' name='semester' value='".$semester."' />
	<input type='hidden' name='theory_practical' value='".$theory_practical."' />
	<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />
	<input type='hidden' name='autoid' value='".$autoid."' />
	<input type='hidden' name='consolidated_report_details' value='".$autoid."' />";
	echo "<input type='submit' class='btn btn-mini btn-danger' 
			value='Details' />";
	echo"
	</form>";
}


function print_consolidated_report($course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $aicte_rc,
        $exam_month,
        $exam_year,
        $ssection,
        $sgroup,$master_lock) {
	echo "<form action='' method='post'>
	<input type='hidden' name='exam_month' value='".$exam_month."' />
	<input type='hidden' name='exam_year' value='".$exam_year."' />
	<input type='hidden' name='ssection' value='".$ssection."' />
	<input type='hidden' name='sgroup' value='".$sgroup."' />
	<input type='hidden' name='branch_code' value='".$branch_code."' />
	<input type='hidden' name='course_code' value='".$course_code."' />
	<input type='hidden' name='subject_code' value='".$subject_code."' />
	<input type='hidden' name='paper_id' value='".$paper_id."' />
	<input type='hidden' name='subject_title' value='".$subject_title."' />
	<input type='hidden' name='shift' value='".$shift."' />
	<input type='hidden' name='full_part_time' value='".$full_part_time."' />
	<input type='hidden' name='semester' value='".$semester."' />
	<input type='hidden' name='theory_practical' value='".$theory_practical."' />
	<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />
	<input type='hidden' name='autoid' value='".$autoid."' />
	<input type='hidden' name='print_consolidated_report' value='".$autoid."' />";
	
	
	if($master_lock==1) {
		echo "<input type='submit' class='btn btn-mini btn-danger' 
			value='Print Report' />";
	}
	else {
		echo "<input type='submit' disabled class='btn btn-mini btn-danger disabled' 
			value='Record Not Locked' />";
	}
	echo"
	</form>";
}


function analysis_sessional_marks($count,$autoid,$course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $aicte_rc,
        $exam_month,
        $exam_year,
        $ssection,
        $sgroup,$m_code) {
	echo "<form action='' method='post'>
	<input type='hidden' name='exam_month' value='".$exam_month."' />
	<input type='hidden' name='exam_year' value='".$exam_year."' />
	<input type='hidden' name='ssection' value='".$ssection."' />
	<input type='hidden' name='sgroup' value='".$sgroup."' />
	<input type='hidden' name='branch_code' value='".$branch_code."' />
	<input type='hidden' name='course_code' value='".$course_code."' />
	<input type='hidden' name='subject_code' value='".$subject_code."' />
	<input type='hidden' name='paper_id' value='".$paper_id."' />
	<input type='hidden' name='subject_title' value='".$subject_title."' />
	<input type='hidden' name='shift' value='".$shift."' />
	<input type='hidden' name='full_part_time' value='".$full_part_time."' />
	<input type='hidden' name='semester' value='".$semester."' />
	<input type='hidden' name='theory_practical' value='".$theory_practical."' />
	<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />
	<input type='hidden' name='m_code' value='".$m_code."' />
	<input type='hidden' name='autoid' value='".$autoid."' />
	<input type='hidden' name='analysis_sessional_marks' value='".$autoid."' />";
	echo "<input type='button' class='btn btn-mini btn-danger' 
			value='Analysis' data-toggle='modal' href='#analysis_sessional_marks".$count."' />";
		include('modules/modals/teacher/analysis_sessional_marks.php');
		echo"</form>";
}

function update_sessional_marks($autoid,$internal_lock_status,$count,$course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $aicte_rc,
        $exam_month,
        $exam_year,
        $ssection,
        $sgroup,$m_code) {
	echo "<form action='' method='post'>
	<input type='hidden' name='exam_month' value='".$exam_month."' />
	<input type='hidden' name='exam_year' value='".$exam_year."' />
	<input type='hidden' name='ssection' value='".$ssection."' />
	<input type='hidden' name='sgroup' value='".$sgroup."' />
	<input type='hidden' name='branch_code' value='".$branch_code."' />
	<input type='hidden' name='course_code' value='".$course_code."' />
	<input type='hidden' name='subject_code' value='".$subject_code."' />
	<input type='hidden' name='paper_id' value='".$paper_id."' />
	<input type='hidden' name='subject_title' value='".$subject_title."' />
	<input type='hidden' name='shift' value='".$shift."' />
	<input type='hidden' name='full_part_time' value='".$full_part_time."' />
	<input type='hidden' name='semester' value='".$semester."' />
	<input type='hidden' name='theory_practical' value='".$theory_practical."' />
	<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />
	<input type='hidden' name='m_code' value='".$m_code."' />
	<input type='hidden' name='autoid' value='".$autoid."' />";
	
	if($internal_lock_status==0){
		echo "<input type='button' class='btn btn-mini btn-danger' 
			value='Update Record' data-toggle='modal' href='#update_sessional_marks".$count."' />";
		include('modules/modals/teacher/update_sessional_marks.php');
		echo"
		</form>";
	}
	else {
		echo "<input type='button' class='btn btn-mini btn-danger disabled' 
			value='Update Record' data-toggle='modal' href='#update_sessional_marks".$count."' disabled/>";
		include('modules/modals/teacher/update_sessional_marks.php');
		echo"
		</form>";
	}
}



function upload_assignments_marks($course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $aicte_rc,
        $exam_month,
        $exam_year,
        $ssection,
        $sgroup,
        $count,
        $internal_lock_status,$elective_details) {
	echo "<form action='' method='post'>
	<input type='hidden' name='exam_month' value='".$exam_month."' />
	<input type='hidden' name='exam_year' value='".$exam_year."' />
	<input type='hidden' name='ssection' value='".$ssection."' />
	<input type='hidden' name='sgroup' value='".$sgroup."' />
	<input type='hidden' name='branch_code' value='".$branch_code."' />
	<input type='hidden' name='course_code' value='".$course_code."' />
	<input type='hidden' name='subject_code' value='".$subject_code."' />
	<input type='hidden' name='paper_id' value='".$paper_id."' />
	<input type='hidden' name='subject_title' value='".$subject_title."' />
	<input type='hidden' name='shift' value='".$shift."' />
	<input type='hidden' name='full_part_time' value='".$full_part_time."' />
	<input type='hidden' name='semester' value='".$semester."' />
	<input type='hidden' name='theory_practical' value='".$theory_practical."' />
	<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />
	<input type='hidden' name='elective_details' value='".$elective_details."' />
	<input type='hidden' name='autoid' value='".$autoid."' />";
	
	if($internal_lock_status==0) {
		echo "<input type='button' class='btn btn-mini btn-danger' 
			value='Upload Assignment Marks' data-toggle='modal' href='#upload_assignments_marks".$count."' />";
		include('modules/modals/teacher/upload_assignments_marks.php');
		echo"
		</form>";
	}
	else {
		echo "<input type='button' class='btn btn-mini btn-danger disabled' 
			value='Upload Assignment Marks' data-toggle='modal' href='#upload_assignments_marks".$count."' disabled/>";
		include('modules/modals/teacher/upload_assignments_marks.php');
		echo"
		</form>";
	}
}



function details_assignments_marks($course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $aicte_rc,
        $exam_month,
        $exam_year,
        $ssection,
        $sgroup,
        $count,
        $assignment_no,
        $internal_lock_status,$elective_details) {
	echo "<form action='' method='post'>
	<input type='hidden' name='exam_month' value='".$exam_month."' />
	<input type='hidden' name='exam_year' value='".$exam_year."' />
	<input type='hidden' name='ssection' value='".$ssection."' />
	<input type='hidden' name='sgroup' value='".$sgroup."' />
	<input type='hidden' name='branch_code' value='".$branch_code."' />
	<input type='hidden' name='course_code' value='".$course_code."' />
	<input type='hidden' name='subject_code' value='".$subject_code."' />
	<input type='hidden' name='paper_id' value='".$paper_id."' />
	<input type='hidden' name='subject_title' value='".$subject_title."' />
	<input type='hidden' name='shift' value='".$shift."' />
	<input type='hidden' name='m_code' value='".$m_code."' />
	<input type='hidden' name='full_part_time' value='".$full_part_time."' />
	<input type='hidden' name='semester' value='".$semester."' />
	<input type='hidden' name='theory_practical' value='".$theory_practical."' />
	<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />
	<input type='hidden' name='elective_details' value='".$elective_details."' />
	<input type='hidden' name='autoid' value='".$autoid."' />
	<input type='hidden' name='assignment_no' value='".$assignment_no."' />
	<input type='hidden' name='teacher_view_assignment_details' value='".$autoid."' />";
	echo "<input type='submit' class='btn btn-mini btn-danger' 
			value='Assignment Details' />";
	echo"
	</form>";
}

function update_assignments_marks($course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $aicte_rc,
        $exam_month,
        $exam_year,
        $ssection,
        $sgroup,
        $count,
        $internal_lock_status,$elective_details) {
	echo "<form action='' method='post'>
	<input type='hidden' name='exam_month' value='".$exam_month."' />
	<input type='hidden' name='exam_year' value='".$exam_year."' />
	<input type='hidden' name='ssection' value='".$ssection."' />
	<input type='hidden' name='sgroup' value='".$sgroup."' />
	<input type='hidden' name='branch_code' value='".$branch_code."' />
	<input type='hidden' name='course_code' value='".$course_code."' />
	<input type='hidden' name='subject_code' value='".$subject_code."' />
	<input type='hidden' name='paper_id' value='".$paper_id."' />
	<input type='hidden' name='subject_title' value='".$subject_title."' />
	<input type='hidden' name='shift' value='".$shift."' />
	<input type='hidden' name='full_part_time' value='".$full_part_time."' />
	<input type='hidden' name='semester' value='".$semester."' />
	<input type='hidden' name='theory_practical' value='".$theory_practical."' />
	<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />
	<input type='hidden' name='elective_details' value='".$elective_details."' />
	<input type='hidden' name='autoid' value='".$autoid."' />";	
	if($internal_lock_status==0) {
		echo "<input type='button' class='btn btn-mini btn-danger' 
			value='Update Assignment Record' data-toggle='modal' href='#update_assignments_marks".$count."' />";
		include('modules/modals/teacher/update_assignments_marks.php');
		echo"
		</form>";
	}
	else {
		echo "<input type='button' class='btn btn-mini btn-danger disabled' 
			value='Update Assignment Record' data-toggle='modal' href='#update_assignments_marks".$count."' disabled/>";
		include('modules/modals/teacher/update_assignments_marks.php');
		echo"
		</form>";
	}
}





function upload_internal_practical_marks($course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $aicte_rc,
        $exam_month,
        $exam_year,
        $ssection,
        $sgroup,
        $count,
        $internal_lock_status,$elective_details) {
		echo "<form action='' method='post'>
		<input type='hidden' name='upload_internal_practical_marks_form_student'/>
		<input type='hidden' name='exam_month' value='".$exam_month."' />
		<input type='hidden' name='exam_year' value='".$exam_year."' />
		<input type='hidden' name='ssection' value='".$ssection."' />
		<input type='hidden' name='sgroup' value='".$sgroup."' />
		<input type='hidden' name='branch_code' value='".$branch_code."' />
		<input type='hidden' name='course_code' value='".$course_code."' />
		<input type='hidden' name='subject_code' value='".$subject_code."' />
		<input type='hidden' name='paper_id' value='".$paper_id."' />
		<input type='hidden' name='subject_title' value='".$subject_title."' />
		<input type='hidden' name='shift' value='".$shift."' />
		<input type='hidden' name='full_part_time' value='".$full_part_time."' />
		<input type='hidden' name='semester' value='".$semester."' />
		<input type='hidden' name='theory_practical' value='".$theory_practical."' />
		<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />
		<input type='hidden' name='elective_details' value='".$elective_details."' />
		<input type='hidden' name='autoid' value='".$autoid."' />
		<input type='submit' class='btn btn-mini btn-danger' value='Upload Internal Practical Marks' /></form>";
}




function update_internal_practical_marks($course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $aicte_rc,
        $exam_month,
        $exam_year,
        $ssection,
        $sgroup,
        $count,
        $internal_lock_status,$elective_details) {
	echo "<form action='' method='post'>
	<input type='hidden' name='exam_month' value='".$exam_month."' />
	<input type='hidden' name='exam_year' value='".$exam_year."' />
	<input type='hidden' name='ssection' value='".$ssection."' />
	<input type='hidden' name='sgroup' value='".$sgroup."' />
	<input type='hidden' name='branch_code' value='".$branch_code."' />
	<input type='hidden' name='course_code' value='".$course_code."' />
	<input type='hidden' name='subject_code' value='".$subject_code."' />
	<input type='hidden' name='paper_id' value='".$paper_id."' />
	<input type='hidden' name='subject_title' value='".$subject_title."' />
	<input type='hidden' name='shift' value='".$shift."' />
	<input type='hidden' name='full_part_time' value='".$full_part_time."' />
	<input type='hidden' name='semester' value='".$semester."' />
	<input type='hidden' name='theory_practical' value='".$theory_practical."' />
	<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />
	<input type='hidden' name='elective_details' value='".$elective_details."' />
	<input type='hidden' name='autoid' value='".$autoid."' />
	<input type='hidden' name='update_internal_practical_marks_form_students' value='' />
	<input type='submit' class='btn btn-mini btn-danger' value='Update Internal Practical Marks' /></form>";
}



function details_internal_practical_marks($course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $aicte_rc,
        $exam_month,
        $exam_year,
        $ssection,
        $sgroup,
        $count,
        $assignment_no,
        $internal_lock_status,$elective_details) {
	echo "<form action='' method='post'>
	<input type='hidden' name='exam_month' value='".$exam_month."' />
	<input type='hidden' name='exam_year' value='".$exam_year."' />
	<input type='hidden' name='ssection' value='".$ssection."' />
	<input type='hidden' name='sgroup' value='".$sgroup."' />
	<input type='hidden' name='branch_code' value='".$branch_code."' />
	<input type='hidden' name='course_code' value='".$course_code."' />
	<input type='hidden' name='subject_code' value='".$subject_code."' />
	<input type='hidden' name='paper_id' value='".$paper_id."' />
	<input type='hidden' name='subject_title' value='".$subject_title."' />
	<input type='hidden' name='shift' value='".$shift."' />
	<input type='hidden' name='m_code' value='".$m_code."' />
	<input type='hidden' name='full_part_time' value='".$full_part_time."' />
	<input type='hidden' name='semester' value='".$semester."' />
	<input type='hidden' name='theory_practical' value='".$theory_practical."' />
	<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />
	<input type='hidden' name='elective_details' value='".$elective_details."' />
	<input type='hidden' name='autoid' value='".$autoid."' />
	<input type='hidden' name='assignment_no' value='".$assignment_no."' />
	<input type='hidden' name='teacher_view_internal_practical_details' value='".$autoid."' />";
	echo "<input type='submit' class='btn btn-mini btn-danger' 
			value='Internal Practical Details' />";
	echo"
	</form>";
}







function upload_attendance_marks($course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $aicte_rc,
        $exam_month,
        $exam_year,
        $ssection,
        $sgroup,
        $count,
        $internal_lock_status,$elective_details) {
		echo "<form action='' method='post'>
		<input type='hidden' name='upload_attendance_marks_form_students'/>
		<input type='hidden' name='exam_month' value='".$exam_month."' />
		<input type='hidden' name='exam_year' value='".$exam_year."' />
		<input type='hidden' name='ssection' value='".$ssection."' />
		<input type='hidden' name='sgroup' value='".$sgroup."' />
		<input type='hidden' name='branch_code' value='".$branch_code."' />
		<input type='hidden' name='course_code' value='".$course_code."' />
		<input type='hidden' name='subject_code' value='".$subject_code."' />
		<input type='hidden' name='paper_id' value='".$paper_id."' />
		<input type='hidden' name='subject_title' value='".$subject_title."' />
		<input type='hidden' name='shift' value='".$shift."' />
		<input type='hidden' name='full_part_time' value='".$full_part_time."' />
		<input type='hidden' name='semester' value='".$semester."' />
		<input type='hidden' name='theory_practical' value='".$theory_practical."' />
		<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />
		<input type='hidden' name='elective_details' value='".$elective_details."' />
		<input type='hidden' name='autoid' value='".$autoid."' />
		<input type='submit' class='btn btn-mini btn-danger' value='Upload Attendance Marks' /></form>";
}




function update_attendance_marks($course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $aicte_rc,
        $exam_month,
        $exam_year,
        $ssection,
        $sgroup,
        $count,
        $internal_lock_status,$elective_details) {
	echo "<form action='' method='post'>
	<input type='hidden' name='exam_month' value='".$exam_month."' />
	<input type='hidden' name='exam_year' value='".$exam_year."' />
	<input type='hidden' name='ssection' value='".$ssection."' />
	<input type='hidden' name='sgroup' value='".$sgroup."' />
	<input type='hidden' name='branch_code' value='".$branch_code."' />
	<input type='hidden' name='course_code' value='".$course_code."' />
	<input type='hidden' name='subject_code' value='".$subject_code."' />
	<input type='hidden' name='paper_id' value='".$paper_id."' />
	<input type='hidden' name='subject_title' value='".$subject_title."' />
	<input type='hidden' name='shift' value='".$shift."' />
	<input type='hidden' name='full_part_time' value='".$full_part_time."' />
	<input type='hidden' name='semester' value='".$semester."' />
	<input type='hidden' name='theory_practical' value='".$theory_practical."' />
	<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />
	<input type='hidden' name='elective_details' value='".$elective_details."' />
	<input type='hidden' name='autoid' value='".$autoid."' />
	<input type='hidden' name='update_attendance_marks_form_students' value='' />
	<input type='submit' class='btn btn-mini btn-danger' value='Update Attendance Marks' /></form>";
}



function details_attendance_marks($course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $aicte_rc,
        $exam_month,
        $exam_year,
        $ssection,
        $sgroup,
        $count,
        $assignment_no,
        $internal_lock_status,$elective_details) {
	echo "<form action='' method='post'>
	<input type='hidden' name='exam_month' value='".$exam_month."' />
	<input type='hidden' name='exam_year' value='".$exam_year."' />
	<input type='hidden' name='ssection' value='".$ssection."' />
	<input type='hidden' name='sgroup' value='".$sgroup."' />
	<input type='hidden' name='branch_code' value='".$branch_code."' />
	<input type='hidden' name='course_code' value='".$course_code."' />
	<input type='hidden' name='subject_code' value='".$subject_code."' />
	<input type='hidden' name='paper_id' value='".$paper_id."' />
	<input type='hidden' name='subject_title' value='".$subject_title."' />
	<input type='hidden' name='shift' value='".$shift."' />
	<input type='hidden' name='m_code' value='".$m_code."' />
	<input type='hidden' name='full_part_time' value='".$full_part_time."' />
	<input type='hidden' name='semester' value='".$semester."' />
	<input type='hidden' name='theory_practical' value='".$theory_practical."' />
	<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />
	<input type='hidden' name='elective_details' value='".$elective_details."' />
	<input type='hidden' name='autoid' value='".$autoid."' />
	<input type='hidden' name='assignment_no' value='".$assignment_no."' />
	<input type='hidden' name='teacher_view_attendance_marks_details' value='".$autoid."' />";
	echo "<input type='submit' class='btn btn-mini btn-danger' 
			value='Attendance Marks Details' />";
	echo"
	</form>";
}





function lock_sessionalmarks_module_form($autoid,$course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $aicte_rc,
        $exam_month,
        $exam_year,
        $ssection,
        $sgroup,$count,$m_code) {
	echo "<form action='' method='post'>
	<input type='hidden' name='exam_month' value='".$exam_month."' />
	<input type='hidden' name='exam_year' value='".$exam_year."' />
	<input type='hidden' name='ssection' value='".$ssection."' />
	<input type='hidden' name='sgroup' value='".$sgroup."' />
	<input type='hidden' name='branch_code' value='".$branch_code."' />
	<input type='hidden' name='course_code' value='".$course_code."' />
	<input type='hidden' name='subject_code' value='".$subject_code."' />
	<input type='hidden' name='paper_id' value='".$paper_id."' />
	<input type='hidden' name='subject_title' value='".$subject_title."' />
	<input type='hidden' name='shift' value='".$shift."' />
	<input type='hidden' name='full_part_time' value='".$full_part_time."' />
	<input type='hidden' name='semester' value='".$semester."' />
	<input type='hidden' name='theory_practical' value='".$theory_practical."' />
	<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />
	<input type='hidden' name='m_code' value='".$m_code."' />
	<input type='hidden' name='autoid' value='".$autoid."' />
	<input type='hidden' name='lock_sessionalmarks' value='".$autoid."' />";
	

		echo "<input type='button' class='btn btn-mini btn-danger' 
			value='Lock Record' data-toggle='modal' href='#lock_sessionalmarks$count' />";
		include('modules/modals/teacher/lock_sessionalmarks.php');
		echo"
		</form>";
}





function lock_consolidated_report_form($autoid,$course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $aicte_rc,
        $exam_month,
        $exam_year,
        $ssection,
        $sgroup,$count,$m_code,$master_lock) {
	echo "<form action='' method='post'>
	<input type='hidden' name='exam_month' value='".$exam_month."' />
	<input type='hidden' name='exam_year' value='".$exam_year."' />
	<input type='hidden' name='ssection' value='".$ssection."' />
	<input type='hidden' name='sgroup' value='".$sgroup."' />
	<input type='hidden' name='branch_code' value='".$branch_code."' />
	<input type='hidden' name='course_code' value='".$course_code."' />
	<input type='hidden' name='subject_code' value='".$subject_code."' />
	<input type='hidden' name='paper_id' value='".$paper_id."' />
	<input type='hidden' name='subject_title' value='".$subject_title."' />
	<input type='hidden' name='shift' value='".$shift."' />
	<input type='hidden' name='full_part_time' value='".$full_part_time."' />
	<input type='hidden' name='semester' value='".$semester."' />
	<input type='hidden' name='theory_practical' value='".$theory_practical."' />
	<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />
	<input type='hidden' name='m_code' value='".$m_code."' />
	<input type='hidden' name='autoid' value='".$autoid."' />
	<input type='hidden' name='lock_conslidated_report' value='".$autoid."' />";
	
	
	if($master_lock==1) {
		echo "<input type='submit' disabled class='btn btn-mini btn-danger disabled' 
			value='Locked' />";
	}
	else {
		echo "<input type='submit' class='btn btn-mini btn-danger' 
			value='Lock Record' onclick='return confirm_action(\"Do you want to lock this record ? Records regarding Assignments, Sessionals, Attendance and Internal Practical will be locked and no further updations will be allowed. So Please make sure that you have uploaded all the records before locking.\")'/>";
	}
	echo"
	</form>";
}



function unlock_consolidated_report_form($autoid,$course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $aicte_rc,
        $exam_month,
        $exam_year,
        $ssection,
        $sgroup,$count,$m_code,$teacher_username) {
	echo "<form action='' method='post'>
	<input type='hidden' name='exam_month' value='".$exam_month."' />
	<input type='hidden' name='exam_year' value='".$exam_year."' />
	<input type='hidden' name='ssection' value='".$ssection."' />
	<input type='hidden' name='sgroup' value='".$sgroup."' />
	<input type='hidden' name='branch_code' value='".$branch_code."' />
	<input type='hidden' name='course_code' value='".$course_code."' />
	<input type='hidden' name='subject_code' value='".$subject_code."' />
	<input type='hidden' name='paper_id' value='".$paper_id."' />
	<input type='hidden' name='subject_title' value='".$subject_title."' />
	<input type='hidden' name='shift' value='".$shift."' />
	<input type='hidden' name='full_part_time' value='".$full_part_time."' />
	<input type='hidden' name='semester' value='".$semester."' />
	<input type='hidden' name='theory_practical' value='".$theory_practical."' />
	<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />
	<input type='hidden' name='m_code' value='".$m_code."' />
	<input type='hidden' name='teacher_username' value='".$teacher_username."' />
	<input type='hidden' name='autoid' value='".$autoid."' />
	<input type='hidden' name='unlock_consolidated_report_now' value='".$autoid."' />";
	
	echo "<input type='submit' class='btn btn-mini btn-danger' 
			value='Unlock Record' onclick='return confirm_action(\"Do you want to continue?\")'/>";
	echo"
	</form>";
}



function lock_sessional_module_form($autoid,$internal_lock_status,$course_code,
        $branch_code,
        $subject_code,
        $paper_id,
        $subject_title,
        $theory_practical,
        $semester,
        $shift,
        $full_part_time,
        $aicte_rc,
        $exam_month,
        $exam_year,
        $ssection,
        $sgroup) {
	echo "<form action='' method='post'>
	<input type='hidden' name='exam_month' value='".$exam_month."' />
	<input type='hidden' name='exam_year' value='".$exam_year."' />
	<input type='hidden' name='ssection' value='".$ssection."' />
	<input type='hidden' name='sgroup' value='".$sgroup."' />
	<input type='hidden' name='branch_code' value='".$branch_code."' />
	<input type='hidden' name='course_code' value='".$course_code."' />
	<input type='hidden' name='subject_code' value='".$subject_code."' />
	<input type='hidden' name='paper_id' value='".$paper_id."' />
	<input type='hidden' name='subject_title' value='".$subject_title."' />
	<input type='hidden' name='shift' value='".$shift."' />
	<input type='hidden' name='full_part_time' value='".$full_part_time."' />
	<input type='hidden' name='semester' value='".$semester."' />
	<input type='hidden' name='theory_practical' value='".$theory_practical."' />
	<input type='hidden' name='aicte_rc' value='".$aicte_rc."' />
	<input type='hidden' name='autoid' value='".$autoid."' />
	<input type='hidden' name='lock_sessional_module' value='".$autoid."' />";
	
	if($internal_lock_status==0) {
		echo "<input type='submit' class='btn btn-mini btn-danger' 
			value='Lock Record' onclick='return confirm_action(\"Do you want to lock this record ? No further updations will be allowed after locking\")'/>";
		echo"
		</form>";
	}
	else {
		echo "<input type='submit' class='btn btn-mini btn-danger disabled' 
			value='Lock Record' disabled/>";
		echo"
		</form>";
		
	}
	
}





function download_practical_attendance_sheet($subject_master_id,
        $external_lock_status,
        $internal_allot,
        $external_allot,
        $theory_practical) {
	echo "<form action='' method='post'>
	<input type='hidden' name='download_practical_attendance_sheet' value='' />
	<input type='hidden' name='subject_master_id' value='".$subject_master_id."' />";
	if($external_lock_status==0 && $theory_practical=='P') {
		echo "<input type='submit' class='btn btn-mini btn-danger' 
					value='Download Sheet'/>";
	 }
	 else {
		 echo "<input type='hidden' name='internal_external' value='I' />
					<input type='submit' class='btn btn-mini btn-danger disabled' disabled 
					value='Disabled'/>";
	 }
	echo"
	</form>";
}
?>

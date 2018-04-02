<?php
function director_view_daily_attendance_details($course_code,
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
        $total_lectures) {
	echo "<form action='' method='post'>
	<input type='hidden' name='director_view_daily_attendance_details' value='' />
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
	echo "<input type='submit' class='btn btn-mini btn-danger ' 
			value='Details' />";
	echo"
	</form>";
}

?>

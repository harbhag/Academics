<?php

$sql ="SELECT distinct cc.course_name as course_name, bc.branch_name as branch_name, ps.course_code, ps.FRM_BRID, `Sub_Sem`,`scheme_code`, aicte_rc,full_part_time, `Regular_Reappear`,cbs, count( distinct ED_RollNo) as count  FROM `ptu_subjects` ps, course_code cc, branch_code bc where received_status='Y' and eligibility='Y' and ps.course_code=cc.course_code and bc.branch_code= FRM_BRID group by ps.course_code, `FRM_BRID`, `Sub_Sem`,`scheme_code`, aicte_rc,full_part_time, `Regular_Reappear`,cbs order by ps.course_code, `FRM_BRID`, `Sub_Sem`,`scheme_code`, cbs, aicte_rc,full_part_time, `Regular_Reappear`";

$result= mysqli_query($mysqli_conn, $sql);

echo "<table  class='table table-bordered striped table-condensed container sortable' ><tr style='background-color:lightgrey'>
	<th>Sr. No.</th> 
	<th>Course(Branch)</th> 
	<th>Semester
	<th>Scheme Code</th>
	<th>CBS</th>
	<th>AICTE/RC</th>
	<th>Full / Part Time</th>
	<th>Regular / Reappear</th>
	<th>Ed_Ext=1 (Theory) | Sup. Att.(Present)</th>
	<th>Ed_Ext=1 (Practical) | SIM (Present)</th>
	<th>Ed_Int=1 (Theory) | SIM (Present)</th>
	<th>Ed_Int=1 (Practical) | SIM (Present)</th>
	<th> Student Count</th></tr>";
$x=1;
while($row_result = mysqli_fetch_assoc($result))
{
echo "<tr><td>$x</td><td>".$row_result['course_name']." ( ".$row_result['branch_name'].")</td><td>".$row_result['Sub_Sem']."</td><td>".$row_result['scheme_code']."</td><td>".$row_result['cbs']."</td><td>".$row_result['aicte_rc']."</td><td>".$row_result['full_part_time']."</td>

<td>".$row_result['Regular_Reappear']."</td>";

$row_ed_ext = mysqli_fetch_assoc(mysqli_query($mysqli_conn, "select count(distinct ED_RollNo) as ed_ext_count from ptu_subjects where course_code='".$row_result['course_code']."' and FRM_BRID='".$row_result['FRM_BRID']."' and Sub_Sem='".$row_result['Sub_Sem']."' and scheme_code='".$row_result['scheme_code']."' and aicte_rc='".$row_result['aicte_rc']."' and full_part_time='".$row_result['full_part_time']."' and Ed_Ext='1' and Sub_TP='T' and received_status='Y' and eligibility='Y' and regular_reappear='".$row_result['Regular_Reappear']."' and cbs='".$row_result['cbs']."' ;")) ;


$row_ed_ext_sem = mysqli_fetch_assoc(mysqli_query($mysqli_conn, "select count(distinct university_roll_no) as sem_count from student_external_marks where course_code='".$row_result['course_code']."' and branch_code='".$row_result['FRM_BRID']."' and semester='".$row_result['Sub_Sem']."' and scheme_code='".$row_result['scheme_code']."' and aicte_rc='".$row_result['aicte_rc']."' and full_part_time='".$row_result['full_part_time']."' and external_attendance_status='Present' and regular_reappear='".$row_result['Regular_Reappear']."' and cbs='".$row_result['cbs']."';")) ;

$row_ed_ext_P = mysqli_fetch_assoc(mysqli_query($mysqli_conn, "select count(distinct ED_RollNo) as ed_ext_count_P from ptu_subjects where course_code='".$row_result['course_code']."' and FRM_BRID='".$row_result['FRM_BRID']."' and Sub_Sem='".$row_result['Sub_Sem']."' and scheme_code='".$row_result['scheme_code']."' and aicte_rc='".$row_result['aicte_rc']."' and full_part_time='".$row_result['full_part_time']."' and Ed_Ext='1' and Sub_TP='P' and received_status='Y' and eligibility='Y' and regular_reappear='".$row_result['Regular_Reappear']."' and cbs='".$row_result['cbs']."';")) ;


$row_ed_ext_sim_P = mysqli_fetch_assoc(mysqli_query($mysqli_conn, "select count(distinct university_roll_no) as sim_count_E_P from student_internal_marks where course_code='".$row_result['course_code']."' and branch_code='".$row_result['FRM_BRID']."' and semester='".$row_result['Sub_Sem']."' and scheme_code='".$row_result['scheme_code']."' and aicte_rc='".$row_result['aicte_rc']."' and full_part_time='".$row_result['full_part_time']."' and internal_external='E' and external_attendance_status='Present' and theory_practical='P' and external_lock_status='1' and regular_reappear='".$row_result['Regular_Reappear']."' and cbs='".$row_result['cbs']."';")) ;



$row_ed_int = mysqli_fetch_assoc(mysqli_query($mysqli_conn, "select count(distinct ED_RollNo) as ed_int_count from ptu_subjects where course_code='".$row_result['course_code']."' and FRM_BRID='".$row_result['FRM_BRID']."' and Sub_Sem='".$row_result['Sub_Sem']."' and scheme_code='".$row_result['scheme_code']."' and aicte_rc='".$row_result['aicte_rc']."' and full_part_time='".$row_result['full_part_time']."' and Ed_Int='1' and Sub_TP='T' and received_status='Y' and eligibility='Y' and regular_reappear='".$row_result['Regular_Reappear']."' and cbs='".$row_result['cbs']."' ;")) ;


$row_ed_int_sim_T = mysqli_fetch_assoc(mysqli_query($mysqli_conn, "select count(distinct university_roll_no) as sim_count_I_T from student_internal_marks where course_code='".$row_result['course_code']."' and branch_code='".$row_result['FRM_BRID']."' and semester='".$row_result['Sub_Sem']."' and scheme_code='".$row_result['scheme_code']."' and aicte_rc='".$row_result['aicte_rc']."' and full_part_time='".$row_result['full_part_time']."' and internal_external='I' and internal_attendance_status='Present' and theory_practical='T' and internal_lock_status='1' and regular_reappear='".$row_result['Regular_Reappear']."'and cbs='".$row_result['cbs']."' ;")) ;



$row_ed_int_P = mysqli_fetch_assoc(mysqli_query($mysqli_conn, "select count(distinct ED_RollNo) as ed_int_count_P from ptu_subjects where course_code='".$row_result['course_code']."' and FRM_BRID='".$row_result['FRM_BRID']."' and Sub_Sem='".$row_result['Sub_Sem']."' and scheme_code='".$row_result['scheme_code']."' and aicte_rc='".$row_result['aicte_rc']."' and full_part_time='".$row_result['full_part_time']."' and Ed_Int='1' and Sub_TP='P' and received_status='Y' and eligibility='Y' and regular_reappear='".$row_result['Regular_Reappear']."' and cbs='".$row_result['cbs']."' ;")) ;

$row_ed_int_sim_P = mysqli_fetch_assoc(mysqli_query($mysqli_conn, "select count(distinct university_roll_no) as sim_count_I_P from student_internal_marks where course_code='".$row_result['course_code']."' and branch_code='".$row_result['FRM_BRID']."' and semester='".$row_result['Sub_Sem']."' and scheme_code='".$row_result['scheme_code']."' and aicte_rc='".$row_result['aicte_rc']."' and full_part_time='".$row_result['full_part_time']."' and internal_external='I' and internal_attendance_status='Present' and theory_practical='P' and internal_lock_status='1' and regular_reappear='".$row_result['Regular_Reappear']."' and cbs='".$row_result['cbs']."' ;")) ;


echo "<td>".$row_ed_ext['ed_ext_count']." | ".$row_ed_ext_sem['sem_count']." </td>
<td>".$row_ed_ext_P['ed_ext_count_P']." | ".$row_ed_ext_sim_P['sim_count_E_P']."</td>

<td>".$row_ed_int['ed_int_count']." | ".$row_ed_int_sim_T['sim_count_I_T']."</td>

<td>".$row_ed_int_P['ed_int_count_P']." | ".$row_ed_int_sim_P['sim_count_I_P']." </td>

<td>".$row_result['count']."</td></tr>";
//echo "select count(distinct ED_RollNo) as ed_ext_count from ptu_subjects where course_code='".$row_result['course_code']."' and FRM_BRID='".$row_result['FRM_BRID']."' and Sub_Sem='".$row_result['Sub_Sem']."' and scheme_code='".$row_result['scheme_code']."' and aicte_rc='".$row_result['aicte_rc']."' and full_part_time='".$row_result['full_part_time']."' and Ed_Ext='1' and Sub_TP='T' and received_status='Y' and eligibility='Y' and regular_reappear='".$row_result['Regular_Reappear']."' ;";
$x++;
}


?>

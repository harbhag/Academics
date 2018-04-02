<?php

show_label('info','Upload Internal Marks');
echo "<br/>";


$module_t_p = fetch_resource_db('admin_controls',array('control_name'),array('teacher_upload_internal_module'),'resource_array','');

if($module_t_p['value']=='P') {
	$subject_allotment = mysql_query("SELECT * FROM subject_master WHERE
	teacher_username='".$_SESSION['username']."' AND
	regular_reappear='".$_POST['regular_reappear']."' AND
	theory_practical='P' AND
	(internal_allot = '1' OR external_allot='1')") or die(mysql_error());
}
if($module_t_p['value']=='T') {
	$subject_allotment = mysql_query("SELECT * FROM subject_master WHERE
	teacher_username='".$_SESSION['username']."' AND
	regular_reappear='".$_POST['regular_reappear']."' AND
	theory_practical='T' AND
	internal_allot = '1'") or die(mysql_error());
}

if($module_t_p['value']=='Both') {
	$subject_allotment = mysql_query("SELECT * FROM subject_master WHERE
	teacher_username='".$_SESSION['username']."' AND
	regular_reappear='".$_POST['regular_reappear']."' AND
	(internal_allot = '1' OR external_allot='1')") or die(mysql_error());
}

if($module_t_p['value']=='None') {
	show_label('important',$module_t_p['message']);
	exit();
}


$regular_reappear = $_POST['regular_reappear'];
?>
<table class='table table-bordered table-condensed container' id='teacher_upload_internal'>
  <tr class='warning'>
    <th>Sr. No</th>
    <th>Branch</th>
    <th>Shift/<br/>FT or PT/</br>AICTE or RC</th>
    <th>S. Code</th>
    <th>S. Title</th>
    <th>Semester</th>
    <th>Int. Max Marks</th>
    <th>Ext. Max Marks</th>
    <th>T/P</th>
    <th>Download Sheet</th>
    <th>Upload Sheet</th>
    <th>Lock Subject</th>
    <th>Print Marks</th>
    <th>Mark Attd.</th>
    <th>Generate Attd. Sheet</th>
  </tr>
<?php
$count = 1;
while ($row = mysql_fetch_assoc($subject_allotment)) {

  $branch_name = fetch_resource_db('branch_code', array('branch_code'), array($row['branch_code']), 'resource_array_value', 'branch_name');

  $internal_attendance_status = fetch_resource_db('subject_master', 
          array('course_code', 
              'exam_month', 
              'exam_year', 
              'shift', 
              'aicte_rc', 
              'branch_code', 
              'semester', 
              'subject_code', 
              'theory_practical', 
              'regular_reappear', 
              'teacher_username', 
              'full_part_time'), 
          array($row['course_code'], 
              $row['exam_month'], 
              $row['exam_year'], 
              $row['shift'], 
              $row['aicte_rc'], 
              $row['branch_code'], 
              $row['semester'], 
              $row['subject_code'], 
              $row['theory_practical'], 
              $row['regular_reappear'], 
              $_SESSION['username'], 
              $row['full_part_time']), 'resource_array_value', 'internal_attendance_status');

  $external_attendance_status = fetch_resource_db('subject_master', 
          array('course_code', 
              'exam_month', 
              'exam_year', 
              'shift', 
              'aicte_rc', 
              'branch_code', 
              'semester', 
              'subject_code', 
              'theory_practical', 
              'regular_reappear', 
              'teacher_username', 
              'full_part_time'),
          array($row['course_code'], 
              $row['exam_month'], 
              $row['exam_year'], 
              $row['shift'], 
              $row['aicte_rc'], 
              $row['branch_code'], 
              $row['semester'], 
              $row['subject_code'], 
              $row['theory_practical'], 
              $row['regular_reappear'], 
              $_SESSION['username'], 
              $row['full_part_time']), 'resource_array_value', 'external_attendance_status');

  $internal_lock_status = fetch_resource_db('subject_master', 
          array('course_code', 
              'exam_month', 
              'exam_year', 
              'shift', 
              'aicte_rc', 
              'branch_code', 
              'semester', 
              'subject_code', 
              'theory_practical', 
              'regular_reappear', 
              'teacher_username', 
              'full_part_time'), 
          array($row['course_code'],
              $row['exam_month'], 
              $row['exam_year'], 
              $row['shift'], 
              $row['aicte_rc'], 
              $row['branch_code'], 
              $row['semester'], 
              $row['subject_code'], 
              $row['theory_practical'], 
              $row['regular_reappear'], 
              $_SESSION['username'], 
              $row['full_part_time']), 'resource_array_value', 'internal_lock_status');

  $external_lock_status = fetch_resource_db('subject_master', 
          array('course_code', 
              'exam_month', 
              'exam_year', 
              'shift', 
              'aicte_rc', 
              'branch_code', 
              'semester', 
              'subject_code', 
              'theory_practical', 
              'regular_reappear', 
              'teacher_username', 
              'full_part_time'), 
          array($row['course_code'], 
              $row['exam_month'], 
              $row['exam_year'], 
              $row['shift'], 
              $row['aicte_rc'], 
              $row['branch_code'], 
              $row['semester'], 
              $row['subject_code'], 
              $row['theory_practical'], 
              $row['regular_reappear'],
              $_SESSION['username'], 
              $row['full_part_time']), 'resource_array_value', 'external_lock_status');
  ?>

    <tr class='warning'>
      <td><?php echo $count; ?></td>
      <td><?php echo $branch_name; ?></td>
      <td><?php echo $row['shift'] . "/<br/>" . $row['full_part_time'] . "/</br>" . $row['aicte_rc']; ?></td>
      <td><?php echo $row['subject_code']; ?></td>
      <td><?php echo $row['subject_title']; ?></td>
      <td><?php echo $row['semester']; ?></td>
      <td><?php echo $row['internal_max_marks']; ?></td>
      <td><?php echo $row['external_max_marks']; ?></td>
      <td><?php echo $row['theory_practical']; ?></td>
      <td><?php
  download_internal_marks_csv_form($row['course_code'], 
          $row['branch_code'], 
          $row['subject_code'], 
          $row['paper_id'], 
          $row['subject_title'], 
          $row['theory_practical'], 
          $row['semester'], 
          $row['shift'], 
          $row['full_part_time'], 
          $regular_reappear, 
          $row['internal_max_marks'], 
          $row['external_max_marks'], 
          $row['aicte_rc'], 
          $internal_attendance_status, 
          $external_attendance_status, 
          $internal_lock_status, 
          $external_lock_status, 
          $row['exam_month'], 
          $row['exam_year'], 
          $count);
  ?></td>

      <td><?php
  select_internal_marks_csv_file($row['course_code'], 
          $row['branch_code'], 
          $row['subject_code'], 
          $row['paper_id'], 
          $row['subject_title'], 
          $row['theory_practical'], 
          $row['semester'], 
          $row['shift'], 
          $row['full_part_time'], 
          $regular_reappear, 
          $row['internal_max_marks'], 
          $row['external_max_marks'], 
          $row['aicte_rc'],
          $internal_attendance_status, 
          $external_attendance_status, 
          $internal_lock_status, 
          $external_lock_status, 
          $row['exam_month'], 
          $row['exam_year'], 
          $count);
  ?></td>

      <td><?php
        lock_internal_marks($row['course_code'], 
                $row['branch_code'], 
                $row['subject_code'], 
                $row['paper_id'], 
                $row['subject_title'], 
                $row['theory_practical'], 
                $row['semester'], 
                $row['shift'], 
                $row['full_part_time'], 
                $regular_reappear, 
                $row['internal_max_marks'], 
                $row['external_max_marks'], 
                $row['aicte_rc'], 
                $internal_attendance_status, 
                $external_attendance_status, 
                $internal_lock_status, 
                $external_lock_status, 
                $row['exam_month'], 
                $row['exam_year'], 
                $count);
        ?></td>

      <td><?php
        print_internal_marks_record($row['course_code'], 
                $row['branch_code'], 
                $row['subject_code'], 
                $row['paper_id'], 
                $row['subject_title'], 
                $row['theory_practical'], 
                $row['semester'], 
                $row['shift'], 
                $row['full_part_time'], 
                $regular_reappear, 
                $row['internal_max_marks'], 
                $row['external_max_marks'], 
                $row['aicte_rc'], 
                $internal_attendance_status, 
                $external_attendance_status,
                $internal_lock_status, 
                $external_lock_status, 
                $row['exam_month'], 
                $row['exam_year'], 
                $count,
                $row['internal_allot'],
                $row['external_allot']);
        ?></td>

      <td><?php
        mark_absent_internal($row['subject_master_id'],
				$row['course_code'], 
                $row['branch_code'], 
                $row['subject_code'], 
                $row['paper_id'], 
                $row['subject_title'], 
                $row['theory_practical'], 
                $row['semester'], 
                $row['shift'], 
                $row['full_part_time'], 
                $regular_reappear, 
                $row['internal_max_marks'], 
                $row['external_max_marks'], 
                $row['aicte_rc'], 
                $internal_attendance_status, 
                $external_attendance_status, 
                $internal_lock_status, 
                $external_lock_status, 
                $row['exam_month'], 
                $row['exam_year'], 
                $count,
                $row['internal_allot'],
                $row['external_allot']
                );
        ?></td>
        
        <td><?php
        download_practical_attendance_sheet($row['subject_master_id'],
                $external_lock_status, 
                $row['internal_allot'],
                $row['external_allot'],
                $row['theory_practical']
                );
        ?></td>
    </tr>
        <?php
        $count++;
      }
      ?>
</table>

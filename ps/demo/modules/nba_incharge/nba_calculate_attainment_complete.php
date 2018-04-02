<?php
$course_branch = explode(',',$_POST['course_branch']);

include_once('modules/nba_incharge/attainment_sessionals.php');
include_once('modules/nba_incharge/attainment_assignment.php');
include_once('modules/nba_incharge/attainment_internal_practicals.php');

show_label('success','Attainment Calculated.');

?>

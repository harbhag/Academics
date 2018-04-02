<?php
require_once('modules/parsecsv/parsecsv.lib.php');
$file_name = $_GET['file'];
$subject_code = $_GET['subject_code'];
$subject_title = $_GET['subject_title'];
$semester = $_GET['semester'];
$file_name = $_GET['file'];

$ie = $_GET['ie'];

$csv = new parseCSV();
$csv->auto("files/".$file_name.".csv");
//$csv->auto($file_name);
//$csv->output("files/".$file_name.".csv");
$csv->output($subject_title."_".$subject_code."_".$semester."_".$ie.".csv");
?>

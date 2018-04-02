<?php
require_once('modules/parsecsv/parsecsv.lib.php');
$file_name = $_GET['file'];
$rp = $_GET['rp'];
$branch = $_GET['branch'];
$course = $_GET['course'];
$paper_id = $_GET['paper_id'];
$csv = new parseCSV();
$csv->auto("files/".$file_name.".csv");
//$csv->auto($file_name);
//$csv->output("files/".$file_name.".csv");
$csv->output($rp."_".$course."_".$branch."_".$paper_id.".csv");
?>

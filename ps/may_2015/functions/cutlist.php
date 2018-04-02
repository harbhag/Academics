<?php

function get_cutlist_csv() {
	
	$_POST['paper_id'] = strtoupper($_POST['paper_id']);
	//$roll_nos = fetch_resource_db('section_groups',array('section','sgroup'),array($_POST['section'],$_POST['group']),'','');
	$course_branch = explode(',',$_POST['branch_code']);
	$branch_name = fetch_resource_db('branch_code',array('branch_code'),array($course_branch[1]),'resource_array_value','branch_name');
	$course_name = fetch_resource_db('course_code',array('course_code'),array($course_branch[0]),'resource_array_value','course_name');
	
	
	$data = mysql_query("select distinct 
						
						ED_RollNo, 
						Sub_PaperID, 
						SUB_CODE, 
						Sub_Sem, 
						SUB_TITLE, 
						date_of_exam,
						upper(StudentName)
						
						
						FROM ptu_subjects WHERE 
						
						
						
						Sub_PaperID='".$_POST['paper_id']."' AND
						FRM_BRID='".$course_branch[1]."' AND
						course_code='".$course_branch[0]."' AND
						Regular_Reappear = '".$_POST['regular_reappear']."' AND
						ucentre = '".$_SESSION['ucentre']."' AND
						usession = '".$_SESSION['usession']."' AND
						date_of_exam = '".$_POST['date_of_exam']."' AND
						Ed_Ext = 1 AND
						received_status='Y' AND
						detention_status='N' AND
						eligibility = 'Y' AND
						SUB_TP='T' order by ED_RollNo ASC ; ") or die(mysql_error());
	
	/*if(mysql_num_rows($data)==0) {
		show_label('warning','No Record Found !!');
	}
	else {*/
	
	$col_name = get_tables_cols('ptu_subjects',array('ED_RollNo','Sub_PaperID','SUB_CODE','Sub_Sem','SUB_TITLE','date_of_exam','StudentName'));

	
	$field = mysql_num_fields($data);

	$csv = new parseCSV();

	$list = array();
	$list[] = $col_name;
	while($row=mysql_fetch_array($data)) {
		for($j=0;$j<=$field-1;$j++) {
			if($j==0) {
				$field_array[] = "R".$row[$j];
			}
			else {
				$field_array[] = $row[$j];
			}
		}
		$list[] = $field_array;
		unset($field_array);
	}
	
	
	$fd = md5(time());
	$file_name = "files/".$fd.".csv";
	$fp = fopen($file_name, 'w');
	

	
	foreach ($list as $fields) {
		fputcsv($fp, $fields);
	}

	fclose($fp);
	
	header("Location:download_cutlist.php?file=".$fd."&rp=".$_POST['regular_reappear']."&course=".$course_name."&branch=".$branch_name."&paper_id=".$_POST['paper_id']);
}
	
	//echo mysql_num_rows($data);
//}

?>

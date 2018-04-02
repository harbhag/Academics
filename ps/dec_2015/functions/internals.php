<?php

function get_internal_marks_csv() {
	
	//$roll_nos = fetch_resource_db('section_groups',array('section','sgroup'),array($_POST['section'],$_POST['group']),'','');
	$branch_name = fetch_resource_db('branch_code',array('branch_code'),array($_POST['branch_code']),'resource_array_value','branch_name');
	
	if($_POST['internal_external']=='I') {
		
		$select_fields = "university_roll_no,upper(student_name),subject_code,semester,theory_practical,regular_reappear,internal_max_marks,internal_obtained_marks,grading_type,normalized_marks,grade_letter,mean,std_dev,total_students";
		
		$max_marks = "internal_max_marks = '".$_POST['internal_max_marks']."' AND";
		
		$col_name = get_tables_cols('student_internal_marks',array('university_roll_no','student_name','subject_code','semester','theory_practical','regular_reappear','internal_max_marks','internal_obtained_marks','grading_type','normalized_marks','grade_letter','mean','std_dev','total_students'));
	}
	if($_POST['internal_external']=='E') {
		
		$select_fields = "university_roll_no,upper(student_name),subject_code,semester,theory_practical,regular_reappear,external_max_marks,external_obtained_marks,grading_type,normalized_marks,grade_letter,mean,std_dev,total_students";
		
		$max_marks = "external_max_marks = '".$_POST['external_max_marks']."' AND";
		
		$col_name = get_tables_cols('student_internal_marks',array('university_roll_no','student_name','subject_code','semester','theory_practical','regular_reappear','external_max_marks','external_obtained_marks','grading_type','normalized_marks','grade_letter','mean','std_dev','total_students'));
	}
	
	if($_POST['theory_practical']=='T') {
		$paper_id = "paper_id = '".$_POST['paper_id']."' AND";
	}
	if($_POST['theory_practical']=='P') {
		$paper_id = "";
	}
	
	echo $select_fields;
	
	$query_string = "SELECT ".$select_fields." FROM student_internal_marks WHERE
			subject_code = '".$_POST['subject_code']."' AND
			course_code = '".$_POST['course_code']."' AND
			branch_code = '".$_POST['branch_code']."' AND
			aicte_rc = '".$_POST['aicte_rc']."' AND
			shift = '".$_POST['shift']."' AND
			full_part_time = '".$_POST['full_part_time']."' AND
			exam_month = '".$_POST['exam_month']."' AND
			exam_year = '".$_POST['exam_year']."' AND
			theory_practical = '".$_POST['theory_practical']."' AND
			semester = '".$_POST['semester']."' AND
			regular_reappear = '".$_POST['regular_reappear']."' AND
			internal_external = '".$_POST['internal_external']."' AND
			".$max_marks."
			
			".$paper_id."
			teacher_username = '".$_SESSION['username']."' ORDER BY university_roll_no ASC";
			
	
	$data = mysql_query($query_string) or die(mysql_error());

	
	$field = mysql_num_fields($data);

	$csv = new parseCSV();

	$list = array();
	$list[] = $col_name;
	while($row=mysql_fetch_array($data)) {
		
		$internal_theory_record_sql = mysql_query("SELECT internal_obtained_marks FROM student_internal_theory_record
		WHERE university_roll_no='".$row[0]."' AND
		subject_code = '".$row[2]."'") or die(mysql_error());
		
		$internal_theory_record = mysql_fetch_assoc($internal_theory_record_sql);
		
		for($j=0;$j<=$field-1;$j++) {
			
			if($j==0) {
				$field_array[] = "R".$row[$j];
			}
			
			elseif($j==7 && $row[7]=='') {
				$field_array[] = $internal_theory_record['internal_obtained_marks'];
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
	
	header("Location:download.php?file=".$fd."&subject_code=".$_POST['subject_code']."&subject_title=".$_POST['subject_title']."&semester=".$_POST['semester']."&ie=".$_POST['internal_external']);
	
}

function internal_lock_subject() {
	
	if($_POST['internal_external']=='I') {
		$lock_field = "internal_lock_status";
	}
	if($_POST['internal_external']=='E') {
		$lock_field = "external_lock_status";
	}
	
	if($_POST['theory_practical']=='T') {
		$paper_id = "paper_id = '".$_POST['paper_id']."' AND";
	}
	if($_POST['theory_practical']=='P') {
		$paper_id = "";
	}
	
	$query_string_sm = "UPDATE subject_master SET $lock_field=1 WHERE
	branch_code = '".$_POST['branch_code']."' AND
	course_code = '".$_POST['course_code']."' AND
	aicte_rc = '".$_POST['aicte_rc']."' AND
	shift = '".$_POST['shift']."' AND
	full_part_time = '".$_POST['full_part_time']."' AND
	subject_code = '".$_POST['subject_code']."' AND
	exam_month = '".$_POST['exam_month']."' AND
	exam_year = '".$_POST['exam_year']."' AND
	theory_practical = '".$_POST['theory_practical']."' AND
	semester = '".$_POST['semester']."' AND
	regular_reappear = '".$_POST['regular_reappear']."' AND
	".$paper_id."
	teacher_username = '".$_SESSION['username']."'";
	
	$query_string_sim = "UPDATE student_internal_marks SET $lock_field=1 WHERE
	branch_code = '".$_POST['branch_code']."' AND
	course_code = '".$_POST['course_code']."' AND
	aicte_rc = '".$_POST['aicte_rc']."' AND
	shift = '".$_POST['shift']."' AND
	full_part_time = '".$_POST['full_part_time']."' AND
	subject_code = '".$_POST['subject_code']."' AND
	exam_month = '".$_POST['exam_month']."' AND
	exam_year = '".$_POST['exam_year']."' AND
	theory_practical = '".$_POST['theory_practical']."' AND
	semester = '".$_POST['semester']."' AND
	internal_external = '".$_POST['internal_external']."' AND
	regular_reappear = '".$_POST['regular_reappear']."' AND
	".$paper_id."
	teacher_username = '".$_SESSION['username']."'";
	
	
	mysql_query($query_string_sm);
	mysql_query($query_string_sim);
	show_label('success','Subject Successfully Locked');
}


function upload_internal_marks_csv() {
	$time = date("Y-m-d H:i:s");
	$working_dir = 'files/';
	$mimes = array('text/csv','application/ms-excel','application/vnd.ms-excel','application/x-msexcel');
	
	$grades = array('O','A(+)','A','B(+)','B','C','P','F','E','I');
	
	/*
	if(!in_array($_FILES["csvfile"]["type"],$mimes)) {
		#echo "Only CSV files allowed";
		show_label('warning','ERROR: Invalid File. Only CSV file is allowed');
		exit();
	}
	if($_FILES["csvfile"]["type"]=='') {
		#echo "Only CSV files allowed";
		show_label('warning','ERROR: Invalid File. Only CSV file is allowed');
		exit();
	}
	* */
	
	$file_info = pathinfo($_FILES["csvfile"]["name"]);
	$extension = $file_info['extension'];
	
	if($extension!='csv') {
		#echo "Only CSV files allowed";
		show_label('warning','ERROR: Invalid File. Only CSV file is allowed');
		exit();
	}

	$uploadfile = $working_dir.md5(time()).".csv";


	if ($_FILES["csvfile"]["error"] > 0){
		echo "Error: " . $_FILES["csvfile"]["error"] . "<br />";
	}
	else {
		if (move_uploaded_file($_FILES['csvfile']['tmp_name'], $uploadfile)) {
			$file_name = $uploadfile;
		} 
		else {
			//echo "<p style='color:red'>Error: File Was not Uploaded. Try again.</p>";
			show_label('warning','Error: File was not uploaded. Try Again');
			return false;		
		}
	}
	
	$errors = 0;
	$errors_major = array();
	
	if($_POST['internal_external']=='I') {
		
		$max_marks = "internal_max_marks = '".$_POST['internal_max_marks']."' AND";
		
		if($_POST['theory_practical']=='T') {
			$paper_id = "paper_id = '".$_POST['paper_id']."' AND";
		}
		
		if($_POST['theory_practical']=='P') {
			$paper_id = "";
		}
	
		$query_string = "SELECT * FROM student_internal_marks WHERE
			subject_code = '".$_POST['subject_code']."' AND
			course_code = '".$_POST['course_code']."' AND
			branch_code = '".$_POST['branch_code']."' AND
			aicte_rc = '".$_POST['aicte_rc']."' AND
			shift = '".$_POST['shift']."' AND
			full_part_time = '".$_POST['full_part_time']."' AND
			exam_month = '".$_POST['exam_month']."' AND
			exam_year = '".$_POST['exam_year']."' AND
			theory_practical = '".$_POST['theory_practical']."' AND
			semester = '".$_POST['semester']."' AND
			regular_reappear = '".$_POST['regular_reappear']."' AND
			internal_external = '".$_POST['internal_external']."' AND
			".$max_marks."
			
			".$paper_id."
			teacher_username = '".$_SESSION['username']."' ORDER BY university_roll_no ASC";
	
		$data = mysql_query($query_string) or die(mysql_error());
	

		$csv = new parseCSV();
		$csv->auto($uploadfile);
		$i=0;
		//echo count($csv->data);
		//for($i=0;$i<=count($csv->data);$i++) {
		while($row = mysql_fetch_assoc($data)) {
			$uroll_array = explode("R",$csv->data[$i]['university_roll_no']);
			
			$lock_status = fetch_resource_db('student_internal_marks',array('university_roll_no','subject_code','semester','regular_reappear','teacher_username','internal_external','internal_max_marks'),array($uroll_array[1],$csv->data[$i]['subject_code'],$csv->data[$i]['semester'],$csv->data[$i]['regular_reappear'],$_SESSION['username'],$_POST['internal_external'],$_POST['internal_max_marks']),'resource_array_value','internal_lock_status');
		
			if($lock_status==1 or $lock_status=='1') {
				show_label('warning',"Error: Wrong File selected. Subject has already been locked.");
				exit();
			}
			
			//echo "<br/>".$csv->data[$i]['std_dev'];
			
			if($csv->data[$i]['internal_obtained_marks']=='' or 
				!is_numeric($csv->data[$i]['internal_obtained_marks']) or
				!is_numeric($csv->data[$i]['normalized_marks']) or
				!in_array($csv->data[$i]['grade_letter'],$grades) or
				$csv->data[$i]['internal_obtained_marks']<0 or 
				($csv->data[$i]['internal_obtained_marks'])>($row['internal_max_marks']) or
				$uroll_array[1]!=$row['university_roll_no'] or 
				$csv->data[$i]['semester']!=$row['semester'] or
				$csv->data[$i]['subject_code']!=$row['subject_code'] or
				$csv->data[$i]['regular_reappear']!=$row['regular_reappear'] or
				$csv->data[$i]['theory_practical']!=$row['theory_practical'] or
				$csv->data[$i]['internal_max_marks']!=$row['internal_max_marks']
			) {
				
					if($uroll_array[1]!=$row['university_roll_no']) {
						$errors_major[] = $csv->data[$i]['university_roll_no'];
					}
					$i++;
					$errors++;
					unset($uroll_array);
					continue;
					//show_label('important','Error: Invalid/Tempered/Corrupted Values found in the file.Check the file and Upload again.');
					//exit();
				
				}
				else {
					
					if($_POST['theory_practical']=='T') {
						
						
						
						mysql_query("UPDATE student_internal_marks set 
						internal_obtained_marks='".$csv->data[$i]['internal_obtained_marks']."',
						grade_letter='".$csv->data[$i]['grade_letter']."',
						normalized_marks='".$csv->data[$i]['normalized_marks']."',
						marks_last_updated_on = '".date("Y-m-d H:i:s")."' WHERE 
						university_roll_no='".$uroll_array[1]."'AND
						subject_code='".$csv->data[$i]['subject_code']."'AND
						semester='".$csv->data[$i]['semester']."'AND
						regular_reappear='".$csv->data[$i]['regular_reappear']."'AND
						theory_practical='".$csv->data[$i]['theory_practical']."'AND
						internal_external='".$_POST['internal_external']."'AND
						internal_max_marks='".$_POST['internal_max_marks']."'AND
						paper_id='".$_POST['paper_id']."'AND
						teacher_username='".$_SESSION['username']."'
					
						") or die(mysql_error());
						
						
						
						
					}
					
					if($_POST['theory_practical']=='P') {
						
						mysql_query("UPDATE student_internal_marks set 
						internal_obtained_marks='".$csv->data[$i]['internal_obtained_marks']."',
						grade_letter='".$csv->data[$i]['grade_letter']."',
						normalized_marks='".$csv->data[$i]['normalized_marks']."',
						marks_last_updated_on = '".date("Y-m-d H:i:s")."' WHERE 
						university_roll_no='".$uroll_array[1]."'AND
						subject_code='".$csv->data[$i]['subject_code']."'AND
						semester='".$csv->data[$i]['semester']."'AND
						regular_reappear='".$csv->data[$i]['regular_reappear']."'AND
						theory_practical='".$csv->data[$i]['theory_practical']."'AND
						internal_external='".$_POST['internal_external']."'AND
						internal_max_marks='".$_POST['internal_max_marks']."'AND
						teacher_username='".$_SESSION['username']."'
					
						") or die(mysql_error());
						
					}
				
					
				}
				$i++;
				unset($uroll_array);
			}
		if($errors==0) {
			show_label('success','Marks Successfully Uploaded');
		}
		else {
			/*if(count($errors_major)>0) {
				$err = implode(",",$errors_major);
				show_label('warning','Error: Invalid/Empty Values found in the file.Marks are not updated for all the students. Check the file and Upload again.');
				show_label('important',"Error: Following Roll No are tempered:".$err);
			}
			else {
				show_label('warning','Error: Invalid/Empty Values found in the file. Check the file and Upload again.');
			}*/
			show_label('warning','Error: Invalid/Tempered/Corrupted Values found in the file.Check the file and Upload again.');
			
		}
	}
	
	
	if($_POST['internal_external']=='E') {
	
		$data = mysql_query("SELECT * FROM student_internal_marks WHERE
		subject_code = '".$_POST['subject_code']."' AND
		course_code = '".$_POST['course_code']."' AND
		branch_code = '".$_POST['branch_code']."' AND
		aicte_rc = '".$_POST['aicte_rc']."' AND
		shift = '".$_POST['shift']."' AND
		full_part_time = '".$_POST['full_part_time']."' AND
		exam_month = '".$_POST['exam_month']."' AND
		exam_year = '".$_POST['exam_year']."' AND
		theory_practical = '".$_POST['theory_practical']."' AND
		semester = '".$_POST['semester']."' AND
		regular_reappear = '".$_POST['regular_reappear']."' AND
		internal_external = '".$_POST['internal_external']."' AND
		external_max_marks = '".$_POST['external_max_marks']."' AND
		internal_attendance_status = 'Present' AND
		teacher_username = '".$_SESSION['username']."' ORDER BY university_roll_no ASC") or die(mysql_error());
	
	

		$csv = new parseCSV();
		$csv->auto($uploadfile);
		$i=0;
		//echo count($csv->data);
		//for($i=0;$i<=count($csv->data);$i++) {
		while($row = mysql_fetch_assoc($data)) {
			$uroll_array = explode("R",$csv->data[$i]['university_roll_no']);
			
			$lock_status = fetch_resource_db('student_internal_marks',array('university_roll_no','subject_code','semester','regular_reappear','teacher_username','internal_external','external_max_marks'),array($uroll_array[1],$csv->data[$i]['subject_code'],$csv->data[$i]['semester'],$csv->data[$i]['regular_reappear'],$_SESSION['username'],$_POST['internal_external'],$_POST['external_max_marks']),'resource_array_value','external_lock_status');
		
			if($lock_status==1 or $lock_status=='1') {
				show_label('warning',"Error: Wrong File selected. Subject has already been locked.");
				exit();
			}
		
			if($lock_status==1 or $lock_status=='1') {
				show_label('warning',"Error: Wrong File selected. Subject has already been locked.");
				exit();
			}
			
			if($csv->data[$i]['external_obtained_marks']=='' or 
				!is_numeric($csv->data[$i]['external_obtained_marks']) or
				!is_numeric($csv->data[$i]['normalized_marks']) or
				!in_array($csv->data[$i]['grade_letter'],$grades) or
				$csv->data[$i]['external_obtained_marks']<0 or 
				($csv->data[$i]['external_obtained_marks'])>($row['external_max_marks']) or
				$uroll_array[1]!=$row['university_roll_no'] or 
				$csv->data[$i]['semester']!=$row['semester'] or
				$csv->data[$i]['subject_code']!=$row['subject_code'] or
				$csv->data[$i]['regular_reappear']!=$row['regular_reappear'] or
				$csv->data[$i]['theory_practical']!=$row['theory_practical'] or
				$csv->data[$i]['external_max_marks']!=$row['external_max_marks']
				) {
				//echo "<br/>".$uroll_array[1]."--".$row['university_roll_no'];
				
				
					if($uroll_array[1]!=$row['university_roll_no']) {
						$errors_major[] = $csv->data[$i]['university_roll_no'];
					}
					$i++;
					$errors++;
					unset($uroll_array);
					continue;
					//show_label('important','Error: Invalid/Tempered/Corrupted Values found in the file.Check the file and Upload again.');
					//exit();
				
				}
				else {
				
					mysql_query("UPDATE student_internal_marks set 
					external_obtained_marks='".$csv->data[$i]['external_obtained_marks']."',
					grade_letter='".$csv->data[$i]['grade_letter']."',
					normalized_marks='".$csv->data[$i]['normalized_marks']."',
					marks_last_updated_on = '".date("Y-m-d H:i:s")."' WHERE 
					university_roll_no='".$uroll_array[1]."'AND
					subject_code='".$csv->data[$i]['subject_code']."'AND
					semester='".$csv->data[$i]['semester']."'AND
					regular_reappear='".$csv->data[$i]['regular_reappear']."'AND
					theory_practical='".$csv->data[$i]['theory_practical']."'AND
					internal_external='".$_POST['internal_external']."'AND
					external_max_marks='".$_POST['external_max_marks']."'AND
					teacher_username='".$_SESSION['username']."'
					
					") or die(mysql_error());
				}
				$i++;
				unset($uroll_array);
			}
		if($errors==0) {
			show_label('success','Marks Successfully Uploaded');
		}
		else {
			/*if(count($errors_major)>0) {
				$err = implode(",",$errors_major);
				show_label('warning','Error: Invalid/Empty Values found in the file.Marks are not updated for all the students. Check the file and Upload again.');
				show_label('important',"Error: Following Roll No are tempered:".$err);
			}
			else {
				show_label('warning','Error: Invalid/Empty Values found in the file. Check the file and Upload again.');
			}*/
			show_label('warning','Error: Invalid/Tempered/Corrupted Values found in the file.Check the file and Upload again.');
		}
	}

}
?>

<?php

/*
 * db_functions.php
	  
	 This file holds various functions required to fetch data from the database.
 * 
 * Copyright 2012 Harbhag Singh Sohal <harbhag@Optiplex780>
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * 
 * 
 */
 
function fetch_resource_db_nowhere($table_name,$field_array,$return_type,$return_type_name) {
	
	
	
	if($field_array[0]=='ALL') {
		
		$resource = mysql_query("SELECT * FROM ".$table_name."") or die(mysql_error());
	}
	else {
		$fields = implode(',',$field_array);
		//$fields = "course,branch,name";
		//$sql = "SELECT ".$fields." FROM ".$table_name."";
		//echo $sql;
		$resource = mysql_query("SELECT ".$fields." FROM ".$table_name."") or die(mysql_error());
	}
	
	
	if($return_type == 'resource') {
		return $resource;
	}
	
	if($return_type == 'resource_array') {
		return mysql_fetch_assoc($resource);
	}
	
	if($return_type == 'resource_array_value') {
		$resource_array = mysql_fetch_assoc($resource);
		return $resource_array[$return_type_name];
	}
	
	
}


 
function fetch_resource_db_selective($table_name,$field_array,$where_array_name,$where_array_value,$return_type,$return_type_name) {
	
	$wheres = '';
	
	for($i=0;$i<=count($where_array_name)-1;$i++) {
		
		if($i==count($where_array_name)-1 or count($where_array_name)==1) {
			$wheres .= $where_array_name[$i]."='".$where_array_value[$i]."'";
		}
		
		else {
			$wheres .= $where_array_name[$i]."='".$where_array_value[$i]."' AND ";
		}
	}
	
	if($field_array[0]=='ALL') {
		
		$resource = mysql_query("SELECT * FROM ".$table_name." WHERE ".$wheres."") or die(mysql_error());
	}
	else {
		$fields = implode(',',$field_array);
		//$fields = "course,branch,name";
		//$sql = "SELECT ".$fields." FROM ".$table_name."";
		//echo $sql;
		$resource = mysql_query("SELECT ".$fields." FROM ".$table_name." WHERE ".$wheres."") or die(mysql_error());
	}
	$resource = mysql_query("SELECT * FROM ".$table_name." WHERE ".$wheres."") or die(mysql_error());
	
	
	if($return_type == 'resource') {
		return $resource;
	}
	
	if($return_type == 'resource_array') {
		return mysql_fetch_assoc($resource);
	}
	
	if($return_type == 'resource_array_value') {
		$resource_array = mysql_fetch_assoc($resource);
		return $resource_array[$return_type_name];
	}
	
	
}

function fetch_resource_db($table_name,$where_array_name,$where_array_value,$return_type,$return_type_name) {
	
	$wheres = '';
	
	for($i=0;$i<=count($where_array_name)-1;$i++) {
		
		if($i==count($where_array_name)-1 or count($where_array_name)==1) {
			$wheres .= $where_array_name[$i]."='".$where_array_value[$i]."'";
		}
		
		else {
			$wheres .= $where_array_name[$i]."='".$where_array_value[$i]."' AND ";
		}
	}
	
	$resource = mysql_query("SELECT * FROM ".$table_name." WHERE ".$wheres."") or die(mysql_error());
	
	if($return_type == 'resource') {
		return $resource;
	}
	
	if($return_type == 'resource_array') {
		return mysql_fetch_assoc($resource);
	}
	
	if($return_type == 'resource_array_value') {
		$resource_array = mysql_fetch_assoc($resource);
		return $resource_array[$return_type_name];
	}
	
	
}

function fetch_resource_student_internal_marks() {
	mysql_query("SELECT college_roll_no,university_roll_no,subject_code,internal_max_marks FROM student_internal_marks WHERE
	subject_code = '".$_POST['subject_code']."' AND
			theory_practical = '".$_POST['theory_practical']."' AND
			semester = '".$_POST['semester']."' AND
			regular_reappear = '".$_POST['regular_reappear']."' AND
			internal_attendance_status = 'Detained' AND
			teacher_username = '".$_SESSION['username']."'") or die(mysql_error());
}

function get_tables_cols($table_name,$fields_array) {
  #$sql = "SELECT university_roll_no,subject_code,semester,regular_reappear,internal_max_marks FROM student_internal_marks";
  $result = fetch_resource_db_nowhere($table_name,$fields_array,'resource','');
  #$result = mysql_query($sql);
  $num_of_fields = mysql_num_fields($result);
  for($j=0;$j<=$num_of_fields-1;$j++){
    $col_names[$j] = mysql_field_name($result,$j);
  }
	return $col_names;
}




function fetch_resource_db_att($table_name,$where_array_name,$where_array_value,$return_type,$return_type_name) {
	
	$wheres = '';
	
	for($i=0;$i<=count($where_array_name)-1;$i++) {
		
		if($i==count($where_array_name)-1 or count($where_array_name)==1) {
			$wheres .= $where_array_name[$i]."='".$where_array_value[$i]."'";
		}
		
		else {
			$wheres .= $where_array_name[$i]."='".$where_array_value[$i]."' AND ";
		}
	}
	
	$resource = mysql_query("SELECT * FROM ".$table_name." WHERE ".$wheres." ORDER BY ED_RollNo ASC") or die(mysql_error());
	
	
	//echo "SELECT * FROM ".$table_name." WHERE ".$wheres." ORDER BY ED_RollNo ASC";
	
	if($return_type == 'resource') {
		return $resource;
	}
	
	if($return_type == 'resource_array') {
		return mysql_fetch_assoc($resource);
	}
	
	if($return_type == 'resource_array_value') {
		$resource_array = mysql_fetch_assoc($resource);
		return $resource_array[$return_type_name];
	}
	
	
}


function fetch_resource_db_att_daily($table_name,$where_array_name,$where_array_value,$return_type,$return_type_name) {
	
	$wheres = '';
	
	for($i=0;$i<=count($where_array_name)-1;$i++) {
		
		if($i==count($where_array_name)-1 or count($where_array_name)==1) {
			$wheres .= $where_array_name[$i]."='".$where_array_value[$i]."'";
		}
		
		else {
			$wheres .= $where_array_name[$i]."='".$where_array_value[$i]."' AND ";
		}
	}
	
	$resource = mysql_query("SELECT * FROM ".$table_name." WHERE ".$wheres." ORDER BY university_roll_no ASC") or die(mysql_error());
	
	
	if($return_type == 'resource') {
		return $resource;
	}
	
	if($return_type == 'resource_array') {
		return mysql_fetch_assoc($resource);
	}
	
	if($return_type == 'resource_array_value') {
		$resource_array = mysql_fetch_assoc($resource);
		return $resource_array[$return_type_name];
	}
	
	
}

?>

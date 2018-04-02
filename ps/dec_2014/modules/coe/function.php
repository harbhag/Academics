<?php
function decode_fieldname($table_name,$field_name,$where_field_name,$where_field_value)
{
	$sql = "SELECT $field_name FROM $table_name WHERE $where_field_name='".$where_field_value."' ;";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	return $row[$field_name];
} 
?>

<?php
//require_once ('config.php');
mysql_select_db($db_name,$conn);

function form_text_field($type,$name,$class,$id,$value,$helptext)
	{
		if ($type=="text"||"password"||"hidden")
		{
			
			echo "<tr>";
			if($type!='hidden')
			{
				echo "<td>".str_replace('_',' ',$name)."</td>";
			}
			echo "<td><input type='".$type."' name='".$name."' class='".$class."' id='".$id."' value='".$value."' />".$helptext." </td>";
			echo "</tr>";	
		}
	}

function form_textarea_field($type,$name,$rows,$cols)
	{
		if ($type =="textarea")
		{	
			echo "<tr>";
			echo "<td>".$name;
			echo "<td><textarea name='".$name."' rows='".$rows."' cols='".$cols."'>";
			echo "</textarea></tr>";
		}
	}
function form_dropdown_field($type,$options,$name,$table,$table_colume,$class,$id,$value,$event)
	{
		if($options[0]!='')
		{
			echo "<td>".str_replace('_',' ',$name)." <td> <select name='".$name."' class='".$class."' id='".$id."' $event>";
			
			echo "<option value='".$value."' selected='selected'>".$value."</option>";
			foreach($options as $key=>$option)
			{
				echo "<option value='".$option."'>".str_replace('_',' ',$option)."</option>";
			}
			echo "</td></select>";
		}
		else
		{
			if($type=="dropdown")
			{	
				mysql_select_db($db_name,$conn);
				$sql="Select distinct ".$table_colume." from ".$table." order by ".$table_colume.";";
				$result = mysql_query($sql) or die("Error in Query: $sql " . mysql_error()); 
				echo "<td>".str_replace('_',' ',$name)."<td><select name='".$name."' class='".$class."' id='".$id."' $event>";
				//echo "<option value='".$value."' selected='selected'>".$value."</option>";
				while($row=mysql_fetch_array($result))
				{	
					if($row[0]!='' && $row[0]!='N/A')	
					echo " <option value='".$row[0]."'>".$row[0]."</option> ";
				}
				echo "</td></select>";
			}
		}
	}
	// Function for Checkbox Field 
function form_checkbox_field($type,$name,$table,$table_colume)
	{
		if ($type=="checkbox"||"radio")
		{
			$sql="Select distinct ".$table_colume." from ".$table." where 1";
			$result = mysql_query($sql) or die("Error in Query: $sql " . mysql_error()); 
			echo "<td>".str_replace('_',' ',$name)."<td>";
			while($row=mysql_fetch_array($result))
			{
				if($row[0]!="")
				{
					echo "<input type='".$type."' name='".$name."' value='".$row[0]."'/>".$row[0]."<br />";
				}
				else
				{
					echo " Data not found";
				}
			}
		}
	}
